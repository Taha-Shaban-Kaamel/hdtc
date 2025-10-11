<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send Notification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6" x-data="{ tab: 'all' }">

                <!-- Tabs Header -->
                <div class="flex border-b border-gray-200 mb-6">
                    <button type="button"
                            @click="tab = 'all'"
                            :class="tab === 'all' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm">
                        {{ __('Send to All') }}
                    </button>
                    <button type="button"
                            @click="tab = 'users'"
                            :class="tab === 'users' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm">
                        {{ __('Send to Users') }}
                    </button>
                </div>

                <!-- Send to All -->
                <div x-show="tab === 'all'" class="space-y-6">
                    <x-form-section method="POST" action="{{ route('notifications.send') }}">
                        <x-slot name="title">{{ __('Send to All Users') }}</x-slot>
                        <x-slot name="description">{{ __('Send a notification to all users subscribed to the app.') }}</x-slot>
                        <x-slot name="form" class="grid grid-cols-6 gap-6">

                            <input type="hidden" name="send_type" value="topic">
                            <input type="hidden" name="topic" value="all">

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="title_all" value="{{ __('Title') }}" />
                                <x-input id="title_all" name="title" type="text" class="mt-1 block w-full" required maxlength="255" />
                                <x-input-error for="title" class="mt-2" />
                            </div>

                            <div class="col-span-6">
                                <x-label for="body_all" value="{{ __('Message') }}" />
                                <textarea id="body_all" name="body" rows="5"
                                          class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                          required maxlength="1000"></textarea>
                                <x-input-error for="body" class="mt-2" />
                            </div>

                        </x-slot>

                        <x-slot name="actions">
                            <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Send to All Users') }}
                            </x-button>
                        </x-slot>
                    </x-form-section>
                </div>

                <!-- Send to Selected Users -->
                <div x-show="tab === 'users'" x-cloak class="space-y-6">
                    <x-form-section method="POST" action="{{ route('notifications.send') }}">
                        <x-slot name="title">{{ __('Send to Selected Users') }}</x-slot>
                        <x-slot name="description">{{ __('Choose users manually to send them a notification.') }}</x-slot>
                        <x-slot name="form" class="grid grid-cols-6 gap-6">

                            <input type="hidden" name="send_type" value="users">

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="user_ids" value="{{ __('Select Users') }}" />
                                <select id="user_ids" name="user_ids[]" multiple
                                        class="select2 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        data-placeholder="Select users...">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->first_name ? json_decode($user->first_name) : 'User' }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error for="user_ids" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <x-label for="title_users" value="{{ __('Title') }}" />
                                <x-input id="title_users" name="title" type="text" class="mt-1 block w-full" required maxlength="255" />
                                <x-input-error for="title" class="mt-2" />
                            </div>

                            <div class="col-span-6">
                                <x-label for="body_users" value="{{ __('Message') }}" />
                                <textarea id="body_users" name="body" rows="5"
                                          class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                          required maxlength="1000"></textarea>
                                <x-input-error for="body" class="mt-2" />
                            </div>

                        </x-slot>

                        <x-slot name="actions">
                            <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Send to Selected Users') }}
                            </x-button>
                        </x-slot>
                    </x-form-section>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
