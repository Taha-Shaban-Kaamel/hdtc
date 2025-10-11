<x-app-layout>
    <div class="py-4 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['label' => __('Plans')],
                    ]" />
                </div>
            </div>
        </div>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header Section -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div
                            class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    {{ __('Plans') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('plans.description') }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('plans.create') }}"
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    {{ __('plans.create') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('plans.name') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('plans.price_monthly') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('plans.price_yearly') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('plans.max_users') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('plans.max_courses') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('common.actions') }}</th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($plans as $plan)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-center font-medium">
                                        {{ $plan->name }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                        ${{ number_format($plan->price_monthly, 2) }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                        ${{ number_format($plan->price_yearly, 2) }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                        {{ $plan->max_users ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                        {{ $plan->max_courses ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('plans.show', $plan->id) }}"
                                               class="text-indigo-600 hover:text-indigo-900"
                                               title="{{ __('common.view') }}">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0
                                                            8.268 2.943 9.542 7-1.274 4.057-5.064
                                                            7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('plans.edit', $plan->id) }}"
                                               class="text-blue-600 hover:text-blue-900"
                                               title="{{ __('common.edit') }}">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0
                                                            002 2h11a2 2 0 002-2v-5m-1.414-9.414a2
                                                            2 0 112.828 2.828L11.828 15H9v-2.828
                                                            l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('plans.destroy', $plan->id) }}" method="POST"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('{{ __('plans.delete_confirm') }}')">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0
                                                                0116.138 21H7.862a2 2 0
                                                                01-1.995-1.858L5 7m5 4v6m4-6v6m1
                                                                -10V4a1 1 0 00-1-1h-4a1 1 0
                                                                00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        {{ __('plans.no_plans_found') }}
                                        <a href="{{ route('plans.create') }}"
                                           class="text-indigo-600 hover:text-indigo-900 ml-1">
                                            {{ __('plans.create_one') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($plans->hasPages())
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $plans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
