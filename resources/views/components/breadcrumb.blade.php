@props(['items'])

<nav class="flex" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-2">
        @foreach($items as $index => $item)
            <li>
                <div class="flex items-center">
                    @if($index > 0)
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                        <a href="{{ $item['url'] ?? '#' }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700 {{ $loop->last ? 'text-gray-700' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <a href="{{ $item['url'] }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span class="sr-only">{{ $item['label'] }}</span>
                        </a>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
