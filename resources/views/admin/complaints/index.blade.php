@extends('layouts.admin')

@section('page-title', 'Complaint Management')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Complaint Management</h2>
        <p class="text-sm text-slate-500 mt-1">Review and manage customer complaints</p>
    </div>
</div>

<!-- Alerts -->
@if(session('success'))
    <div class="toast-success mb-4">
        <i class="fa-solid fa-check toast-icon"></i>
        <div>
            <div class="toast-title">Success</div>
            <div class="toast-description">{{ session('success') }}</div>
        </div>
    </div>
@endif

<!-- Complaints Card -->
<div class="card">
    <!-- Card Header -->
    <div class="p-6 border-b border-slate-200">
        <h3 class="font-semibold text-slate-900">All Complaints</h3>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="table">
            <thead class="table-header bg-slate-50">
                <tr>
                    <th class="table-head">Complaint ID</th>
                    <th class="table-head">Invoice / Customer</th>
                    <th class="table-head">Reason</th>
                    <th class="table-head">Type</th>
                    <th class="table-head">Date</th>
                    <th class="table-head">Status</th>
                    <th class="table-head text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse($complaints as $complaint)
                <tr class="table-row">
                    <td class="table-cell">
                        <span class="font-medium text-slate-900">#CMP-{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="table-cell">
                        <div>
                            <p class="font-medium text-slate-900">{{ $complaint->transaction->invoice_code }}</p>
                            <p class="text-xs text-slate-500">{{ $complaint->user->name }}</p>
                        </div>
                    </td>
                    <td class="table-cell">
                        <span class="text-slate-600">{{ $complaint->reason_category }}</span>
                    </td>
                    <td class="table-cell">
                        <span class="text-slate-600">
                            {{ $complaint->action_type == 'refund' ? 'Refund' : 'Replacement' }}
                        </span>
                    </td>
                    <td class="table-cell">
                        <span class="text-sm text-slate-600">{{ $complaint->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="table-cell">
                        <span class="badge
                            @switch($complaint->status)
                                @case('pending') badge-warning @break
                                @case('reviewed') badge-info @break
                                @case('approved') badge-success @break
                                @case('rejected') badge-danger @break
                                @case('resolved') badge-secondary @break
                            @endswitch
                        ">
                            <i class="fa-solid
                                @switch($complaint->status)
                                    @case('pending') fa-clock @break
                                    @case('reviewed') fa-eye @break
                                    @case('approved') fa-check-circle @break
                                    @case('rejected') fa-times-circle @break
                                    @case('resolved') fa-check-double @break
                                @endswitch
                            text-xs mr-1"></i>
                            {{ ucfirst($complaint->status) }}
                        </span>
                    </td>
                    <td class="table-cell text-right">
                        <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="btn btn-ghost btn-sm">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="table-cell">
                        <div class="empty-state">
                            <i class="fa-solid fa-inbox empty-state-icon"></i>
                            <h3 class="empty-state-title">No complaints found</h3>
                            <p class="empty-state-description">There are currently no complaints to review</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
