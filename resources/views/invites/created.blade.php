<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invite to {{ $familyGroup->name }}
            </h2>
            <a href="{{ route('family-groups.show', $familyGroup) }}" class="text-indigo-600 hover:underline text-sm">
                ← Back to Group
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <p class="text-gray-700 mb-4">
                    Share this invite link with someone you'd like to add to
                    <strong>{{ $familyGroup->name }}</strong>.
                    The link expires in <strong>7 days</strong> and can only be used once.
                </p>

                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <input type="text" id="invite-url" value="{{ $inviteUrl }}" readonly
                           class="flex-1 bg-transparent text-sm text-gray-700 outline-none">
                    <button onclick="copyInviteUrl()"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-1.5 px-3 rounded">
                        Copy
                    </button>
                </div>

                <p class="text-xs text-gray-400 mt-2">
                    Expires {{ $invite->expires_at->format('F j, Y \a\t g:i A') }}
                </p>

                <script>
                    function copyInviteUrl() {
                        const input = document.getElementById('invite-url');
                        input.select();
                        document.execCommand('copy');
                        alert('Invite link copied!');
                    }
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
