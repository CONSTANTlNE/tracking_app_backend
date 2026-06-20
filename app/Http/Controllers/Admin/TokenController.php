<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function store(Request $request, User $user)
    {
        $request->validate([
            'token_name' => ['required', 'string', 'max:255'],
        ]);

        $token = $user->createToken($request->token_name);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('plain_token', $token->plainTextToken)
            ->with('success', 'Token generated. Copy it now — it will not be shown again.');
    }

    public function destroy(User $user, int $tokenId)
    {
        $user->tokens()->where('id', $tokenId)->delete();

        return redirect()->route('admin.users.show', $user)->with('success', 'Token revoked.');
    }
}
