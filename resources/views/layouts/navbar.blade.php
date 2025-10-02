<header class="flex items-center justify-between bg-white border-b h-16 px-4">
    <!-- Sidebar Toggle Button -->
    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-gray-800 focus:outline-none">
        <!-- Hamburger Icon -->
        <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <!-- Close Icon -->
        <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <!-- Logo -->
    <div class="font-semibold text-lg">
        My App
    </div>

    <!-- User Avatar -->
    <div>
        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-8 h-8 rounded-full" alt="avatar">
    </div>
</header>
