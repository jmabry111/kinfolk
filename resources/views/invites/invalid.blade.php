<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Invalid Invite
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <p class="text-gray-700 text-lg mb-4">
                    This invite link is no longer valid.
                </p>
                <p class="text-gray-500 text-sm mb-6">
                    It may have expired or already been used. Ask the group owner to send you a new invite.
                </p>
                <a href="{{ route('dashboard') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                    Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
