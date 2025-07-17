<?php

namespace App\Http\Controllers;

use App\Models\KreatorProfile;
use App\Models\PerusahaanProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        if ($user->account_type == 'kreator') {
            // Jika profil belum ada, buat yang baru (kosong)
            $profile = $user->kreatorProfile()->firstOrCreate([]);
            return view('profile.edit-kreator', compact('user', 'profile'));

        } elseif ($user->account_type == 'perusahaan') {
            // Jika profil belum ada, buat yang baru (kosong)
            $profile = $user->perusahaanProfile()->firstOrCreate([]);
            return view('profile.edit-perusahaan', compact('user', 'profile'));
        }

        // Fallback jika ada peran lain
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
     public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi data dasar pengguna
        $validatedUserData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Jika Anda punya field email di form, aktifkan validasi ini
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->fill($validatedUserData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Logika update spesifik berdasarkan peran
        if ($user->account_type == 'kreator') {
            $this->updateKreatorProfile($request, $user);
        } elseif ($user->account_type == 'perusahaan') {
            $this->updatePerusahaanProfile($request, $user);
        }

        $user->save();

        return Redirect::route('profile.show', $user)->with('status', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the kreator's profile.
     */
    protected function updateKreatorProfile(Request $request, $user)
    {
        // Validasi SEMUA data yang dikirim dari form kreator
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'photo' => 'nullable|image|max:10240',
            'banner' => 'nullable|image|max:10240',
            'skills' => 'nullable|string',
            'social_linkedin' => 'nullable|url',
            'social_dribbble' => 'nullable|url',
            'experience' => 'nullable|array',
            'experience.*.title' => 'required_with:experience.*.company|nullable|string|max:255',
            'experience.*.company' => 'required_with:experience.*.title|nullable|string|max:255',
            'experience.*.start' => 'nullable|date',
            'experience.*.end' => 'nullable|date|after_or_equal:experience.*.start',
            'education' => 'nullable|array',
            'education.*.school' => 'required_with:education.*.degree|nullable|string|max:255',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.year' => 'nullable|integer|min:1980',
        ]);

        $profile = $user->kreatorProfile;

        // Handle file uploads
        if ($request->hasFile('photo')) {
            if ($profile->photo) Storage::disk('public')->delete($profile->photo);
            $validatedData['photo'] = $request->file('photo')->store('profiles/photos', 'public');
        }
        if ($request->hasFile('banner')) {
            if ($profile->banner) Storage::disk('public')->delete($profile->banner);
            $validatedData['banner'] = $request->file('banner')->store('profiles/banners', 'public');
        }

        // Format data sebelum disimpan
        $validatedData['skills'] = $request->skills ? array_map('trim', explode(',', $request->skills)) : [];
        $validatedData['social_links'] = [
            'linkedin' => $request->social_linkedin,
            'dribbble' => $request->social_dribbble,
        ];

        // Hapus data yang tidak perlu disimpan langsung
        unset($validatedData['social_linkedin'], $validatedData['social_dribbble']);

        // Ambil data pengalaman dan pendidikan dari request
        $experience = $request->input('experience', []);
        $education = $request->input('education', []);

        // Simpan data sebagai array ke profil pengguna
         $request->user()->kreatorProfile()->update([
        'title' => $profile['title'],
        'about' => $profile['about'],
        // ... field lainnya ...
        'experience' => $experience, // Langsung simpan array-nya
        'education' => $education,   // Langsung simpan array-nya
    ]);

        $profile->update($validatedData);
    }

    /**
     * Update the perusahaan's profile.
     */
    protected function updatePerusahaanProfile(Request $request, $user)
    {
        $validated = $request->validate([
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'location' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:10240',
            'banner' => 'nullable|image|max:10240',
        ]);

        $profile = $user->perusahaanProfile;

        if ($request->hasFile('logo')) {
            if ($profile->logo) Storage::disk('public')->delete($profile->logo);
            $validated['logo'] = $request->file('logo')->store('profiles/logos', 'public');
        }
        if ($request->hasFile('banner')) {
            if ($profile->banner) Storage::disk('public')->delete($profile->banner);
            $validated['banner'] = $request->file('banner')->store('profiles/banners', 'public');
        }

        $profile->update($validated);
    }

    /**
     * Display the user's settings page.
     */
    public function settings(Request $request): View
    {
        return view('profile.settings', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // ... (method destroy tetap sama)
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
