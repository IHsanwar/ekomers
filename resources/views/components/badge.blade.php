@props([
    'variant' => 'default',
])

@php
    $baseClass = 'badge';
    
    $variants = [
        'default' => 'badge-default',
        'secondary' => 'badge-secondary',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'danger' => 'badge-danger',
        'info' => 'badge-info',
        'outline' => 'badge-outline',
    ];

    $classes = $baseClass . ' ' . ($variants[$variant] ?? $variants['default']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
