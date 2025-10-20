@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-sm font-medium text-gray-500">Total Transaksi</h3>
        <p class="text-2xl font-bold">{{ number_format($totalTransactions) }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-sm font-medium text-gray-500">Total Pendapatan</h3>
        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-sm font-medium text-gray-500">Pending</h3>
        <p class="text-2xl font-bold text-yellow-600">{{ number_format($pendingCount) }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-sm font-medium text-gray-500">Selesai</h3>
        <p class="text-2xl font-bold text-blue-600">{{ number_format($completedCount) }}</p>
    </div>
</div>

<h2 class="text-xl font-bold mb-4">Transaksi Terbaru</h2>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($recentTransactions as $t)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $t->invoice_code }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ $t->user?->name ?? 'User #' . $t->user_id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">Rp {{ number_format($t->total_amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $t->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $t->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $t->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                        {{ $t->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $t->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($t->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $t->created_at->format('d M Y H:i') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex space-x-1">
                        <form action="{{ route('admin.transactions.update-status', [$t, 'confirmed']) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">Konfirmasi</button>
                        </form>
                        <form action="{{ route('admin.transactions.update-status', [$t, 'shipped']) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded hover:bg-purple-200">Dikirim</button>
                        </form>
                        <form action="{{ route('admin.transactions.update-status', [$t, 'completed']) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200">Selesai</button>
                        </form>
                        <form action="{{ route('admin.transactions.update-status', [$t, 'cancelled']) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">Batalkan</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection