<div class="min-w-fit absolute !bottom-0">
    <div class="fixed inset-0 bg-white z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>
    <div id="sidebar"
        class="flex lg:flex! flex-col absolute z-40 left-0 !bottom-0 lg:static lg:left-auto lg:bottom-0 lg:translate-x-0 h-[calc(100dvh-4rem)] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20  shrink-0 bg-[#64A1B2] p-4 transition-all duration-200 ease-in-out"
        :style="sidebarExpanded ? 'width: 315px' : ''"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false">
        <div class="space-y-8">
            <div>
                <ul class="mt-3">
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                        x-data="{ sidebarExpanded: false }"
                        :class="[
                            sidebarExpanded && @js(Route::is('dashboard')) ?
                            'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                            ''
                        ]">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white"
                            href="{{ route('dashboard') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <img class="w-5 h-5" src="{{ asset('storage/dashboard/icons/Home.png') }}"
                                        alt="">
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                        :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">{{ __('sidebar.dashboard') }}</span>
                                </div>

                            </div>
                        </a>
                    </li>
                    @canany(['view-admins', 'create-admins', 'edit-admins', 'delete-admins'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                            x-data="{ sidebarExpanded: false }"
                            :class="[
                                sidebarExpanded && @js(Route::is('admins.index') || Route::is('admins.create') || Route::is('admins.edit')) ?
                                'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                                ''
                            ]">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white"
                                href="{{ route('admins.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                            :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">{{ __('admin.admins') }}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcanany

                    @canany(['view-roles', 'create-roles', 'edit-roles', 'delete-roles'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                            x-data="{ sidebarExpanded: false }"
                            :class="[
                                sidebarExpanded && @js(Route::is('roles.index') || Route::is('roles.create') || Route::is('roles.edit')) ?
                                'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                                ''
                            ]">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white"
                                href="{{ route('roles.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                            :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">{{ __('sidebar.roles') }}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcanany

                    @canany(['view-courses', 'create-courses', 'edit-courses', 'delete-courses'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                            x-data="{ sidebarExpanded: false }"
                            :class="[
                                sidebarExpanded && @js(Route::is('courses.index') || Route::is('courses.create') || Route::is('courses.edit')) ?
                                'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                                ''
                            ]">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white"
                                href="{{ route('courses.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                            :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">{{ __('sidebar.courses') }}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcanany
                    @canany(['view-categories', 'create-categories', 'edit-categories', 'delete-categories'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                            x-data="{ sidebarExpanded: false }"
                            :class="[
                                sidebarExpanded && @js(Route::is('courses.categories.index')) ?
                                'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                                ''
                            ]">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white"
                                href="{{ route('courses.categories.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                            :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">{{ __('sidebar.categories') }}</span>
                                    </div>
                                </div>
                            </a>


                        </li>
                    @endcanany

                    @canany(['view-instructors', 'create-instructors', 'edit-instructors', 'delete-instructors'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                            x-data="{ sidebarExpanded: false }"
                            :class="[
                                sidebarExpanded && @js(Route::is('web.instructors.index') || Route::is('web.instructors.create') || Route::is('web.instructors.edit')) ?
                                'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                                ''
                            ]">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white"
                                href="{{ route('web.instructors.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex shrink-0 ">
                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                            :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">{{ __('sidebar.instructors') }}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcanany

                    @canany(['view-notifications', 'create-notifications', 'edit-notifications',
                        'delete-notifications'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                            x-data="{ sidebarExpanded: false }"
                            :class="[
                                sidebarExpanded && @js(Route::is('notifications.index') || Route::is('notifications.create')) ?
                                'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                                ''
                            ]">
                            <a class="block text-white  truncate transition hover:text-gray-900 dark:hover:text-white"
                                href="{{ route('notifications.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                            :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">
                                            {{ __('sidebar.notifications') }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcanany

                    @canany(['view-plans', 'create-plans', 'edit-plans', 'delete-plans'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                            x-data="{ sidebarExpanded: false }"
                            :class="[
                                sidebarExpanded && @js(Route::is('plans.index') || Route::is('plans.create') || Route::is('plans.edit')) ?
                                'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                                ''
                            ]">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white"
                                href="{{ route('plans.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                            :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">
                                            {{ __('sidebar.plans') }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcanany
                    @canany(['view-subscriptions', 'manage-subscriptions'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                            x-data="{ sidebarExpanded: false }"
                            :class="[
                                sidebarExpanded && @js(Route::is('subscriptions.index')) ?
                                'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                                ''
                            ]">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white"
                                href="{{ route('subscription.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                            :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">
                                            {{ __('sidebar.subscriptions') }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endcanany
                    @canany(['view-payments', 'create-payments', 'edit-payments', 'delete-payments'])
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: true }"
                        x-data="{ sidebarExpanded: false }"
                        :class="[
                            sidebarExpanded && @js(Route::is('payments.index')) ?
                            'w-[255px] h-[60px] bg-[#066B87] flex items-center justify-center' :
                            ''
                        ]">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition hover:text-gray-900 dark:hover:text-white"
                            href="{{ route('payments.index') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200"
                                        :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">
                                        {{ __('sidebar.payments') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endcanany
                    @can('view-reports')
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r" x-data="{ open: false }"
                            :class="[
                                sidebarExpanded && (
                                    @js(Route::is('reports.index') || Route::is('reports.plans') || Route::is('reports.courses') || Route::is('reports.instructors') || Route::is('reports.subscriptions'))
                                ) ? 'w-[255px] bg-[#066B87] flex flex-col justify-center' : ''
                            ]">

                            <!-- 🔹 العنوان الرئيسي "التقارير" -->
                            <div class="flex items-center justify-between">
                                <a href="{{ route('reports.index') }}"
                                    class="flex items-center gap-1 text-gray-800 dark:text-gray-100 transition hover:text-gray-900 dark:hover:text-white">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 duration-200"
                                        :style="sidebarExpanded ? 'opacity: 1' : 'opacity: 0'">
                                        {{ __('sidebar.reports') }}
                                    </span>
                                </a>

                                <!-- 🔹 زر السهم لفتح/غلق القائمة -->
                                <button @click.stop="open = !open"
                                    class="flex items-center justify-center ml-1 text-gray-400 hover:text-gray-600 transition">
                                    <svg class="w-3 h-3 shrink-0 fill-current transform transition-transform duration-200"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- 🔹 القائمة الفرعية -->
                            <ul x-show="open" class="mt-2 ml-8 space-y-1" x-transition>
                                <li>
                                    <a href="{{ route('reports.plans') }}"
                                        class="block text-gray-700 hover:text-[#066B87] text-sm">
                                        {{ __('sidebar.plans_reports') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('reports.courses') }}"
                                        class="block text-gray-700 hover:text-[#066B87] text-sm">
                                        {{ __('sidebar.courses_reports') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('reports.instructors') }}"
                                        class="block text-gray-700 hover:text-[#066B87] text-sm">
                                        {{ __('sidebar.instructors_reports') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('reports.subscriptions') }}"
                                        class="block text-gray-700 hover:text-[#066B87] text-sm">
                                        {{ __('sidebar.subscriptions_reports') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                </ul>

            </div>
        </div>
        <div class="pt-3 lg:inline-flex justify-end mt-auto">
            <div class="w-12 pl-4 pr-3 py-2">
                <button class="text-black hover:text-gray-500 transition-colors"
                    @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="shrink-0 fill-current text-black sidebar-expanded:rotate-180"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
