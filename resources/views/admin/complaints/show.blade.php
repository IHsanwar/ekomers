@extends('layouts.admin')

@section('content')
<div class="sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.complaints.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-600 mb-2 inline-block">
            &lt;- Kembali ke Daftar Komplain
        </a>
        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Review Komplain #CMP-{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}</h1>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded mb-6">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Informasi Komplain -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Detail Pengajuan User</h2>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-slate-500">Tipe Solusi</p>
                        <p class="font-medium text-slate-800">{{ $complaint->action_type == 'refund' ? 'Pengembalian Dana (Refund)' : 'Penukaran Barang' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Alasan</p>
                        <p class="font-medium text-slate-800">{{ $complaint->reason_category }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-slate-500 mb-1">Deskripsi Masalah</p>
                    <div class="bg-slate-50 p-3 rounded border text-slate-800">
                        {{ $complaint->description }}
                    </div>
                </div>

                @if($complaint->evidence_images)
                <div>
                    <p class="text-sm text-slate-500 mb-2">Foto Bukti Keluhan</p>
                    <a href="{{ Storage::url($complaint->evidence_images) }}" target="_blank">
                        <img src="{{ Storage::url($complaint->evidence_images) }}" class="rounded border max-w-sm hover:opacity-75 transition" alt="Bukti">
                    </a>
                </div>
                @endif
            </div>

            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Informasi Kontak & Refund</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Nomor HP/WhatsApp</p>
                        <p class="font-medium text-slate-800">{{ $complaint->contact_number }}</p>
                    </div>
                    @if($complaint->action_type == 'refund')
                    <div>
                        <p class="text-sm text-slate-500">Tujuan Pengembalian Dana</p>
                        <p class="font-medium text-slate-800 mb-1">Metode: {{ $complaint->refund_method ?? '-' }}</p>
                        <p class="font-medium text-slate-800">No/Akun: {{ $complaint->refund_account ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Panel -->
        <div>
            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-6 sticky top-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Admin Panel Approval</h2>
                
                <div class="mb-4">
                    <p class="text-sm text-slate-500 mb-1">Status Komplain Saat Ini:</p>
                    <span class="text-sm font-medium px-3 py-1 rounded-full bg-slate-100 text-slate-800">
                        {{ ucfirst($complaint->status) }}
                    </span>
                </div>

                <form action="{{ route('admin.complaints.action', $complaint->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Keputusan Kepada User:</label>
                        <select name="status" class="form-select w-full" required>
                            <option value="">-- Pilih --</option>
                            <option value="approved" {{ $complaint->status == 'approved' ? 'selected' : '' }}>Approve (Setujui Permintaan)</option>
                            <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Reject (Tolak Komplain)</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved (Sudah Selesai/Tuntas)</option>
                        </select>
                        <p class="text-xs text-slate-500 mt-2 block">
                            *Jika di-Approve, status pesanan otomatis menjadi <strong>{{ $complaint->action_type == 'refund' ? 'Refunded' : 'Returning' }}</strong>.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Admin (Untuk User):</label>
                        <textarea name="admin_notes" class="form-input w-full" rows="3" placeholder="Contoh: Kami sedang memproses dana Anda...">{{ $complaint->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="btn bg-primary-500 hover:bg-primary-600 text-white w-full">
                        Simpan Keputusan & Update Status
                    </button>
                    <p class="text-xs text-slate-400 mt-2 text-center">User dapat melihat status dan catatan ini.</p>
                </form>
            </div>
            
            <div class="bg-slate-50 shadow-sm rounded-sm border border-slate-200 p-4 mt-6">
                <p class="text-sm font-medium text-slate-800 mb-2">Detail Referensi Pesanan Terkait</p>
                <div class="text-xs text-slate-600 mb-2">Order ID: {{ $complaint->transaction->invoice_code }}</div>
                <a href="{{ route('admin.transactions.show', $complaint->transaction->id) }}" class="btn border-slate-200 hover:border-slate-300 w-full">
                    Lihat Histori Transaksi Asli
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
