@extends('layouts.admin')

@php
    use App\Helpers\TransactionStatusHelper;
@endphp

@section('page-title', 'Transaction Management')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Transaction Management</h2>
        <p class="text-sm text-slate-500 mt-1">Manage and monitor all transactions</p>
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

<!-- Transactions Card -->
<div class="card">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <h3 class="font-semibold text-slate-900">All Transactions</h3>
        <div id="bulkTransactionActions" class="hidden flex gap-3 items-center">
            <span class="text-sm text-slate-600"><span id="transactionSelectedCount">0</span> selected</span>
            <form id="bulkTransactionDeleteForm" action="{{ route('admin.transactions.bulk-delete') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" id="bulkTransactionIds" name="transaction_ids" value="">
                <button type="submit" class="btn btn-destructive btn-sm"
                        onclick="return confirm('Delete selected transaction(s) permanently?')">
                    <i class="fa-solid fa-trash"></i>Delete Selected
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="table">
            <thead class="table-header bg-slate-50">
                <tr>
                    <th class="table-head w-12">
                        <input type="checkbox" id="selectAllTransactions" class="w-4 h-4 rounded" />
                    </th>
                    <th class="table-head">Invoice</th>
                    <th class="table-head">Customer</th>
                    <th class="table-head">Amount</th>
                    <th class="table-head">Status</th>
                    <th class="table-head">Shipping</th>
                    <th class="table-head">Date</th>
                    <th class="table-head text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse($transactions as $transaction)
                <tr class="table-row">
                    <td class="table-cell">
                        <input type="checkbox" class="transaction-checkbox w-4 h-4 rounded" value="{{ $transaction->id }}" />
                    </td>
                    <td class="table-cell">
                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="text-primary-600 hover:underline font-semibold">
                            {{ $transaction->invoice_code }}
                        </a>
                    </td>
                    <td class="table-cell">
                        <span class="font-medium text-slate-900">{{ $transaction->user->name }}</span>
                    </td>
                    <td class="table-cell">
                        <span class="font-semibold text-emerald-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </td>
                    <td class="table-cell">
                        @php
                            $status = TransactionStatusHelper::getStatus($transaction->status);
                        @endphp
                        <span class="{{ 'badge ' . $status['badge_class'] }}">
                            <i class="{{ 'fa-solid ' . $status['icon_fa'] . ' text-xs mr-1' }}"></i>{{ $status['label'] }}
                        </span>
                    </td>
                    <td class="table-cell">
                        @if($transaction->shipping_code)
                            <div>
                                <p class="font-semibold text-emerald-600">{{ $transaction->shipping_code }}</p>
                                <p class="text-xs text-slate-500">{{ ucfirst(str_replace('_', ' ', $transaction->shipping_status)) }}</p>
                            </div>
                        @else
                            <span class="text-slate-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="table-cell text-sm text-slate-600">
                        {{ $transaction->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="table-cell text-right">
                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-ghost btn-sm">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="table-cell">
                        <div class="empty-state">
                            <i class="fa-solid fa-inbox empty-state-icon"></i>
                            <h3 class="empty-state-title">No transactions found</h3>
                            <p class="empty-state-description">Transactions will appear here</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($transactions, 'hasPages') && $transactions->hasPages())
    <div class="p-4 border-t border-slate-200 flex items-center justify-between">
        <div class="text-xs text-slate-500">
            Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} transactions
        </div>
        <div class="flex gap-2">
            {{ $transactions->links() }}
        </div>
    </div>
    @endif
</div>

<script>
// Handle select all checkbox
const selectAllCheckbox = document.getElementById('selectAllTransactions');
const transactionCheckboxes = document.querySelectorAll('.transaction-checkbox');

if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function() {
        transactionCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateTransactionBulkActions();
    });
}

// Handle individual checkbox changes
transactionCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allChecked = Array.from(transactionCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(transactionCheckboxes).some(cb => cb.checked);

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        }

        updateTransactionBulkActions();
    });
});

// Update bulk actions display
function updateTransactionBulkActions() {
    const checkedBoxes = document.querySelectorAll('.transaction-checkbox:checked');
    const bulkActions = document.getElementById('bulkTransactionActions');
    const selectedCount = document.getElementById('transactionSelectedCount');
    const bulkIds = document.getElementById('bulkTransactionIds');

    selectedCount.textContent = checkedBoxes.length;

    if (checkedBoxes.length > 0) {
        bulkActions.classList.remove('hidden');
        const ids = Array.from(checkedBoxes).map(cb => cb.value);
        bulkIds.value = JSON.stringify(ids);
    } else {
        bulkActions.classList.add('hidden');
    }
}
</script>
@endsection
