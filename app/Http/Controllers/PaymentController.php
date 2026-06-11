<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Rate;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = auth()->user();
        $client = $user->client;

        return view('payments.index', [
            'payments' => Payment::with(['client', 'agent'])
                ->when($user->isClient(), fn ($query) => $client
                    ? $query->whereBelongsTo($client, 'client')
                    : $query->whereRaw('1 = 0'))
                ->latest('paid_at')
                ->paginate(50),
            'paymentsCount' => Payment::count(),
            'cashCount' => Payment::where('payment_method', 'cash')->count(),
            'momoCount' => Payment::where('payment_method', 'mobile_money')->count(),
            'bankCount' => Payment::where('payment_method', 'bank_transfer')->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('payments.create', [
            'clients' => Client::where('status', 'active')->orderBy('name')->get(),
            'methods' => [
                'cash' => 'Espèces',
                'mobile_money' => 'Mobile money',
                'bank_transfer' => 'Virement',
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request): RedirectResponse
    {
        Payment::create([
            ...$request->validated(),
            'agent_id' => $request->user()->id,
            'paid_at' => $request->date('paid_at') ?? now(),
        ]);

        return redirect()->route('payments.index')->with('status', 'Paiement enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment): View
    {
        $this->authorizePaymentAccess($payment);
        $rate = Rate::first()->value ?? 2250; // 1 USD = X CDF

        $invoicePayments = Payment::with('agent')
                ->where('invoice_number', $payment->invoice_number)
                ->where('client_id', $payment->client_id)
                ->oldest('paid_at')
                ->get();

        $invoiceTotals = Payment::query()
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

        //dd($invoiceTotals);

        return view('payments.show', [
            'payment' => $payment->load(['client', 'agent']),
            'invoicePayments' => $invoicePayments,
            'invoiceTotals' => $invoiceTotals->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment): RedirectResponse
    {
        return redirect()->route('payments.show', $payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePaymentRequest $request, Payment $payment): RedirectResponse
    {
        $payment->update($request->validated());

        return redirect()->route('payments.show', $payment)->with('status', 'Paiement modifié.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('status', 'Paiement supprimé.');
    }

    private function authorizePaymentAccess(Payment $payment): void
    {
        $user = auth()->user();

        abort_if($user->isClient() && $payment->client_id !== $user->client?->id, 403);
    }

    public function printInvoice(Payment $payment)
    {
        $acquitNumber = sprintf('%04d/16', $payment->id);

        $paNumber = sprintf(
            '66-803-%04d',
            $payment->client_id
        );

        return view('receipts.print', compact(
            'payment',
            'acquitNumber',
            'paNumber'
        ));
    }

    public function printInvoicePdf(Payment $payment)
    {
        $client = $payment->client;
        $acquitNumber = sprintf('%04d/16', $payment->id);
        $rate = Rate::first()->value ?? 2250; // 1 USD = X CDF

        $paNumber = sprintf(
            '66-803-%04d',
            $payment->client_id
        );

        $invoicePayments = Payment::with('agent')
                ->where('invoice_number', $payment->invoice_number)
                ->where('client_id', $payment->client_id)
                ->oldest('paid_at')
                ->get();

        $invoiceTotals = Payment::query()
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
            ->values()->first();

        \Carbon\Carbon::setLocale('fr');

        return view('receipts.invoice', compact(
            'payment',
            'client',
            'acquitNumber',
            'paNumber',
            'invoicePayments',
            'invoiceTotals',
            'rate'
        ));
    }

    public function exportPdf(Payment $payment)
    {
        $client = $payment->client;

        $pdf = Pdf::loadView('receipts.invoice', [
            'payment' => $payment,
            'client' => $client,
            'invoiceNumber' => $payment->invoice_number,
            'paNumber' => sprintf('66-803-%04d', $client->id),
        ]);

        return $pdf->download(
            'Facture-'.$payment->invoice_number.'.pdf'
        );
    }
}
