<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">{{ __('notifications.notifications_list') }}</h2>
        <a href="{{ route('notifications.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + {{ __('notifications.new_notification') }}
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Title</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Type</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Recipient</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Sent At</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 text-center">Actions</th>
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
                            x-data
                            x-on:click="$dispatch('open-modal', { id: 'notificationModal{{ $notification->id }}' })"
                            class="text-blue-600 hover:text-blue-800 font-medium">
                            View
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-4">
                        No notifications found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

    <!-- Notification Modal -->
    @foreach($notifications as $notification)
        <x-modal name="notificationModal{{ $notification->id }}">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-2">{{ $notification->title }}</h2>
                <p class="text-gray-600 mb-1"><strong>Type:</strong> {{ ucfirst($notification->type) }}</p>
                @if($notification->type === 'topic')
                    <p class="text-gray-600 mb-1"><strong>Topic:</strong> {{ ucfirst($notification->topic ?? '-') }}</p>
                @else
                    <p class="text-gray-600 mb-1"><strong>Recipient:</strong> {{ $notification->user->name ?? 'N/A' }}</p>
                @endif
                <p class="text-gray-600 mb-3"><strong>Sent At:</strong> {{ optional($notification->sent_at)->format('M d, Y H:i') }}</p>
                <hr class="my-3">
                <p class="text-gray-700 whitespace-pre-line">{{ $notification->body }}</p>
            </div>
        </x-modal>
    @endforeach
</div>
