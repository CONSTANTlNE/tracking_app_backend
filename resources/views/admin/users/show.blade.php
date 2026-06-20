@extends('layouts.admin')

@section('title', $user->name)

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-zinc-500 hover:text-zinc-900 transition">← Users</a>
        <div class="mt-3 flex items-start justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900">{{ $user->name }}</h2>
                <p class="mt-0.5 text-sm text-zinc-500">{{ $user->email }}</p>
            </div>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition">Delete user</button>
            </form>
        </div>
    </div>

    {{-- User info --}}
    <div class="bg-white rounded-xl border border-zinc-200 mb-6">
        <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-zinc-900">User details</h3>
            <div class="flex items-center gap-3">
                <button onclick="document.getElementById('modal-credentials').showModal()" class="text-xs text-zinc-500 hover:text-zinc-900 transition">Edit credentials</button>
                <button onclick="document.getElementById('modal-password').showModal()" class="text-xs text-zinc-500 hover:text-zinc-900 transition">Change password</button>
            </div>
        </div>
        <dl class="divide-y divide-zinc-100">
            <div class="px-6 py-3.5 flex gap-4">
                <dt class="w-32 text-xs font-medium text-zinc-500 uppercase tracking-wider pt-0.5">Name</dt>
                <dd class="text-sm text-zinc-900">{{ $user->name }}</dd>
            </div>
            <div class="px-6 py-3.5 flex gap-4">
                <dt class="w-32 text-xs font-medium text-zinc-500 uppercase tracking-wider pt-0.5">Email</dt>
                <dd class="text-sm text-zinc-900">{{ $user->email }}</dd>
            </div>
            <div class="px-6 py-3.5 flex gap-4">
                <dt class="w-32 text-xs font-medium text-zinc-500 uppercase tracking-wider pt-0.5">Mobile</dt>
                <dd class="text-sm text-zinc-900">{{ $user->mobile ?? '—' }}</dd>
            </div>
            <div class="px-6 py-3.5 flex gap-4">
                <dt class="w-32 text-xs font-medium text-zinc-500 uppercase tracking-wider pt-0.5">Joined</dt>
                <dd class="text-sm text-zinc-500">{{ $user->created_at->format('M j, Y') }}</dd>
            </div>
        </dl>
    </div>

    {{-- API Tokens --}}
    <div class="bg-white rounded-xl border border-zinc-200">
        <div class="px-6 py-4 border-b border-zinc-200 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-zinc-900">API Tokens</h3>
            <span class="text-xs text-zinc-400">{{ $user->tokens->count() }} {{ Str::plural('token', $user->tokens->count()) }}</span>
        </div>

        {{-- Generate token form --}}
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50">
            <form method="POST" action="{{ route('admin.users.tokens.store', $user) }}" class="flex items-center gap-3">
                @csrf
                <input
                    name="token_name"
                    type="text"
                    required
                    placeholder="Token name (e.g. iPhone 15)"
                    class="flex-1 rounded-lg border border-zinc-300 bg-white px-3.5 py-2 text-sm text-zinc-900 placeholder-zinc-400 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                >
                <button
                    type="submit"
                    class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 transition whitespace-nowrap"
                >Generate token</button>
            </form>
        </div>

        {{-- Token list --}}
        @if ($user->tokens->isEmpty())
            <div class="px-6 py-10 text-center text-sm text-zinc-400">No tokens yet.</div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Last used</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach ($user->tokens as $token)
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="px-6 py-3.5 font-medium text-zinc-900">{{ $token->name }}</td>
                            <td class="px-6 py-3.5 text-zinc-500 text-xs">
                                {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'Never' }}
                            </td>
                            <td class="px-6 py-3.5 text-zinc-400 text-xs">{{ $token->created_at->format('M j, Y') }}</td>
                            <td class="px-6 py-3.5 text-right">
                                <form method="POST" action="{{ route('admin.users.tokens.destroy', [$user, $token->id]) }}" onsubmit="return confirm('Revoke this token?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition">Revoke</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Modal: Edit credentials --}}
    <dialog id="modal-credentials" class="rounded-xl border border-zinc-200 shadow-xl p-0 w-96 m-auto backdrop:bg-zinc-900/40">
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100">
            <h3 class="text-sm font-semibold text-zinc-900">Edit credentials</h3>
            <button type="button" onclick="document.getElementById('modal-credentials').close()" class="text-zinc-400 hover:text-zinc-700 transition text-lg leading-none">&times;</button>
        </div>

        @if ($errors->has('name') || $errors->has('email') || $errors->has('mobile'))
            <div class="mx-6 mt-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3">
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach ($errors->only(['name', 'email', 'mobile']) as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="px-6 py-5 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit-name" class="block text-sm font-medium text-zinc-700 mb-1.5">Full name</label>
                <input
                    id="edit-name"
                    name="name"
                    type="text"
                    required
                    value="{{ old('name', $user->name) }}"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                >
            </div>

            <div>
                <label for="edit-email" class="block text-sm font-medium text-zinc-700 mb-1.5">Email</label>
                <input
                    id="edit-email"
                    name="email"
                    type="email"
                    required
                    value="{{ old('email', $user->email) }}"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                >
            </div>

            <div>
                <label for="edit-mobile" class="block text-sm font-medium text-zinc-700 mb-1.5">Mobile</label>
                <input
                    id="edit-mobile"
                    name="mobile"
                    type="text"
                    required
                    value="{{ old('mobile', $user->mobile) }}"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                >
            </div>

            <div class="flex items-center gap-3 pt-1">
                <button
                    type="submit"
                    class="rounded-lg bg-zinc-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-zinc-700 transition"
                >Save changes</button>
                <button type="button" onclick="document.getElementById('modal-credentials').close()" class="text-sm text-zinc-500 hover:text-zinc-900 transition">Cancel</button>
            </div>
        </form>
    </dialog>

    {{-- Modal: Change password --}}
    <dialog id="modal-password" class="rounded-xl border border-zinc-200 shadow-xl p-0 w-96 m-auto backdrop:bg-zinc-900/40">
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100">
            <h3 class="text-sm font-semibold text-zinc-900">Change password</h3>
            <button type="button" onclick="document.getElementById('modal-password').close()" class="text-zinc-400 hover:text-zinc-700 transition text-lg leading-none">&times;</button>
        </div>

        @if ($errors->has('password'))
            <div class="mx-6 mt-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3">
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach ($errors->get('password') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.password', $user) }}" class="px-6 py-5 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="new-password" class="block text-sm font-medium text-zinc-700 mb-1.5">New password</label>
                <input
                    id="new-password"
                    name="password"
                    type="password"
                    required
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                    placeholder="••••••••"
                >
            </div>

            <div>
                <label for="new-password-confirmation" class="block text-sm font-medium text-zinc-700 mb-1.5">Confirm password</label>
                <input
                    id="new-password-confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 focus:outline-none transition"
                    placeholder="••••••••"
                >
            </div>

            <div class="flex items-center gap-3 pt-1">
                <button
                    type="submit"
                    class="rounded-lg bg-zinc-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-zinc-700 transition"
                >Update password</button>
                <button type="button" onclick="document.getElementById('modal-password').close()" class="text-sm text-zinc-500 hover:text-zinc-900 transition">Cancel</button>
            </div>
        </form>
    </dialog>

    {{-- Re-open modal on validation error --}}
    @if ($errors->has('name') || $errors->has('email') || $errors->has('mobile'))
        <script>document.getElementById('modal-credentials').showModal();</script>
    @endif
    @if ($errors->has('password'))
        <script>document.getElementById('modal-password').showModal();</script>
    @endif
@endsection
