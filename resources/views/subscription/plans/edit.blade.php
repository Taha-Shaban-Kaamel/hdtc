<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                <x-form-section method="POST" :action="route('plans.update', ['id' => $plan->id])" enctype="multipart/form-data">
                    @method('PUT')

                    <x-slot name="title">
                        {{ __('plans edit') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('Description') }}
                    </x-slot>

                    <x-slot name="form" class="grid grid-cols-6 gap-6">

                        <!-- Plan Name -->
                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="name" :value="__('plans.name')" />
                            <x-input id="name" type="text" class="mt-1 block w-full" name="name"
                                     value="{{ old('name', $plan->name) }}" required />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="description" :value="__('plans.description')" />
                            <textarea id="description" name="description"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $plan->description) }}</textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        <!-- Monthly Price -->
                        <div class="lg:col-span-2 sm:col-span-3">
                            <x-label for="price_monthly" :value="__('plans.price_monthly')" />
                            <x-input id="price_monthly" type="number" step="0.01" class="mt-1 block w-full" name="price_monthly"
                                     value="{{ old('price_monthly', $plan->price_monthly) }}" required />
                            <x-input-error for="price_monthly" class="mt-2" />
                        </div>

                        <!-- Yearly Price -->
                        <div class="lg:col-span-2 sm:col-span-3">
                            <x-label for="price_yearly" :value="__('plans.price_yearly')" />
                            <x-input id="price_yearly" type="number" step="0.01" class="mt-1 block w-full" name="price_yearly"
                                     value="{{ old('price_yearly', $plan->price_yearly) }}" required />
                            <x-input-error for="price_yearly" class="mt-2" />
                        </div>

                        <!-- Yearly Discount -->
                        <div class="lg:col-span-2 sm:col-span-3">
                            <x-label for="yearly_discount_percent" :value="__('plans.yearly_discount_percent')" />
                            <x-input id="yearly_discount_percent" type="number" class="mt-1 block w-full" name="yearly_discount_percent"
                                     value="{{ old('yearly_discount_percent', $plan->yearly_discount_percent) }}" />
                            <x-input-error for="yearly_discount_percent" class="mt-2" />
                        </div>



                        <!-- Features -->
                        <div class="lg:col-span-6 sm:col-span-6">
                            <x-label for="features" :value="__('plans.features')" />
                            <textarea id="features" name="features"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      rows="6"
                                      placeholder="{{ __('plans.features_placeholder') }}">{{ old('features', is_array($plan->features) ? implode("\n", $plan->features) : $plan->features) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">{{ __('plans.features_hint') }}</p>
                            <x-input-error for="features" class="mt-2" />
                        </div>

                    </x-slot>

                    <x-slot name="actions">
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('plans.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                {{ __('Back to List') }}
                            </a>

                            <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white">
                                {{ __('plans.update') }}
                            </x-button>
                        </div>
                    </x-slot>
                </x-form-section>
            </div>
        </div>
    </div>

</x-app-layout>
