<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItems;
class TransactionUserController extends Controller
{
    public function userTransactions()
    {
        $userTransaction = auth()->user()->transactions()->where('is_deleted_by_user', false)->orderBy('created_at', 'desc')->get();

        return view('frontend.transaction-list', compact('userTransaction'));
    }


    public function userTransactionDetails($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('is_deleted_by_user', false)
            ->firstOrFail();

        $transactionItems = TransactionItems::where('transaction_id', $transaction->id)
            ->with('product')
            ->get();

        return view('frontend.transaction-details', compact('transaction', 'transactionItems'));
    }

    public function cancelTransaction($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('is_deleted_by_user', false)
            ->firstOrFail();

        if ($transaction->status === 'pending') {
            $transaction->status = 'cancelled';
            $transaction->save();

            return redirect()->route('user.transactions.index')->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->route('user.transactions.index')->with('error', 'Pesanan tidak dapat dibatalkan. Hanya pesanan dengan status pending yang dapat dibatalkan.');
    }

    public function deleteTransaction($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('is_deleted_by_user', false)
            ->firstOrFail();

        // Hanya bisa delete jika status cancelled atau completed atau failed
        if (!in_array($transaction->status, ['cancelled', 'completed', 'failed'])) {
            return redirect()->route('user.transactions.index')->with('error', 'Pesanan tidak dapat dihapus. Hanya pesanan yang dibatalkan, selesai, atau gagal yang dapat dihapus.');
        }

        // Hide transaction from user user instead of deleting
        $transaction->update(['is_deleted_by_user' => true]);

        return redirect()->route('user.transactions.index')->with('success', 'Riwayat pesanan berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $transactionIds = $request->input('transaction_ids');
        
        // Jika dikirim sebagai JSON string, decode terlebih dahulu
        if (is_string($transactionIds)) {
            $transactionIds = json_decode($transactionIds, true);
        }

        $request->merge(['transaction_ids' => $transactionIds]);
        
        $request->validate([
            'transaction_ids' => 'required|array|min:1',
            'transaction_ids.*' => 'integer|exists:transactions,id',
        ]);

        $transactions = Transaction::where('user_id', auth()->id())
            ->whereIn('id', $request->transaction_ids)
            ->whereIn('status', ['cancelled', 'completed', 'failed'])
            ->where('is_deleted_by_user', false)
            ->get();

        if ($transactions->isEmpty()) {
            return redirect()->route('user.transactions.index')->with('error', 'Tidak ada pesanan yang dapat dihapus.');
        }

        // Hide semua transactions sekaligus instead of deleting
        $deleted = Transaction::whereIn('id', $transactions->pluck('id'))->update(['is_deleted_by_user' => true]);

        return redirect()->route('user.transactions.index')->with('success', "$deleted riwayat pesanan berhasil dihapus.");
    }
}