<x-app-layout>

    <div class="py-8 mt-5  max-h-[calc(100vh-20rem)]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-8 sm:p-10">
                    <div class="md:flex md:flex-col md:items-center text-center">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 h-24 w-24 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                    <img class="h-full w-full object-cover"
                                        src="{{ $instructor->user->avatar ? asset('storage/instructors/' . $instructor->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($instructor->user->getTranslation('first_name', app()->getLocale()) . ' ' . $instructor->user->getTranslation('second_name', app()->getLocale())) . '&size=512&color=7F9CF5&background=EBF4FF' }}"
                                        alt="{{ $instructor->user->getTranslation('first_name', app()->getLocale()) }} {{ $instructor->user->getTranslation('second_name', app()->getLocale()) }}">
                                </div>
                                <div class="ml-6">
                                    <h1 class="text-2xl font-bold text-gray-900">
                                        {{ $instructor->user->getTranslation('first_name', app()->getLocale()) }}
                                        {{ $instructor->user->getTranslation('second_name', app()->getLocale()) }}
                                    </h1>
                                    <p class="text-gray-600">
                                        {{ $instructor->specialization ?? __('instructors.no_specialization') }}
                                    </p>
                                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                    clip-rule="evenodd" />
                                                <path
                                                    d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                            </svg>
                                            {{ $instructor->experience ?? '0' }}
                                            {{ __('instructors.years_experience') }}
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84l5.5 2.35L9.49 9.42a1 1 0 01.2-.2l1.8-1.8 5.5 2.35a1 1 0 00.94-.06l4-2.5a1 1 0 00.32-1.41l-8-10z" />
                                                <path d="M3.5 12.5l-1.8-1.8 1.32-1.32 1.8 1.8-1.32 1.32z" />
                                                <path d="M5.6 14.4l-1.8-1.8 1.32-1.32 1.8 1.8-1.32 1.32z" />
                                                <path d="M7.8 16.2l-1.8-1.8 1.32-1.32 1.8 1.8-1.32 1.32z" />
                                                <path d="M9.5 18l-1.8-1.8 1.32-1.32 1.8 1.8-1.32 1.32z" />
                                            </svg>
                                            {{ $instructor->getTranslation('education', app()->getLocale()) ?? __('instructors.no_education') }}
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $instructor->company ?? __('instructors.no_company') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex flex-wrap gap-3 justify-center">
                                <a href="{{ route('instructors.edit', $instructor) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    {{ __('common.edit') }}
                                </a>
                                <form action="{{ route('instructors.destroy', $instructor) }}" method="POST"
                                    onsubmit="return confirm('{{ __('instructors.confirm_delete') }}')">
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
                        <!-- Social Links -->
                        <div class="mt-6 flex flex-shrink-0 md:mt-0 md:ml-4">
                            @if ($instructor->twitter_url)
                                <a href="{{ $instructor->twitter_url }}" target="_blank"
                                    class="text-gray-400 hover:text-blue-500">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                            @endif
                            @if ($instructor->linkedin_url)
                                <a href="{{ $instructor->linkedin_url }}" target="_blank"
                                    class="ml-3 text-gray-400 hover:text-blue-700">
                                    <span class="sr-only">LinkedIn</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                            @endif
                            @if ($instructor->facebook_url)
                                <a href="{{ $instructor->facebook_url }}" target="_blank"
                                    class="ml-3 text-gray-400 hover:text-blue-600">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                            @if ($instructor->youtube_url)
                                <a href="{{ $instructor->youtube_url }}" target="_blank"
                                    class="ml-3 text-gray-400 hover:text-red-600">
                                    <span class="sr-only">YouTube</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M19.812 5.418c.861.23 1.538.907 1.768 1.768.386 1.445.42 4.46.42 4.81s-.034 3.365-.42 4.81c-.23.861-.907 1.538-1.768 1.768-1.445.386-7.277.42-7.687.42s-6.242-.034-7.687-.42c-.861-.23-1.538-.907-1.768-1.768C2.034 15.365 2 12.35 2 12s.034-3.365.42-4.81c.23-.861.907-1.538 1.768-1.768C5.633 5.034 11.465 5 11.875 5s6.242.034 7.687.42zM10 15.5l6-3.5-6-3.5v7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Left Column -->
                <div class="lg:col-span-2 mx-auto w-full">
                    <!-- About Section -->
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('instructors.about') }}</h3>
                        </div>
                        <div class="px-6 py-4">
                            <div class="prose max-w-none">
                                {!! nl2br(e($instructor->bio ?? __('instructors.no_bio'))) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Experience Section -->
                    <div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('instructors.experience') }}</h3>
                        </div>
                        <div class="px-6 py-4">
                            <div class="space-y-4">

                                <div>
                                    <h4 class="font-medium text-gray-900">
                                        {{ $instructor->company ?? __('instructors.no_company') }}</h4>
                                    <p class="text-sm text-gray-500">{{ $instructor->experience ?? '0' }}
                                        {{ __('instructors.years_experience') }}</p>
                                    <p class="mt-1 text-gray-600">{{ $instructor->specialization ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8 mx-auto w-full">
                    <!-- Contact Information -->
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('instructors.contact_information') }}
                            </h3>
                        </div>
                        <div class="px-6 py-4">
                            <ul class="space-y-3">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ $instructor->user->email }}</span>
                                </li>
                                @if ($instructor->user->phone)
                                    <li class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        <span class="ml-3 text-gray-600">{{ $instructor->user->phone }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('instructors.education') }}</h3>
                        </div>
                        <div class="px-6 py-4">
                            <div class="space-y-2">
                                <h4 class="font-medium text-gray-900">
                                    {{ $instructor->education ?? __('instructors.no_education') }}</h4>
                                <p class="text-sm text-gray-600">{{ $instructor->experience ?? '0' }}
                                    {{ __('instructors.years_experience') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Instructor Details -->
            <div class="w-full md:w-2/3 lg:w-3/4">
                {{-- <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $instructor->user->first_name }}
                    {{ $instructor->user->second_name }}</h3> --}}

                <div class="space-y-4">
                    <!-- Contact Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-900 mb-3">{{ __('instructors.info') }}
                        </h4>
                        <dl class="space-y-3">
                            <div class="sm:flex">
                                <dt class="text-sm font-medium text-gray-500 sm:w-32 sm:flex-shrink-0">
                                    {{ __('instructors.email') }}</dt>
                                <dd class="text-sm text-gray-900">{{ $instructor->user->email }}</dd>
                            </div>
                            @if ($instructor->user->phone)
                                <div class="sm:flex">
                                    <dt class="text-sm font-medium text-gray-500 sm:w-32 sm:flex-shrink-0">
                                        {{ __('instructors.phone') }}</dt>
                                    <dd class="text-sm text-gray-900">{{ $instructor->user->phone }}</dd>
                                </div>
                            @endif
                            @if ($instructor->user->gender)
                                <div class="sm:flex">
                                    <dt class="text-sm font-medium text-gray-500 sm:w-32 sm:flex-shrink-0">
                                        {{ __('instructors.gender') }}</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ ucfirst(__('instructors.' . $instructor->user->gender)) }}</dd>
                                </div>
                            @endif
                            @if ($instructor->user->birth_date)
                                <div class="sm:flex">
                                    <dt class="text-sm font-medium text-gray-500 sm:w-32 sm:flex-shrink-0">
                                        {{ __('instructors.birth_date') }}</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($instructor->user->birth_date)->format('M d, Y') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Bio -->
                    @if ($instructor->bio)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 mb-3">{{ __('instructors.bio') }}</h4>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($instructor->bio)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 text-center">
                            <dt class="text-sm font-medium text-gray-500">{{ __('instructors.courses') }}</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                {{ $instructor->courses_count ?? 0 }}</dd>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 text-center">
                            <dt class="text-sm font-medium text-gray-500">{{ __('instructors.students') }}</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                {{ $instructor->students_count ?? 0 }}</dd>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 text-center">
                            <dt class="text-sm font-medium text-gray-500">{{ __('instructors.rating') }}</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                {{ number_format($instructor->average_rating ?? 0, 1) }}
                                <span class="text-yellow-500">★</span>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</x-app-layout>
