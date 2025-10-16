@props(['title', 'value', 'color' => 'indigo'])

<div class="bg-white shadow rounded-lg p-4 text-center border-t-4 border-{{ $color }}-500">
    <p class="text-sm text-gray-500">{{ $title }}</p>
    <p class="text-2xl font-bold text-{{ $color }}-600">{{ $value }}</p>
</div>
