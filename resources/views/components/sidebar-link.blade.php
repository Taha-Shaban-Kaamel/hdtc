@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-gray-900 border-l-4 border-indigo-500'
        : 'block px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 hover:text-white hover:bg-gray-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
