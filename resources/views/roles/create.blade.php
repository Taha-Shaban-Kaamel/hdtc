{{-- <x-app-layout>
    <div class="py-5 max-h-[calc(100vh-12rem)]">
        <div class="px-6 py-4 !pt-9">
            <x-breadcrumb :items="[
                ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                ['url' => route('roles.index'), 'label' => __('common.roles')],
                ['label' => __('roles.add_role')],
            ]" />
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form-section submit="store" :action="route('roles.store')">
                <x-slot name="title" class="text-xl font-bold text-gray-900">
                    {{ __('roles.add_role') }}
                </x-slot>

                <x-slot name="description" class="text-gray-600">
                    {{ __('roles.add_role_description') }}
                </x-slot>

                <x-slot name="form">

                    <div class="mt-4 col-span-3">
                        <x-label for="name" value="{{ __('common.name') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full" name="name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>


                </x-slot>

                <x-slot name="actions">
                    <div class="flex justify-end">
                        <x-button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm leading-tight rounded-md shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            {{ __('common.create') }}

                        </x-button>
                    </div>
                </x-slot>
            </x-form-section>
        </div>
    </div>

</x-app-layout>, --}}



<x-app-layout>
    <div class="py-5 max-h-[calc(100vh-12rem)]">
      <div class="px-6 py-4 !pt-9">
          <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
              <div class="px-6 py-4">
                  <x-breadcrumb :items="[
                      ['url' => route('dashboard'), 'label' => __('common.dashboard')],
                      ['url' => route('roles.index'), 'label' => __('common.roles')],
                      ['label' => __('common.create')]
                  ]" />
              </div>
          </div>
      </div>
  <div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <form action="{{ route('roles.store') }}" method="POST" novalidate>
                      @csrf
                      @method('POST')

                      <div class="mb-6">
                          <x-label for="name" :value="__('roles.role_name')" />
                          <x-input id="name" type="text" class="mt-1 block w-full" name="name"
                              :value="old('name')"   />
                          <x-input-error for="name" class="mt-2" />
                      </div>

                      <div class="mb-6">
                          <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('roles.permissions') }}</h3>

                          <div class="overflow-x-auto">
                              <table class="min-w-full divide-y divide-gray-200">
                                  <thead class="bg-gray-50">
                                      <tr>
                                          <th
                                              class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                              {{ __('roles.section') }}
                                          </th>
                                          <th
                                              class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                              {{ __('common.view') }}
                                          </th>
                                          <th
                                              class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                              {{ __('common.create') }}
                                          </th>
                                          <th
                                              class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                              {{ __('common.edit') }}
                                          </th>
                                          <th
                                              class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                              {{ __('common.delete') }}
                                          </th>
                                      </tr>
                                  </thead>
                                  <tbody class="bg-white divide-y divide-gray-200">
                                      @php
                                          $groupedPermissions = $permissions->groupBy(function ($permission) {
                                              $parts = explode('-', $permission->name, 2);
                                              return $parts[1] ?? 'other';
                                          });
                                      @endphp


                                      @foreach ($groupedPermissions as $section => $sectionPermissions)
                                          <tr>
                                              <td
                                                  class="px-6 py-4 whitespace-nowrap text-center font-medium text-gray-900">
                                                  {{ ucfirst($section) }}
                                              </td>

                                              @foreach (['view', 'create', 'edit', 'delete'] as $action)
                                                  <td class="px-6 py-4 whitespace-nowrap text-center">
                                                      @php
                                                          $permissionName = "{$action}-{$section}"; // Changed order here
                                                          $permission = $sectionPermissions->firstWhere(
                                                              'name',
                                                              $permissionName,
                                                          );
                                                      @endphp

                                                      @if ($permission)
                                                          <input type="checkbox" name="permissions[]"
                                                              value="{{ $permissionName }}"
                                                              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                      @endif
                                                  </td>
                                              @endforeach
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>

                      <div class="flex items-center justify-end gap-2 mt-8 ">
                          <a href="{{ route('roles.index') }}" 
                             class="inline-flex items-center gap-1 px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                              <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                              </svg>
                              {{ __('common.cancel') }}
                          </a>
                          <button type="submit" 
                                  class="inline-flex items-center gap-1 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                              <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                              </svg>
                              {{ __('common.create') }}
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>

