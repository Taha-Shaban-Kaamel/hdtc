<x-app-layout>
    <div class="py-4 max-h-[calc(100vh-12rem)]">
        <!-- 🧭 Breadcrumb -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('reports.index'), 'label' => __('reports.reports')],
                        ['label' => __('reports.courses_reports')],
                    ]" />
                </div>
            </div>
        </div>

        <!-- 📊 المحتوى -->
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- 🧩 العنوان والأزرار -->
                    <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ __('reports.courses_reports') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ __('reports.courses_reports_description') }}
                            </p>
                        </div>

                        <!-- أزرار التصدير -->
                        <div class="flex gap-3 mt-4 md:mt-0">
                            <a href="{{ route('reports.courses.export.excel') }}"
                               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('reports.export_excel') }}
                            </a>

                            <a href="{{ route('reports.courses.export.pdf') }}"
                               class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('reports.export_pdf') }}
                            </a>
                        </div>
                    </div>

                    <!-- 📋 جدول الكورسات -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-center">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">#</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">{{ __('reports.course') }}</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">{{ __('reports.instructor') }}</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">{{ __('reports.plans_reports') }}</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">{{ __('reports.chapters') }}</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">{{ __('reports.lectures') }}</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">{{ __('reports.views') }}</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">{{ __('reports.price') }}</th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($courses as $course)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                        {{ is_array($course->name) ? ($course->name[app()->getLocale()] ?? reset($course->name)) : $course->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ optional($course->instructors->first())->name ?? __('reports.no_data') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $course->plans_count ?? 0 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $course->chapters->count() ?? 0 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $course->lectures()->count() ?? 0 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                        {{ number_format($course->lectures_sum_lecture_views ?? 0) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $course->price ? number_format($course->price, 2) . ' EGP' : __('common.free') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                        {{ __('reports.no_data') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($courses->hasPages())
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
