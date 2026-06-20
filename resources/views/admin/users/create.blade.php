@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-zinc-500 hover:text-zinc-900 transition">← Users</a>
        <h2 class="mt-3 text-xl font-semibold text-zinc-900">Add user</h2>
    </div>

    <div class="bg-white rounded-xl border border-zinc-200 p-8 max-w-lg">
        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3">
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-zinc-700 mb-1.5">Full name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    required
                    autofocus
                    value="{{ old('name') }}"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-xs focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                    placeholder="Jane Doe"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700 mb-1.5">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    value="{{ old('email') }}"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-xs focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                    placeholder="jane@example.com"
                >
            </div>

            <div>
                <label for="mobile" class="block text-sm font-medium text-zinc-700 mb-1.5">Mobile number</label>
                <input
                    id="mobile"
                    name="mobile"
                    type="text"
                    required
                    value="{{ old('mobile') }}"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-xs focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                    placeholder="+1234567890"
                >
                <p class="mt-1 text-xs text-zinc-400">Used to authenticate from the mobile app.</p>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-zinc-700 mb-1.5">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-xs focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                    placeholder="••••••••"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-zinc-700 mb-1.5">Confirm password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-xs focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                    placeholder="••••••••"
                >
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button
                    type="submit"
                    class="rounded-lg bg-zinc-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-zinc-700 transition focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2"
                >
                    Create user
                </button>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-zinc-500 hover:text-zinc-900 transition">Cancel</a>
            </div>
        </form>
    </div>
@endsection
