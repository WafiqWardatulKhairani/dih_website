@props([
    'title' => 'Title',
    'value' => 0,
    'icon' => 'bar-chart',
    'color' => 'blue'
])

@php
    $colors = [
        'blue' => 'from-blue-500 to-blue-700',
        'green' => 'from-green-500 to-green-700',
        'purple' => 'from-purple-500 to-purple-700',
        'orange' => 'from-orange-500 to-orange-700',
    ];
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-all duration-300">
    <div>
        <h3 class="text-sm font-medium text-gray-500">{{ $title }}</h3>
        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $value }}</p>
    </div>

    <div class="p-3 rounded-full bg-gradient-to-br {{ $colors[$color] ?? $colors['blue'] }}">
        <i class="fa-solid fa-{{ $icon }} text-white text-lg"></i>
    </div>
</div>
