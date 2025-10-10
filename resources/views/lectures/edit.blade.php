<x-app-layout>
    <div class="py-6 max-h-[calc(100vh-12rem)]">
        <div class="h-[100px] py-6 px-6 flex items-center">
            <x-breadcrumb :items="[
                ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                ['url' => route('courses.index'), 'label' => __('common.courses')],
                [
                    'url' => route('chapters.index', $course->id),
                    'label' => $course->getTranslation('name', app()->getLocale()),
                ],
                [
                    'url' => route('lectures.index', [$course->id, $chapter->id]),
                    'label' => $chapter->getTranslation('name', app()->getLocale()),
                ],
                ['label' => __('lectures.edit_lecture')],
            ]" />
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form-section :action="route('lectures.update', [$course->id, $chapter->id, $lecture->id])" method="PUT">
      
                <x-slot name="title" class="text-xl font-bold text-gray-900">
                    {{ __('lectures.edit_lecture') }}
                </x-slot>

                <x-slot name="description" class="text-gray-600">
                    {{ __('lectures.edit_lecture_description') }}
                </x-slot>

                <x-slot name="form">
                    <div class="mt-4 col-span-3">
                        <x-label for="title_ar" value="{{ __('lectures.title_ar') }}" />
                        <x-input id="title_ar" type="text" class="mt-1 block w-full" name="title_ar"
                            :value="old('title_ar', $lecture->getTranslation('title', 'ar'))" autofocus />
                        <x-input-error for="title_ar" class="mt-2" />
                    </div>

                    <div class="mt-4 col-span-3">
                        <x-label for="title_en" value="{{ __('lectures.title_en') }}" />
                        <x-input id="title_en" type="text" class="mt-1 block w-full" name="title_en"
                            :value="old('title_en', $lecture->getTranslation('title', 'en'))" />
                        <x-input-error for="title_en" class="mt-2" />
                    </div>

                    <div class="mt-4 col-span-3">
                        <x-label for="video_url" value="{{ __('lectures.video_url') }}" />
                        <x-input id="video_url" type="url" class="mt-1 block w-full" name="video_url"
                            :value="old('video_url', $lecture->video_url)" />
                        <x-input-error for="video_url" class="mt-2" />
                    </div>

                    <div class="mt-4 col-span-3">
                        <x-label for="order" value="{{ __('common.order') }}" />
                        <x-input id="order" type="number" class="mt-1 block w-full" name="order"
                            :value="old('order', $lecture->order)" min="0" />
                        <x-input-error for="order" class="mt-2" />
                    </div>

                    <div class="mt-4" x-show="type === 'exam'">
                        <x-label for="exam" value="{{ __('lectures.exam_details') }}" />
                        <textarea id="exam"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            rows="3" name="exam">{{ old('exam', $lecture->exam) }}</textarea>
                        <x-input-error for="exam" class="mt-2" />
                    </div>
                    
                    <input type="hidden" name="type" value="{{ $lecture->type }}">
                </x-slot>

                <x-slot name="actions">
                    <div class="flex justify-end">
                        <x-button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm leading-tight rounded-md shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            {{ __('common.update') }}
                        </x-button>
                    </div>
                </x-slot>
            </x-form-section>
        </div>
    </div>
</x-app-layout>