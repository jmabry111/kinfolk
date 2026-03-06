<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="max-w-xl">
        <h2 class="text-lg font-medium text-gray-900">App Tour</h2>
        <p class="mt-1 text-sm text-gray-600">
            Replay the getting started tour to learn about Kinfolk's features.
        </p>
        <div class="mt-4 flex gap-3">
<a href="{{ route('dashboard') }}?tour=1"
   class="bg-sage-500 hover:bg-sage-600 text-white text-sm font-medium px-4 py-2 rounded-lg">
    Take the Tour
</a>
            <form method="POST" action="{{ route('walkthrough.reset') }}">
                @csrf
                <button type="submit"
                        class="border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-lg">
                    Reset Tour
                </button>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
