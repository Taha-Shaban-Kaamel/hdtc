<x-app-layout>
    <div class="py-5">
        <div class="px-6 py-4">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <div class="px-6 py-4 mt-4 flex h-[100px] w-full">
                    <x-breadcrumb :items="[
                        ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                        ['url' => route('admins.index'), 'label' => __('common.administrators')],
                        ['label' => __('common.edit')],
                    ]" />
                </div>
            </div>
        </div>

        <div class="pb-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white max-h-[calc(100vh-12rem)] overflow-scroll shadow-sm sm:rounded-lg p-6">
                    <x-admins.form-stepper 
                        :admin="$admin"
                        :steps="3" 
                        :currentStep="1" 
                        :totalSteps="3" 
                        :action="route('admins.update', $admin)" 
                        :method="'PUT'" 
                        :redirect="route('admins.index')" 
                    />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
