<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\TransactionItems;
use App\Models\Product;
class DashboardController extends Controller
{
     public function index()
    {
        // Statistik utama
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total_amount');
        $totalRevenueMonthly = Transaction::whereMonth('created_at', Carbon::now()->month)->sum('total_amount');

        // Statistik berdasarkan status transaksi
        $pendingCount = Transaction::where('status', 'pending')->count();
        $completedCount = Transaction::where('status', 'completed')->count();
        $failedCount = Transaction::where('status', 'failed')->count();

        // Produk
        $totalProducts = Product::count();
        $latestProducts = Product::latest()->take(5)->get();

        // Transaksi terbaru
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Grafik pendapatan 7 hari terakhir
        $revenueData = Transaction::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        return view('admin.dashboard.index', [
            'totalUsers' => $totalUsers,
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'pendingCount' => $pendingCount,
            'completedCount' => $completedCount,
            'failedCount' => $failedCount,
            'totalProducts' => $totalProducts,
            'latestProducts' => $latestProducts,
            'recentTransactions' => $recentTransactions,
            'revenueData' => $revenueData,
            'totalRevenueMonthly' => $totalRevenueMonthly,
        ]);
    }

    public function updateStatus(Transaction $transaction, $status)
    {
        $validStatuses = ['pending', 'confirmed', 'shipped', 'completed', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return back()->with('error', 'Status tidak valid.');
        }

        $transaction->update(['status' => $status]);

        return back()->with('success', "Status transaksi #{$transaction->invoice_code} diubah menjadi {$status}.");
    }


// Transaction Page and management
    public function transactionPage()
    {
        $transactions = Transaction::with('user')->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function transactionDetail(Transaction $transaction)
    {
        $transaction->load('user', 'items.product');
        return view('admin.transactions.detail', compact('transaction'));
    }

    public function transactionUpdateShippingDetails(Request $request, Transaction $transaction)
    {
        $request->validate([
            'shipping_option_id' => 'required|exists:shipping_options,id',
        ]);

        $transaction->update([
            'shipping_option_id' => $request->shipping_option_id,
        ]);

        return back()->with('success', 'Detail pengiriman berhasil diperbarui.');
    }

    public function bulkDeleteTransactions(Request $request)
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

        // Get all transactions yang akan dihapus
        $transactions = Transaction::whereIn('id', $request->transaction_ids)
            ->whereIn('status', ['cancelled', 'completed', 'failed'])
            ->get();

        if ($transactions->isEmpty()) {
            return back()->with('error', 'Tidak ada transaksi yang dapat dihapus.');
        }

        // Delete transaction items terlebih dahulu
        TransactionItems::whereIn('transaction_id', $transactions->pluck('id'))->delete();

        // Delete semua transactions sekaligus
        $deleted = Transaction::whereIn('id', $transactions->pluck('id'))->delete();

        return back()->with('success', "$deleted transaksi berhasil dihapus.");
    }

    // Update Shipping Status dengan nomor resi
    public function updateShippingStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'shipping_code' => 'required|string|max:255',
            'shipping_status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);

        $updateData = [
            'shipping_code' => $request->shipping_code,
            'shipping_status' => $request->shipping_status,
        ];

        // Set timestamp saat barang dikirim
        if ($request->shipping_status === 'shipped') {
            $updateData['shipped_at'] = now();
        }

        // Set timestamp saat barang tiba
        if ($request->shipping_status === 'delivered') {
            $updateData['delivered_at'] = now();
            $updateData['status'] = 'completed'; // Update status transaksi jika pengiriman selesai
        }

        $transaction->update($updateData);

        return back()->with('success', "Status pengiriman untuk transaksi #{$transaction->invoice_code} berhasil diperbarui ke '{$request->shipping_status}' dengan nomor resi: {$request->shipping_code}");
    }
}

