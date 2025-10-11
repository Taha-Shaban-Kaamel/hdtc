<x-app-layout>
    <div class="py-5 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 !pt-9">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['label' => __('common.courses')],
                    ]" />
                </div>
            </div>
        </div>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header Section -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div
                            class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    {{ __('common.courses') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('courses.description') }}
                                </p>
                            </div>
                            <div class="flex space-x-2">

                                <a href="{{ route('courses.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    {{ __('courses.create') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('courses.title') }}</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('courses.instructors') }}</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('courses.difficulty_level') }}</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('courses.duration') }}</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('courses.price') }}</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('common.status') }}</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('courses.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($courses as $course)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap flex items-center justify-center">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if ($course['thumbnail'])
                                                        <img class="h-10 w-10 rounded-full object-cover"
                                                            src="{{ asset($course['thumbnail']) }}"
                                                            alt="{{ $course['title'] }}">
                                                    @else
                                                        <div
                                                            class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center shadow-sm">
                                                            <svg class="h-5 w-5 text-indigo-500" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5"
                                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $course['title'] }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        @foreach ($course['categories'] as $category)
                                                            <span
                                                                class="inline-flex items-center px-2.5 p-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                                {{ $category['name'] }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center  gap-3 lg:!h-[40px] overflow-scroll">
                                                @forelse($course['instructors'] as $instructor)
                                                    <div class="flex items-center gap-1">
                                                        <div class="flex-shrink-0 h-8 w-8">
                                                            @if (isset($instructor['avatar']))
                                                                <img class="h-8 w-8 rounded-full object-cover"
                                                                    src="{{ asset('storage/' . $instructor['avatar']) }}"
                                                                    alt="{{ $instructor['name'] }}">
                                                            @else
                                                                <div
                                                                    class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                                    <svg class="h-5 w-5 text-gray-400"
                                                                        fill="currentColor" viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M12 14.75C8.28 14.75 4.25 15.92 4.25 18.25C4.25 20.58 8.28 21.75 12 21.75C15.72 21.75 19.75 20.58 19.75 18.25C19.75 15.92 15.72 14.75 12 14.75Z">
                                                                        </path>
                                                                        <path
                                                                            d="M12 13C14.7614 13 17 10.7614 17 8C17 5.23858 14.7614 3 12 3C9.23858 3 7 5.23858 7 8C7 10.7614 9.23858 13 12 13Z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <span
                                                            class="ml-2 text-sm text-gray-600">{{ $instructor['name'] }}</span>
                                                    </div>
                                                @empty
                                                    <span class="text-sm text-gray-500">{{ __('common.none') }}</span>
                                                @endforelse
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $difficultyClasses =
                                                    [
                                                        'beginner' => 'bg-green-100 text-green-800',
                                                        'intermediate' => 'bg-yellow-100 text-yellow-800',
                                                        'advanced' => 'bg-red-100 text-red-800',
                                                    ][$course['difficulty_degree']] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $difficultyClasses }}">
                                                {{ $course['difficulty_degree'] ? __('courses.' . $course['difficulty_degree']) : '' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500  justify-center">
                                            {{ $course['duration'] }} {{ __('common.hour') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                            ${{ number_format($course['price'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($course['status'] === 'active')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800  items-center justify-center">
                                                    {{ __('common.active') }}
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800  items-center justify-center">
                                                    {{ __('common.inactive') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">

                                                <div class="flex space-x-1">
                                                    <a href="{{ route('courses.show', $course['id']) }}"
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                        title="{{ __('common.view') }}">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('courses.edit', $course['id']) }}"
                                                        class="text-blue-600 hover:text-blue-900"
                                                        title="{{ __('common.edit') }}">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('courses.destroy', $course['id']) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                                            title="{{ __('common.delete') }}"
                                                            onclick="return confirm('{{ __('Are you sure you want to delete this course?') }}')">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('chapters.index', $course['id']) }}"
                                                        class="text-green-600 hover:text-green-900"
                                                        title="{{ __('chapters.manage') }}">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 w-full">
                                            <div class="text-gray-500 text-center w-full">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <p class="mt-2 text-sm font-medium">
                                                    {{ __('courses.no_courses_found') }}</p>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    {{ __('courses.get_started_by_creating_a_new_course') }}</p>
                                                <div class="mt-4">
                                                    <a href="{{ route('courses.create') }}"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                        {{ __('courses.new_category') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- @if ($courses->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $courses->links() }}
                    </div>
                @endif --}}
                </div>
            </div>
        </div>
</x-app-layout>
