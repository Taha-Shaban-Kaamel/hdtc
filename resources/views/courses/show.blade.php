<x-app-layout>

    <div class="py-4 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('courses.index'), 'label' => __('common.courses')],
                        ['label' => $course->getTranslation('title', app()->getLocale())],
                    ]" />
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="h-64 bg-cover bg-center"
                    style="background-image: url('{{ $course->cover ? asset($course->cover) : asset('images/default-course-cover.jpg') }}')">
                </div>

                <div class="px-6 py-8 sm:p-10">
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="flex-1 min-w-0">
                            <h1 class="text-3xl font-bold text-gray-900">
                                {{ $course->getTranslation('title', app()->getLocale()) }}
                            </h1>
                            <p class="mt-2 text-lg text-gray-600">
                                {{ $course->getTranslation('name', app()->getLocale()) }}
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-4">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $course->duration }} {{ __('courses.hours') }}
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.584 1.065 2.693 1.093V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.584-1.065-2.693-1.093V5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    ${{ number_format($course->price, 2) }}
                                </div>
                                <div
                                    class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ __('courses.' . $course->difficulty_deree) }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex flex-wrap gap-3 md:mt-0">
                            <a href="{{ route('courses.edit', $course) }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                {{ __('common.edit') }}
                            </a>

                            <a href="{{ route('chapters.index', $course) }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                </svg>
                                {{ __('chapters.manage') }}
                            </a>

                            <form action="{{ route('courses.destroy', $course) }}" method="POST"
                                onsubmit="return confirm('{{ __('courses.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ __('common.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Course Content -->
                    <div class="mt-12 grid grid-cols-1 gap-8 lg:grid-cols-3">
                        <!-- Left Column -->
                        <div class="lg:col-span-2">
                            <!-- Course Description -->
                            <div class="prose max-w-none">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('courses.description') }}</h3>
                                <div class="text-gray-700">
                                    {!! nl2br(e($course->getTranslation('description', app()->getLocale()))) !!}
                                </div>
                            </div>

                            <!-- Course Objectives -->
                            <div class="mt-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    {{ __('courses.learning_objectives') }}</h3>
                                <div class="text-gray-700">
                                    {!! nl2br(e(is_array($course->getTranslation('objectives', app()->getLocale())) ? 
                                    implode("\n", $course->getTranslation('objectives', app()->getLocale())) : 
                                    $course->getTranslation('objectives', app()->getLocale()))) !!}                                </div>
                            </div>

                            <!-- Video Preview -->
                            {{-- @if ($course->video)
                            <div class="mt-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('courses.course_preview') }}</h3>
                                <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                                    <iframe class="w-full h-96" src="{{ $course->video }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                            @endif --}}
                        </div>

                        <!-- Right Column -->
                        <div class="lg:col-span-1">
                            <!-- Instructors -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('courses.instructors') }}</h3>
                                <ul class="space-y-4">
                                    @forelse($course->instructors as $instructor)
                                        <li class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden">
                                                <img class="h-full w-full object-cover"
                                                    src="{{ $instructor->user->avatar ? asset('storage/' . $instructor->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($instructor->user->getTranslation('first_name', app()->getLocale()) . ' ' . $instructor->user->getTranslation('second_name', app()->getLocale())) . '&size=512' }}"
                                                    alt="{{ $instructor->user->getTranslation('first_name', app()->getLocale()) }}">
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $instructor->user->getTranslation('first_name', app()->getLocale()) }}
                                                    {{ $instructor->user->getTranslation('second_name', app()->getLocale()) }}
                                                </p>
                                                @if ($instructor->specialization)
                                                    <p class="text-sm text-gray-500">{{ $instructor->specialization }}
                                                    </p>
                                                @endif
                                            </div>
                                        </li>
                                    @empty
                                        <p class="text-sm text-gray-500">{{ __('courses.no_instructors') }}</p>
                                    @endforelse
                                </ul>
                            </div>

                            <!-- Categories -->
                            <div class="mt-6 bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('courses.categories') }}</h3>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($course->categories as $category)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $category->getTranslation('name', app()->getLocale()) }}
                                        </span>
                                    @empty
                                        <p class="text-sm text-gray-500">{{ __('courses.no_categories') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
