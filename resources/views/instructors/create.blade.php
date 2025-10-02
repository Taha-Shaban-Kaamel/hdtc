<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('instructors.add_instructor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                <x-form-section method="POST" action="{{ route('instructors.store') }}">
                    <x-slot name="title" class="text-xl font-bold text-gray-900">
                        {{ __('instructors.instructor_information') }}
                    </x-slot>

                    <x-slot name="description" class="text-gray-600">
                        {{ __('instructors.create_a_new_instructor') }}
                    </x-slot>

                    <x-slot name="form" class="grid grid-cols-6 gap-6">
                        <!-- Name -->
                        <div class="col-span-6 sm:col-span-3">
                            <x-label for="name" value="{{ __('instructors.name') }}" />
                            <x-input id="name" type="text" class="mt-1 block w-full" name="name" :value="old('name')" required autofocus />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="col-span-6 sm:col-span-3">
                            <x-label for="email" value="{{ __('instructors.email') }}" />
                            <x-input id="email" type="email" class="mt-1 block w-full" name="email" :value="old('email')" required />
                            <x-input-error for="email" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div class="col-span-6 sm:col-span-3">
                            <x-label for="phone" value="{{ __('instructors.phone') }}" />
                            <x-input id="phone" type="tel" class="mt-1 block w-full" name="phone" :value="old('phone')" />
                            <x-input-error for="phone" class="mt-2" />
                        </div>

                        <!-- Bio -->
                        <div class="col-span-6">
                            <x-label for="bio" value="{{ __('instructors.bio') }}" />
                            <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-gray-300 focus:border-[#066B87] focus:ring focus:ring-[#066B87] focus:ring-opacity-50 rounded-md shadow-sm">{{ old('bio') }}</textarea>
                            <x-input-error for="bio" class="mt-2" />
                        </div>

                        <!-- Profile Photo -->
                        <div class="col-span-6">
                            <x-label for="photo" value="{{ __('instructors.profile_photo') }}" />
                            <input type="file" id="photo" name="photo" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-[#066B87] file:text-white
                                hover:file:bg-[#055a72]">
                            <x-input-error for="photo" class="mt-2" />
                        </div>
                    </x-slot>

                    <x-slot name="actions">
                        <x-button type="submit" class="px-6 py-2.5 bg-[#066B87] hover:bg-[#055a72] text-white font-medium text-sm leading-tight rounded-md shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#066B87] transition duration-150 ease-in-out">
                            {{ __('instructors.create_instructor') }}
                        </x-button>
                    </x-slot>
                </x-form-section>
            </div>
        </div>
    </div>
</x-app-layout>
