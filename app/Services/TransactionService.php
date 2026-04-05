<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Cart;
use Midtrans\Transaction as MidtransTransaction;

class TransactionService
{
    /**
     * Update transaction status based on Midtrans response or manual override.
     */
    public function updateStatus(Transaction $transaction, $status)
    {
        // Validate status
        $validStatuses = ['pending', 'confirmed', 'shipped', 'completed', 'cancelled', 'paid', 'failed', 'complained', 'returning', 'refunded'];
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException("Status '$status' tidak valid.");
        }

        // Prevent double update if status is already the same (unless retrying failed)
        if ($transaction->status === $status) {
            return;
        }

        // Update status
        $transaction->status = $status;
        $transaction->save(); 

        // If PAID or new paid status, decrease stock & clear cart
        if (in_array($status, ['paid', 'confirmed'])) {
            $this->handlePaidTransaction($transaction);
        }
    }

    /**
     * Check status from Midtrans API and update local database.
     */
    public function checkAndUpdateStatus(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return;
        }

        try {
            // Configure Midtrans (ensure config is loaded)
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = false; // Adjust based on env
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $statusMidtrans = MidtransTransaction::status($transaction->invoice_code);
            $transactionStatus = $statusMidtrans->transaction_status;

            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                $this->updateStatus($transaction, 'paid');
            } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
                $this->updateStatus($transaction, 'failed');
            }
        } catch (\Exception $e) {
            // Log error or ignore
        }
    }

    protected function handlePaidTransaction(Transaction $transaction)
    {
        // Decrease Stock
        foreach ($transaction->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->quantity = max(0, $product->quantity - $item->quantity);
                $product->save();
            }
        }

        // Clear User's Cart
        Cart::where('user_id', $transaction->user_id)->delete();
    }
}
