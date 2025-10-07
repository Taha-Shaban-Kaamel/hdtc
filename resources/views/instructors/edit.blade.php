<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('instructors.edit_instructor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                <x-instructors.form-stepper 
                    :steps="4" 
                    :currentStep="1" 
                    :totalSteps="4" 
                    :action="route('instructors.update', $instructor->id)" 
                    :method="'PUT'" 
                    :redirect="route('instructors.index')" 
                    :instructor="$instructor"
                />
            </div>
        </div>
    </div>
</x-app-layout>
