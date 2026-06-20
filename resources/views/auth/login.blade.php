<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 flex items-center justify-center">
    <div class="w-full max-w-sm px-6">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-semibold text-zinc-900 tracking-tight">{{ config('app.name') }}</h1>
            <p class="mt-1 text-sm text-zinc-500">Sign in to your account</p>
        </div>

        <div class="bg-white rounded-xl border border-zinc-200 p-8 shadow-xs">
            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-50 border border-red-200 px-4 py-3">
                    <ul class="text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-5 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700 mb-1.5">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        autofocus
                        value="{{ old('email') }}"
                        class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-xs focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                        placeholder="you@example.com"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-700 mb-1.5">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-xs focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-zinc-300 text-zinc-900 focus:ring-zinc-500">
                        <span class="text-sm text-zinc-600">Remember me</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-zinc-700 active:bg-zinc-800 transition focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2"
                >
                    Sign in
                </button>
            </form>
        </div>
    </div>
</body>
</html>
