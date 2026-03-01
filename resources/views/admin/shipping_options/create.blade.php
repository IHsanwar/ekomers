@extends('layouts.admin')
@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Shipping Services</h2>
        <p class="text-sm text-slate-500 mt-1">Manage your shipping options</p>
    </div>
    <form action="{{ route('admin.shipping-options.store') }}" method="POST" class="flex items-center gap-2" id="shippingForm">
        @csrf
        <input type="text" name="name" placeholder="Service Name" class="input input-sm" required>
        <input type="number" name="cost" placeholder="Cost" class="input input-sm" required>
        <select name="delivery_type" class="input input-sm" required>
            <option value="">Delivery Type</option>
            <option value="standard">Standard</option>
            <option value="express">Express</option>
            <option value="same_day">Same Day</option>
        </select>
        <input type="text" name="estimated_delivery_time" placeholder="Estimated Delivery Time" class="input input-sm" required>
        <button type="submit" class="btn-primary btn-sm" id="submitBtn">
            <i class="fa-solid fa-plus mr-1"></i>Add
        </button>
    </form>

    <script>
        document.getElementById('shippingForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
        });
    </script>
</div>
@endsection