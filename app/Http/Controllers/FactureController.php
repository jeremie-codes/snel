<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class FactureController extends Controller
{
    /**
     * Liste des factures
     */

    public function index(Request $request): View
    {
        try {

            $factures = Facture::with(['client', 'user'])

                ->when($request->search, function ($query, $search) {

                    $query->where(function ($q) use ($search) {

                        $q->where('code', 'like', "%{$search}%")
                            ->orWhere('pa', 'like', "%{$search}%")
                            ->orWhereHas('client', function ($client) use ($search) {
                                $client->where('name', 'like', "%{$search}%")
                                    ->orWhere('reference', 'like', "%{$search}%");
                            });
                    });
                })

                ->latest()
                ->paginate(20)
                ->withQueryString();

            $clients = Client::where('status', 'active')
                ->orderBy('name')
                ->get();

            return view('factures.index', compact('factures', 'clients'));
        } catch (Exception $e) {

            abort(500, $e->getMessage());
        }
    }

    /**
     * Enregistrement
     */
    public function store(Request $request): RedirectResponse
    {
        try {

            $validated = $request->validate([
                'client_id'      => ['required', 'exists:clients,id'],
                'amount'         => ['required', 'numeric'],
                'precedent'      => ['nullable', 'numeric'],
                'actuel'         => ['nullable', 'numeric'],
                'kwh_calcule'    => ['nullable', 'numeric'],
                'rabais'         => ['nullable', 'numeric'],
                'kwh_facture'    => ['nullable', 'numeric'],
                'code_tarif'     => ['nullable', 'numeric'],
                'interpretation' => ['nullable', 'string'],
            ]);

            $validated['code'] = 'FACT-' . strtoupper(uniqid());
            $validated['user_id'] = auth()->user()->id;

            $facture = Facture::create($validated);

            $facture->update([
                'pa' => sprintf('66-803-%04d', $facture->id)
            ]);

            return redirect()
                ->route('factures.show', $facture)
                ->with('status', 'Facture génerée avec succès.');
        } catch (Exception $e) {

            //dd($e->getMessage());
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Détails
     */
    public function show(Facture $facture): View
    {
        try {

            $facture->load(['client', 'user']);
            \Carbon\Carbon::setLocale('fr');
            return view('factures.show', compact('facture'));
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }
    }


    /**
     * Suppression
     */
    public function destroy(Facture $facture): RedirectResponse
    {
        try {

            if (!auth()->user()->isAdmin()) {
                return redirect()
                    ->route('factures.index')
                    ->with('error', 'Vous devez avoir les droits d' . 'administrateur pour supprimer une facture.');
            }
            $facture->delete();

            return redirect()
                ->route('factures.index')
                ->with('status', 'Facture supprimée avec succès.');
        } catch (Exception $e) {

            return back()
                ->with('error', $e->getMessage());
        }
    }

    public function printInvoicePdf(Facture $facture)
    {
        $client = $facture->client;
        \Carbon\Carbon::setLocale('fr');

        return view('receipts.invoice', compact(
            'facture',
            'client',
        ));
    }
}
