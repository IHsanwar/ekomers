@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    @if($status == 'success')
                        <div class="mb-4 text-success">
                            <i class="fa-solid fa-circle-check fa-4x"></i>
                        </div>
                        <h3 class="card-title">Pembayaran Berhasil!</h3>
                        <p class="card-text">Terima kasih, pembayaran Anda telah kami terima.</p>
                        @if($transaction)
                            <p class="text-muted">Invoice: {{ $transaction->invoice_code }}</p>
                        @endif
                        <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                            <i class="fa-solid fa-house me-2"></i> Kembali ke Beranda
                        </a>
                    @elseif($status == 'pending')
                        <div class="mb-4 text-warning">
                            <i class="fa-solid fa-clock fa-4x"></i>
                        </div>
                        <h3 class="card-title">Menunggu Pembayaran</h3>
                        <p class="card-text">Silahkan selesaikan pembayaran Anda.</p>
                        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">
                            <i class="fa-solid fa-house me-2"></i> Kembali ke Beranda
                        </a>
                    @else
                        <div class="mb-4 text-danger">
                            <i class="fa-solid fa-circle-xmark fa-4x"></i>
                        </div>
                        <h3 class="card-title">Pembayaran Gagal</h3>
                        <p class="card-text">Maaf, terjadi kesalahan saat memproses pembayaran.</p>
                        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">
                            <i class="fa-solid fa-house me-2"></i> Kembali ke Beranda
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
