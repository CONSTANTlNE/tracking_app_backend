@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-xl font-semibold text-zinc-900">Users</h2>
            <p class="mt-1 text-sm text-zinc-500">{{ $users->total() }} {{ Str::plural('user', $users->total()) }}</p>
        </div>
        <a
            href="{{ route('admin.users.create') }}"
            class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 transition"
        >+ Add user</a>
    </div>

    <div class="bg-white rounded-xl border border-zinc-200">
        @if ($users->isEmpty())
            <div class="px-6 py-16 text-center text-sm text-zinc-400">No users yet. <a href="{{ route('admin.users.create') }}" class="text-zinc-900 underline">Add the first one.</a></div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Mobile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Tokens</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="px-6 py-3.5">
                                <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-zinc-900 hover:underline">{{ $user->name }}</a>
                            </td>
                            <td class="px-6 py-3.5 text-zinc-500">{{ $user->email }}</td>
                            <td class="px-6 py-3.5 text-zinc-500">{{ $user->mobile ?? '—' }}</td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-700">
                                    {{ $user->tokens_count }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-zinc-400 text-xs">{{ $user->created_at->format('M j, Y') }}</td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-xs text-zinc-500 hover:text-zinc-900 transition">Manage →</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-zinc-100">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
