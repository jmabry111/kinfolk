<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User — {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:underline text-sm">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- User Details --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-sage-200 flex items-center justify-center text-slate-700 font-bold text-2xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">
                                {{ $user->name }}
                                @if($user->is_admin)
                                    <span class="ml-2 text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">Admin</span>
                                @endif
                            </h3>
                            <p class="text-slate-500">{{ $user->email }}</p>
                            <p class="text-slate-400 text-sm mt-1">Joined {{ $user->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="flex items-center gap-3">
                        @if($user->is_active)
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-sm font-medium px-3 py-1.5 rounded-full">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span> Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-sm font-medium px-3 py-1.5 rounded-full">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span> Inactive
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-slate-100">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-slate-700">{{ $user->family_groups_count }}</p>
                        <p class="text-sm text-slate-500">Family Groups</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-slate-700">{{ $user->contacts_count }}</p>
                        <p class="text-sm text-slate-500">Contacts Added</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-slate-700">{{ $user->walkthrough_completed ? '✅' : '⏳' }}</p>
                        <p class="text-sm text-slate-500">Walkthrough</p>
                    </div>
                </div>

                {{-- Actions --}}
                @if($user->id !== auth()->id())
                    <div class="flex gap-3 mt-6 pt-6 border-t border-slate-100">
                        <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="text-sm font-medium px-4 py-2 rounded-lg border {{ $user->is_active ? 'text-amber-600 border-amber-300 hover:bg-amber-50' : 'text-green-600 border-green-300 hover:bg-green-50' }}">
                                {{ $user->is_active ? 'Deactivate Account' : 'Activate Account' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Are you sure you want to delete {{ addslashes($user->name) }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-sm font-medium px-4 py-2 rounded-lg border text-red-600 border-red-300 hover:bg-red-50">
                                Delete Account
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Family Groups --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-slate-700 mb-4">Family Groups</h3>
                @forelse($user->familyGroups as $group)
                    <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
                        <div>
                            <p class="font-medium text-slate-700">{{ $group->name }}</p>
                            <p class="text-sm text-slate-400">{{ $group->contacts->count() }} contacts</p>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 text-sm">No family groups yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
