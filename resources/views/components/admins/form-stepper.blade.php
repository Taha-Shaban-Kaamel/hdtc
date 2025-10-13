@props([
    'admin' => null,
    'currentStep' => 1,
    'totalSteps' => 3,
    'method' => 'POST',
    'action' => route('admins.store'),
    'redirect' => route('admins.index'),
    'roles' => null,
])

<div x-data="{
    currentStep: {{ $currentStep }},
    totalSteps: {{ $totalSteps }},
    formData: {
        email: '{{ old('email', $admin?->user?->email ?? '') }}',
        phone: '{{ old('phone', $admin?->user?->phone ?? '') }}',
        password: '',
        password_confirmation: '',

        first_name_ar: '{{ old('first_name_ar', $admin?->user?->getTranslation('first_name', 'ar') ?? '') }}',
        first_name_en: '{{ old('first_name_en', $admin?->user?->getTranslation('first_name', 'en') ?? '') }}',
        second_name_ar: '{{ old('second_name_ar', $admin?->user?->getTranslation('second_name', 'ar') ?? '') }}',
        second_name_en: '{{ old('second_name_en', $admin?->user?->getTranslation('second_name', 'en') ?? '') }}',
        bio_ar: '{{ old('bio_ar', $admin?->user?->getTranslation('bio', 'ar') ?? '') }}',
        bio_en: '{{ old('bio_en', $admin?->user?->getTranslation('bio', 'en') ?? '') }}',

        birth_date: '{{ old('birth_date', $admin?->user?->birth_date ?? '') }}',
        gender: '{{ old('gender', $admin?->user?->gender ?? '') }}',
        status: '{{ old('status', $admin?->user?->status ?? 'active') }}',
        avatar: '{{ old('avatar', $admin?->user?->avatar ?? '') }}',

        position: '{{ old('position', $admin?->position ?? '') }}',
        department: '{{ old('department', $admin?->department ?? '') }}',
        is_active: '{{ old('is_active', $admin?->is_active ?? '1') }}',

        roles: [],

        address: '{{ old('address', $admin?->address ?? '') }}',
        city: '{{ old('city', $admin?->city ?? '') }}',
        country: '{{ old('country', $admin?->country ?? '') }}',
        postal_code: '{{ old('postal_code', $admin?->postal_code ?? '') }}',
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
        if (this.currentStep === this.totalSteps - 1) {
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                if (input.name && input.name in this.formData) {
                    if (input.type === 'checkbox') {
                        this.formData[input.name] = input.checked ? input.value : '';
                    } else {
                        this.formData[input.name] = input.value;
                    }
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
                        {{ __('admin.personal_information') }}
                    @elseif($i === 2)
                        {{ __('admin.contact_information') }}
                    @elseif($i === $totalSteps)
                        {{ __('admin.review_information') }}
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

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method($method)
        <input type="hidden" name="redirect" value="{{ $redirect }}">

        <div x-show="currentStep === 1" x-transition>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="first_name_ar" value="{{ __('admin.first_name_ar') }}" />
                    <x-input id="first_name_ar" name="first_name_ar" type="text" class="mt-1 block w-full"
                        x-model="formData.first_name_ar" required />
                    <x-input-error for="first_name_ar" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="first_name_en" value="{{ __('admin.first_name_en') }}" />
                    <x-input id="first_name_en" name="first_name_en" type="text" class="mt-1 block w-full"
                        x-model="formData.first_name_en" required />
                    <x-input-error for="first_name_en" class="mt-2" />
                </div>

                <!-- Second Name (AR) -->
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="second_name_ar" value="{{ __('admin.second_name_ar') }}" />
                    <x-input id="second_name_ar" name="second_name_ar" type="text" class="mt-1 block w-full"
                        x-model="formData.second_name_ar" required />
                    <x-input-error for="second_name_ar" class="mt-2" />
                </div>

                <!-- Second Name (EN) -->
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="second_name_en" value="{{ __('admin.second_name_en') }}" />
                    <x-input id="second_name_en" name="second_name_en" type="text" class="mt-1 block w-full"
                        x-model="formData.second_name_en" required />
                    <x-input-error for="second_name_en" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="email" value="{{ __('admin.email') }}" />
                    <x-input id="email" name="email" type="email" class="mt-1 block w-full"
                        x-model="formData.email" required />
                    <x-input-error for="email" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="password" value="{{ __('admin.password') }}" />
                    <x-input id="password" name="password" type="password" class="mt-1 block w-full"
                        x-model="formData.password" :required="!$admin" autocomplete="new-password" />
                    <x-input-error for="password" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="password_confirmation" value="{{ __('admin.password_confirmation') }}" />
                    <x-input id="password_confirmation" name="password_confirmation" type="password"
                        class="mt-1 block w-full" x-model="formData.password_confirmation" :required="!$admin"
                        autocomplete="new-password" />
                    <x-input-error for="password_confirmation" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="status" value="{{ __('admin.status') }}" />
                    <select id="status" name="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        x-model="formData.status" required>
                        <option value="active">{{ __('admin.active') }}</option>
                        <option value="inactive">{{ __('admin.inactive') }}</option>
                    </select>
                    <x-input-error for="status" class="mt-2" />
                </div>
            </div>
        </div>

        <div x-show="currentStep === 2" x-transition>
            <div class="grid grid-cols-6 gap-6">




                <!-- Gender -->
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="gender" value="{{ __('admin.gender') }}" />
                    <select id="gender" name="gender"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        x-model="formData.gender">
                        <option value="">{{ __('admin.select_gender') }}</option>
                        <option value="male">{{ __('admin.male') }}</option>
                        <option value="female">{{ __('admin.female') }}</option>
                    </select>
                    <x-input-error for="gender" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-label for="birth_date" value="{{ __('admin.birth_date') }}" />
                    <x-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full"
                        x-model="formData.birth_date" />
                    <x-input-error for="birth_date" class="mt-2" />
                </div>

                <div class="col-span-3">
                    <x-label for="bio_ar" value="{{ __('admin.bio_ar') }}" />
                    <textarea id="bio_ar" name="bio_ar" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        x-model="formData.bio_ar"></textarea>
                    <x-input-error for="bio_ar" class="mt-2" />
                </div>

                <div class="col-span-3">
                    <x-label for="bio_en" value="{{ __('admin.bio_en') }}" />
                    <textarea id="bio_en" name="bio_en" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        x-model="formData.bio_en"></textarea>
                    <x-input-error for="bio_en" class="mt-2" />
                </div>



                <div class="col-span-6 sm:col-span-3">
                    <x-label for="phone" value="{{ __('admin.phone') }}" />
                    <x-input id="phone" name="phone" type="tel" class="mt-1 block w-full"
                        x-model="formData.phone" />
                    <x-input-error for="phone" class="mt-2" />
                </div>



            </div>
        </div>

        <div x-show="currentStep === 2" x-transition>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6">
                    <x-label for="avatar" value="{{ __('admin.profile_photo') }}" />
                    <input id="avatar" name="avatar" type="file" class="mt-1 block w-full"
                        @change="formData.avatar = $event.target.files[0]?.name || ''">
                    <x-input-error for="avatar" class="mt-2" />
                    <div x-show="formData.avatar" class="mt-2 text-sm text-gray-500">
                        {{ __('admin.selected_file') }}: <span x-text="formData.avatar"></span>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="currentStep === 3" x-transition>
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('admin.review_information') }}</h3>

                <div class="space-y-6">
                    <div>
                        <h4 class="font-medium text-gray-900 border-b pb-2 mb-3">
                            {{ __('admin.personal_information') }}</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('admin.first_name_ar') }} / {{ __('admin.first_name_en') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900"
                                    x-text="formData.first_name_ar + ' / ' + formData.first_name_en"></dd>
                            </div>
                            <div class="sm:col-span-1" x-show="formData.second_name_ar || formData.second_name_en">
                                <dt class="text-sm font-medium text-gray-500">{{ __('admin.second_name_en') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900"
                                    x-text="(formData.second_name_ar || '') + (formData.second_name_ar && formData.second_name_en ? ' / ' : '') + (formData.second_name_en || '')">
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('admin.email') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900" x-text="formData.email || ''"></dd>
                            </div>
                            <div class="sm:col-span-1" x-show="formData.phone">
                                <dt class="text-sm font-medium text-gray-500">{{ __('admin.phone') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900" x-text="formData.phone"></dd>
                            </div>
                            <div class="sm:col-span-1" x-show="formData.gender">
                                <dt class="text-sm font-medium text-gray-500">{{ __('admin.gender') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900" x-text="formData.gender"></dd>
                            </div>
                            <div class="sm:col-span-1" x-show="formData.birth_date">
                                <dt class="text-sm font-medium text-gray-500">{{ __('admin.birth_date') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900" x-text="formData.birth_date"></dd>
                            </div>
                        </dl>
                    </div>
                    <div x-show="formData.bio_ar || formData.bio_en">
                        <h4 class="font-medium text-gray-900 border-b pb-2 mb-3">{{ __('admin.bio') }}</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2">
                            <div x-show="formData.bio_ar">
                                <dt class="text-sm font-medium text-gray-500">{{ __('admin.bio_ar') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900" x-text="formData.bio_ar"></dd>
                            </div>
                            <div x-show="formData.bio_en">
                                <dt class="text-sm font-medium text-gray-500">{{ __('admin.bio_en') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900" x-text="formData.bio_en"></dd>
                            </div>
                        </dl>
                    </div>

                    <div x-show="formData.status">
                        <h4 class="font-medium text-gray-900 border-b pb-2 mb-3">{{ __('admin.status') }}</h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="{
                                'bg-green-100 text-green-800': formData.status === 'active',
                                'bg-yellow-100 text-yellow-800': formData.status === 'inactive',
                                'bg-red-100 text-red-800': formData.status === 'suspended'
                            }"
                            x-text="formData.status.charAt(0).toUpperCase() + formData.status.slice(1)">
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6">
            <button type="button" x-show="!isFirstStep()" @click="prevStep()"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('admin.previous') }}
            </button>

            <div class="flex space-x-3">
                <button type="button" x-show="!isLastStep()" @click="nextStep(); updateFormData();"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('admin.next') }}
                </button>

                <button type="submit" x-show="isLastStep()"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    {{ __('admin.save_changes') }}
                </button>
            </div>
        </div>
    </form>
</div>
