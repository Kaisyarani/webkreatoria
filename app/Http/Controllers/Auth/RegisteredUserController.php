<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): \Illuminate\View\View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ================== PERBAIKAN VALIDASI DI SINI ==================
        $request->validate([
            'accountType' => ['required', 'string', Rule::in(['user', 'company'])],

            // Aturan untuk 'username': Wajib jika 'accountType' adalah 'user', jika tidak boleh kosong.
            'username' => ['required_if:accountType,user', 'nullable', 'string', 'max:255'],

            // Aturan untuk 'companyName': Wajib jika 'accountType' adalah 'company', jika tidak boleh kosong.
            'companyName' => ['required_if:accountType,company', 'nullable', 'string', 'max:255'],

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        // ===============================================================

        $account_type = ($request->accountType === 'company') ? 'perusahaan' : 'kreator';
        $name = ($request->accountType === 'company') ? $request->companyName : $request->username;

        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_type' => $account_type,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Logika pengalihan tetap sama
        if (Auth::user()->account_type == 'perusahaan') {
            return redirect()->route('perusahaan.dashboard');
        }

        return redirect()->route('kreator.dashboard');
    }
}
