@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-zinc-900">Dashboard</h2>
        <p class="mt-1 text-sm text-zinc-500">Overview of your application.</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
        <div class="bg-white rounded-xl border border-zinc-200 px-6 py-5">
            <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Total Users</p>
            <p class="mt-2 text-3xl font-semibold text-zinc-900">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white rounded-xl border border-zinc-200 px-6 py-5">
            <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Active Tokens</p>
            <p class="mt-2 text-3xl font-semibold text-zinc-900">{{ $totalTokens }}</p>
        </div>
    </div>

    {{-- Recent users --}}
    <div class="bg-white rounded-xl border border-zinc-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200">
            <h3 class="text-sm font-semibold text-zinc-900">Recent Users</h3>
            <a href="{{ route('admin.users.index') }}" class="text-xs text-zinc-500 hover:text-zinc-900 transition">View all →</a>
        </div>
        @if ($recentUsers->isEmpty())
            <div class="px-6 py-10 text-center text-sm text-zinc-400">No users yet.</div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Mobile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach ($recentUsers as $user)
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="px-6 py-3.5">
                                <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-zinc-900 hover:underline">{{ $user->name }}</a>
                            </td>
                            <td class="px-6 py-3.5 text-zinc-500">{{ $user->email }}</td>
                            <td class="px-6 py-3.5 text-zinc-500">{{ $user->mobile ?? '—' }}</td>
                            <td class="px-6 py-3.5 text-zinc-400 text-xs">{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
