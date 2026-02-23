@props([
    'variant' => 'primary',
    'size' => 'default',
    'href' => null,
    'icon' => null,
    'iconPosition' => 'left',
])

@php
    $baseClass = 'btn';
    
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'destructive' => 'btn-destructive',
        'outline' => 'btn-outline',
        'ghost' => 'btn-ghost',
        'link' => 'btn-link',
    ];

    $sizes = [
        'default' => '',
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        'icon' => 'btn-icon',
    ];

    $classes = $baseClass . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? '');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'mr-2' : '' }}"></i>
        @endif
        
        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'ml-2' : '' }}"></i>
        @endif
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'mr-2' : '' }}"></i>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'ml-2' : '' }}"></i>
        @endif
    </button>
@endif
