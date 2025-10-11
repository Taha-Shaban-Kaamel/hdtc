<x-app-layout>
    <div class="py-12">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('Dashboard')],
                        ['url' => route('plans.index'), 'label' => __('Plans')],
                        ['label' => __('common.show') . ' : ' . $plan->name],
                    ]" />
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-scroll max-h-[calc(100vh-12rem)] shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Plan Info Section -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('general_info') }}</h3>
                                <dl class="mt-2 space-y-2">
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('name') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $plan->name }}
                                        </dd>
                                    </div>
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('description') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                            {{ $plan->description ?? __('not_available') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="border-b border-gray-200 pb-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('pricing') }}</h3>
                                <dl class="mt-2 space-y-2">
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('price_monthly') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            ${{ number_format($plan->price_monthly, 2) }}
                                        </dd>
                                    </div>
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('price_yearly') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            ${{ number_format($plan->price_yearly, 2) }}
                                        </dd>
                                    </div>
                                    @if($plan->yearly_discount_percent)
                                        <div class="py-2">
                                            <dt class="text-sm font-medium text-gray-500">{{ __('plans.yearly_discount_percent') }}</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $plan->yearly_discount_percent }}%
                                            </dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>


                        </div>

                        <!-- Features Section -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('features') }}</h3>

                                @if(!empty($plan->features) && is_array($plan->features))
                                    <ul class="mt-3 space-y-2 list-disc list-inside text-sm text-gray-800">
                                        @foreach($plan->features as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-500 mt-2">{{ __('common.not_available') }}</p>
                                @endif
                            </div>

                            <!-- Timestamps -->
                            <div class="pt-4 border-t border-gray-200">
                                <div class="text-sm text-gray-500">
                                    <p>{{ __('Created at') }}: {{ $plan->created_at->format('Y-m-d H:i') }}</p>
                                    <p class="mt-1">{{ __('Last updated') }}: {{ $plan->updated_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <a href="{{ route('plans.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            {{ __('Back to List') }}
                        </a>
                        <a href="{{ route('plans.edit', $plan->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            {{ __('Edit') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
