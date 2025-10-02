<!-- resources/views/components/courses/form-stepper.blade.php -->
@props(['course' => null, 'currentStep' => 1, 'totalSteps' => 3])

<div x-data="{
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
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
        <div class="bg-blue-600 h-2.5 rounded-full" :style="'width: ' + stepProgress() + '%'"></div>
    </div>

    <!-- Step Indicators -->
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
                        Course Info
                    @elseif($i === 2)
                        Details
                    @else
                        Review
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

    <form method="POST" action="{{ isset($course) ? route('courses.update', $course) : route('courses.store') }}"
        class="space-y-6">
        @csrf
        @if (isset($course))
            @method('PUT')
        @endif

        <!-- Step 1: Basic Information -->
        <div x-show="currentStep === 1" x-transition>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-3">
                    <x-label for="title_ar" value="{{ __('Course Title arabic') }}" />
                    <x-input id="title_ar" name="title_ar" type="text" class="mt-1 block w-full"
                        value="{{ old('title_ar', $course->title_ar ?? '') }}" required autofocus />
                    @if ($errors->has('title_ar'))
                        <x-input-error for="title_ar" :messages="$errors->get('title_ar')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-3">
                    <x-label for="title_en" value="{{ __('Course Title english') }}" />
                    <x-input id="title_en" name="title_en" type="text" class="mt-1 block w-full"
                        value="{{ old('title_en', $course->title_en ?? '') }}" required autofocus />
                    @if ($errors->has('title_en'))
                        <x-input-error for="title_en" :messages="$errors->get('title_en')" class="mt-2" />
                    @endif
                </div>


                <div class="col-span-3">
                    <x-label for="name_ar" value="{{ __('Course Name arabic') }}" />
                    <x-input id="name_ar" name="name_ar" type="text" class="mt-1 block w-full"
                        value="{{ old('name_ar', $course->name_ar ?? '') }}" required autofocus />
                    @if ($errors->has('name_ar'))
                        <x-input-error for="name_ar" :messages="$errors->get('name_ar')" class="mt-2" />
                    @endif
                </div>


                <div class="col-span-3">
                    <x-label for="name_en" value="{{ __('Course Name english') }}" />
                    <x-input id="name_en" name="name_en" type="text" class="mt-1 block w-full"
                        value="{{ old('name_en', $course->name_en ?? '') }}" required autofocus />
                    @if ($errors->has('name_en'))
                        <x-input-error for="name_en" :messages="$errors->get('name_en')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="description_ar" value="{{ __('Short Description arabic') }}" />
                    <textarea id="description_ar" name="description_ar" rows="3"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required>{{ old('description_ar', $course->description_ar ?? '') }}</textarea>
                    @if ($errors->has('description_ar'))
                        <x-input-error for="description_ar" :messages="$errors->get('description_ar')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-3">
                    <x-label for="description_en" value="{{ __('Short Description english') }}" />
                    <textarea id="description_en" name="description_en" rows="3"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required>{{ old('description_en', $course->description_en ?? '') }}</textarea>
                    @if ($errors->has('description_en'))
                        <x-input-error for="description_en" :messages="$errors->get('description_en')" class="mt-2" />
                    @endif
                </div>
            </div>
        </div>

        <!-- Step 2: Course Details -->
        <div x-show="currentStep === 2" x-transition>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="price" value="{{ __('Price (USD)') }}" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <x-input type="number" name="price" id="price" class="pl-7" min="0"
                            step="0.01" value="{{ old('price', $course->price ?? '0.00') }}" required />
                    </div>
                    @if ($errors->has('price'))
                        <x-input-error for="price" :messages="$errors->get('price')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="duration" value="{{ __('Duration (hours)') }}" />
                    <x-input id="duration" name="duration" type="number" min="1" class="mt-1 block w-full"
                        value="{{ old('duration', $course->duration ?? '4') }}" required />
                    @if ($errors->has('duration'))
                        <x-input-error for="duration" :messages="$errors->get('duration')" class="mt-2" />
                    @endif
                </div>


                <div class="col-span-3">
                    <x-label for="difficulty_degree" value="{{ __('Difficulty Level') }}" />
                    <select id="difficulty_degree" name="difficulty_degree"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required>
                        <option value="">{{ __('Select Difficulty') }}</option>
                        <option value="beginner"
                            {{ old('difficulty_degree', $course->difficulty_degree ?? '') == 'beginner' ? 'selected' : '' }}>
                            {{ __('Beginner') }}
                        </option>
                        <option value="intermediate"
                            {{ old('difficulty_degree', $course->difficulty_degree ?? '') == 'intermediate' ? 'selected' : '' }}>
                            {{ __('Intermediate') }}
                        </option>
                        <option value="advanced"
                            {{ old('difficulty_degree', $course->difficulty_degree ?? '') == 'advanced' ? 'selected' : '' }}>
                            {{ __('Advanced') }}
                        </option>
                    </select>
                    @if ($errors->has('difficulty_degree'))
                        <x-input-error for="difficulty_degree" :messages="$errors->get('difficulty_degree')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <div x-data="instructorSelect()" @click.away="expanded = false" class="relative">
                        <!-- Search input and selected items in the same box -->
                        <div class="relative">
                            <div @click="expanded = !expanded"
                                class="flex flex-wrap items-center min-h-[38px] w-full rounded-md border border-gray-300 bg-white py-2 px-3 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 cursor-pointer">
                                <!-- Selected items as tags -->
                                <template x-for="item in selectedItems" :key="item.id">
                                    <span
                                        class="inline-flex items-center rounded bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800 mr-1 mb-1">
                                        <span x-text="item.name"></span>
                                        <button type="button" @click.stop="toggleItem(item)"
                                            class="ml-1 inline-flex h-4 w-4 items-center justify-center rounded-full bg-indigo-200 text-indigo-600 hover:bg-indigo-300">
                                            <span class="sr-only">Remove</span>
                                            <svg class="h-2 w-2" stroke="currentColor" fill="none"
                                                viewBox="0 0 8 8">
                                                <path stroke-linecap="round" stroke-width="1.5"
                                                    d="M1 1l6 6m0-6L1 7" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>
                                <!-- Search input -->
                                <input type="text" x-model="search" @click.stop="expanded = true"
                                    @focus="expanded = true"
                                    :placeholder="selectedItems.length === 0 ? 'Select instructors...' : ''"
                                    class="flex-1 min-w-[100px] border-0 p-0 text-sm focus:ring-0 focus:outline-none">
                            </div>
                            <button type="button" @click="expanded = !expanded"
                                class="absolute inset-y-0 right-0 flex items-center pr-2">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown -->
                        <div x-show="expanded" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-10 mt-1 w-full rounded-md bg-white shadow-lg">
                            <ul
                                class="max-h-60 overflow-auto rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <template x-for="item in filteredItems()" :key="item.id">
                                    <li @click="toggleItem(item)"
                                        :class="{ 'bg-indigo-100': isSelected(item), 'text-gray-900': true }"
                                        class="relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-indigo-50">
                                        <div class="flex items-center">
                                            <span x-text="item.name" class="block truncate"></span>
                                            <span x-show="isSelected(item)"
                                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                    </li>
                                </template>
                                <li x-show="filteredItems().length === 0" class="px-4 py-2 text-sm text-gray-500">
                                    No instructors found
                                </li>
                            </ul>
                        </div>

                        <!-- Hidden inputs for form submission -->
                        <template x-for="(item, index) in selectedItems" :key="item.id">
                            <input type="hidden" :name="'instructors[]'" :value="item.id">
                        </template>
                    </div>

                    @if ($errors->has('instructors'))
                        <x-input-error for="instructors" :messages="$errors->get('instructors')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="objectives_ar" value="{{ __('Learning Objectives arabic') }}" />
                    <textarea id="objectives_ar" name="objectives_ar" rows="4"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('objectives_ar', $course->objectives_ar ?? '') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Enter each objective on a new line</p>
                    @if ($errors->has('objectives_ar'))
                        <x-input-error for="objectives_ar" :messages="$errors->get('objectives_ar')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="objectives_en" value="{{ __('Learning Objectives english') }}" />
                    <textarea id="objectives_en" name="objectives_en" rows="4"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('objectives_en', $course->objectives_en ?? '') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Enter each objective on a new line</p>
                    @if ($errors->has('objectives_en'))
                        <x-input-error for="objectives_en" :messages="$errors->get('objectives_en')" class="mt-2" />
                    @endif
                </div>
            </div>
        </div>




        <!-- Step 3: Review and Submit -->
        <div x-show="currentStep === 3" x-transition>
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Review Your Course</h3>

                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-gray-700">Course Title</h4>
                        <p x-text="document.getElementById('title').value" class="text-gray-600"></p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-700">Description</h4>
                        <p x-text="document.getElementById('description').value" class="text-gray-600"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium text-gray-700">Price</h4>
                            <p x-text="'$' + parseFloat(document.getElementById('price').value).toFixed(2)"
                                class="text-gray-600"></p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700">Duration</h4>
                            <p x-text="document.getElementById('duration').value + ' weeks'" class="text-gray-600">
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="terms"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" required>
                        <span class="ml-2 text-sm text-gray-600">I confirm that all information is correct</span>
                    </label>
                    @if ($errors->has('terms'))
                        <x-input-error for="terms" :messages="$errors->get('terms')" class="mt-2" />
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6">
            <button type="button" x-show="!isFirstStep()" @click="prevStep()"
                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Previous
            </button>

            <button type="button" x-show="!isLastStep()" @click="nextStep()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Next
            </button>

            <button type="submit" x-show="isLastStep()"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ isset($course) ? 'Update Course' : 'Create Course' }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        function instructorSelect() {
            return {
                items: [{
                        id: 1,
                        name: 'John Doe'
                    },
                    {
                        id: 2,
                        name: 'Jane Smith'
                    },
                    {
                        id: 3,
                        name: 'Bob Johnson'
                    },
                    {
                        id: 4,
                        name: 'Alice Williams'
                    }
                ],
                selectedItems: [],
                search: '',
                expanded: false,

                init() {
                    // Load any previously selected items
                    const selectedIds = [];
                    if (selectedIds.length > 0) {
                        this.selectedItems = this.items.filter(item =>
                            selectedIds.includes(item.id)
                        );
                    }
                },

                filteredItems() {
                    const searchTerm = this.search.toLowerCase();
                    return this.items.filter(item =>
                        item.name.toLowerCase().includes(searchTerm) &&
                        !this.isSelected(item)
                    );
                },

                isSelected(item) {
                    return this.selectedItems.some(selected => selected.id === item.id);
                },

                toggleItem(item) {
                    if (this.isSelected(item)) {
                        this.selectedItems = this.selectedItems.filter(selected => selected.id !== item.id);
                    } else {
                        this.selectedItems = [...this.selectedItems, item];
                    }
                    // Clear search after selection
                    this.search = '';
                    // Close dropdown on mobile
                    if (window.innerWidth < 768) {
                        this.expanded = false;
                    }
                }
            }
        }
    </script>
@endpush
