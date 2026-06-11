<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();
        $client = $user->client;
        $rate = Rate::first()->value ?? 22500; // 1 USD = 2250 CDF

        if ($user->isAgent()) {

            // Paiements effectués par cet agent
            $payments = Payment::where('agent_id', $user->id);

            $dailyPaiements = Payment::query()
                ->where('agent_id', $user->id)
                ->whereDate('paid_at', today())
                ->get();

            $totalUsd = 0;

            foreach ($dailyPaiements as $dailyPaiement) {
                if ($dailyPaiement->currency === 'USD') {
                    $totalUsd += $dailyPaiement->amount;
                }

                if ($dailyPaiement->currency === 'CDF') {
                    $totalUsd += $dailyPaiement->amount / $rate;
                }
            }

            $totalCdf = $totalUsd * $rate;

            $dailyBalances = [
                'USD' => $totalUsd,
                'CDF' => $totalCdf
            ];

            $payments = Payment::query()
                ->with(['client'])
                ->where('agent_id', $user->id)
                ->when(
                    $user->isClient(),
                    fn($query) => $client
                        ? $query->whereBelongsTo($client, 'client')
                        : $query->whereRaw('1 = 0')
                )
                ->latest('paid_at')
                ->limit(8)
                ->get();


            $data = [
                'cashPaymentsCount' => (clone $payments)
                    ->where('payment_method', 'cash')
                    ->count(),

                'mobilePaymentsCount' => (clone $payments)
                    ->where('payment_method', 'mobile_money')
                    ->count(),

                'transferPaymentsCount' => (clone $payments)
                    ->where('payment_method', 'bank_transfer')
                    ->count(),

                'totalPaymentsCount' => (clone $payments)->count(),

                'dailyBalances' => $dailyBalances,
                'invoiceTotals' => Payment::query()
                    ->where('agent_id', $user->id)
                    ->select(
                        'invoice_number',
                        'currency',
                        DB::raw('SUM(amount) as total_amount'),
                        DB::raw('COUNT(*) as payments_count'),
                        DB::raw('MAX(paid_at) as last_payment_at')
                    )
                    ->groupBy('invoice_number', 'currency')
                    ->orderByDesc('last_payment_at')
                    ->limit(5)
                    ->get(),
                'payments' => $payments,
            ];
        } else {

            $dailyPaiements = Payment::query()
                //->whereDate('paid_at', today())
                ->get();

            $totalUsd = 0;

            foreach ($dailyPaiements as $dailyPaiement) {
                if ($dailyPaiement->currency === 'USD') {
                    $totalUsd += $dailyPaiement->amount;
                }


                if ($dailyPaiement->currency === 'CDF') {
                    $totalUsd += $dailyPaiement->amount / $rate;
                    //dd($dailyPaiement->amount / $rate);
                }
            }

            $totalCdf = $totalUsd * $rate;

            $dailyBalances = [
                'USD' => $totalUsd,
                'CDF' => $totalCdf
            ];

            $payments = Payment::query()
                ->with(['client', 'agent'])
                ->when(
                    $user->isClient(),
                    fn($query) => $client
                        ? $query->whereBelongsTo($client, 'client')
                        : $query->whereRaw('1 = 0')
                )
                ->latest('paid_at')
                ->limit(8)
                ->get();

            $data = [
                'clientsCount' => Client::count(),
                'agentsCount' => User::where('role', User::RoleAgent)->count(),
                'paymentsCount' => Payment::count(),
                'dailyBalances' => $dailyBalances,
                'payments' => $payments,

                'invoiceTotals' => Payment::query()
                    ->select(
                        'invoice_number',
                        'currency',
                        DB::raw('SUM(amount) as total_amount'),
                        DB::raw('COUNT(*) as payments_count'),
                        DB::raw('MAX(paid_at) as last_payment_at')
                    )
                    ->groupBy('invoice_number', 'currency')
                    ->orderByDesc('last_payment_at')
                    ->limit(5)
                    ->get(),
                'payments' => $payments,
            ];
        }

        return view('index', $data);
    }
}
