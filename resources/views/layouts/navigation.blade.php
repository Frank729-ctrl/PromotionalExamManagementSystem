<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="bg-blue-700 text-white font-extrabold text-sm px-3 py-1 rounded-lg tracking-widest">
                        PROMEX
                    </div>
                    <span class="text-gray-500 text-sm hidden sm:block">Promotional Exam Management System</span>
                </a>
            </div>

            {{-- Right side - Desktop --}}
            <div class="hidden sm:flex sm:items-center sm:gap-4">

                {{-- Role Badge --}}
                @php $role = Auth::user()->getRoleNames()->first(); @endphp
                @if($role)
                    <span class="text-xs font-semibold px-3 py-1 rounded-full
                        @if($role === 'instructor') bg-blue-100 text-blue-700
                        @elseif($role === 'examboard') bg-indigo-100 text-indigo-700
                        @elseif($role === 'director') bg-emerald-100 text-emerald-700
                        @elseif($role === 'student') bg-yellow-100 text-yellow-700
                        @else bg-gray-100 text-gray-600
                        @endif">
                        {{ ucfirst($role) }}
                    </span>
                @endif

                {{-- User Dropdown --}}
                <div class="relative" x-data="{ dropOpen: false }">
                    <button @click="dropOpen = !dropOpen"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                        <div class="bg-blue-700 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="dropOpen" @click.outside="dropOpen = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            Profile
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Hamburger - Mobile --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="px-4 py-3 border-b border-gray-100">
            <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
        </div>
        <div class="py-2">
            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</nav>
