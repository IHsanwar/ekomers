@extends('layouts.admin')

@php
    use App\Helpers\TransactionStatusHelper;
@endphp

@section('page-title', 'Transaction Detail')

@section('content')
<!-- Header -->
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.transactions.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-slate-900">{{ $transaction->invoice_code }}</h2>
        <p class="text-sm text-slate-500 mt-1">Transaction details and shipping information</p>
    </div>
</div>

<!-- Alerts -->
@if (session('success'))
    <div class="toast-success mb-4">
        <i class="fa-solid fa-check toast-icon"></i>
        <div>
            <div class="toast-title">Success</div>
            <div class="toast-description">{{ session('success') }}</div>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="toast-error mb-4">
        <i class="fa-solid fa-exclamation-circle toast-icon"></i>
        <div>
            <div class="toast-title">Error</div>
            <div class="toast-description">{{ session('error') }}</div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Transaction Info Card -->
        <div class="card">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-receipt mr-2 text-slate-400"></i>Transaction Information
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Customer Name</p>
                        <p class="font-semibold text-slate-900 mt-2">{{ $transaction->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Email</p>
                        <p class="font-medium text-slate-600 mt-2">{{ $transaction->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Total Amount</p>
                        <p class="font-semibold text-emerald-600 text-lg mt-2">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Transaction Date</p>
                        <p class="text-slate-600 mt-2">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Payment Method</p>
                        <p class="text-slate-600 mt-2">{{ $transaction->payment_method ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Status</p>
                        <div class="mt-2">
                            @php
                                $status = TransactionStatusHelper::getStatus($transaction->status);
                            @endphp
                            <span class="{{ 'badge ' . $status['badge_class'] }}">
                                <i class="{{ 'fa-solid ' . $status['icon_fa'] . ' text-xs mr-1' }}"></i>{{ $status['label'] }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($transaction->address)
                    <div class="mt-6 pt-6 border-t border-slate-200">
                        <p class="text-xs font-semibold text-slate-500 uppercase">Shipping Address</p>
                        <p class="text-slate-900 mt-2">{{ $transaction->address }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Items Detail Card -->
        <div class="card">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-box mr-2 text-slate-400"></i>Product Details
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="table-header bg-slate-50">
                        <tr>
                            <th class="table-head">Product</th>
                            <th class="table-head text-right">Quantity</th>
                            <th class="table-head text-right">Price</th>
                            <th class="table-head text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach($transaction->items as $item)
                        <tr class="table-row">
                            <td class="table-cell">
                                <span class="font-semibold text-slate-900">{{ $item->product->name }}</span>
                            </td>
                            <td class="table-cell text-right">{{ $item->quantity }}</td>
                            <td class="table-cell text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="table-cell text-right">
                                <span class="font-semibold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Shipping Status Card -->
        <div class="card">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-truck mr-2 text-slate-400"></i>Shipping Status
                </h3>
            </div>
            <div class="p-6">
                @if($transaction->shipping_code)
                    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 mb-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Tracking Number</p>
                        <p class="font-bold text-emerald-600 text-lg">{{ $transaction->shipping_code }}</p>

                        <p class="text-xs font-semibold text-slate-500 uppercase mt-3 mb-2">Status</p>
                        <div class="space-y-2">
                            @if($transaction->shipping_status === 'pending')
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-amber-600"></i>
                                    <span class="text-amber-600 font-semibold">Waiting for Pickup</span>
                                </div>
                            @elseif($transaction->shipping_status === 'shipped')
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-truck text-blue-600"></i>
                                    <span class="text-blue-600 font-semibold">In Transit</span>
                                </div>
                                @if($transaction->shipped_at)
                                    <p class="text-xs text-slate-600">Shipped: {{ $transaction->shipped_at->format('d M Y H:i') }}</p>
                                @endif
                            @elseif($transaction->shipping_status === 'delivered')
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-check-circle text-emerald-600"></i>
                                    <span class="text-emerald-600 font-semibold">Delivered</span>
                                </div>
                                @if($transaction->delivered_at)
                                    <p class="text-xs text-slate-600">Delivered: {{ $transaction->delivered_at->format('d M Y H:i') }}</p>
                                @endif
                            @elseif($transaction->shipping_status === 'cancelled')
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-ban text-red-600"></i>
                                    <span class="text-red-600 font-semibold">Cancelled</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4 flex gap-3">
                        <i class="fa-solid fa-exclamation-triangle text-amber-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-amber-900 font-semibold text-sm">No Tracking Number</p>
                            <p class="text-xs text-amber-800 mt-1">Please add a tracking number using the form below</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Update Shipping Form -->
        <div class="card">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-edit mr-2 text-slate-400"></i>Update Shipping
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.transactions.update-shipping', $transaction->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="shipping_code" class="text-sm font-semibold text-slate-900">
                            Tracking Number
                        </label>
                        <input type="text"
                               id="shipping_code"
                               name="shipping_code"
                               value="{{ $transaction->shipping_code }}"
                               placeholder="e.g: JNE123456789"
                               class="input mt-2 w-full @error('shipping_code') input-error @enderror"
                               required>
                        @error('shipping_code')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="shipping_status" class="text-sm font-semibold text-slate-900">
                            Shipping Status
                        </label>
                        <select id="shipping_status"
                                name="shipping_status"
                                class="input mt-2 w-full @error('shipping_status') input-error @enderror"
                                required>
                            <option value="">-- Select Status --</option>
                            <option value="pending" @selected($transaction->shipping_status === 'pending')>Waiting for Pickup</option>
                            <option value="shipped" @selected($transaction->shipping_status === 'shipped')>In Transit</option>
                            <option value="delivered" @selected($transaction->shipping_status === 'delivered')>Delivered</option>
                            <option value="cancelled" @selected($transaction->shipping_status === 'cancelled')>Cancelled</option>
                        </select>
                        @error('shipping_status')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fa-solid fa-save"></i>Save & Notify Customer
                    </button>
                </form>

                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-xs text-blue-900">
                        <i class="fa-solid fa-info-circle mr-2"></i>
                        <strong>Note:</strong> Shipping information will be saved and the customer will be notified via email.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
