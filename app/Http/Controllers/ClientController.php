<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Rate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request): View
    {
        $lastClient = Client::latest('id')->first();

        if (!$lastClient) {
            $reference = 'CLI000001';
        } else {
            $lastNumber = (int) substr($lastClient->reference, 3);
            $reference = 'CLI' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        }

        $clients = Client::withCount('payments')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('reference', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('clients.index', [
            'clients' => $clients,
            'reference' => $reference
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request): RedirectResponse
    {
        try {

            Client::create($request->validated());
            return redirect()->route('clients.index')->with('status', 'Client enregistré avec succès.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la création du client.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client): View
    {
        $client = $client->load(['payments.agent', 'user']);

        $rate = Rate::first()->value ?? 2250; // 1 USD = X CDF

        $invoiceTotals = Payment::query()
            ->where('client_id', $client->id)
            ->get()
            ->groupBy('invoice_number')
            ->map(function ($payments) use ($rate) {

                $totalUsd = 0;

                foreach ($payments as $payment) {
                    if ($payment->currency === 'USD') {
                        $totalUsd += $payment->amount;
                    } elseif ($payment->currency === 'CDF') {
                        $totalUsd += $payment->amount / $rate;
                    }
                }

                return (object) [
                    'invoice_number'   => $payments->first()->invoice_number,
                    'payments_count'   => $payments->count(),
                    'last_payment_at'  => $payments->max('paid_at'),
                    'total_usd'        => round($totalUsd, 2),
                    'total_cdf'        => round($totalUsd * $rate, 2),
                ];
            })
            ->values();

        //dd($invoiceTotals->first());
        return view('clients.show', [
            'client' => $client,
            'invoicePayments' => $client->payments()->with('agent')->latest()->get(),
            'invoiceTotals' => $invoiceTotals->first()
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        try {

            $client->update($request->validated());
            return redirect()->route('clients.index')->with('status', 'Client modifié avec succès.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la modification du client.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('clients.index')->with('status', 'Client supprimé.');
    }
}
