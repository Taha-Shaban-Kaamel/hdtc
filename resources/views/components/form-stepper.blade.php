@vite(['resources/js/app.js'])
@vite(['resources/js/tagify.js'])
@props(['course' => null, 'currentStep' => 1, 'totalSteps' => 3, 'instructors' => null, 'categories' => null])
<div x-data="{
    formData: {
        title_ar: '{{ old('title_ar', $course?->getTranslation('title', 'ar') ?? '') }}',
        title_en: '{{ old('title_en', $course?->getTranslation('title', 'en') ?? '') }}',
        name_ar: '{{ old('name_ar', $course?->getTranslation('name', 'ar') ?? '') }}',
        name_en: '{{ old('name_en', $course?->getTranslation('name', 'en') ?? '') }}',
        description_ar: `{{ old('description_ar', $course?->getTranslation('description', 'ar') ?? '') }}`,
        description_en: `{{ old('description_en', $course?->getTranslation('description', 'en') ?? '') }}`,
        objectives_ar: `{{ old('objectives_ar', $course?->getTranslation('objectives', 'ar') ?? '') }}`,
        objectives_en: `{{ old('objectives_en', $course?->getTranslation('objectives', 'en') ?? '') }}`,
        difficulty_degree: '{{ old('difficulty_degree', $course?->difficulty_degree ?? '') }}',
        price: {{ old('price', $course?->price ?? 0) }},
        duration: {{ old('duration', $course?->duration ?? 1) }},
        video_url: '{{ old('video_url', $course?->video ?? '') }}',
        instructors: @json(old('instructors', $course ? $course->instructors->pluck('id') : [])),
        categories: @json(old('categories', $course ? $course->categories->pluck('id') : [])),
        thumbnail: null,
        thumbnailPreview: '{{ $course?->thumbnail ? Storage::url($course->thumbnail) : '' }}',
        availability: '{{ old('availability', $course?->availability ?? '') }}',
        {{-- tags: @json(old('tags', $course ? $course->tags()->pluck('name') : [])), --}}
    },
    currentStep: {{ $currentStep }},
    totalSteps: {{ $totalSteps }},
    nextStep() {
        if (this.currentStep < this.totalSteps) {
            this.currentStep++;
        }
    },
    prevStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
        }
    },
    isFirstStep() {
        return this.currentStep === 1;
    },
    isLastStep() {
        return this.currentStep === this.totalSteps;
    },
    stepProgress() {
        return (this.currentStep / this.totalSteps) * 100;
    }
}">


    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
        <div class="bg-blue-600 h-2.5 rounded-full" :style="'width: ' + stepProgress() + '%'"></div>
    </div>

    <div class="flex justify-between mb-8">
        @for ($i = 1; $i <= $totalSteps; $i++)
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold"
                    :class="currentStep >= {{ $i }} ? 'bg-blue-600' : 'bg-gray-300'">
                    {{ $i }}
                </div>
                <span class="text-sm mt-2"
                    :class="currentStep === {{ $i }} ? 'font-bold text-blue-600' : 'text-gray-500'">
                    @if ($i === 1)
                        {{ __('courses.basic_information') }}
                    @elseif($i === 2)
                        {{ __('courses.learning_objectives') }}
                    @else
                        {{ __('courses.review_course') }}
                    @endif
                </span>
            </div>
            @if ($i < $totalSteps)
                <div class="flex-1 flex items-center">
                    <div class="w-full h-1 bg-gray-300"></div>
                </div>
            @endif
        @endfor
    </div>
    <div>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <form method="POST" action="{{ isset($course) ? route('courses.update', $course) : route('courses.store') }}"
        class="space-y-6" enctype="multipart/form-data" x-on:submit.prevent="$el.submit()">
        @csrf
        @if (isset($course))
            @method('PUT')
        @endif

        <!-- Hidden inputs for form data that needs to be submitted -->
        <template x-for="instructor in formData.instructors" :key="instructor">
            <input type="hidden" name="instructors[]" :value="instructor">
        </template>
        <template x-for="category in formData.categories" :key="category">
            <input type="hidden" name="categories[]" :value="category">
        </template>

        <div x-show="currentStep === 1" x-transition>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-3">
                    <x-label for="title_ar" value="{{ __('courses.course_title_ar') }}" />
                    <x-input id="title_ar" name="title_ar" type="text" class="mt-1 block w-full"
                        x-model="formData.title_ar" required autofocus />
                    <x-input-error for="title_ar" :messages="$errors->get('title_ar')" class="mt-2" />
                </div>
                <div class="col-span-3">
                    <x-label for="title_en" value="{{ __('courses.course_title_en') }}" />
                    <x-input id="title_en" name="title_en" type="text" class="mt-1 block w-full"
                        x-model="formData.title_en" required autofocus />
                    <x-input-error for="title_en" :messages="$errors->get('title_en')" class="mt-2" />
                </div>


                <div class="col-span-3">
                    <x-label for="name_ar" value="{{ __('courses.course_name_ar') }}" />
                    <x-input id="name_ar" name="name_ar" type="text" class="mt-1 block w-full"
                        x-model="formData.name_ar" required autofocus />
                    <x-input-error for="name_ar" :messages="$errors->get('name_ar')" class="mt-2" />
                </div>


                <div class="col-span-3">
                    <x-label for="name_en" value="{{ __('courses.course_name_en') }}" />
                    <x-input id="name_en" name="name_en" type="text" class="mt-1 block w-full"
                        x-model="formData.name_en" required autofocus />
                    <x-input-error for="name_en" :messages="$errors->get('name_en')" class="mt-2" />
                </div>

                <div class="col-span-3">
                    <label for="tags" class="block font-medium text-sm text-gray-700">Tags</label>
                    <input id="tags" name="tags[]" value="{{ old('tags', $course ? $course?->tags()->pluck('name') :'') }}" class="tagify mt-1 block w-full" placeholder="Enter tags..." multiple>
                </div>

                <div class="col-span-3">
                    <label for="availablety" class="block font-medium text-sm text-gray-700">Availablety</label>
                    <x-input id="availablety" name="availablety" type="text" class="mt-1 block w-full"
                    x-model="formData.availablety"/>
                </div>

                <div class="col-span-3">
                    <x-label for="description_ar" value="{{ __('courses.short_description_ar') }}" />
                    <textarea id="description_ar" name="description_ar" rows="3"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        x-model="formData.description_ar" required></textarea>
                    <x-input-error for="description_ar" :messages="$errors->get('description_ar')" class="mt-2" />
                </div>
                <div class="col-span-3">
                    <x-label for="description_en" value="{{ __('courses.short_description_en') }}" />
                    <textarea id="description_en" name="description_en" rows="3"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        x-model="formData.description_en" required></textarea>
                    <x-input-error for="description_en" :messages="$errors->get('description_en')" class="mt-2" />
                </div>
            </div>
        </div>

        <div x-show="currentStep === 2" x-transition>
            <div class="grid grid-cols-6 gap-6">
               
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="price" value="{{ __('courses.price') }}" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <x-input type="number" name="price" id="price" class="pl-7" min="0"
                            step="0.01" x-model="formData.price" required />
                    </div>
                    @if ($errors->has('price'))
                        <x-input-error for="price" :messages="$errors->get('price')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="duration" value="{{ __('courses.duration_hours') }}" />
                    <x-input id="duration" name="duration" type="number" min="1" class="mt-1 block w-full"
                        x-model="formData.duration" required />
                    <x-input-error for="duration" :messages="$errors->get('duration')" class="mt-2" />
                </div>

                {{-- @dd(old('categories', $course?->categories->toArray())) --}}
                <div class="col-span-3 mt-6">
                    <x-label for="categories" value="{{ __('courses.select_categories') }}" />
                    <x-multi-select :items="$categories" name="categories[]" :placeholder="__('common.select_items')" id="category-selector"
                        x-model="formData.categories" :selected-items="json_encode(
                            old(
                                'categories',
                                $course
                                    ? $course->categories
                                        ->map(fn($c) => ['id' => $c->id, 'name' => $c->name])
                                        ->toArray()
                                    : [],
                            ),
                        )" />
                </div>


                <div class="col-span-3 mt-6">
                    <x-label for="instructors" value="{{ __('courses.select_instructors') }}" />
                    <x-multi-select :items="$instructors" name="instructors[]" :placeholder="__('common.select_items')"
                        id="instructor-selector" x-model="formData.instructors" :selected-items="json_encode(
                            old(
                                'instructors',
                                $course
                                    ? $course->instructors
                                        ->map(fn($i) => ['id' => $i->id, 'name' => $i->name])
                                        ->toArray()
                                    : [],
                            ),
                        )" />
                </div>

                <div class="col-span-3">
                    <x-label for="difficulty_degree" value="{{ __('courses.difficulty_level') }}" />
                    <select id="difficulty_degree" name="difficulty_degree" x-model="formData.difficulty_degree"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required>
                        <option value="">{{ __('courses.select_difficulty') }}</option>
                        <option
                            {{ $course?->getTranslation('difficulty_degree', 'ar') === 'beginner' ? 'selected' : '' }}
                            value="beginner">
                            {{ __('courses.beginner') }}
                        </option>
                        <option
                            {{ $course?->getTranslation('difficulty_degree', 'ar') === 'intermediate' ? 'selected' : '' }}
                            value="intermediate">
                            {{ __('courses.intermediate') }}
                        </option>
                        <option
                            {{ $course?->getTranslation('difficulty_degree', 'ar') === 'advanced' ? 'selected' : '' }}
                            value="advanced">
                            {{ __('courses.advanced') }}
                        </option>
                    </select>
                    @if ($errors->has('difficulty_degree'))
                        <x-input-error for="difficulty_degree" :messages="$errors->get('difficulty_degree')" class="mt-2" />
                    @endif
                </div>


                <div class="col-span-3">
                    <x-label for="video_url" value="{{ __('courses.video_url') }}" />
                    <x-input type="text" name="video_url" x-model="formData.video_url" />
                    <x-input-error for="video_url" :messages="$errors->get('video_url')" class="mt-2" />
                </div>

                <div class="col-span-3">
                    <x-label for="objectives_ar" value="{{ __('courses.learning_objectives_ar') }}" />
                    <textarea id="objectives_ar" name="objectives_ar" rows="4"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        x-model="formData.objectives_ar"></textarea>
                    <p class="mt-1 text-sm text-gray-500">{{ __('courses.objectives_help_text') }}</p>
                    <x-input-error for="objectives_ar" :messages="$errors->get('objectives_ar')" class="mt-2" />
                </div>

                <div class="col-span-3">
                    <x-label for="objectives_en" value="{{ __('courses.learning_objectives_en') }}" />
                    <textarea id="objectives_en" name="objectives_en" rows="4"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        x-model="formData.objectives_en"></textarea>
                    <p class="mt-1 text-sm text-gray-500">{{ __('courses.objectives_help_text') }}</p>
                    <x-input-error for="objectives_en" :messages="$errors->get('objectives_en')" class="mt-2" />
                </div>

                <div class="col-span-3">
                    <x-label for="thumbnail" value="{{ __('courses.thumbnail') }}" />
                    <x-image-input name="thumbnail" x-model="formData.thumbnail"
                        x-on:change="formData.thumbnail = $event.detail" />
                    <p class="mt-1 text-xs text-gray-500">{{ __('courses.thumbnail_help_text') }}</p>
                    @if ($errors->has('thumbnail'))
                        <x-input-error for="thumbnail" :messages="$errors->get('thumbnail')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="cover" value="{{ __('Cover') }}" />
                    <x-image-input name="cover" x-model="formData.cover"
                        x-on:change="formData.cover = $event.detail" />
                    <p class="mt-1 text-xs text-gray-500">{{ __('courses.cover_help_text') }}</p>
                    @if ($errors->has('cover'))
                        <x-input-error for="cover" :messages="$errors->get('cover')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <label class="flex items-start gap-2">
                        <input type="checkbox" name="status" required
                            class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">
                            {{ __('common.status') }}
                        </span>
                    </label>
                    @if ($errors->has('status'))
                        <x-input-error for="status" :messages="$errors->get('status')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <label class="flex items-start gap-2" title="{{ __('courses.accessability') }}">
                        <input type="checkbox" name="accessability" required
                            class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">
                            {{ __('courses.accessability') }}
                        </span>
                    </label>
                    @if ($errors->has('accessability'))
                        <x-input-error for="accessability" :messages="$errors->get('accessability')" class="mt-2" />
                    @endif
                </div>

            </div>
        </div>

        <div x-show="currentStep === 3" x-transition>
            <div class="bg-gray-50 p-6 rounded-lg space-y-6">
                <h3 class="text-lg font-medium text-gray-900">{{ __('courses.review_course') }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h4 class="font-medium text-gray-700 border-b pb-2 mb-2">
                                {{ __('courses.basic_information') }}</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Title (English)</span>
                                    <p x-text="formData.title_en || 'Not provided'" class="text-gray-800"></p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Title (Arabic)</span>
                                    <p x-text="formData.title_ar || 'Not provided'" class="text-gray-800"></p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Description (English)</span>
                                    <p x-text="formData.description_en || 'Not provided'"
                                        class="text-gray-800 whitespace-pre-line"></p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Description (Arabic)</span>
                                    <p x-text="formData.description_ar || 'Not provided'"
                                        class="text-gray-800 whitespace-pre-line"></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow">
                            <h4 class="font-medium text-gray-700 border-b pb-2 mb-2">Pricing & Duration</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Price </span>
                                    <p x-text="'$' + parseFloat(formData.price || 0).toFixed(2)"
                                        class="text-gray-800"></p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Duration</span>
                                    <p x-text="(formData.duration || 0) + ' hours'" class="text-gray-800"></p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Difficulty</span>
                                    <p x-text="formData.difficulty_degree ? formData.difficulty_degree.charAt(0).toUpperCase() + formData.difficulty_degree.slice(1) : 'Not specified'"
                                        class="text-gray-800"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h4 class="font-medium text-gray-700 border-b pb-2 mb-2">
                                {{ __('courses.learning_objectives') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">English</span>
                                    <ul class="list-disc list-inside text-gray-800 mt-1">
                                        <template
                                            x-for="(item, index) in (formData.objectives_en || '').split('\n').filter(Boolean)"
                                            :key="index">
                                            <li x-text="item"></li>
                                        </template>
                                        <span x-show="!formData.objectives_en" class="text-gray-400">No objectives
                                            provided</span>
                                    </ul>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Arabic</span>
                                    <ul class="list-disc list-inside text-gray-800 mt-1" dir="rtl">
                                        <template
                                            x-for="(item, index) in (formData.objectives_ar || '').split('\n').filter(Boolean)"
                                            :key="index">
                                            <li x-text="item"></li>
                                        </template>
                                        <span x-show="!formData.objectives_ar" class="text-gray-400">لا توجد أهداف
                                            محددة</span>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <label class="flex items-start">
                        <input type="checkbox" name="terms" required
                            class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">
                            I confirm that all information is correct and I have the rights to use the uploaded content.
                            I understand that this course will be reviewed before being published.
                        </span>
                    </label>
                    @if ($errors->has('terms'))
                        <x-input-error for="terms" :messages="$errors->get('terms')" class="mt-2" />
                    @endif
                </div>
            </div>
        </div>

        <div x-data="{
            addInstructor(instructorId) {
                    if (!this.formData.instructors.includes(instructorId)) {
                        this.formData.instructors.push(instructorId);
                    } else {
                        this.formData.instructors = this.formData.instructors.filter(id => id !== instructorId);
                    }
                },
                addCategory(categoryId) {
                    if (!this.formData.categories.includes(categoryId)) {
                        this.formData.categories.push(categoryId);
                    } else {
                        this.formData.categories = this.formData.categories.filter(id => id !== categoryId);
                    }
                },
                isInstructorSelected(instructorId) {
                    return this.formData.instructors.includes(instructorId);
                },
                isCategorySelected(categoryId) {
                    return this.formData.categories.includes(categoryId);
                }
        }">

            <div class="flex justify-between pt-6">
                <button type="button" x-show="!isFirstStep()" @click="prevStep()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('courses.previous') }}
                </button>

                <button type="button" x-show="!isLastStep()" @click="nextStep()"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('courses.next') }}
                </button>

                <button type="submit" x-show="isLastStep()"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ isset($course) ? __('common.update') : __('common.create') }}
                </button>
            </div>
    </form>
</div>




@push('scripts')
    <script>
        window.tagWhitelist = @json(\App\Models\Tag::pluck('name')->toArray());
    </script>
    @vite(['resources/js/tagify.js'])

@endpush