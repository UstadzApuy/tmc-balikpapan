<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string'],
        ]);

        // For username-based password reset, we need to find the user by username
        // and then use their email for the reset process if they have one
        $user = \App\Models\User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'User not found.']);
        }

        // Since we don't have email, we'll return an error
        return back()->withErrors(['username' => 'Password reset not available.']);
    }
}
