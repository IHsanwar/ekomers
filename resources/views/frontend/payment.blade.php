@extends('layouts.frontend')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Payment Card -->
    <div class="card overflow-hidden">
        <!-- Header -->
        <div class="bg-slate-50 border-b border-slate-200 p-6 text-center">
            <div class="w-16 h-16 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-credit-card text-primary-600 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Complete Your Payment</h1>
            <p class="text-slate-500 mt-1">Please review your order details before proceeding.</p>
        </div>

        <div class="p-8">
            <!-- Order Summary -->
            <div class="space-y-6">
                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Invoice Code</label>
                        <p class="mt-1 font-mono font-medium text-slate-900">{{ $transaction->invoice_code }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Customer</label>
                        <p class="mt-1 font-medium text-slate-900">{{ $transaction->user->name }}</p>
                    </div>
                </div>

                <div class="border-t border-slate-100 my-4"></div>

                <!-- Total Amount -->
                <div class="flex items-center justify-between bg-slate-50 p-4 rounded-lg border border-slate-100">
                    <span class="text-slate-600 font-medium">Total Amount</span>
                    <span class="text-2xl font-bold text-primary-600">
                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                    </span>
                </div>

                <!-- Security Note -->
                <div class="flex items-start gap-3 p-4 bg-blue-50 text-blue-700 rounded-lg text-sm">
                    <i class="fa-solid fa-shield-halved mt-0.5"></i>
                    <p>Your payment is processed securely by Midtrans. We do not store your card details.</p>
                </div>

                <!-- Action Button -->
                <button id="pay-button" class="btn-primary w-full justify-center h-12 text-lg font-semibold shadow-lg shadow-primary-500/20 hover:shadow-primary-500/30 transition-all">
                    <i class="fa-solid fa-lock mr-2"></i> Pay Now
                </button>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="bg-slate-50 border-t border-slate-200 p-4 text-center text-xs text-slate-500">
            Powered by Midtrans Payment Gateway
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}"></script>

@if(isset($snapToken))
    <script>
        // Auto-trigger snap popup if token exists (optional, keeping manual button for better UX)
        // snap.pay('{{ $snapToken }}');
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        
        if(payButton) {
            payButton.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent any default action
                
                // Disable button to prevent multiple clicks
                payButton.disabled = true;
                payButton.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Processing...';
                
                try {
                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function (result) {
                            window.location.href = "{{ route('payment.result') }}?status=success&transaction={{ $transaction->id }}";
                        },
                        onPending: function (result) {
                            window.location.href = "{{ route('payment.result') }}?status=pending&transaction={{ $transaction->id }}";
                        },
                        onError: function (result) {
                            window.location.href = "{{ route('payment.result') }}?status=failed&transaction={{ $transaction->id }}";
                        },
                        onClose: function () {
                            // Re-enable button
                            payButton.disabled = false;
                            payButton.innerHTML = '<i class="fa-solid fa-lock mr-2"></i> Pay Now';
                        }
                    });
                } catch (error) {
                    console.error('Midtrans Snap Error:', error);
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fa-solid fa-lock mr-2"></i> Pay Now';
                    alert('Could not open payment window. Please try again.');
                }
            });
        }
    });
</script>
@endsection
