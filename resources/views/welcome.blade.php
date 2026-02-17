<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 dark:bg-zinc-950 antialiased flex flex-col">
        
        <!-- Navbar -->
        <header class="w-full border-b border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-app-logo-icon class="size-8 text-indigo-600 dark:text-indigo-400" />
                    <span class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white">SubTrack</span>
                </div>
                <nav class="flex items-center gap-4">
                     @auth
                        <flux:button href="{{ route('dashboard') }}" variant="subtle" size="sm">Dashboard</flux:button>
                    @else
                        <flux:button href="{{ route('login') }}" variant="ghost" size="sm">Log in</flux:button>
                        @if (Route::has('register'))
                            <flux:button href="{{ route('register') }}" variant="primary" size="sm">Get Started</flux:button>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Hero -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center">
                <flux:heading level="1" size="xl" class="mb-6 !text-4xl sm:!text-5xl font-extrabold tracking-tight text-zinc-900 dark:text-white">
                    Stop Overpaying for <span class="text-indigo-600 dark:text-indigo-400">Subscriptions</span>
                </flux:heading>
                
                <p class="max-w-2xl mx-auto mb-10 text-lg text-zinc-600 dark:text-zinc-400">
                    Track your monthly recurring expenses in one place. See exactly how much you're spending every year and take control of your budget.
                </p>
                
                <!-- Calculator -->
                <div class="mt-12 w-full flex justify-center">
                    <livewire:subscription-calculator />
                </div>
            </div>
        </main>

        <footer class="border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
             <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                &copy; {{ date('Y') }} SubTrack. All rights reserved.
            </div>
        </footer>

        @fluxScripts
    </body>
</html>