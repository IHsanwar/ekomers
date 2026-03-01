@extends('layouts.stitch-admin')

@section('header', 'Dashboard Overview')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Transactions -->
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-blue-500/10 rounded-xl">
                <span class="material-icons-round text-blue-500">receipt_long</span>
            </div>
            <!-- Placeholder trend -->
            <span class="flex items-center text-secondary text-xs font-bold">
                <span class="material-icons-round text-sm mr-1">trending_up</span>
                +5%
            </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Transactions</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($totalTransactions) }}</h3>
    </div>

    <!-- Total Revenue -->
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-secondary/10 rounded-xl">
                <span class="material-icons-round text-secondary">payments</span>
            </div>
            <span class="flex items-center text-secondary text-xs font-bold">
                <span class="material-icons-round text-sm mr-1">trending_up</span>
                +12%
            </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Revenue</p>
        <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>

    <!-- Pending Orders -->
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-amber-500/10 rounded-xl">
                <span class="material-icons-round text-amber-500">pending_actions</span>
            </div>
            <span class="flex items-center text-amber-500 text-xs font-bold">
                <span class="material-icons-round text-sm mr-1">schedule</span>
                Action Needed
            </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pending Orders</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($pendingCount) }}</h3>
    </div>

    <!-- Completed Orders -->
    <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-primary-admin/10 rounded-xl">
                <span class="material-icons-round text-primary-admin">check_circle</span>
            </div>
            <span class="flex items-center text-secondary text-xs font-bold">
                <span class="material-icons-round text-sm mr-1">verified</span>
                Success
            </span>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Completed Orders</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($completedCount) }}</h3>
    </div>
</div>

<!-- Recent Transactions -->
<div class="bg-surface-light dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
        <h4 class="font-bold text-lg">Recent Transactions</h4>
        <div class="flex gap-3">
            <!-- Bulk Delete Actions -->
            <div id="bulkAdminActions" class="hidden flex gap-3 items-center">
                <span class="text-sm text-slate-600"><span id="adminSelectedCount">0</span> selected</span>
                <form id="adminBulkDeleteForm" action="{{ route('admin.transactions.bulk-delete') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" id="adminBulkIds" name="transaction_ids" value="">
                    <button type="submit" class="px-3 py-1 text-sm bg-red-100 text-red-600 rounded hover:bg-red-200 transition" 
                            onclick="return confirm('Hapus transaksi terpilih secara permanen?')">
                        <i class="fa-solid fa-trash mr-1.5"></i>Delete Selected
                    </button>
                </form>
            </div>
            <button class="text-primary-admin text-sm font-bold hover:underline">View All</button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 w-12">
                        <input type="checkbox" id="adminSelectAll" class="rounded" />
                    </th>
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($recentTransactions as $t)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors admin-transaction-row">
                    <td class="px-6 py-4">
                        @if(in_array($t->status, ['cancelled', 'completed', 'failed']))
                            <input type="checkbox" class="admin-transaction-checkbox" value="{{ $t->id }}" />
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-400">{{ $t->invoice_code }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-xs font-bold">
                                <span class="material-icons-round text-slate-500 text-sm">person</span>
                            </div>
                            <span class="text-sm font-medium">{{ $t->user?->name ?? 'User #' . $t->user_id }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold">Rp {{ number_format($t->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400',
                                'confirmed' => 'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400',
                                'shipped' => 'bg-purple-100 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400',
                                'completed' => 'bg-secondary/10 text-secondary',
                                'cancelled' => 'bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400',
                            ];
                            $statusClass = $statusColors[$t->status] ?? 'bg-slate-100 text-slate-600';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                            <span class="w-1 h-1 rounded-full mr-2 {{ str_replace(['/10','/20'], '', $statusClass) }} bg-current opacity-50"></span>
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                        {{ $t->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                             <form action="{{ route('admin.transactions.update-status', [$t, 'confirmed']) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded transition-colors text-blue-500" title="Confirm">
                                    <span class="material-icons-round text-sm">check</span>
                                </button>
                            </form>
                            <form action="{{ route('admin.transactions.update-status', [$t, 'shipped']) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded transition-colors text-purple-500" title="Ship">
                                    <span class="material-icons-round text-sm">local_shipping</span>
                                </button>
                            </form>
                            <form action="{{ route('admin.transactions.update-status', [$t, 'completed']) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded transition-colors text-secondary" title="Complete">
                                    <span class="material-icons-round text-sm">check_circle</span>
                                </button>
                            </form>
                            <form action="{{ route('admin.transactions.update-status', [$t, 'cancelled']) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded transition-colors text-red-500" title="Cancel">
                                    <span class="material-icons-round text-sm">cancel</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                     <td colspan="7" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                        <span class="material-icons-round text-4xl mb-2 opacity-20">inbox</span>
                        <p>No transactions yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function updateAdminBulkActions() {
        const checkboxes = document.querySelectorAll('.admin-transaction-checkbox:checked');
        const bulkActions = document.getElementById('bulkAdminActions');
        const selectedCount = document.getElementById('adminSelectedCount');
        const bulkIds = document.getElementById('adminBulkIds');

        selectedCount.textContent = checkboxes.length;

        if (checkboxes.length > 0) {
            bulkActions.classList.remove('hidden');
            const ids = Array.from(checkboxes).map(cb => cb.value);
            bulkIds.value = JSON.stringify(ids);
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    const selectAllCheckbox = document.getElementById('adminSelectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.admin-transaction-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
            });
            updateAdminBulkActions();
        });
    }

    document.querySelectorAll('.admin-transaction-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateAdminBulkActions);
    });
</script>
@endsection