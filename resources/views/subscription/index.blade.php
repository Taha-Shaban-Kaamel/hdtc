<x-app-layout>
    <div class="py-4 max-h-[calc(100vh-12rem)]">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['label' => __('Subscriptions')],
                    ]" />
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header Section -->
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ __('Subscriptions') }}</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ __('Manage active and expired user subscriptions.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">
                                    User
                                </th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">
                                    Plan
                                </th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">
                                    Cycle
                                </th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">
                                    Start Date
                                </th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">
                                    End Date
                                </th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">
                                    Payment Status
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($subscriptions as $sub)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-center">
                                        {{ trim(($sub->user->first_name ?? '') . ' ' . ($sub->user->second_name ?? '')) ?: 'N/A' }}

                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-center">
                                        {{ $sub->plan->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 text-center capitalize">
                                        {{ $sub->billing_cycle }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 text-center">
                                        {{ $sub->start_date->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 text-center">
                                        {{ $sub->end_date->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $sub->status === 'active' ? 'bg-green-100 text-green-800' :
                                                   ($sub->status === 'canceled' ? 'bg-red-100 text-red-800' :
                                                   'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($sub->status) }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $sub->payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                                                   ($sub->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($sub->payment_status) }}
                                            </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No subscriptions found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($subscriptions->hasPages())
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $subscriptions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
