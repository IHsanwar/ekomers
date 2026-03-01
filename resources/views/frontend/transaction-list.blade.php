@extends('layouts.frontend')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900 mb-4">
            <i class="fa-solid fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    <i class="fa-solid fa-receipt mr-2 text-primary-600"></i>Your Transactions
                </h1>
                <p class="text-slate-500 mt-1">View and manage your order history</p>
            </div>
            <!-- Bulk Delete Actions -->
            <div id="bulkActions" class="hidden flex gap-3">
                <span class="text-sm text-slate-600"><span id="selectedCount">0</span> selected</span>
                <form id="bulkDeleteForm" action="{{ route('user.transactions.bulk-delete') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" id="bulkIds" name="transaction_ids" value="">
                    <button type="submit" class="btn-outline btn-sm text-red-600 hover:bg-red-50" 
                            onclick="return confirm('Hapus riwayat pesanan terpilih secara permanen?')">
                        <i class="fa-solid fa-trash mr-1.5"></i>Delete Selected
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if($userTransaction->isEmpty())
        <!-- Empty State -->
        <div class="card">
            <div class="empty-state py-16">
                <i class="fa-solid fa-inbox empty-state-icon"></i>
                <h3 class="empty-state-title">No transactions yet</h3>
                <p class="empty-state-description">You haven't made any purchases yet. Start shopping now!</p>
                <a href="{{ route('product.index') }}" class="btn-primary">
                    <i class="fa-solid fa-grid-2 mr-2"></i>Browse Products
                </a>
            </div>
        </div>
    @else
        <div class="space-y-4">
            @foreach($userTransaction as $transaction)
                <div class="card p-4 md:p-6 hover:shadow-lg transition-shadow transaction-item">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <!-- Checkbox -->
                        @if(in_array($transaction->status, ['cancelled', 'completed', 'failed']))
                            <div class="md:col-span-1">
                                <input type="checkbox" class="transaction-checkbox" value="{{ $transaction->id }}" />
                            </div>
                        @else
                            <div class="md:col-span-1"></div>
                        @endif

                        <!-- Transaction ID & Date -->
                        <div class="md:col-span-2">
                            <p class="text-sm text-slate-500 mb-1">Transaction ID</p>
                            <p class="font-semibold text-slate-900">#{{ $transaction->id }}</p>
                            <p class="text-xs text-slate-400 mt-2">
                                <i class="fa-solid fa-calendar mr-1"></i>{{ $transaction->created_at->format('d M Y H:i') }}
                            </p>
                        </div>

                        <!-- Total Amount -->
                        <div class="md:col-span-2">
                            <p class="text-sm text-slate-500 mb-1">Total Amount</p>
                            <p class="text-xl font-bold text-primary-600">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Status Badge -->
                        <div class="md:col-span-2">
                            <p class="text-sm text-slate-500 mb-1">Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($transaction->status === 'completed')
                                    bg-green-100 text-green-800
                                @elseif($transaction->status === 'pending')
                                    bg-yellow-100 text-yellow-800
                                @elseif($transaction->status === 'failed')
                                    bg-red-100 text-red-800
                            
                                @elseif($transaction->status === 'paid')
                                    bg-green-100 text-green-800
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
                                @else
                                    fa-circle mr-2
                                @endif
                                "></i>
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="md:col-span-3 flex gap-2 justify-end flex-wrap">
                            <a href="{{ route('user.transactions.details', $transaction->id) }}" 
                               class="btn-primary btn-sm">
                                <i class="fa-solid fa-eye mr-1.5"></i>View Details
                            </a>
                            
                            @if($transaction->status === 'completed')
                                <a href="{{ route('transactions.invoice.download', $transaction->id) }}" 
                                   class="btn-outline btn-sm">
                                    <i class="fa-solid fa-download mr-1.5"></i>Invoice
                                </a>
                            @endif
                            @if($transaction->status === 'pending')
                                <form action="{{ route('user.transactions.cancel', $transaction->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-outline btn-sm text-red-600 hover:bg-red-50" 
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                        <i class="fa-solid fa-ban mr-1.5"></i>Cancel
                                    </button>
                                </form>
                            @endif
                            @if(in_array($transaction->status, ['cancelled', 'completed', 'failed']))
                                <form action="{{ route('user.transactions.delete', $transaction->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline btn-sm text-red-600 hover:bg-red-50" 
                                            onclick="return confirm('Hapus riwayat pesanan ini secara permanen?')">
                                        <i class="fa-solid fa-trash mr-1.5"></i>Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    function updateBulkActions() {
        const checkboxes = document.querySelectorAll('.transaction-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        const bulkIds = document.getElementById('bulkIds');

        selectedCount.textContent = checkboxes.length;

        if (checkboxes.length > 0) {
            bulkActions.classList.remove('hidden');
            const ids = Array.from(checkboxes).map(cb => cb.value);
            bulkIds.value = JSON.stringify(ids);
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    document.querySelectorAll('.transaction-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
</script>
@endsection