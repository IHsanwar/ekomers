@extends('layouts.frontend')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('user.transactions.details', $complaint->transaction_id) }}" class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900 mb-4">
            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Detail Transaksi
        </a>
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Detail Komplain
                </h1>
                <p class="text-slate-500 mt-1">Order #{{ $complaint->transaction->invoice_code }}</p>
            </div>
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                @switch($complaint->status)
                    @case('pending') bg-amber-100 text-amber-800 @break
                    @case('reviewed') bg-blue-100 text-blue-800 @break
                    @case('approved') bg-emerald-100 text-emerald-800 @break
                    @case('rejected') bg-red-100 text-red-800 @break
                    @case('resolved') bg-slate-100 text-slate-800 @break
                @endswitch
            ">
                Status Komplain: {{ ucfirst($complaint->status) }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Rincian Komplain -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold border-b pb-2 mb-4 text-slate-900">Rincian Komplain</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-500">Tanggal Pengajuan</p>
                    <p class="font-medium text-slate-900">{{ $complaint->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Tipe Pengajuan</p>
                    <p class="font-medium text-slate-900">{{ $complaint->action_type == 'refund' ? 'Pengembalian Dana (Refund)' : 'Penukaran Barang (Replacement)' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Kategori Masalah</p>
                    <p class="font-medium text-slate-900">{{ $complaint->reason_category }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Penjelasan Masalah</p>
                    <p class="text-slate-900 mt-1 p-3 bg-slate-50 rounded border">{{ $complaint->description }}</p>
                </div>
                
                @if($complaint->evidence_images)
                <div>
                    <p class="text-sm text-slate-500 mb-2">Bukti Lampiran</p>
                    <img src="{{ Storage::url($complaint->evidence_images) }}" class="rounded border max-w-full h-auto" alt="Bukti Komplain">
                </div>
                @endif
            </div>
        </div>

        <!-- Detail Tambahan -->
        <div class="space-y-6">
            <div class="card p-6">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4 text-slate-900">Informasi Kontak & Refund</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-slate-500">Nomor Kontak (WhatsApp/HP)</p>
                        <p class="font-medium text-slate-900">{{ $complaint->contact_number }}</p>
                    </div>
                    
                    @if($complaint->action_type == 'refund')
                    <div>
                        <p class="text-sm text-slate-500">Metode Pengembalian Dana</p>
                        <p class="font-medium text-slate-900">{{ $complaint->refund_method ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Detail Rekening/E-Wallet</p>
                        <p class="font-medium text-slate-900">{{ $complaint->refund_account ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($complaint->admin_notes)
            <div class="card p-6 border-l-4 border-l-amber-500 bg-amber-50">
                <h3 class="text-lg font-semibold mb-2 text-slate-900"><i class="fa-solid fa-message mr-2"></i>Catatan dari Admin</h3>
                <p class="text-slate-800">{{ $complaint->admin_notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
