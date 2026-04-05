@extends('layouts.frontend')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('user.transactions.details', $transaction->id) }}" class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900 mb-4">
            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Detail Transaksi
        </a>
        <h1 class="text-2xl font-bold text-slate-900">
            <i class="fa-solid fa-triangle-exclamation mr-2 text-amber-600"></i>Ajukan Komplain Pembelian
        </h1>
        <p class="text-slate-500 mt-1">Order #{{ $transaction->invoice_code }}</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="card p-6">
        <form action="{{ route('frontend.complaints.store', $transaction->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Tipe Komplain -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Solusi yang Diharapkan <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="border rounded-lg p-4 cursor-pointer hover:bg-slate-50 flex items-center gap-3">
                        <input type="radio" name="action_type" value="refund" class="text-primary-600 focus:ring-primary-500" {{ old('action_type') == 'refund' ? 'checked' : '' }} required>
                        <div>
                            <span class="block font-medium text-slate-900">Pengembalian Dana (Refund)</span>
                            <span class="block text-sm text-slate-500">Barang dikembalikan & uang dikembalikan</span>
                        </div>
                    </label>
                    <label class="border rounded-lg p-4 cursor-pointer hover:bg-slate-50 flex items-center gap-3">
                        <input type="radio" name="action_type" value="replacement" class="text-primary-600 focus:ring-primary-500" {{ old('action_type') == 'replacement' ? 'checked' : '' }} required>
                        <div>
                            <span class="block font-medium text-slate-900">Penukaran Barang</span>
                            <span class="block text-sm text-slate-500">Barang akan ditukar dengan yang baru/sesuai</span>
                        </div>
                    </label>
                </div>
                @error('action_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alasan -->
            <div class="mb-4">
                <label for="reason_category" class="block text-sm font-medium text-slate-700 mb-2">Alasan Komplain <span class="text-red-500">*</span></label>
                <select id="reason_category" name="reason_category" class="form-input w-full" required>
                    <option value="">-- Pilih Alasan --</option>
                    <option value="Barang Rusak/Cacat" {{ old('reason_category') == 'Barang Rusak/Cacat' ? 'selected' : '' }}>Barang Rusak/Cacat</option>
                    <option value="Tidak Sesuai Pesanan" {{ old('reason_category') == 'Tidak Sesuai Pesanan' ? 'selected' : '' }}>Tidak Sesuai Pesanan</option>
                    <option value="Barang Kurang" {{ old('reason_category') == 'Barang Kurang' ? 'selected' : '' }}>Jumlah Barang Kurang</option>
                    <option value="Lainnya" {{ old('reason_category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('reason_category')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Detail Keluhan -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Detail Keluhan <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="4" class="form-input w-full" placeholder="Jelaskan secara detail permasalahan yang Anda alami..." required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Bukti -->
            <div class="mb-6">
                <label for="evidence_image" class="block text-sm font-medium text-slate-700 mb-2">Bukti Foto / Video <span class="text-red-500">*</span></label>
                <input type="file" id="evidence_image" name="evidence_image" class="form-input w-full p-2" accept="image/jpeg,image/png,image/jpg" required>
                <p class="text-xs text-slate-500 mt-1">Maksimal 5MB. Format JPG, PNG.</p>
                @error('evidence_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6">
            <h3 class="text-lg font-semibold mb-4 text-slate-900">Informasi Kontak & Pengembalian Dana</h3>

            <!-- Informasi Kontak -->
            <div class="mb-4">
                <label for="contact_number" class="block text-sm font-medium text-slate-700 mb-2">Nomor HP / WhatsApp yang bisa dihubungi <span class="text-red-500">*</span></label>
                <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" class="form-input w-full" required>
                @error('contact_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jika pilih Refund, isi ini -->
            <div id="refund-details" class="bg-slate-50 p-4 rounded-lg border border-slate-200 mt-4 hidden">
                <p class="text-sm text-slate-600 mb-4"><i class="fa-solid fa-circle-info mr-1 text-primary-500"></i> Silakan isi detail rekening atau e-wallet untuk keperluan pengembalian dana.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="refund_method" class="block text-sm font-medium text-slate-700 mb-2">Metode (Bank / E-Wallet)</label>
                        <input type="text" id="refund_method" name="refund_method" value="{{ old('refund_method') }}" class="form-input w-full" placeholder="e.g. BCA, Mandiri, OVO, Dana">
                        @error('refund_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="refund_account" class="block text-sm font-medium text-slate-700 mb-2">Atas Nama & Nomor Rekening</label>
                        <input type="text" id="refund_account" name="refund_account" value="{{ old('refund_account') }}" class="form-input w-full" placeholder="e.g. 123456789 A/N Budi">
                        @error('refund_account')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const radios = document.querySelectorAll('input[name="action_type"]');
                    const refundDetails = document.getElementById('refund-details');
                    
                    function toggleRefundDetails() {
                        const checked = document.querySelector('input[name="action_type"]:checked');
                        if (checked && checked.value === 'refund') {
                            refundDetails.classList.remove('hidden');
                        } else {
                            refundDetails.classList.add('hidden');
                        }
                    }

                    radios.forEach(radio => radio.addEventListener('change', toggleRefundDetails));
                    toggleRefundDetails(); // Run on load in case of validation back
                });
            </script>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="btn-primary">
                    Kirim Pengajuan Komplain
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
