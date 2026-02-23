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
        $userTransaction = auth()->user()->transactions()->orderBy('created_at', 'desc')->get();

        return view('frontend.transaction-list', compact('userTransaction'));
    }


    public function userTransactionDetails($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $transactionItems = TransactionItems::where('transaction_id', $transaction->id)
            ->with('product')
            ->get();

        return view('frontend.transaction-details', compact('transaction', 'transactionItems'));
    }
}