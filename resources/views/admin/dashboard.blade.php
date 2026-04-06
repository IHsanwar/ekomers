@extends('layouts.admin')

@php
    use App\Helpers\TransactionStatusHelper;
@endphp

@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Transactions -->
    <div class="stat-card">
        <div class="flex justify-between items-start mb-4">
            <div class="stat-card-icon bg-blue-100 text-blue-600">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <span class="flex items-center text-blue-600 text-xs font-bold">
                <i class="fa-solid fa-arrow-trend-up mr-1"></i>+5%
            </span>
        </div>
        <p class="stat-card-label">Total Transactions</p>
        <h3 class="stat-card-value">{{ number_format($totalTransactions) }}</h3>
    </div>

    <!-- Total Revenue -->
    <div class="stat-card">
        <div class="flex justify-between items-start mb-4">
            <div class="stat-card-icon bg-emerald-100 text-emerald-600">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <span class="flex items-center text-emerald-600 text-xs font-bold">
                <i class="fa-solid fa-arrow-trend-up mr-1"></i>+12%
            </span>
        </div>
        <p class="stat-card-label">Total Revenue</p>
        <h3 class="stat-card-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>

    <!-- Pending Orders -->
    <div class="stat-card">
        <div class="flex justify-between items-start mb-4">
            <div class="stat-card-icon bg-amber-100 text-amber-600">
                <i class="fa-solid fa-clock"></i>
            </div>
            <span class="flex items-center text-amber-600 text-xs font-bold">
                <i class="fa-solid fa-exclamation mr-1"></i>Action Needed
            </span>
        </div>
        <p class="stat-card-label">Pending Orders</p>
        <h3 class="stat-card-value">{{ number_format($pendingCount) }}</h3>
    </div>

    <!-- Completed Orders -->
    <div class="stat-card">
        <div class="flex justify-between items-start mb-4">
            <div class="stat-card-icon bg-green-100 text-green-600">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <span class="flex items-center text-green-600 text-xs font-bold">
                <i class="fa-solid fa-check mr-1"></i>Success
            </span>
        </div>
        <p class="stat-card-label">Completed Orders</p>
        <h3 class="stat-card-value">{{ number_format($completedCount) }}</h3>
    </div>
</div>

<!-- Recent Transactions Section -->
<div class="card">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <h3 class="font-semibold text-slate-900 text-lg">
                <i class="fa-solid fa-list mr-2 text-slate-400"></i>Recent Transactions
            </h3>
        </div>
        <div class="flex gap-3">
            <!-- Bulk Delete Actions -->
            <div id="bulkAdminActions" class="hidden flex gap-3 items-center">
                <span class="text-sm text-slate-600"><span id="adminSelectedCount">0</span> selected</span>
                <form id="adminBulkDeleteForm" action="{{ route('admin.transactions.bulk-delete') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" id="adminBulkIds" name="transaction_ids" value="">
                    <button type="submit" class="btn btn-destructive btn-sm"
                            onclick="return confirm('Delete selected transaction(s) permanently?')">
                        <i class="fa-solid fa-trash"></i>Delete
                    </button>
                </form>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-right"></i>View All
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <thead class="table-header bg-slate-50">
                <tr>
                    <th class="table-head w-12">
                        <input type="checkbox" id="adminSelectAll" class="w-4 h-4 rounded" />
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
                        <input type="checkbox" class="admin-checkbox w-4 h-4 rounded" value="{{ $transaction->id }}" />
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
                        <div class="empty-state py-12">
                            <i class="fa-solid fa-inbox empty-state-icon"></i>
                            <h3 class="empty-state-title">No transactions yet</h3>
                            <p class="empty-state-description">Transactions will appear here</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// Handle select all checkbox
const adminSelectAllCheckbox = document.getElementById('adminSelectAll');
const adminCheckboxes = document.querySelectorAll('.admin-checkbox');

if (adminSelectAllCheckbox) {
    adminSelectAllCheckbox.addEventListener('change', function() {
        adminCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateAdminBulkActions();
    });
}

// Handle individual checkbox changes
adminCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allChecked = Array.from(adminCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(adminCheckboxes).some(cb => cb.checked);

        if (adminSelectAllCheckbox) {
            adminSelectAllCheckbox.checked = allChecked;
            adminSelectAllCheckbox.indeterminate = someChecked && !allChecked;
        }

        updateAdminBulkActions();
    });
});

// Update bulk actions display
function updateAdminBulkActions() {
    const checkedBoxes = document.querySelectorAll('.admin-checkbox:checked');
    const bulkActions = document.getElementById('bulkAdminActions');
    const selectedCount = document.getElementById('adminSelectedCount');
    const bulkIds = document.getElementById('adminBulkIds');

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
