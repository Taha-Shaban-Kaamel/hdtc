<div class="bg-white rounded-lg border border-gray-200 shadow-sm">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                {{ __('plans.plans') }}
            </h2>
            <a href="{{ route('plans.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('plans.new_plan') }}
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0
                              00-1.414-1.414L9 10.586 7.707 9.293a1 1 0
                              00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('plans.name') }}
                    </th>
                    <th class="px-6 py-3 text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('plans.price_monthly') }}
                    </th>
                    <th class="px-6 py-3 text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('plans.price_yearly') }}
                    </th>
                    <th class="px-6 py-3 text-xs text-center font-medium text-gray-500 uppercase tracking-wider">
                        {{ __('plans.actions') }}
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 text-center">
                @forelse($plans as $plan)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $plan->name }}</td>
                        <td class="px-6 py-4 text-gray-600">${{ number_format($plan->price_monthly, 2) }}</td>
                        <td class="px-6 py-4 text-gray-600">${{ number_format($plan->price_yearly, 2) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('plans.show', $plan->id) }}"
                                   class="text-green-600 hover:text-green-800" title="{{ __('View') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0
                                                    8.268 2.943 9.542 7-1.274 4.057-5.064
                                                    7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('plans.edit', $plan->id) }}"
                                   class="text-blue-600 hover:text-blue-800" title="{{ __('Edit') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5
                                                    2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>

                                <form action="{{ route('plans.destroy', $plan->id) }}" method="POST"
                                      class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 transition-colors"
                                            title="{{ __('Delete') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
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
                        <td colspan="4" class="px-6 py-10 text-center">
                            <div class="text-gray-500 flex flex-col items-center justify-center">
                                <svg class="mx-auto h-14 w-14 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0
                                                11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-3 text-sm font-medium">{{ __('plans.no_plans_found') }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ __('plans.get_started_by_creating_a_new_plan') }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('plans.create') }}"
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        {{ __('plans.new_plan') }}
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($plans->hasPages())
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $plans->links() }}
            </div>
        @endif
    </div>
</div>
