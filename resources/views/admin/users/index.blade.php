<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin — User Management
            </h2>
            <span class="text-sm text-slate-500">{{ $users->total() }} total users</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Search & Filter --}}
            <div class="bg-white rounded-2xl shadow-sm p-4 mb-6">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-3 items-end">
                    <div class="flex-1">
                        <label class="block text-xs text-slate-500 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Name or email..."
                               class="w-full rounded-lg border-slate-300 focus:border-sage-400 focus:ring-sage-400 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Status</label>
                        <select name="status" class="rounded-lg border-slate-300 focus:border-sage-400 focus:ring-sage-400 text-sm">
                            <option value="">All</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="bg-slate-700 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2 rounded-lg">
                        Search
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.users.index') }}"
                           class="text-sm text-slate-500 hover:text-slate-700 py-2">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            {{-- Users Table --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">User</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Groups</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Contacts</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-sage-200 flex items-center justify-center text-slate-700 font-bold text-sm flex-shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800">{{ $user->name }}
                                                @if($user->is_admin)
                                                    <span class="ml-1 text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">Admin</span>
                                                @endif
                                            </p>
                                            <p class="text-slate-400 text-xs">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->family_groups_count }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->contacts_count }}</td>
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs">{{ $user->created_at->format('M j, Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 justify-end">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                           class="text-xs text-slate-600 hover:text-slate-800 font-medium px-3 py-1.5 rounded-lg border border-slate-200 hover:border-slate-300">
                                            View
                                        </a>

                                        @if($user->id !== auth()->id())
                                            {{-- Toggle Active --}}
                                            <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="text-xs font-medium px-3 py-1.5 rounded-lg border {{ $user->is_active ? 'text-amber-600 border-amber-200 hover:bg-amber-50' : 'text-green-600 border-green-200 hover:bg-green-50' }}">
                                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                            {{-- Delete --}}
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                  onsubmit="return confirm('Are you sure you want to delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-xs font-medium px-3 py-1.5 rounded-lg border text-red-600 border-red-200 hover:bg-red-50">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
