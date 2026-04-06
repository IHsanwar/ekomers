@extends('layouts.admin')

@section('page-title', 'Review Complaint')

@section('content')
<!-- Header -->
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.complaints.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-slate-900">Review Complaint #CMP-{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}</h2>
        <p class="text-sm text-slate-500 mt-1">Customer complaint details and approval panel</p>
    </div>
</div>

<!-- Errors -->
@if($errors->any())
    <div class="card border-red-200 bg-red-50 p-4 mb-6">
        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Main Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Complaint Details Card -->
        <div class="card">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-file-lines mr-2 text-slate-400"></i>Complaint Details
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Solution Type</p>
                        <p class="font-medium text-slate-900 mt-2">
                            {{ $complaint->action_type == 'refund' ? 'Refund' : 'Replacement' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Reason</p>
                        <p class="font-medium text-slate-900 mt-2">{{ $complaint->reason_category }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Description</p>
                    <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 text-slate-800">
                        {{ $complaint->description }}
                    </div>
                </div>

                @if($complaint->evidence_images)
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Evidence Image</p>
                    <a href="{{ Storage::url($complaint->evidence_images) }}" target="_blank" class="inline-block">
                        <img src="{{ Storage::url($complaint->evidence_images) }}"
                             class="rounded-lg border border-slate-200 max-w-sm hover:opacity-90 transition object-cover"
                             alt="Evidence">
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Contact & Refund Info Card -->
        <div class="card">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-wallet mr-2 text-slate-400"></i>Contact & Refund Information
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Phone / WhatsApp</p>
                        <p class="font-medium text-slate-900 mt-2">{{ $complaint->contact_number }}</p>
                    </div>
                    @if($complaint->action_type == 'refund')
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Refund Method</p>
                        <p class="font-medium text-slate-900 mt-2">{{ $complaint->refund_method ?? '-' }}</p>
                    </div>
                    @endif
                </div>
                @if($complaint->action_type == 'refund')
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase">Account / Number</p>
                    <p class="font-mono font-medium text-slate-900 mt-2">{{ $complaint->refund_account ?? '-' }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar - Admin Panel -->
    <div class="lg:col-span-1">
        <!-- Approval Panel -->
        <div class="card sticky top-6">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-gavel mr-2 text-slate-400"></i>Admin Panel
                </h3>
            </div>
            <div class="p-6">
                <!-- Current Status -->
                <div class="mb-6">
                    <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Current Status</p>
                    <span class="badge badge-secondary">
                        <i class="fa-solid fa-circle text-xs mr-1"></i>
                        {{ ucfirst($complaint->status) }}
                    </span>
                </div>

                <!-- Action Form -->
                <form action="{{ route('admin.complaints.action', $complaint->id) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="status" class="text-sm font-semibold text-slate-900">
                            Decision
                        </label>
                        <select id="status"
                                name="status"
                                class="input w-full mt-2"
                                required>
                            <option value="">-- Select Action --</option>
                            <option value="approved" {{ $complaint->status == 'approved' ? 'selected' : '' }}>
                                Approve (Accept Request)
                            </option>
                            <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>
                                Reject (Deny Complaint)
                            </option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>
                                Resolved (Completed)
                            </option>
                        </select>
                        <p class="text-xs text-slate-500 mt-2">
                            <i class="fa-solid fa-info-circle mr-1"></i>
                            Approving will automatically set order status to <strong>{{ $complaint->action_type == 'refund' ? 'Refunded' : 'Returning' }}</strong>
                        </p>
                    </div>

                    <div>
                        <label for="admin_notes" class="text-sm font-semibold text-slate-900">
                            Admin Notes (Visible to Customer)
                        </label>
                        <textarea id="admin_notes"
                                  name="admin_notes"
                                  rows="3"
                                  placeholder="e.g., We are processing your refund..."
                                  class="input w-full mt-2">{{ $complaint->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fa-solid fa-save"></i>Save Decision & Update
                    </button>
                </form>

                <p class="text-xs text-slate-500 text-center mt-4">
                    <i class="fa-solid fa-comment-dots mr-1"></i>Customer will see status and notes
                </p>
            </div>
        </div>

        <!-- Related Order Card -->
        <div class="card mt-6 border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-receipt mr-2 text-slate-400"></i>Related Order
                </h3>
            </div>
            <div class="p-6 space-y-3">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase">Invoice</p>
                    <p class="font-mono font-medium text-slate-900 mt-1">{{ $complaint->transaction->invoice_code }}</p>
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection
