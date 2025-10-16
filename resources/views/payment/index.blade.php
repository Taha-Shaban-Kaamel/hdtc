<x-app-layout>
    <div class="py-4 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['label' => __('Payments')],
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
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    {{ __('Payments') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('List of all user payments and their statuses.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('User') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Plan') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Currency') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Transaction ID') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Created At') }}</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-center font-medium">
                                        {{ trim(($payment->user->first_name ?? '') . ' ' . ($payment->user->second_name ?? '')) ?: '-' }}

                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-center font-medium">
                                        {{ $payment->plan->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                        {{ number_format($payment->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                        {{ $payment->currency }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $color = match($payment->status) {
                                                'paid' => 'bg-green-100 text-green-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'failed' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                        {{ $payment->transaction_id ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                        {{ $payment->created_at->format('Y-m-d H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        {{ __('No payments found.') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($payments->hasPages())
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
