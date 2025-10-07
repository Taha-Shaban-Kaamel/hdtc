<x-app-layout>
    <div class="py-4 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('courses.index'), 'label' => __('common.courses')],
                        ['label' => __('common.edit') . ': ' . $course->getTranslation('title', app()->getLocale())]
                    ]" />
                </div>
            </div>
        </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                <x-form-stepper 
                    :course="$course"
                    :currentStep="1" 
                    :totalSteps="3" 
                    :instructors="$instructors" 
                    :categories="$categories"
                />
            </div>
        </div>
    </div>
</x-app-layout>
