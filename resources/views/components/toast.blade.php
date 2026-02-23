@props(['type' => 'success'])

@php
$icons = [
    'success' => 'fa-solid fa-circle-check',
    'error' => 'fa-solid fa-circle-xmark',
    'warning' => 'fa-solid fa-triangle-exclamation',
    'info' => 'fa-solid fa-circle-info',
];
$icon = $icons[$type] ?? $icons['info'];
@endphp

<div class="toast-{{ $type }}" 
     x-data="{ show: true }" 
     x-show="show" 
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-x-full"
     x-transition:enter-end="opacity-100 transform translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform translate-x-0"
     x-transition:leave-end="opacity-0 transform translate-x-full">
    <i class="{{ $icon }} toast-icon text-lg"></i>
    <div class="flex-1">
        {{ $slot }}
    </div>
    <button @click="show = false" class="text-slate-400 hover:text-slate-600 transition-colors">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
