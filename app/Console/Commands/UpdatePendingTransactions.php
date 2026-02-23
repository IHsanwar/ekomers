<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Services\TransactionService;

class UpdatePendingTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update pending transaction statuses from Midtrans API';

    protected $transactionService;

    public function __construct(TransactionService $transactionService) {
        parent::__construct();
        $this->transactionService = $transactionService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking pending transactions...');

        $transactions = Transaction::where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(1)) // Give user time to complete payment
            ->get();

        if ($transactions->isEmpty()) {
            $this->info('No pending transactions found.');
            return;
        }

        foreach ($transactions as $transaction) {
            $this->info("Checking transaction: {$transaction->invoice_code}");
            $this->transactionService->checkAndUpdateStatus($transaction);
        }

        $this->info('Pending transactions updated.');
    }
}
