@extends('layouts.frontend')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('user.transactions.index') }}" class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900 mb-4">
            <i class="fa-solid fa-arrow-left mr-2"></i>Back to Transactions
        </a>
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    <i class="fa-solid fa-receipt mr-2 text-primary-600"></i>Transaction Details
                </h1>
                <p class="text-slate-500 mt-1">Order #{{ $transaction->id }}</p>
            </div>
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                @if($transaction->status === 'completed')
                    bg-green-100 text-green-800
                @elseif($transaction->status === 'pending')
                    bg-yellow-100 text-yellow-800
                @elseif($transaction->status === 'failed')
                    bg-red-100 text-red-800
                @elseif($transaction->status === 'paid')
                    bg-gray-100 text-green-800
                @else
                    bg-slate-100 text-slate-800
                @endif
            ">
                <i class="fa-solid 
                @if($transaction->status === 'completed')
                    fa-circle-check mr-2
                @elseif($transaction->status === 'pending')
                    fa-clock mr-2
                @elseif($transaction->status === 'failed')
                    fa-circle-xmark mr-2
                @elseif($transaction->status === 'paid')
                    fa-check-circle mr-2
                @endif
                "></i>
                {{ ucfirst($transaction->status) }}
            </span>
        </div>
    </div>

    <!-- Transaction Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Date -->
        <div class="card p-4 md:p-6">
            <p class="text-sm text-slate-500 mb-2">
                <i class="fa-solid fa-calendar mr-2"></i>Date
            </p>
            <p class="text-lg font-semibold text-slate-900">
                {{ $transaction->created_at->format('d M Y') }}
            </p>
            <p class="text-xs text-slate-400 mt-1">{{ $transaction->created_at->format('H:i') }}</p>
        </div>

        <!-- Payment Method -->
        <div class="card p-4 md:p-6">
            <p class="text-sm text-slate-500 mb-2">
                <i class="fa-solid fa-credit-card mr-2"></i>Payment Method
            </p>
            <p class="text-lg font-semibold text-slate-900">
                {{ ucfirst($transaction->payment_method) }}
            </p>
        </div>

        <!-- Total Amount -->
        <div class="card p-4 md:p-6 bg-primary-50 border border-primary-200">
            <p class="text-sm text-primary-600 font-medium mb-2">
                <i class="fa-solid fa-wallet mr-2"></i>Total Amount
            </p>
            <p class="text-2xl font-bold text-primary-600">
                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card mb-6">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">
                <i class="fa-solid fa-box mr-2 text-slate-400"></i>Order Items
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead class="table-header bg-slate-50">
                    <tr>
                        <th class="table-head">Product</th>
                        <th class="table-head text-right">Price</th>
                        <th class="table-head text-center">Quantity</th>
                        <th class="table-head text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @foreach($transactionItems as $item)
                        <tr class="table-row">
                            <td class="table-cell">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item->product->images->first()?->image_url ?? '/images/default.png' }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $item->product->name }}</p>
                                        <p class="text-xs text-slate-500">SKU: {{ $item->product->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="table-cell text-right text-slate-600">
                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </td>
                            <td class="table-cell text-center text-slate-900 font-medium">
                                {{ $item->quantity }}
                            </td>
                            <td class="table-cell text-right font-semibold text-slate-900">
                                Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Summary -->
        <div class="p-6 border-t border-slate-200">
            <div class="space-y-2 text-right">
                <div class="flex justify-end items-center text-slate-600">
                    <span>Subtotal:</span>
                    <span class="ml-4 font-medium">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-end items-center pt-4 border-t border-slate-200">
                    <span class="font-semibold text-slate-900">Total:</span>
                    <span class="ml-4 text-2xl font-bold text-primary-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="card p-6">
        <div class="flex flex-col sm:flex-row gap-3 justify-between items-start sm:items-center">
            <p class="text-sm text-slate-500">
                <i class="fa-solid fa-info-circle mr-2"></i>Need help? Contact our support team for assistance.
            </p>
            <div class="flex gap-3 flex-wrap">
                @if($transaction->status === 'completed')
                    <a href="{{ route('transactions.invoice.download', $transaction->id) }}" 
                       class="btn-primary btn-sm">
                        <i class="fa-solid fa-download mr-1.5"></i>Download Invoice
                    </a>
                @endif
                
                @if($transaction->status === 'pending')
                    <form action="{{ route('user.transactions.cancel', $transaction->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-outline btn-sm text-red-600 hover:bg-red-50" 
                                onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                            <i class="fa-solid fa-ban mr-1.5"></i>Cancel Order
                        </button>
                    </form>
                @endif

                @if(in_array($transaction->status, ['cancelled', 'completed', 'failed']))
                    <form action="{{ route('user.transactions.delete', $transaction->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-outline btn-sm text-red-600 hover:bg-red-50" 
                                onclick="return confirm('Hapus riwayat pesanan ini secara permanen?')">
                            <i class="fa-solid fa-trash mr-1.5"></i>Delete History
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('user.transactions.index') }}" 
                   class="btn-outline btn-sm">
                    <i class="fa-solid fa-arrow-left mr-1.5"></i>Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
