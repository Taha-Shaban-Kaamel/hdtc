@props(['for', 'messages', 'class' => ''])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-sm text-red-600 ' . $class]) }}>
        @if (is_array($message))
            {{ $message[0] }}
        @else
            {{ $message }}
        @endif
    </p>
@enderror

@if (isset($messages) && is_array($messages))
    @foreach ((array) $messages as $message)
        <p class="text-sm text-red-600 {{ $class }}">
            {{ is_array($message) ? $message[0] : $message }}
        </p>
    @endforeach
@endif
