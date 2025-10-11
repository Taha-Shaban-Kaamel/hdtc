<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('plans.create_plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                <x-form-section method="POST" action="{{ route('plans.store') }}">
                    <x-slot name="title" class="text-xl font-bold text-gray-900">
                        {{ __('plans.plan_information') }}
                    </x-slot>

                    <x-slot name="description" class="text-gray-600">
                        {{ __('plans.create_a_new_plan') }}
                    </x-slot>

                    <x-slot name="form" class="grid grid-cols-6 gap-6">

                        {{-- Plan Name --}}
                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="name" value="{{ __('plans.name') }}" />
                            <x-input id="name" type="text" class="mt-1 block w-full" name="name"
                                     value="{{ old('name') }}" required autofocus />
                            @if ($errors->has('name'))
                                <x-input-error for="name" class="mt-2" />
                            @endif
                        </div>

                        {{-- Description --}}
                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="description" value="{{ __('plans.description') }}" />
                            <textarea id="description" name="description"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <x-input-error for="description" class="mt-2" />
                            @endif
                        </div>

                        {{-- Price Monthly --}}
                        <div class="lg:col-span-2 sm:col-span-4">
                            <x-label for="price_monthly" value="{{ __('plans.price_monthly') }}" />
                            <x-input id="price_monthly" type="number" step="0.01" class="mt-1 block w-full"
                                     name="price_monthly" value="{{ old('price_monthly') }}" required />
                            @if ($errors->has('price_monthly'))
                                <x-input-error for="price_monthly" class="mt-2" />
                            @endif
                        </div>

                        {{-- Price Yearly --}}
                        <div class="lg:col-span-2 sm:col-span-4">
                            <x-label for="price_yearly" value="{{ __('plans.price_yearly') }}" />
                            <x-input id="price_yearly" type="number" step="0.01" class="mt-1 block w-full"
                                     name="price_yearly" value="{{ old('price_yearly') }}" required />
                            @if ($errors->has('price_yearly'))
                                <x-input-error for="price_yearly" class="mt-2" />
                            @endif
                        </div>

                        {{-- Yearly Discount --}}
                        <div class="lg:col-span-2 sm:col-span-4">
                            <x-label for="yearly_discount_percent" value="{{ __('plans.yearly_discount_percent') }}" />
                            <x-input id="yearly_discount_percent" type="number" class="mt-1 block w-full"
                                     name="yearly_discount_percent" value="{{ old('yearly_discount_percent') }}" placeholder="10%" />
                            @if ($errors->has('yearly_discount_percent'))
                                <x-input-error for="yearly_discount_percent" class="mt-2" />
                            @endif
                        </div>




                        {{-- Features --}}
                        <div class="lg:col-span-6 sm:col-span-6">
                            <x-label for="features" value="{{ __('plans.features') }}" />
                            <textarea id="features" name="features"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      placeholder="اكتب المميزات كل ميزة في سطر">{{ old('features') }}</textarea>
                            @if ($errors->has('features'))
                                <x-input-error for="features" class="mt-2" />
                            @endif
                        </div>

                    </x-slot>

                    <x-slot name="actions">
                        <div class="flex justify-end">
                            <x-button type="submit"
                                      class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm leading-tight rounded-md shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                {{ __('plans.create') }}
                            </x-button>
                        </div>
                    </x-slot>
                </x-form-section>
            </div>
        </div>
    </div>
</x-app-layout>
