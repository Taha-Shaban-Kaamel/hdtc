@props(['availableLocales' => config('app.available_locales'), 'currentLocale' => app()->getLocale()])

<div class="flex items-center space-x-2 rtl:space-x-reverse">
    {{-- @foreach ($availableLocales as $locale => $details)

        @if ($locale !== $currentLocale)
            <a href="{{ route('lang.switch', $locale) }}" 
               class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 transition-colors"
               title="{{ $details['name'] }}">
                <span class="text-base">{{ $details['flag'] ?? $locale }}</span>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100">
                <span class="text-base">{{ $details['flag'] ?? $locale }}</span>
            </span>
        @endif
    @endforeach --}}

    <a href="{{ route('lang.switch', 'ar') }}"
        class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 transition-colors"
        title="{{ 'ar' }}">
        <span class="text-base">{{ 'ar' }}</span>
    </a>
    <a href="{{ route('lang.switch', 'en') }}"
        class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 transition-colors"
        title="{{ 'en' }}">
        <span class="text-base">{{ 'en' }}</span>
    </a>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endpush
