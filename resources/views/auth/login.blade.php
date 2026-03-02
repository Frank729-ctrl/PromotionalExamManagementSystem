<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROMEX - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="bg-blue-700 text-white font-extrabold text-xl px-3 py-1 rounded-lg tracking-widest">
                PROMEX
            </div>
            <span class="text-gray-500 text-sm hidden sm:block">Promotional Exam Management System</span>
        </a>
    </nav>

    {{-- Login Card --}}
    <div class="flex-1 flex items-center justify-center py-16 px-4">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 w-full max-w-md p-10">

            <div class="text-center mb-8">
                <div class="bg-blue-700 text-white font-extrabold text-2xl px-4 py-2 rounded-xl tracking-widest inline-block mb-4">
                    PROMEX
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Sign in to your account</h2>
                <p class="text-sm text-gray-500 mt-1">Enter your credentials to continue</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between mb-6">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember"
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-blue-600 hover:underline">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 rounded-lg transition text-sm">
                    Sign In
                </button>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="text-center text-xs text-gray-400 py-4">
        &copy; {{ date('Y') }} PROMEX — Promotional Exam Management System
    </footer>

</body>
</html>
