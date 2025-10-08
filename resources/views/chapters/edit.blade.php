<x-app-layout>
    <div class="py-12">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('courses.index'), 'label' => __('common.courses')],
                        ['url' => route('chapters.index', $course->id), 'label' => __('chapters.chapters')],
                        ['label' => __('common.edit')]
                    ]" />
                </div>
            </div>
        </div>

        <div>
            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                <x-form-section method="POST" :action="route('chapters.update',['course_id'=> $course->id , 'id' => $chapter?->id])">
                    @csrf
                    @method('PUT')
                    <x-slot name="title" class="text-xl font-bold text-gray-900">
                        {{ __('chapters.chapter_information') }}
                    </x-slot>

                    <x-slot name="description" class="text-gray-600">
                        {{ __('chapters.create_a_new_chapter') }}
                    </x-slot>

                    <x-slot name="form" class="grid grid-cols-6 gap-6">
                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="name_ar" value="{{ __('chapters.name_ar') }}" />
                            <x-input id="name_ar" type="text" class="mt-1 block w-full" name="name_ar"
                                value="{{ old('name_ar', $chapter?->getTranslation('name','ar') ) }}" required autofocus />
                            @if ($errors->has('name_ar'))
                                <x-input-error for="name_ar" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="name_en" value="{{ __('chapters.name_en') }}" />
                            <x-input id="name_en" type="text" class="mt-1 block w-full" name="name_en"
                                value="{{ old('name_en',$chapter?->getTranslation('name','en')) }}" required />
                            @if ($errors->has('name_en'))
                                <x-input-error for="name_en" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="order" value="{{ __('chapters.order') }}" />
                            <x-input id="order" type="number" class="mt-1 block w-full" name="order"
                                value="{{ old('order' , $chapter?->order) }}" required min="1" />
                            @if ($errors->has('order'))
                                <x-input-error for="order" class="mt-2" />
                            @endif
                        </div>
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                    </x-slot>

                    <x-slot name="actions">
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('chapters.index', $course->id) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('common.cancel') }}
                            </a>
                            <x-button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm leading-tight rounded-md shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                {{ __('common.save') }}
                            </x-button>
                        </div>
                    </x-slot>
                </x-form-section>
            </div>
        </div>
    </div>
</x-app-layout>
