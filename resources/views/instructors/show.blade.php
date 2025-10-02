<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $instructor->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Instructor Photo -->
                        <div class="w-full md:w-1/3 lg:w-1/4">
                            <div class="bg-gray-100 rounded-lg overflow-hidden">
                                <img class="w-full h-64 object-cover" 
                                     src="{{ $instructor->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($instructor->name).'&size=512&color=7F9CF5&background=EBF4FF' }}" 
                                     alt="{{ $instructor->name }}">
                            </div>
                            <div class="mt-4 flex space-x-3">
                                <a href="{{ route('instructors.edit', $instructor) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('common.edit') }}
                                </a>
                                <form action="{{ route('instructors.destroy', $instructor) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('instructors.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('common.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Instructor Details -->
                        <div class="w-full md:w-2/3 lg:w-3/4">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $instructor->name }}</h3>
                            
                            <div class="space-y-4">
                                <!-- Contact Information -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="text-lg font-medium text-gray-900 mb-3">{{ __('instructors.contact_information') }}</h4>
                                    <dl class="space-y-3">
                                        <div class="sm:flex">
                                            <dt class="text-sm font-medium text-gray-500 sm:w-32 sm:flex-shrink-0">{{ __('instructors.email') }}</dt>
                                            <dd class="text-sm text-gray-900">{{ $instructor->email }}</dd>
                                        </div>
                                        @if($instructor->phone)
                                            <div class="sm:flex">
                                                <dt class="text-sm font-medium text-gray-500 sm:w-32 sm:flex-shrink-0">{{ __('instructors.phone') }}</dt>
                                                <dd class="text-sm text-gray-900">{{ $instructor->phone }}</dd>
                                            </div>
                                        @endif
                                    </dl>
                                </div>

                                <!-- Bio -->
                                @if($instructor->bio)
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
                                        <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $instructor->courses_count ?? 0 }}</dd>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 text-center">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('instructors.students') }}</dt>
                                        <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $instructor->students_count ?? 0 }}</dd>
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
