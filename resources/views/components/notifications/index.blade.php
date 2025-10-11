<div
    x-data="{
        open: false,
        current: {},
        show(notification) {
            this.current = notification;
            this.open = true;
        },
        close() {
            this.open = false;
        }
    }"
>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">{{ __('notifications.notifications_list') }}</h2>
        <a href="{{ route('notifications.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + {{ __('notifications.new_notification') }}
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ __('notifications.title') }}</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ __('notifications.type') }}</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ __('notifications.recipient') }}</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ __('notifications.sent_at') }}</th>
                <th class="px-4 py-2 text-center text-sm font-medium text-gray-600">{{ __('notifications.actions') }}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @forelse($notifications as $notification)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $notification->title }}</td>
                    <td class="px-4 py-2 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $notification->type === 'topic' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                            {{ ucfirst($notification->type) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        @if($notification->type === 'topic')
                            {{ ucfirst($notification->topic ?? 'General') }}
                        @else
                            {{ $notification->user->name ?? 'N/A' }}
                        @endif
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        {{ optional($notification->sent_at)->format('M d, Y H:i') ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button
                            @click="show({
                                id: '{{ $notification->id }}',
                                title: '{{ addslashes($notification->title) }}',
                                body: `{{ addslashes($notification->body ?? '') }}`,
                                type: '{{ $notification->type }}',
                                topic: '{{ $notification->topic ?? '' }}',
                                recipient: '{{ $notification->user->name ?? 'N/A' }}',
                                sent_at: '{{ optional($notification->sent_at)->format('M d, Y H:i') ?? '-' }}'
                            })"
                            class="text-blue-600 hover:text-blue-800 font-medium"
                        >
                            {{ __('notifications.view') }}
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-4">
                        {{ __('notifications.no_notifications_found') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

    <!-- Simple Alpine Modal -->
    <div
        x-show="open"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
        @keydown.escape.window="close()"
    >
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6 relative">
            <!-- Close Button -->
            <button @click="close()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                ✕
            </button>

            <h2 class="text-lg font-semibold mb-3 text-gray-800" x-text="current.title"></h2>

            <p class="text-sm text-gray-600 mb-1">
                <strong>{{ __('notifications.type') }}:</strong>
                <span x-text="current.type"></span>
            </p>

            <template x-if="current.type === 'topic'">
                <p class="text-sm text-gray-600 mb-1">
                    <strong>{{ __('notifications.topic') }}:</strong>
                    <span x-text="current.topic || '-'"></span>
                </p>
            </template>

            <template x-if="current.type !== 'topic'">
                <p class="text-sm text-gray-600 mb-1">
                    <strong>{{ __('notifications.recipient') }}:</strong>
                    <span x-text="current.recipient"></span>
                </p>
            </template>

            <p class="text-sm text-gray-600 mb-3">
                <strong>{{ __('notifications.sent_at') }}:</strong>
                <span x-text="current.sent_at"></span>
            </p>

            <hr class="my-3">

            <div class="text-gray-700 text-sm whitespace-pre-line" x-text="current.body"></div>

            <div class="mt-6 flex justify-end">
                <button
                    @click="close()"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition"
                >
                    {{ __('notifications.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
