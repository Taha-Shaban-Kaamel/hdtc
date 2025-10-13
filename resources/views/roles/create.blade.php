<x-app-layout>
    <div class="py-5 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 !pt-9">
            <x-breadcrumb :items="[
                ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                ['url' => route('roles.index'), 'label' => __('common.roles')],
                ['label' => __('roles.add_role')],
            ]" />
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form-section submit="store" :action="route('roles.store')">
                <x-slot name="title" class="text-xl font-bold text-gray-900">
                    {{ __('roles.add_role') }}
                </x-slot>

                <x-slot name="description" class="text-gray-600">
                    {{ __('roles.add_role_description') }}
                </x-slot>

                <x-slot name="form">

                    <div class="mt-4 col-span-3">
                        <x-label for="name" value="{{ __('common.name') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full" name="name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>


                </x-slot>

                <x-slot name="actions">
                    <div class="flex justify-end">
                        <x-button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm leading-tight rounded-md shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            {{ __('common.create') }}

                        </x-button>
                    </div>
                </x-slot>
            </x-form-section>
        </div>
    </div>

</x-app-layout>,
