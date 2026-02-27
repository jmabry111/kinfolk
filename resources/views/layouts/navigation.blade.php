<nav x-data="{ open: false }" class="bg-slate-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo & Primary Nav -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center mr-8">
                    <img src="/images/kinfolk-logo-light.svg" alt="Kinfolk" class="h-20 w-auto">
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden sm:flex sm:items-center sm:gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                              {{ request()->routeIs('dashboard') 
                                 ? 'bg-slate-700 text-white' 
                                 : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('family-groups.index') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                              {{ request()->routeIs('family-groups.*') 
                                 ? 'bg-slate-700 text-white' 
                                 : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">
                        My Groups
                    </a>
                </div>
            </div>

            <!-- Right side -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-200 hover:bg-slate-700 hover:text-white transition-colors duration-150">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-sage-500 text-white text-sm font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-xs text-gray-500">Signed in as</p>
                            <p class="text-sm font-medium text-gray-800 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile Settings
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Sign Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-lg text-slate-200 hover:bg-slate-700 hover:text-white transition-colors">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="sm:hidden border-t border-slate-700">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2 rounded-lg text-sm font-medium
                      {{ request()->routeIs('dashboard') 
                         ? 'bg-slate-700 text-white' 
                         : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">
                Dashboard
            </a>
            <a href="{{ route('family-groups.index') }}"
               class="block px-4 py-2 rounded-lg text-sm font-medium
                      {{ request()->routeIs('family-groups.*') 
                         ? 'bg-slate-700 text-white' 
                         : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">
                My Groups
            </a>
        </div>
        <div class="px-4 py-3 border-t border-slate-700">
            <div class="flex items-center gap-3 mb-3">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-sage-500 text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <div>
                    <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-300">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 rounded-lg text-sm text-slate-200 hover:bg-slate-700 hover:text-white">
                Profile Settings
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg text-sm text-slate-200 hover:bg-slate-700 hover:text-white">
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</nav>
