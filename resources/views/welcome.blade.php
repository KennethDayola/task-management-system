<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Management System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <div class="min-h-screen flex flex-col">

        <!-- Top bar -->
        <header class="w-full">
            <nav class="max-w-5xl mx-auto flex items-center justify-between px-6 py-6">
                <div class="flex items-center gap-2">
                    <x-application-logo class="h-8 w-auto fill-current text-indigo-600" />
                    <span class="font-semibold text-lg text-gray-800">Task Management System</span>
                </div>

                @if (Route::has('login'))
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="btn-primary text-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="btn-primary text-sm">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>
        </header>

        <!-- Hero -->
        <main class="flex-1 flex items-center">
            <div class="max-w-3xl mx-auto px-6 py-20 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                    Organize your projects,<br class="hidden sm:block"> track every task.
                </h1>
                <p class="mt-5 text-lg text-gray-500 max-w-xl mx-auto">
                    A simple, focused way to manage projects and tasks — create, assign statuses, track progress, and stay on top of deadlines.
                </p>

                <div class="mt-8 flex items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">
                            Go to Dashboard
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">
                                Get Started Free
                            </a>
                        @endif
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-gray-600 hover:text-gray-900 font-medium text-sm">
                            Log in →
                        </a>
                    @endauth
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-6 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} Task Management System. Built with Laravel v{{ app()->version() }}.
        </footer>

    </div>

</body>
</html>