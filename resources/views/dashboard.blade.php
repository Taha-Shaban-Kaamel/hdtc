@php
    $title = __('Dashboard');
    $description = __('Overview of your platform statistics and analytics');
@endphp

<x-app-layout :title="$title" :description="$description">
    @push('styles')
        <style>
            .chart-container {
                position: relative;
                margin: auto;
                height: 300px;
                width: 100%;
            }
            .dashboard-container {
                min-height: calc(100vh - 4rem);
                width: 100%;
            }
            .dashboard-content {
                height: calc(100vh - 8rem);
                width: 100%;
                overflow-y: auto;
            }
        </style>
    @endpush
    <div class="dashboard-container bg-gray-50">
        <div class="w-full h-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class=" shadow-sm rounded-lg p-6 dashboard-content">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Courses -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Total Courses') }}</h3>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_courses'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Instructors -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Total Instructors') }}</h3>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_instructors'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Enrollments -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Total Enrollments') }}</h3>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_enrollments'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Courses by Category -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Courses by Category') }}</h3>
                <div class="chart-container">
                    <canvas id="coursesByCategoryChart"></canvas>
                </div>
            </div>

            <!-- Monthly Enrollments -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Monthly Enrollments') }}</h3>
                <div class="chart-container">
                    <canvas id="monthlyEnrollmentsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mt-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Top Instructors by Courses') }}</h3>
                <div class="chart-container">
                    <canvas id="topInstructorsChart"></canvas>
                </div>
            </div>
        </div>

    @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const coursesByCategoryCtx = document.getElementById('coursesByCategoryChart').getContext('2d');
        new Chart(coursesByCategoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($coursesByCategory->pluck('name')->toArray()) !!},
                datasets: [{
                    data: {!! json_encode($coursesByCategory->pluck('courses_count')->toArray()) !!},
                    backgroundColor: [
                        '#3B82F6',
                        '#10B981',
                        '#F59E0B',
                        '#EF4444',
                        '#8B5CF6',
                        '#EC4899',
                        '#14B8A6',
                        '#F97316'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });

        const monthlyEnrollmentsCtx = document.getElementById('monthlyEnrollmentsChart').getContext('2d');
        new Chart(monthlyEnrollmentsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyEnrollments->pluck('month')->toArray()) !!},
                datasets: [{
                    label: '{{ __("Enrollments") }}',
                    data: {!! json_encode($monthlyEnrollments->pluck('count')->toArray()) !!},
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        const topInstructorsCtx = document.getElementById('topInstructorsChart').getContext('2d');
        new Chart(topInstructorsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topInstructors->pluck('name')->toArray()) !!},
                datasets: [{
                    label: '{{ __("Number of Courses") }}',
                    data: {!! json_encode($topInstructors->pluck('courses_count')->toArray()) !!},
                    backgroundColor: [
                        '#10B981',
                        '#3B82F6',
                        '#F59E0B',
                        '#EF4444',
                        '#8B5CF6',
                        '#EC4899',
                        '#14B8A6',
                        '#F97316'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
    </script>
    @endpush
</x-app-layout>
