<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;

class AutoCancelPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-cancel-pending-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically cancel pending orders that are older than 3 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Hitung waktu 3 hari lalu
        $threeDaysAgo = Carbon::now()->subDays(3);

        // Query semua order dengan status 'pending' yang dibuat lebih dari 3 hari lalu
        $cancelledCount = Transaction::where('status', 'pending')
            ->where('created_at', '<', $threeDaysAgo)
            ->update(['status' => 'cancelled']);

        if ($cancelledCount > 0) {
            $this->info("✓ Successfully cancelled $cancelledCount pending orders that are older than 3 days.");
        } else {
            $this->info("No pending orders older than 3 days found.");
        }

        return Command::SUCCESS;
    }
}
