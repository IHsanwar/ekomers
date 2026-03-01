@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manajemen Transaksi</h1>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200 text-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Invoice</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Customer</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Total</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Pengiriman</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">
                                <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="text-blue-600 hover:underline">
                                    {{ $transaction->invoice_code }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $transaction->user->name }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-600">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($transaction->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($transaction->status === 'shipped') bg-purple-100 text-purple-800
                                    @elseif($transaction->status === 'completed') bg-green-100 text-green-800
                                    @elseif($transaction->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($transaction->shipping_code)
                                    <span class="text-green-600 font-semibold">{{ $transaction->shipping_code }}</span>
                                    <br>
                                    <small class="text-gray-600">
                                        {{ ucfirst(str_replace('_', ' ', $transaction->shipping_status)) }}
                                    </small>
                                @else
                                    <span class="text-gray-400">Belum ada resi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <a href="{{ route('admin.transactions.show', $transaction->id) }}" 
                                   class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada transaksi ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
