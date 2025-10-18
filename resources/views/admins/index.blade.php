<x-app-layout>
    <div class="py-5 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 mt-6 !pt-9">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['label' => __('common.admins')],
                    ]" />
                </div>
            </div>
        </div>

        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('admin.manage_admins') }}</h3>
                            <a href="{{ route('admins.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-[#066B87] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#055a72] focus:bg-[#055a72] active:bg-[#044d63] focus:outline-none focus:ring-2 focus:ring-[#055a72] focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('admin.add_admin') }}
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                            {{ __('common.name') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                            {{ __('common.email') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                            {{ __('common.phone') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                            {{ __('common.roles') }}
                                        </th>
                                        <th scope="col" class="relative px-6 py-3 text-center">
                                            <span class="sr-only">{{ __('actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($admins as $admin)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" src="{{ $admin->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($admin->user->first_name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $admin->user->first_name }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $admin->user->first_name }} {{ $admin->user->second_name ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                {{ $admin->user->email }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                {{ $admin->user->phone ?? __('common.not_available') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                @foreach($admin->user->roles as $role)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('admins.show', $admin) }}" class="text-[#066B87] hover:text-[#055a72]">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('admins.edit', $admin) }}" class="text-blue-600 hover:text-blue-900">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('admins.destroy', $admin) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('admins.confirm_delete') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center">
                                                <div class="text-gray-500">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                    <p class="mt-2">{{ __('admins.no_admins_found') }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($admins->hasPages())
                            <div class="mt-4">
                                {{ $admins->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
