@php
    use App\Helpers\TransactionStatusHelper;
    $statusConfig = TransactionStatusHelper::getStatus($status);
@endphp

<span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $statusConfig['bg_class'] ?? 'bg-slate-100 text-slate-600' }}">
    <i class="fa-solid {{ $statusConfig['icon_fa'] }} text-sm mr-1.5"></i>
    {{ $statusConfig['label'] }}
</span>
