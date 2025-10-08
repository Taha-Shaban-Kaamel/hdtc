@props(['method' => 'POST', 'action' => '#'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6 lg:grid-rows-1 lg:grid-cols-2']) }}>
    <x-section-title>
        <x-slot name="title" class="lg:col-span-1 text-black">{{ $title ?? '' }}</x-slot>
        <x-slot name="description" class="lg:col-span-1 text-black">{{ $description ?? '' }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">

        <form method="{{ $method === 'GET' ? 'GET' : 'POST' }}" action="{{ $action }}" enctype="multipart/form-data">
            @if (! in_array(strtoupper($method), ['GET', 'POST']))
                @method($method)
            @endif
            
            @csrf
            
            <div class="px-4 py-5 bg-white sm:p-6 shadow-sm {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end lg:col-span-1 sm:col-span-4 px-4 py-3 bg-inherit text-right sm:px-6 shadow-sm sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>