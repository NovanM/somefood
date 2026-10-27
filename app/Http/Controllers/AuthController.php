<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:25'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => 'customer',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang di SomeFood.');
    }

    /**
     * Google OAuth Login / Callback Simulation & Handler
     */
    public function redirectToGoogle(Request $request)
    {
        $email = $request->query('email', 'customer.google@somefood.com');
        $name = $request->query('name', 'Google Customer');
        $role = $request->query('role', 'customer');

        if (! in_array($role, ['admin', 'kitchen_staff', 'customer'])) {
            $role = 'customer';
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'role' => $role,
                'google_id' => 'google_' . Str::random(16),
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=ea580c&color=fff',
                'password' => Hash::make(Str::random(24)),
            ]
        );

        Auth::login($user, true);

        return $this->redirectByRole($user)->with('success', "Berhasil masuk menggunakan Google sebagai {$user->name} (" . strtoupper($user->role) . ").");
    }

    /**
     * API Login returning Sanctum / JWT Bearer Token
     */
    public function apiLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $token = $user->createToken('somefood-jwt-token', ['role:' . $user->role])->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Authenticated successfully.',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }

    protected function redirectByRole(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isKitchenStaff()) {
            return redirect()->route('kitchen.index');
        }

        return redirect()->route('home');
    }
}
