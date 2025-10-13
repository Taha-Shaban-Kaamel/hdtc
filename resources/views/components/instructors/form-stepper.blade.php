<!-- resources/views/components/instructors/form-stepper.blade.php -->
@props([
    'instructor' => null,
    'currentStep' => 1,
    'totalSteps' => 3,
    'method' => 'POST',
    'action' => route('web.instructors.store'),
])

<div x-data="{
    currentStep: {{ $currentStep }},
    totalSteps: {{ $totalSteps }},
    formData: {
        first_name_ar: '{{ old('first_name_ar', $instructor?->user?->getTranslation('first_name', 'ar') ?? '') }}',
        first_name_en: '{{ old('first_name_en', $instructor?->user?->getTranslation('first_name', 'en') ?? '') }}',
        second_name_ar: '{{ old('second_name_ar', $instructor?->user?->getTranslation('second_name', 'ar') ?? '') }}',
        second_name_en: '{{ old('second_name_en', $instructor?->user?->getTranslation('second_name', 'en') ?? '') }}',
        specialization_ar: '{{ old('specialization_ar', $instructor?->getTranslation('specialization', 'ar') ?? '') }}',
        specialization_en: '{{ old('specialization_en', $instructor?->getTranslation('specialization', 'en') ?? '') }}',
        bio_ar: '{{ old('bio_ar', $instructor?->user?->getTranslation('bio', 'ar') ?? '') }}',
        bio_en: '{{ old('bio_en', $instructor?->user?->getTranslation('bio', 'en') ?? '') }}',
        gender: '{{ old('gender', $instructor?->user?->gender ?? '') }}',
        birth_date: '{{ old('birth_date', $instructor?->user?->birth_date ?? '') }}',
        experience: '{{ old('experience', $instructor?->experience ?? '') }}',
        education_ar: '{{ old('education_ar', $instructor?->getTranslation('education', 'ar') ?? '') }}',
        education_en: '{{ old('education_en', $instructor?->getTranslation('education', 'en') ?? '') }}',
        company: '{{ old('company', $instructor?->company ?? '') }}',
        email: '{{ old('email', $instructor?->user?->email ?? '') }}',
        phone: '{{ old('phone', $instructor?->user?->phone ?? '') }}',
        twitter_url: '{{ old('twitter_url', $instructor?->twitter_url ?? '') }}',
        linkedin_url: '{{ old('linkedin_url', $instructor?->linkedin_url ?? '') }}',
        facebook_url: '{{ old('facebook_url', $instructor?->facebook_url ?? '') }}',
        youtube_url: '{{ old('youtube_url', $instructor?->youtube_url ?? '') }}',
        avatar: '{{ old('avatar', $instructor?->user?->avatar ?? '') }}'
    },
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
    },
    updateFormData() {
        // Update form data from input fields when moving to the next step
        if (this.currentStep === this.totalSteps - 1) {
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                if (input.name && input.name in this.formData) {
                    this.formData[input.name] = input.value;
                }
            });
        }
    }
}" @next-step.window="nextStep()" @prev-step.window="prevStep()">
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
                        {{ __('instructors.instructor_info') }}
                    @elseif($i === 2)
                        {{ __('instructors.instructor_details') }}
                    @elseif($i === 3)
                        {{ __('instructors.instructor_contact') }}
                    @elseif($i === $totalSteps)
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

    <form method="POST" action="{{ $action }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div x-show="currentStep === 1" x-transition>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-3">
                    <x-label for="first_name_ar" value="{{ __('instructors.first_name_ar') }}" />
                    <x-input id="first_name_ar" name="first_name_ar" type="text" class="mt-1 block w-full"
                        x-model="formData.first_name_ar"  autofocus />
                    @if ($errors->has('first_name_ar'))
                        <x-input-error for="first_name_ar" :messages="$errors->get('first_name_ar')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-3">
                    <x-label for="first_name_en" value="{{ __('instructors.first_name_en') }}" />
                    <x-input id="first_name_en" name="first_name_en" type="text" class="mt-1 block w-full"
                        x-model="formData.first_name_en"  />
                    @if ($errors->has('first_name_en'))
                        <x-input-error for="first_name_en" :messages="$errors->get('first_name_en')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="second_name_ar" value="{{ __('instructors.second_name_ar') }}" />
                    <x-input id="second_name_ar" name="second_name_ar" type="text" class="mt-1 block w-full"
                        x-model="formData.second_name_ar"  />
                    @if ($errors->has('second_name_ar'))
                        <x-input-error for="second_name_ar" :messages="$errors->get('second_name_ar')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-3">
                    <x-label for="second_name_en" value="{{ __('instructors.second_name_en') }}" />
                    <x-input id="second_name_en" name="second_name_en" type="text" class="mt-1 block w-full"
                        x-model="formData.second_name_en"  />
                    @if ($errors->has('second_name_en'))
                        <x-input-error for="second_name_en" :messages="$errors->get('second_name_en')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-3">
                    <x-label for="password" value="{{ __('instructors.password') }}" />
                    <x-input 
                        id="password" 
                        name="password" 
                        type="password" 
                        class="mt-1 block w-full"
                        x-model="formData.password" 
                        :aria-="!$instructor"
                        :placeholder="$instructor ? 'Leave blank to keep current password' : ''"
                    />
                    @if ($errors->has('password'))
                        <x-input-error for="password" :messages="$errors->get('password')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="birth_date" value="{{ __('instructors.birth_date') }}" />
                    <x-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full"
                        x-model="formData.birth_date" :value="old(
                            'birth_date',
                            isset($instructor->birth_date)
                                ? \Carbon\Carbon::parse($instructor->birth_date)->format('Y-m-d')
                                : '',
                        )"  />
                    @if ($errors->has('birth_date'))
                        <x-input-error for="birth_date" :messages="$errors->get('birth_date')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="bio_ar" value="{{ __('instructors.bio_ar') }}" />
                    <textarea id="bio_ar" name="bio_ar" rows="3"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        x-model="formData.bio_ar" ></textarea>
                    @if ($errors->has('bio_ar'))
                        <x-input-error for="bio_ar" :messages="$errors->get('bio_ar')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-3">
                    <x-label for="bio_en" value="{{ __('instructors.bio_en') }}" />
                    <textarea id="bio_en" name="bio_en" rows="3"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        x-model="formData.bio_en" ></textarea>
                    @if ($errors->has('bio_en'))
                        <x-input-error for="bio_en" :messages="$errors->get('bio_en')" class="mt-2" />
                    @endif
                </div>
            </div>
        </div>


        <div x-show="currentStep === 2" x-transition>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="specialization" value="{{ __('instructors.specialization') }}" />
                    <x-input id="specialization_ar" name="specialization_ar" type="text" class="mt-1 block w-full"
                        x-model="formData.specialization_ar"  />
                    @if ($errors->has('specialization_ar'))
                        <x-input-error for="specialization_ar" :messages="$errors->get('specialization_ar')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="specialization_en" value="{{ __('instructors.specialization_en') }}" />
                    <x-input id="specialization_en" name="specialization_en" type="text" class="mt-1 block w-full"
                        x-model="formData.specialization_en"  />
                    @if ($errors->has('specialization_en'))
                        <x-input-error for="specialization_en" :messages="$errors->get('specialization_en')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="experience" value="{{ __('instructors.experience') }}" />
                    <x-input id="experience" name="experience" type="number" class="mt-1 block w-full"
                        x-model="formData.experience"  />
                    @if ($errors->has('experience'))
                        <x-input-error for="experience" :messages="$errors->get('experience')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="education" value="{{ __('instructors.education') }}" />
                    <x-input id="education_ar" name="education_ar" type="text" class="mt-1 block w-full"
                        x-model="formData.education_ar"  />
                    @if ($errors->has('education_ar'))
                        <x-input-error for="education_ar" :messages="$errors->get('education_ar')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="education_en" value="{{ __('instructors.education_en') }}" />
                    <x-input id="education_en" name="education_en" type="text" class="mt-1 block w-full"
                        x-model="formData.education_en"  />
                    @if ($errors->has('education_en'))
                        <x-input-error for="education_en" :messages="$errors->get('education_en')" class="mt-2" />
                    @endif
                </div>


                <div class="col-span-3">
                    <x-label for="gender" value="{{ __('Gender') }}" />
                    <select id="gender" name="gender" x-model="formData.gender"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        >
                        <option value="">{{ __('instructors.select_gender') }}</option>
                        <option value="male"
                            {{ old('gender', $instructor?->user?->gender ?? '') === 'male' ? 'selected' : '' }}>
                            {{ __('instructors.male') }}
                        </option>
                        <option value="female"
                            {{ old('gender', $instructor?->user?->gender ?? '') === 'female' ? 'selected' : '' }}>
                            {{ __('instructors.female') }}
                        </option>
                    </select>
                    @if ($errors->has('gender'))
                        <x-input-error for="gender" :messages="$errors->get('gender')" class="mt-2" />
                    @endif
                </div>

              
                <div class="col-span-6">
                    <x-label for="avatar" value="{{ __('instructors.avatar') }}" />
                    <x-image-input name="avatar" />
                    @if ($instructor?->user?->avatar)
                        <div class="mt-4">
                            <img src="{{ asset('storage/instructors/' . $instructor->user->avatar) }}"
                                class="h-40 w-40 object-cover rounded-md"
                                alt="{{ $instructor->user->name }}'s avatar" />
                        </div>
                    @endif

                    @if ($errors->has('avatar'))
                        <x-input-error for="avatar" :messages="$errors->get('avatar')" class="mt-2" />
                    @endif
                </div>


            </div>
        </div>


        <div x-show="currentStep === 3" x-transition>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="email" value="{{ __('instructors.email') }}" />
                    <x-input id="email" name="email" type="email" class="mt-1 block w-full"
                        x-model="formData.email"  />
                    @if ($errors->has('email'))
                        <x-input-error for="email" :messages="$errors->get('email')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="phone" value="{{ __('instructors.phone') }}" />
                    <x-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                        x-model="formData.phone"  />
                    @if ($errors->has('phone'))
                        <x-input-error for="phone" :messages="$errors->get('phone')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="company" value="{{ __('instructors.company') }}" />
                    <x-input id="company" name="company" type="text" class="mt-1 block w-full"
                        x-model="formData.company"  />
                    @if ($errors->has('company'))
                        <x-input-error for="company" :messages="$errors->get('company')" class="mt-2" />
                    @endif
                </div>


                <div class="col-span-3">
                    <x-label for="twitter_url" value="{{ __('instructors.twitter_url') }}" />
                    <x-input id="twitter_url" name="twitter_url" type="text" class="mt-1 block w-full"
                        x-model="formData.twitter_url" />
                    @if ($errors->has('twitter_url'))
                        <x-input-error for="twitter_url" :messages="$errors->get('twitter_url')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="linkedin_url" value="{{ __('instructors.linkedin_url') }}" />
                    <x-input id="linkedin_url" name="linkedin_url" type="text" class="mt-1 block w-full"
                        x-model="formData.linkedin_url" />
                    @if ($errors->has('linkedin_url'))
                        <x-input-error for="linkedin_url" :messages="$errors->get('linkedin_url')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="facebook_url" value="{{ __('instructors.facebook_url') }}" />
                    <x-input id="facebook_url" name="facebook_url" type="text" class="mt-1 block w-full"
                        x-model="formData.facebook_url" />
                    @if ($errors->has('facebook_url'))
                        <x-input-error for="facebook_url" :messages="$errors->get('facebook_url')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-3">
                    <x-label for="youtube_url" value="{{ __('instructors.youtube_url') }}" />
                    <x-input id="youtube_url" name="youtube_url" type="text" class="mt-1 block w-full"
                        x-model="formData.youtube_url" />
                    @if ($errors->has('youtube_url'))
                        <x-input-error for="youtube_url" :messages="$errors->get('youtube_url')" class="mt-2" />
                    @endif
                </div>





            </div>
        </div>

        <div x-show="currentStep === 4" x-transition>
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('instructors.review_information') }}</h3>

                <div class="space-y-6">
                    <!-- Personal Information -->
                    <div>
                        <h4 class="font-medium text-gray-900 border-b pb-2 mb-3">
                            {{ __('instructors.personal_information') }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.first_name_ar') }}</p>
                                <p x-text="formData.first_name_ar || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.first_name_en') }}</p>
                                <p x-text="formData.first_name_en || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.second_name_ar') }}</p>
                                <p x-text="formData.second_name_ar || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.second_name_en') }}</p>
                                <p x-text="formData.second_name_en || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.gender') }}</p>
                                <p x-text="formData.gender ? (formData.gender === 'male' ? '{{ __('instructors.male') }}' : '{{ __('instructors.female') }}') : 'N/A'"
                                    class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.birth_date') }}</p>
                                <p x-text="formData.birth_date || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">{{ __('instructors.bio_ar') }}</p>
                                <p x-text="formData.bio_ar || 'N/A'" class="text-gray-900 whitespace-pre-line"></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">{{ __('instructors.bio_en') }}</p>
                                <p x-text="formData.bio_en || 'N/A'" class="text-gray-900 whitespace-pre-line"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div>
                        <h4 class="font-medium text-gray-900 border-b pb-2 mb-3">
                            {{ __('instructors.professional_information') }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.specialization_ar') }}</p>
                                <p x-text="formData.specialization_ar || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.experience') }}</p>
                                <p x-text="formData.experience ? formData.experience + ' ' + '{{ __('instructors.years') }}' : 'N/A'"
                                    class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.education') }}</p>
                                <p x-text="formData.education || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.company') }}</p>
                                <p x-text="formData.company || 'N/A'" class="text-gray-900"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h4 class="font-medium text-gray-900 border-b pb-2 mb-3">
                            {{ __('instructors.contact_information') }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.email') }}</p>
                                <p x-text="formData.email || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.phone') }}</p>
                                <p x-text="formData.phone || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.twitter_url') }}</p>
                                <p x-text="formData.twitter_url || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.linkedin_url') }}</p>
                                <p x-text="formData.linkedin_url || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.facebook_url') }}</p>
                                <p x-text="formData.facebook_url || 'N/A'" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('instructors.youtube_url') }}</p>
                                <p x-text="formData.youtube_url || 'N/A'" class="text-gray-900"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-t pt-6">
                    <label class="flex items-start">
                        <input type="checkbox" name="terms"
                            class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            >
                        <span class="ml-2 text-sm text-gray-600">{{ __('instructors.confirm_information') }}</span>
                    </label>
                    @if ($errors->has('terms'))
                        <x-input-error for="terms" :messages="$errors->get('terms')" class="mt-2" />
                    @endif
                </div>
            </div>
        </div>


        <div class="flex justify-between pt-6">
            <button type="button" x-show="!isFirstStep()" @click="prevStep()"
                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('instructors.previous') }}
            </button>

            <button type="button" x-show="!isLastStep()" @click="nextStep()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('instructors.next') }}
            </button>

            <button type="submit" x-show="isLastStep()"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ isset($instructor) ? __('instructors.update_instructor') : __('instructors.create_instructor') }}
            </button>
        </div>
    </form>
</div>
