
<x-app-layout>
    <div class="py-4">
        <div class="px-6 ">
            <div class="flex lg:flex-row items-start lg:items-center space-y-4 lg:space-y-0 h-[100px]">
                <div class="px-6 py-4 ">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('courses.index'), 'label' => __('common.courses')],
                        ['label' => __('common.create')]
                    ]" />
                </div>
            </div>
        </div>


        <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                <x-form-stepper :currentStep="1" :totalSteps="4" :instructors="$instructors" :categories="$categories"/>
            </div>
        </div>
    </div>


        
</x-app-layout>



