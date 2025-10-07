<x-app-layout>
    <div class="py-4 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('courses.index'), 'label' => __('common.courses')],
                        ['url' => route('chapters.index'), 'label' => __('chapters.chapters')],
                        ['label' => __('common.create')]
                    ]" />
                </div>
            </div>
        </div>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                            {{ __('chapters.create_new_chapter') }}
                        </h2>

                        <form action="{{ route('chapters.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Chapter Name -->
                            <div>
                                <x-label for="name_ar" :value="__('chapters.name_ar')" />
                                <x-input id="name_ar" name="name[ar]" type="text" class="mt-1 block w-full" :value="old('name.ar')" required autofocus />
                                @error('name.ar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <x-label for="name_en" :value="__('chapters.name_en')" />
                                <x-input id="name_en" name="name[en]" type="text" class="mt-1 block w-full" :value="old('name.en')" required />
                                @error('name.en')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Course Selection -->
                            <div class="mt-4">
                                <x-label for="course_id" :value="__('chapters.course')" />
                                <select id="course_id" name="course_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">
                                            {{ $course->getTranslation('name', app()->getLocale()) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Order -->
                            <div class="mt-4">
                                <x-label for="order" :value="__('chapters.order')" />
                                <x-input id="order" name="order" type="number" min="1" class="mt-1 block w-32" :value="old('order', 1)" required />
                                @error('order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center justify-end mt-6">
                                <a href="{{ route('chapters.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('common.cancel') }}
                                </a>
                                <x-button class="ml-4">
                                    {{ __('common.save') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
