<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $communes = [
            'Bandalungwa',
            'Barumbu',
            'Bumbu',
            'Gombe',
            'Kalamu',
            'Kasa-Vubu',
            'Kimbanseke',
            'Kinshasa',
            'Kintambo',
            'Kisenso',
            'Lemba',
            'Limete',
            'Lingwala',
            'Makala',
            'Maluku',
            'Masina',
            'Matete',
            'Mont-Ngafula',
            'Ndjili',
            'Ngaba',
            'Ngaliema',
            'Ngiri-Ngiri',
            'Nsele',
            'Selembao',
        ];
        return view('users.profile', [
            'user' => auth()->user(),
            'roles' => User::roles(),
            'communes' => $communes
        ]);
    }

    /**
     * Update the specified resource in storage.
    */
   public function update(Request $request, User $user): RedirectResponse
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($user->id),
                ],
                'password' => ['nullable', 'string', 'min:8'],
                'role' => ['nullable', Rule::in(User::roles())],
                'phone' => ['nullable', 'string', 'max:50'],
                'status' => ['nullable', Rule::in(['active', 'inactive'])],
            ]);

            if (blank($data['password'] ?? null)) {
                unset($data['password']);
            }

            if (!isset($data['role'])) {
                unset($data['role']);
            }

            if (!isset($data['status'])) {
                unset($data['status']);
            }

            $user->update($data);

            return redirect()
                ->back()
                ->with('status', 'Profil modifié avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la modification du profil.');
        }
    }

}
