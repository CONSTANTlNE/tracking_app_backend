<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900">

    {{-- Top nav --}}
    <header class="bg-white border-b border-zinc-200">
        <div class="mx-auto max-w-6xl px-6 flex h-14 items-center justify-between">
            <div class="flex items-center gap-8">
                <span class="font-semibold text-zinc-900 tracking-tight">{{ config('app.name') }}</span>
                <nav class="flex items-center gap-1">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="px-3 py-1.5 text-sm rounded-md transition {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-100 text-zinc-900 font-medium' : 'text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50' }}"
                    >Dashboard</a>
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="px-3 py-1.5 text-sm rounded-md transition {{ request()->routeIs('admin.users.*') ? 'bg-zinc-100 text-zinc-900 font-medium' : 'text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50' }}"
                    >Users</a>
                </nav>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-zinc-500">{{ auth()->user()->name }}</span>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="text-sm text-zinc-500 hover:text-zinc-900 transition">Sign out</button>
                </form>
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    @if (session('success') || session('plain_token'))
        <div class="mx-auto max-w-6xl px-6 mt-5">
            @if (session('plain_token'))
                <div class="rounded-lg bg-amber-50 border border-amber-200 px-4 py-3 text-sm">
                    <p class="font-medium text-amber-800 mb-1">Token generated — copy it now, it won't be shown again:</p>
                    <code class="block bg-white border border-amber-200 rounded px-3 py-2 text-amber-900 break-all font-mono text-xs select-all">{{ session('plain_token') }}</code>
                </div>
            @endif
            @if (session('success'))
                <div class="rounded-lg bg-green-50 border border-green-200 px-4 py-2.5 text-sm text-green-700 {{ session('plain_token') ? 'mt-2' : '' }}">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    @endif

    {{-- Main content --}}
    <main class="mx-auto max-w-6xl px-6 py-8">
        @yield('content')
    </main>

</body>
</html>
