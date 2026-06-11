<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'value' => ['required', 'numeric'],
            ]);

           Rate::query()->updateOrCreate(
                [],
                [
                    'value' => $request->value,
                ]
            );

            return back()->withInput()->with('status', 'Taux de change mise à jour avec succès.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour du taux.');
        }
    }
}
