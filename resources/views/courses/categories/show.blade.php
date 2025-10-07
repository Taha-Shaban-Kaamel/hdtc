<x-app-layout>    
    <div class="py-12">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Breadcrumb -->
                <div class="px-6 py-4">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('courses.categories.index'), 'label' => __('common.categories')],
                        ['label' => __('common.show') . ' : ' . $courseCategorie->getTranslation('name', app()->getLocale())],                    ]" />
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-scroll max-h-[calc(100vh-12rem)] shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category Image -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('courses.image') }}</h3>
                            @if($courseCategorie->image)
                                <div class="mt-2 overflow-hidden rounded-md bg-gray-100">
                                    <img src="{{ asset($courseCategorie->image) }}" 
                                         alt="{{ $courseCategorie->name }}" 
                                         class="mx-auto max-h-96 w-auto max-w-full object-contain p-4"
                                         style="max-height: 400px;">
                                </div>
                            @else
                                <div class="h-64 bg-gray-100 rounded-md flex items-center justify-center">
                                    <span class="text-gray-400">{{ __('No image available') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Category Details -->
                        <div class="space-y-6">
                            <!-- Arabic Details -->
                            <div class="border-b border-gray-200 pb-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Arabic Details') }}</h3>
                                <dl class="mt-2 space-y-2">
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('courses.name_ar') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $courseCategorie->getTranslation('name', 'ar') }}
                                        </dd>
                                    </div>
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('courses.description_ar') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                            {{ $courseCategorie->getTranslation('description', 'ar') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- English Details -->
                            <div class="pt-2">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('English Details') }}</h3>
                                <dl class="mt-2 space-y-2">
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('courses.name_en') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $courseCategorie->getTranslation('name', 'en') }}
                                        </dd>
                                    </div>
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('courses.description_en') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                            {{ $courseCategorie->getTranslation('description', 'en') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Parent Category -->
                            @if($courseCategorie->parent)
                            <div class="pt-2 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Parent Category') }}</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $courseCategorie->parent->getTranslation('name', app()->getLocale()) }}
                                </p>
                            </div>
                            @endif

                            <!-- Timestamps -->
                            <div class="pt-4 border-t border-gray-200">
                                <div class="text-sm text-gray-500">
                                    <p>{{ __('Created at') }}: {{ $courseCategorie->created_at->format('Y-m-d H:i') }}</p>
                                    <p class="mt-1">{{ __('Last updated') }}: {{ $courseCategorie->updated_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <a href="{{ route('courses.categories.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            {{ __('Back to List') }}
                        </a>
                        <a href="{{ route('courses.categories.edit', $courseCategorie->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            {{ __('Edit') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
