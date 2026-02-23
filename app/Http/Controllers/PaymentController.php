<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Transaction;
use App\Models\Cart;

class PaymentController extends Controller
{
    protected $transactionService;

    public function __construct(\App\Services\TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // =========================
    // HALAMAN PAYMENT
    // =========================
    public function pay(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            abort(403);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->invoice_code,
                'gross_amount' => $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
            'callbacks' => [
                'finish' => route('payment.result', ['transaction' => $transaction->id, 'status' => 'success']),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('frontend.payment', compact('transaction', 'snapToken'));
    }

    // =========================
    // PAYMENT RESULT (REDIRECT)
    // =========================
    public function result(Request $request)
    {
        $status = $request->get('status'); // success, pending, failed
        $transactionId = $request->get('transaction');
        
        $transaction = Transaction::find($transactionId);

        if (!$transaction) {
            abort(404);
        }

        // FALLBACK FOR LOCALHOST:
        // Cek status manual ke API Midtrans jika status masih pending.
        if ($transaction->status == 'pending') {
            $this->transactionService->checkAndUpdateStatus($transaction);
            
            // Refresh model to get updated status
            $transaction->refresh();
            if ($transaction->status == 'paid') {
                $status = 'success';
            } elseif ($transaction->status == 'failed') {
                $status = 'failed';
            }
        }

        return view('frontend.payment-result', compact('status', 'transaction'));
    }

    // =========================
    // MIDTRANS CALLBACK
    // =========================
    public function callback()
    {
        $notif = new Notification();

        $transaction = Transaction::where(
            'invoice_code',
            $notif->order_id
        )->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        if (in_array($notif->transaction_status, ['settlement', 'capture'])) {
            $this->transactionService->updateStatus($transaction, 'paid');
        } elseif (in_array($notif->transaction_status, ['expire', 'cancel', 'deny'])) {
            $this->transactionService->updateStatus($transaction, 'failed');
        }

        return response()->json(['status' => 'ok']);
    }
}
