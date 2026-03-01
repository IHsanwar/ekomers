<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItems;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ShippingOption;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan sudah install barryvdh/laravel-dompdf
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class TransactionController extends Controller
{
    public function checkout(Request $request)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'shipping_option_id' => 'required|exists:shipping_options,id',
        'address' => 'required|string|max:500',
    ]);

    $totalAmount = 0;

    foreach ($request->items as $item) {
        $product = Product::findOrFail($item['product_id']);
        $totalAmount += $product->price * $item['quantity'];
    }

    // Add shipping cost to total
    $shippingOption = ShippingOption::findOrFail($request->input('shipping_option_id'));
    $totalAmount += $shippingOption->cost;

    // invoice unik
    $invoiceCode = 'INV-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6));

    DB::beginTransaction();
    try {
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_method' => 'midtrans',
            'invoice_code' => $invoiceCode,
            'shipping_option_id' => $request->input('shipping_option_id'),
            'address' => $request->input('address'),
        ]);

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);

            TransactionItems::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        DB::commit();

        return redirect()->route('payment.pay', $transaction->id);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error($e->getMessage());
        return response()->json(['error' => 'Checkout failed'], 500);
    }
}

    
    public function checkoutPage()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();
        
        $shippingOptions = ShippingOption::all();

        return view('frontend.checkout', compact('cartItems', 'shippingOptions'));
    }

    public function generateReport(Request $request)
{
    $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
    $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

    $transactions = Transaction::with('user')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->orderBy('created_at', 'desc')
        ->get();

    $totalRevenue = $transactions->sum('total_amount');
    $totalRevenueMonthly = $transactions->groupBy(function($transaction) {
        return Carbon::parse($transaction->created_at)->format('Y-m');
    })->map(function($group) {
        return $group->sum('total_amount');
    });
    $pdf = Pdf::loadView('admin.transactions.report', compact('transactions', 'totalRevenue', 'totalRevenueMonthly', 'startDate', 'endDate'))
              ->setPaper('A4', 'portrait');

    return $pdf->download("laporan-transaksi-$startDate-$endDate.pdf");
}
    public function generateInvoice(Transaction $transaction)
{
    $this->authorize('view', $transaction); // pastikan user hanya bisa lihat miliknya sendiri

    $transaction->load('user', 'items.product');

    $pdf = Pdf::loadView('user.transactions.invoice', compact('transaction'))
              ->setPaper('A4', 'portrait');

    return $pdf->download("invoice-{$transaction->id}.pdf");
}

    public function printInvoice(Transaction $transaction)
    {
        // Pastikan hanya pemilik transaksi yang bisa melihat
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $pdf = Pdf::loadView('admin.transactions.invoice', compact('transaction'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('Invoice-' . $transaction->invoice_code . '.pdf');
    }
    public function destroy(Transaction $transaction)
    {
        // Hapus transaksi beserta item-itemnya
        $transaction->deleteRecords();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus beserta item-itemnya.');

    }

}
