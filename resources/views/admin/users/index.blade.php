@extends('layouts.admin')

@section('page-title', 'User Management')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-900">User Management</h2>
        <p class="text-sm text-slate-500 mt-1">Manage and monitor all user accounts</p>
    </div>
</div>

<!-- Alert Messages -->
@if ($errors->any())
    <div class="mb-4 card border-red-200 bg-red-50 p-4">
        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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

<!-- Users Table Card -->
<div class="card">
    <!-- Card Header -->
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <h3 class="font-semibold text-slate-900">All Users</h3>
            <span class="inline-flex items-center justify-center h-7 px-4 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                {{ $users->total() }} total
            </span>
        </div>

        <!-- Bulk Delete Actions -->
        <div id="bulkUserActions" class="hidden flex gap-3 items-center">
            <span class="text-sm text-slate-600"><span id="userSelectedCount">0</span> selected</span>
            <form id="bulkDeleteForm" action="{{ route('admin.users.bulk-delete') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" id="bulkUserIds" name="user_ids" value="">
                <button type="submit" class="btn btn-destructive btn-sm"
                        onclick="return confirm('Delete selected user(s) permanently?')">
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
                        <input type="checkbox" id="selectAllUsers" class="w-4 h-4 rounded" />
                    </th>
                    <th class="table-head">Name</th>
                    <th class="table-head">Email</th>
                    <th class="table-head">Role</th>
                    <th class="table-head">Joined</th>
                    <th class="table-head text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse($users as $user)
                <tr class="table-row">
                    <td class="table-cell">
                        <input type="checkbox" class="user-checkbox w-4 h-4 rounded" value="{{ $user->id }}" />
                    </td>
                    <td class="table-cell">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center text-white font-semibold text-sm bg-gradient-to-br from-primary-600 to-primary-700">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-slate-900">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="table-cell">
                        <span class="text-sm text-slate-600">{{ $user->email }}</span>
                    </td>
                    <td class="table-cell">
                        @if($user->role === 'admin')
                            <span class="badge badge-warning">
                                <i class="fa-solid fa-crown text-xs mr-1"></i>{{ ucfirst($user->role) }}
                            </span>
                        @else
                            <span class="badge badge-secondary">
                                {{ ucfirst($user->role) }}
                            </span>
                        @endif
                    </td>
                    <td class="table-cell">
                        <span class="text-sm text-slate-500">{{ $user->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="table-cell">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Edit Role Button -->
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="btn btn-ghost btn-sm"
                               title="Edit role">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete user {{ $user->name }}? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-ghost btn-sm text-red-600 hover:bg-red-50"
                                        title="Delete user">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="table-cell">
                        <div class="empty-state">
                            <i class="fa-solid fa-users empty-state-icon"></i>
                            <h3 class="empty-state-title">No users found</h3>
                            <p class="empty-state-description">Start adding users to your application.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="p-4 border-t border-slate-200 flex items-center justify-between">
        <div class="text-xs text-slate-500">
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
        </div>
        <div class="flex gap-2">
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>

<script>
// Handle select all checkbox
const selectAllCheckbox = document.getElementById('selectAllUsers');
const userCheckboxes = document.querySelectorAll('.user-checkbox');

if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });
}

// Handle individual checkbox changes
userCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allChecked = Array.from(userCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(userCheckboxes).some(cb => cb.checked);

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        }

        updateBulkActions();
    });
});

// Update bulk actions display
function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
    const bulkActions = document.getElementById('bulkUserActions');
    const selectedCount = document.getElementById('userSelectedCount');
    const bulkIds = document.getElementById('bulkUserIds');

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
