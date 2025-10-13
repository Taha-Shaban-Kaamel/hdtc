<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="w-full h-full max-w-md  p-8 rounded-lg  text-center">
            <div class="text-6xl text-red-500 mb-4 font-bold">403</div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Access Denied</h1>
            <p class="text-gray-600 mb-6">You don't have permission to access this page.</p>
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Go Back
            </a>
            <a href="{{ route('dashboard') }}" 
               class="ml-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Dashboard
            </a>
        </div>
    </div>
</x-app-layout>