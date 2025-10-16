<x-app-layout>
    <div class="py-12">
        <!-- 🧭 Breadcrumb -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="px-6 py-4">
                <x-breadcrumb :items="[
                    ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                    ['label' => __('reports.general_reports')],
                ]" />
            </div>
        </div>

        <!-- 📊 المحتوى -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-y-auto shadow-sm sm:rounded-lg p-6">

                <!-- 🧩 العنوان والأزرار -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">📈 {{ __('reports.general_reports') }}</h2>

                    <div class="flex gap-3 mt-4 md:mt-0">
                        <!-- تصدير Excel -->
                        <a href="{{ route('reports.export.excel', request()->query()) }}"
                           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4" />
                            </svg>
                            {{ __('reports.export_excel') }}
                        </a>

                        <!-- تصدير PDF -->
                        <a href="{{ route('reports.export.pdf', request()->query()) }}"
                           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4" />
                            </svg>
                            {{ __('reports.export_pdf') }}
                        </a>
                    </div>
                </div>

                <!-- 🧮 جدول الإحصاءات العامة -->
                <div class="overflow-hidden rounded-lg border border-gray-200 mb-6">
                    <table class="min-w-full divide-y divide-gray-200 text-center">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">{{ __('reports.item') }}</th>
                            <th class="px-6 py-3">{{ __('reports.value') }}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                        <tr><td>{{ __('reports.total_users') }}</td><td>{{ $stats['total_users'] }}</td></tr>
                        <tr><td>{{ __('reports.active_users') }}</td><td>{{ $stats['active_users'] }}</td></tr>
                        <tr><td>{{ __('reports.total_subscriptions') }}</td><td>{{ $stats['total_subscriptions'] }}</td></tr>
                        <tr><td>{{ __('reports.total_plans') }}</td><td>{{ $stats['total_plans'] }}</td></tr>
                        <tr><td>{{ __('reports.total_courses') }}</td><td>{{ $stats['total_courses'] }}</td></tr>
                        <tr><td>{{ __('reports.total_instructors') }}</td><td>{{ $stats['total_instructors'] }}</td></tr>
                        <tr><td>{{ __('reports.total_payments') }}</td><td>{{ $stats['total_payments'] }}</td></tr>
                        <tr><td>{{ __('reports.total_revenue') }}</td><td>{{ number_format($stats['total_revenue'], 2) }} EGP</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- 💳 آخر المدفوعات -->
                <h3 class="text-lg font-semibold mb-4 text-gray-700">💳 {{ __('reports.recent_payments') }}</h3>

                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-center">
                        <thead class="bg-gray-100">
                        <tr>
                            <th>#</th>
                            <th>{{ __('reports.user') }}</th>
                            <th>{{ __('reports.plan') }}</th>
                            <th>{{ __('reports.amount') }}</th>
                            <th>{{ __('reports.status') }}</th>
                            <th>{{ __('reports.date') }}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->user->first_name ?? '-' }}</td>
                                <td>{{ $payment->plan->name ?? '-' }}</td>
                                <td>{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                                <td>
                                    @if($payment->status === 'paid')
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">{{ __('reports.paid') }}</span>
                                    @elseif($payment->status === 'pending')
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">{{ __('reports.pending') }}</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">{{ __('reports.failed') }}</span>
                                    @endif
                                </td>
                                <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-gray-500">{{ __('reports.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    @if($payments->hasPages())
                        <div class="p-4 border-t">
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
