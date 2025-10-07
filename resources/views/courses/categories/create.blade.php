<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('courses.create_course_category') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                <x-form-section method="POST" action="store" >
                    <x-slot name="title" class="text-xl font-bold text-gray-900">
                        {{ __('courses.category_information') }}
                    </x-slot>

                    <x-slot name="description" class="text-gray-600">
                        {{ __('courses.create_a_new_course_category') }}
                    </x-slot>

                    <x-slot name="form" class="grid grid-cols-6 gap-6">
                      
                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="name_ar" value="{{ __('courses.name_ar') }}" />
                            <x-input id="name_ar" type="text" class="mt-1 block w-full" name="name_ar"
                                value="{{ old('name_ar') }}" autofocus />
                            @if ($errors->has('name_ar'))
                                <x-input-error for="name_ar" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="name_en" value="{{ __('courses.name_en') }}" />
                            <x-input id="name_en" type="text" class="mt-1 block w-full" name="name_en"
                                value="{{ old('name_en') }}" autofocus />
                            @if ($errors->has('name_en'))
                                <x-input-error for="name_en" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="description_ar" value="{{ __('courses.description_ar') }}" />
                            <textarea id="description_ar" name="description_ar" value="{{ old('description_ar') }}"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            @if ($errors->has('description_ar'))
                                <x-input-error for="description_ar" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="description_en" value="{{ __('courses.description_en') }}" />
                            <textarea id="description_en" name="description_en" value="{{ old('description_en') }}"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            @if ($errors->has('description_en'))
                                <x-input-error for="description_en" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-6 sm:col-span-6">
                            <x-label for="image" value="{{ __('courses.image') }}" />
                            <x-image-input name="image" />
                            @if ($errors->has('image'))
                                <x-input-error for="image" :message="$errors->first('image')" class="mt-2" />
                            @endif
                        </div>

                    </x-slot>


                    <x-slot name="actions">
                        <div class="flex justify-end">
                            <x-button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm leading-tight rounded-md shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                {{ __('courses.create') }}

                            </x-button>
                        </div>
                    </x-slot>
                </x-form-section>
            </div>
        </div>
    </div>
</x-app-layout>
