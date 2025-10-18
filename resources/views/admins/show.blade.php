<x-app-layout>
    <div class="py-8 mt-5 max-h-[calc(100vh-20rem)]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-8 sm:p-10">
                    <div class="md:flex md:flex-col md:items-center text-center">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-24 w-24 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                    <img class="h-full w-full object-cover"
                                    src="{{ $admin->user->avatar ? asset($admin->user->avatar) : asset('images/default-avatar.png') }}" 
                                    alt="{{ $admin->user->getTranslation('first_name', app()->getLocale()) }} {{ $admin->user->getTranslation('second_name', app()->getLocale()) }}">
                                </div>
                                <div class="ml-6">
                                    <h1 class="text-2xl font-bold text-gray-900">
                                        {{ $admin->user->getTranslation('first_name', app()->getLocale()) }}
                                        {{ $admin->user->getTranslation('second_name', app()->getLocale()) }}
                                    </h1>
                                    <p class="text-gray-600">
                                        {{ __('common.admin') }}
                                    </p>
                                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $admin->user->email }}
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $admin->user->address ?? __('common.no_address') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex flex-wrap gap-3 justify-center">
                                <a href="{{ route('admins.edit', $admin) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    {{ __('common.edit') }}
                                </a>
                                <form action="{{ route('admins.destroy', $admin) }}" method="POST"
                                    onsubmit="return confirm('{{ __('common.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ __('common.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Admin Details -->
                    <div class="mt-8 border-t border-gray-200 pt-8">
                        <h2 class="text-lg font-medium text-gray-900">{{ __('common.additional_details') }}</h2>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <!-- Contact Information -->
                            <div class="sm:col-span-2">
                                <h3 class="text-md font-medium text-gray-700 mb-3">{{ __('common.contact_information') }}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">{{ __('common.phone') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $admin->user->phone ?? __('common.not_provided') }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">{{ __('common.email') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $admin->user->email }}
                                        </dd>
                                    </div>
                                    @if($admin->user->address)
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('common.address') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $admin->user->address }}
                                        </dd>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Account Status -->
                            <div class="sm:col-span-2">
                                <h3 class="text-md font-medium text-gray-700 mb-3">{{ __('common.account_status') }}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">{{ __('common.status') }}</dt>
                                        <dd class="mt-1 text-sm">
                                            @if($admin->user->status == 'active')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ __('common.active') }}
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ __('common.inactive') }}
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">{{ __('common.registered_at') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $admin->user->created_at->format('M d, Y') }}
                                        </dd>
                                    </div>
                                </div>
                            </div>
                            <!-- Bio Section -->
                            @if($admin->user->bio)
                            <div class="sm:col-span-2">
                                <h3 class="text-md font-medium text-gray-700 mb-3">{{ __('common.bio') }}</h3>
                                <div class="prose max-w-none text-sm text-gray-900">
                                    {!! nl2br(e($admin->user->bio)) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
