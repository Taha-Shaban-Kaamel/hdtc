<x-app-layout>
    <div class="py-5 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 !pt-9">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('courses.index'), 'label' => __('common.courses')],
                        ['label' => __('chapters.chapters_for') . ': ' . $course->name]
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
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    {{ __('chapters.chapters_for') }}: {{ $course->name }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('chapters.manage_chapters_description') }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('chapters.create', $course->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    {{ __('chapters.add_chapter') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('chapters.order') }}
                                    </th>
                                    <th class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('chapters.name_en') }}
                                    </th>
                                    <th class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('chapters.name_ar') }}
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        {{ __('common.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($chapters as $chapter)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $chapter->order }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $chapter->getTranslation('name','en') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm text-gray-900" dir="rtl">
                                                {{ $chapter->getTranslation('name','ar') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap  text-sm font-medium t">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('chapters.edit', ['course_id' => $course->id, 'id' => $chapter->id]) }}" 
                                                    class="text-indigo-600 hover:text-indigo-900" 
                                                    title="{{ __('common.edit') }}">
                                                     <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                     </svg>
                                                 </a>
                                                <form action="{{ route('chapters.destroy', ['course_id' => $course->id, 'id' => $chapter->id]) }}" method="POST" class="inline">                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" 
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
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            {{ __('chapters.no_chapters_found') }}
                                            <a href="{{ route('chapters.create', $course->id) }}" class="text-indigo-600 hover:text-indigo-900 ml-1">
                                                {{ __('chapters.create_one') }}
                                            </a>
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

                