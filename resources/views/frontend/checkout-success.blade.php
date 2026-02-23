@extends('layouts.frontend')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Success Card -->
    <div class="card p-8 text-center">
        <!-- Success Icon -->
        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-check text-emerald-600 text-4xl"></i>
        </div>

        <h1 class="text-2xl font-bold text-slate-900 mb-2">Payment Successful!</h1>
        <p class="text-slate-500 mb-6">Thank you for your purchase. Your order has been confirmed.</p>

        <!-- Order Details -->
        <div class="bg-slate-50 rounded-lg p-6 text-left mb-8">
            <h2 class="font-semibold text-slate-900 mb-4">
                <i class="fa-solid fa-receipt mr-2 text-primary-600"></i>Order Details
            </h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-slate-500">Invoice Code</span>
                    <span class="font-mono font-semibold text-slate-900">{{ $transaction->invoice_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Total Amount</span>
                    <span class="font-semibold text-primary-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Status</span>
                    <x-badge variant="info">{{ ucfirst($transaction->status) }}</x-badge>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Date</span>
                    <span class="text-slate-900">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('transactions.print-invoice', $transaction->id) }}" class="btn-outline">
                <i class="fa-solid fa-file-invoice mr-2"></i>Download Invoice
            </a>
            <a href="{{ route('product.index') }}" class="btn-primary">
                <i class="fa-solid fa-cart-shopping mr-2"></i>Continue Shopping
            </a>
        </div>
    </div>

    <!-- Help Text -->
    <p class="text-center text-sm text-slate-500 mt-6">
        <i class="fa-solid fa-circle-info mr-1"></i>
        Need help? Contact our support team for assistance.
    </p>
</div>
@endsection
