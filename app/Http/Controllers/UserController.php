<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
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
        return view('users.index', [
            //'users' => User::where('role', '!=', User::RoleClient)->where('id', '!=', auth()->user()->id)->orderBy('name')->latest()->paginate(10),
            'users' => User::where('role', '!=', User::RoleClient)->orderBy('name')->latest()->paginate(10),
            'roles' => User::roles(),
            'communes' => $communes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            User::create($request->validated());
            return redirect()->route('users.index')->with('status', 'Profil créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', "Erreur lors de la création");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('status', 'Profil modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->is(auth()->user()), 422, 'Vous ne pouvez pas supprimer votre propre compte.');

        $user->delete();

        return redirect()->route('users.index')->with('status', 'Profil supprimé.');
    }
}
