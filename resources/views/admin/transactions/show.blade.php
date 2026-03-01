@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-6">
    <div class="mb-6">
        <a href="{{ route('admin.transactions.index') }}" class="text-blue-600 hover:underline">
            ← Kembali ke Daftar Transaksi
        </a>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Transaction Info -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">{{ $transaction->invoice_code }}</h2>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600 text-sm">Nama Pelanggan</p>
                        <p class="font-semibold text-lg">{{ $transaction->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Email</p>
                        <p class="font-semibold">{{ $transaction->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total Belanja</p>
                        <p class="font-semibold text-lg text-green-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Tanggal Transaksi</p>
                        <p class="font-semibold">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Metode Pembayaran</p>
                        <p class="font-semibold">{{ $transaction->payment_method ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Status Transaksi</p>
                        <p class="font-semibold">
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
                        </p>
                    </div>
                </div>

                @if($transaction->address)
                    <div class="border-t pt-4">
                        <p class="text-gray-600 text-sm">Alamat Pengiriman</p>
                        <p class="font-semibold">{{ $transaction->address }}</p>
                    </div>
                @endif
            </div>

            <!-- Items Detail -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold mb-4">Detail Produk</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Produk</th>
                                <th class="px-4 py-2 text-right">Qty</th>
                                <th class="px-4 py-2 text-right">Harga</th>
                                <th class="px-4 py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->items as $item)
                                <tr class="border-b">
                                    <td class="px-4 py-2">
                                        <span class="font-semibold">{{ $item->product->name }}</span>
                                    </td>
                                    <td class="px-4 py-2 text-right">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right font-semibold">
                                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar - Shipping Info & Form -->
        <div class="lg:col-span-1">
            <!-- Current Shipping Status -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Status Pengiriman</h3>
                
                @if($transaction->shipping_code)
                    <div class="bg-green-50 border border-green-200 rounded p-4 mb-4">
                        <p class="text-gray-600 text-sm mb-1">Nomor Resi</p>
                        <p class="font-bold text-green-600 text-lg">{{ $transaction->shipping_code }}</p>
                        <p class="text-gray-600 text-sm mt-3 mb-1">Status</p>
                        <p class="font-semibold">
                            @if($transaction->shipping_status === 'pending')
                                <span class="text-yellow-600">Menunggu Pengiriman</span>
                            @elseif($transaction->shipping_status === 'shipped')
                                <span class="text-blue-600">Dalam Perjalanan</span>
                                @if($transaction->shipped_at)
                                    <br><small class="text-gray-600">Dikirim: {{ $transaction->shipped_at->format('d/m/Y H:i') }}</small>
                                @endif
                            @elseif($transaction->shipping_status === 'delivered')
                                <span class="text-green-600">Sudah Tiba</span>
                                @if($transaction->delivered_at)
                                    <br><small class="text-gray-600">Tiba: {{ $transaction->delivered_at->format('d/m/Y H:i') }}</small>
                                @endif
                            @elseif($transaction->shipping_status === 'cancelled')
                                <span class="text-red-600">Dibatalkan</span>
                            @endif
                        </p>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded p-4 mb-4">
                        <p class="text-yellow-600 font-semibold">⚠️ Belum ada nomor resi</p>
                        <p class="text-gray-600 text-sm mt-2">Silakan input nomor resi dan status pengiriman di form di bawah</p>
                    </div>
                @endif
            </div>

            <!-- Update Shipping Form -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Update Pengiriman</h3>
                
                <form action="{{ route('admin.transactions.update-shipping', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Nomor Resi</label>
                        <input type="text" 
                               name="shipping_code" 
                               value="{{ $transaction->shipping_code }}"
                               placeholder="Contoh: JNE123456789"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 @error('shipping_code') border-red-500 @enderror"
                               required>
                        @error('shipping_code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Status Pengiriman</label>
                        <select name="shipping_status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 @error('shipping_status') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Status --</option>
                            <option value="pending" @selected($transaction->shipping_status === 'pending')>Menunggu Pengiriman</option>
                            <option value="shipped" @selected($transaction->shipping_status === 'shipped')>Dalam Perjalanan</option>
                            <option value="delivered" @selected($transaction->shipping_status === 'delivered')>Sudah Tiba</option>
                            <option value="cancelled" @selected($transaction->shipping_status === 'cancelled')>Dibatalkan</option>
                        </select>
                        @error('shipping_status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                        💾 Simpan & Kirim ke Pelanggan
                    </button>
                </form>

                <p class="text-gray-600 text-xs mt-4 p-3 bg-blue-50 border border-blue-200 rounded">
                    📧 <strong>Catatan:</strong> Data pengiriman akan disimpan di sistem. 
                    Silakan hubungi pelanggan melalui WhatsApp atau email untuk memberikan informasi nomor resi.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
