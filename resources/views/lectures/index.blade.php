<x-app-layout>
    <div class="py-5 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 !pt-9">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('courses.index'), 'label' => __('common.courses')],
                        ['url' => route('chapters.index', $course->id), 'label' => $course->getTranslation('name', app()->getLocale())],
                        ['label' => $chapter->getTranslation('name', app()->getLocale())]
                    ]" />
                </div>
                <div>
                    <a href="{{ route('lectures.create', [$course->id, $chapter->id]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        {{ __('lectures.add_lecture') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-6">
                        {{ $chapter->getTranslation('name', app()->getLocale()) }} - {{ __('lectures.lectures') }}
                    </h2>
                    <p class="text-gray-600 mb-6">{{ __('lectures.manage_lectures_description') }}</p>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('lectures.title') }}</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('lectures.type') }}</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('common.order') }}</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($lectures as $lecture)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $lecture->getTranslation('title', app()->getLocale()) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $lecture->type === 'exam' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $lecture->type === 'exam' ? __('lectures.type_exam') : __('lectures.type_lecture') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $lecture->order }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex justify-center">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('lectures.edit', [$course->id, $chapter->id, $lecture->id]) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900"
                                                   title="{{ __('common.edit') }}">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('lectures.destroy', [$course->id, $chapter->id, $lecture->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900"
                                                            title="{{ __('common.delete') }}"
                                                            onclick="return confirm('{{ __('common.are_you_sure') }}')">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center">
                                            <div class="text-gray-500">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <p class="mt-2 text-sm font-medium">{{ __('lectures.no_lectures_found') }}</p>
                                                <p class="mt-1 text-xs text-gray-500">{{ __('lectures.get_started_by_creating') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>