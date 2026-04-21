@props(['label', 'value', 'color' => 'gray'])

@php
$colors = match($color) {
    'green' => 'text-green-600',
    'red'   => 'text-red-600',
    'blue'  => 'text-blue-600',
    default => 'text-gray-900',
};
@endphp

<div class="bg-white rounded-lg border border-gray-100 p-6">
    <p class="text-sm text-gray-500 mb-1">{{ $label }}</p>
    <p class="text-2xl font-bold {{ $colors }}">{{ $value }}</p>
</div>