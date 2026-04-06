@props(['type' => 'success'])

@php
$icons = [
    'success' => 'fa-solid fa-circle-check',
    'error' => 'fa-solid fa-circle-xmark',
    'warning' => 'fa-solid fa-triangle-exclamation',
    'info' => 'fa-solid fa-circle-info',
];

$styles = [
    'success' => 'bg-white border border-emerald-200 text-slate-700 [&_.toast-icon]:text-emerald-500',
    'error'   => 'bg-white border border-red-200 text-slate-700 [&_.toast-icon]:text-red-500',
    'warning' => 'bg-white border border-amber-200 text-slate-700 [&_.toast-icon]:text-amber-500',
    'info'    => 'bg-white border border-blue-200 text-slate-700 [&_.toast-icon]:text-blue-500',
];

$icon = $icons[$type] ?? $icons['info'];
$style = $styles[$type] ?? $styles['info'];
@endphp

<div class="flex items-start gap-3 w-80 rounded-xl shadow-lg px-4 py-3 {{ $style }}"
     x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-x-full"
     x-transition:enter-end="opacity-100 transform translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform translate-x-0"
     x-transition:leave-end="opacity-0 transform translate-x-full">
    <i class="{{ $icon }} toast-icon text-lg mt-0.5"></i>
    <div class="flex-1 text-sm">
        {{ $slot }}
    </div>
    <button @click="show = false" class="text-slate-400 hover:text-slate-600 transition-colors">
        <i class="fa-solid fa-xmark text-sm"></i>
    </button>
</div>