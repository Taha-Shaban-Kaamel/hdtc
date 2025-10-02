<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course Category') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                <x-form-section method="POST" :action="route('courses.categories.update', ['id' => $courseCategorie->id])" enctype="multipart/form-data">
                    @method('PUT')
                    <x-slot name="title">
                        {{ __('Update Category Information') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('Update the category details.') }}
                    </x-slot>

                    <x-slot name="form" class="grid grid-cols-6 gap-6">
                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="name_ar" :value="__('courses.name_ar')" />
                            <x-input id="name_ar" type="text" class="mt-1 block w-full" name="name_ar"
                                value="{{ old('name_ar', $courseCategorie->getTranslation('name', 'ar')) }}" autofocus />
                            @if ($errors->has('name_ar'))
                                <x-input-error for="name_ar" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="name_en" :value="__('courses.name_en')" />
                            <x-input id="name_en" type="text" class="mt-1 block w-full" name="name_en"
                                value="{{ old('name_en', $courseCategorie->getTranslation('name', 'en')) }}" />
                            @if ($errors->has('name_en'))
                                <x-input-error for="name_en" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="description_ar" :value="__('courses.description_ar')" />
                            <textarea id="description_ar" name="description_ar"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description_ar', $courseCategorie->getTranslation('description', 'ar')) }}</textarea>
                            @if ($errors->has('description_ar'))
                                <x-input-error for="description_ar" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-3 sm:col-span-4">
                            <x-label for="description_en" :value="__('courses.description_en')" />
                            <textarea id="description_en" name="description_en"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description_en', $courseCategorie->getTranslation('description', 'en')) }}</textarea>
                            @if ($errors->has('description_en'))
                                <x-input-error for="description_en" class="mt-2" />
                            @endif
                        </div>

                        <div class="lg:col-span-6 sm:col-span-6">
                            <x-label for="image" :value="__('courses.image')" />

                            <input id="image" type="file" name="image" onchange="previewImage(this, 'preview')" class="hidden">

                            <div class="flex items-center space-x-4">
                                <button type="button" onclick="document.getElementById('image').click()"
                                    class="mt-1 block border-2 border-dashed border-gray-300 rounded-md p-4 text-center hover:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        {{ __('Change Image') }}
                                    </span>
                                    <span class="mt-1 text-xs text-gray-500">
                                        {{ __('PNG, JPG, GIF up to 2MB') }}
                                    </span>
                                </button>

                                <!-- Current Image Preview -->
                                @if($courseCategorie->image)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 mb-2">{{ __('Current Image') }}:</p>
                                        <div class="relative">
                                            <img src="{{ asset($courseCategorie->image) }}" alt="{{ $courseCategorie->name }}" 
                                                class="h-40 w-40 object-cover rounded-md">
                                        </div>
                                    </div>
                                @endif

                                <!-- New Image Preview -->
                                <div id="imagePreview" class="mt-2 hidden">
                                    <p class="text-sm text-gray-500 mb-2">{{ __('New Image') }}:</p>
                                    <img id="preview" class="h-40 w-40 object-cover rounded-md" src="#"
                                        alt="Preview" />
                                </div>
                            </div>

                            @if ($errors->has('image'))
                                <x-input-error for="image" :message="$errors->first('image')" class="mt-2" />
                            @endif
                        </div>
                    </x-slot>

                    <x-slot name="actions">
                        <x-button type="submit">
                            {{ __('Update') }}
                        </x-button>
                    </x-slot>
                </x-form-section>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewImage(input, previewId) {
                const preview = document.getElementById(previewId);
                const previewContainer = document.getElementById('imagePreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '#';
                    previewContainer.classList.add('hidden');
                }
            }
        </script>
    @endpush
</x-app-layout>
