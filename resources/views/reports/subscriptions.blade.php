<x-app-layout>
    <div class="py-12">
        <!-- 🔹 Breadcrumb -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="px-6 py-4">
                <x-breadcrumb :items="[
                    ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                    ['url' => route('reports.index'), 'label' => __('reports.reports')],
                    ['label' => __('reports.subscriptions_reports')],
                ]" />
            </div>
        </div>

        <!-- 🔹 Page Content -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-y-auto shadow-sm sm:rounded-lg p-6">

                <!-- 🧾 Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">💳 {{ __('reports.subscriptions_reports') }}</h2>

                    <!-- 🔘 Export Buttons -->
                    <div class="flex gap-3 mt-4 md:mt-0">
                        <a href="{{ route('reports.export.subscriptions.excel') }}"
                           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            {{ __('reports.export_excel') }}
                        </a>

                        <a href="{{ route('reports.export.subscriptions.pdf') }}"
                           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            {{ __('reports.export_pdf') }}
                        </a>
                    </div>
                </div>

                <!-- 📊 Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <x-report-card title="{{ __('reports.active') }}" value="{{ $summary['active'] }}" color="green" />
                    <x-report-card title="{{ __('reports.upcoming') }}" value="{{ $summary['upcoming'] }}" color="yellow" />
                    <x-report-card title="{{ __('reports.expired') }}" value="{{ $summary['expired'] }}" color="red" />
                </div>

                <!-- 📋 Table -->
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-center">
                        <thead class="bg-gray-100">
                        <tr>
                            <th>#</th>
                            <th>{{ __('reports.user') }}</th>
                            <th>{{ __('reports.plan') }}</th>
                            <th>{{ __('reports.start_date') }}</th>
                            <th>{{ __('reports.end_date') }}</th>
                            <th>{{ __('reports.status') }}</th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($subscriptions as $subscription)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subscription->user->full_name ?? '-' }}</td>
                                <td>{{ $subscription->plan->name ?? '-' }}</td>
                                <td>{{ optional($subscription->start_date)->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ optional($subscription->end_date)->format('Y-m-d') ?? '-' }}</td>
                                <td>
                                    @if($subscription->end_date && $subscription->end_date->isFuture())
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">{{ __('reports.active') }}</span>
                                    @elseif($subscription->start_date && $subscription->start_date->isFuture())
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">{{ __('reports.upcoming') }}</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">{{ __('reports.expired') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if($subscriptions->isEmpty())
                            <tr>
                                <td colspan="6" class="py-6 text-gray-500 text-center">{{ __('reports.no_data') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                    <!-- 📑 Pagination -->
                    <div class="p-4 border-t">
                        {{ $subscriptions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
