<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROMEX - Promotional Exam Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-blue-700 text-white font-extrabold text-xl px-3 py-1 rounded-lg tracking-widest">
                PROMEX
            </div>
            <span class="text-gray-500 text-sm hidden sm:block">Promotional Exam Management System</span>
        </div>
        <a href="{{ route('login') }}"
           class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2 rounded-lg transition">
            Login
        </a>
    </nav>

    {{-- Hero --}}
    <div class="bg-gradient-to-br from-blue-800 to-blue-600 text-white py-24 px-8 text-center">
        <h1 class="text-5xl font-extrabold mb-4 tracking-tight">PROMEX</h1>
        <p class="text-xl text-blue-100 mb-2">Promotional Exam Management System</p>
        <p class="text-blue-200 max-w-xl mx-auto mb-10 text-sm">
            A secure, structured platform for managing promotional examinations — from result entry and review to final publication.
        </p>
        <a href="{{ route('login') }}"
           class="inline-block bg-white text-blue-700 font-bold px-8 py-3 rounded-xl shadow hover:bg-blue-50 transition text-lg">
            Sign In to Your Portal
        </a>
    </div>

    {{-- Features --}}
    <div class="max-w-6xl mx-auto px-6 py-20">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-12">How It Works</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="bg-blue-100 text-blue-600 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Instructor</h3>
                <p class="text-sm text-gray-500">Enters and submits exam results for assigned subjects.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="bg-indigo-100 text-indigo-600 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Chief Examiner</h3>
                <p class="text-sm text-gray-500">Reviews, approves or returns results to instructors.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="bg-emerald-100 text-emerald-600 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h0a4 4 0 014 4v2M12 3a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Director General</h3>
                <p class="text-sm text-gray-500">Approves final publication of results to student portals.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="bg-yellow-100 text-yellow-600 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Student</h3>
                <p class="text-sm text-gray-500">Views published results and downloads result slip.</p>
            </div>

        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 px-8 py-6 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} PROMEX — Promotional Exam Management System. All rights reserved.
    </footer>

</body>
</html>
