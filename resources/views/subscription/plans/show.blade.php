<x-app-layout>
    <div class="py-8 mt-5 max-h-[calc(100vh-20rem)]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- ✅ Flash Messages -->
            @if (session('success'))
                <div class="mb-4" x-data="{ show: true }" x-show="show" x-transition
                     x-init="setTimeout(() => show = false, 3000)">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-md" role="alert">
                        <strong class="font-bold">{{ __('common.success') }}!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4" x-data="{ show: true }" x-show="show" x-transition
                     x-init="setTimeout(() => show = false, 4000)">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-md" role="alert">
                        <strong class="font-bold">{{ __('common.error') }}:</strong>
                        <span class="block sm:inline">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif
            <!-- ✅ End Flash Messages -->

            <!-- Header Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-8 sm:p-10 text-center">
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $plan->name }}
                    </h1>
                    <p class="mt-2 text-gray-600">
                        {{ $plan->description ?? __('common.not_available') }}
                    </p>

                    <!-- Pricing Summary -->
                    <div class="mt-6 flex justify-center gap-4">
                        <div class="bg-gray-100 px-4 py-2 rounded-lg text-center">
                            <p class="text-sm text-gray-500">{{ __('plans.price_monthly') }}</p>
                            <p class="text-lg font-semibold text-gray-900">
                                ${{ number_format($plan->price_monthly, 2) }}
                            </p>
                        </div>

                        <div class="bg-gray-100 px-4 py-2 rounded-lg text-center">
                            <p class="text-sm text-gray-500">{{ __('plans.price_yearly') }}</p>
                            <p class="text-lg font-semibold text-gray-900">
                                ${{ number_format($plan->price_yearly, 2) }}
                            </p>
                        </div>

                        @if($plan->yearly_discount_percent)
                            <div class="bg-green-100 px-4 py-2 rounded-lg text-center">
                                <p class="text-sm text-gray-500">{{ __('plans.yearly_discount_percent') }}</p>
                                <p class="text-lg font-semibold text-green-700">
                                    {{ $plan->yearly_discount_percent }}%
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Features Section -->
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('plans.features') }}</h3>
                        </div>
                        <div class="px-6 py-4">
                            @if(!empty($plan->features) && is_array($plan->features))
                                <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                                    @foreach($plan->features as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500">{{ __('common.not_available') }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('plans.description') }}</h3>
                        </div>
                        <div class="px-6 py-4 text-gray-700">
                            {!! nl2br(e($plan->description ?? __('common.not_available'))) !!}
                        </div>
                    </div>

                    <!-- 🔹 Courses Section -->
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('plans.courses_associated_with_plan') }}</h3>
                        </div>
                        <div class="px-6 py-4">
                            @if($plan->courses && $plan->courses->count() > 0)
                                <ul class="list-disc list-inside text-gray-700 space-y-1">
                                    @foreach($plan->courses as $course)
                                        <li>
                                            {{ is_array($course->name) ? ($course->name['ar'] ?? $course->name['en']) : $course->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500">{{ __('plans.no_courses_associated') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Statistics -->
                    @php
                        $monthlySubs = $plan->subscriptions()->where('billing_cycle', 'monthly')->count();
                        $yearlySubs = $plan->subscriptions()->where('billing_cycle', 'yearly')->count();
                        $totalRevenue = ($monthlySubs * $plan->price_monthly) + ($yearlySubs * $plan->price_yearly);
                    @endphp

                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('plans.statistics') }}</h3>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-2 gap-4 text-center">
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <dt class="text-sm text-gray-500">{{ __('plans.subscriptions_count') }}</dt>
                                <dd class="text-xl font-semibold text-gray-900">
                                    {{ $plan->subscriptions()->count() ?? 0 }}
                                </dd>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <dt class="text-sm text-gray-500">{{ __('plans.total_revenue') }}</dt>
                                <dd class="text-xl font-semibold text-gray-900">
                                    ${{ number_format($totalRevenue, 2) }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
