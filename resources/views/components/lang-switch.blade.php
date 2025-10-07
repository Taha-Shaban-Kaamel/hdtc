@php
    $currentLocale = app()->getLocale();
    $otherLocale = $currentLocale === 'en' ? 'ar' : 'en';
    $switchTitle = $currentLocale === 'en' ? 'Switch to Arabic' : 'Switch to English';
    $displayText = $currentLocale === 'en' ? 'E' : 'ع';
@endphp

<div class="flex items-center">
    <a 
        href="{{ route('lang.switch', $otherLocale) }}"
        class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 transition-colors"
        title="{{ $switchTitle }}"
        style="border: 1px solid #e5e7eb;"
    >
        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-700 text-sm font-bold" 
              style="font-family: 'Traditional Arabic', Arial, sans-serif; line-height: 1;">
            {{ $displayText }}
        </span>
    </a>
</div>
