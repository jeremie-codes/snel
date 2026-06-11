@extends('base')

@section('title', 'Tableau de bord')
@section('subtitle', 'Accueil')

@section('body')

    @php
        $defaultCurrency = array_key_first($dailyBalances) ?? 'USD';
        $defaultAmount = $dailyBalances[$defaultCurrency] ?? 0;
        $defaultOtherCurrency = array_key_first($dailyBalances) == 'USD' ? 'CDF' : 'USD';
    @endphp

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4">

        <div class="col">
            <div class="card border-0 rounded-3">
                <div class="card-header border-0 justify-content-between">
                    <h4 class="card-title pt-0 mt-0">
                        Balance Journalière
                    </h4>
                    <div class="dropdown ms-auto">
                        <a href="#" class="btn btn-sm btn-default btn-icon px-4 fw-bold" data-bs-toggle="dropdown">
                            <span id="selected-currency">
                                {{ $defaultCurrency }}
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach($dailyBalances as $currency => $amount)
                                <li>
                                    <a
                                        class="dropdown-item balance-currency"
                                        href="#"
                                        data-currency="{{ $currency }}"
                                        data-amount="{{ $amount }}"
                                    >
                                        {{ $currency }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <h2 class="fw-bold fs-4" id="user-balance-data">
                        <span id="user-balance-currency">
                            {{ $defaultCurrency }}
                        </span>
                        <span id="user-balance-number">
                            {{ number_format($defaultAmount, 2, ',', ' ') }}
                        </span>
                    </h2>
                    <div class="row g-2 mt-3">
                        <div class="col">
                            @if (auth()->user()->canManagePayments())
                            <a href="{{ route('payments.create') }}" class="btn btn-secondary bg-gradient w-100"><i class="ti ti-coin me-1"></i>
                                Nouveau
                            </a>
                            @endif
                        </div>
                        <div class="col">
                            <a href="{{ route('payments.index') }}" class="btn btn-info bg-gradient w-100"><i class="ti ti-coin me-1"></i>
                                Historique
                            </a>
                        </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
        </div>
        <!-- end col -->

        @if(auth()->user()->isAdmin())
            <div class="col">
                <div class="card border-0 rounded-3 text-white"
                    style="background-image: url({{ asset('assets/images/stock/small-1.jpg') }}); background-size: cover">
                    <div class="card-body bg-gradient bg-primary bg-opacity-90 rounded-3">
                        <iconify-icon icon="solar:user-bold-duotone" class="fs-36"></iconify-icon>
                        <p class="text-white text-opacity-75 mb-1 text-uppercase">Clients</p>
                        <h3 class="fw-semibold mb-2 fs-20 text-white">Enregistrés</h3>
                        <h4 class="fw-medium fs-16 mb-1 text-white"><span>{{ $clientsCount }}</span></h4>
                    </div>
                </div>
            </div>
            <!-- end col -->

            <div class="col">
                <div class="card border-0 rounded-3 text-white"
                    style="background-image: url({{ asset('assets/images/stock/small-2.jpg') }}); background-size: cover">
                    <div class="card-body bg-gradient bg-secondary bg-opacity-90 rounded-3">
                        <iconify-icon icon="solar:user-bold-duotone" class="fs-36"></iconify-icon>
                        <p class="text-white text-opacity-75 mb-1 text-uppercase">Agents</p>
                        <h3 class="fw-semibold mb-2 fs-20 text-white">Caisse</h3>
                        <h4 class="fw-medium fs-16 mb-1 text-white"><span>{{ $agentsCount }}</span></h4>
                    </div>
                </div>
            </div>
            <!-- end col -->

            <div class="col">
                <div class="card border-0 rounded-3 text-white"
                    style="background-image: url({{ asset('assets/images/stock/small-4.jpg') }}); background-size: cover">
                    <div class="card-body bg-gradient bg-danger bg-opacity-90 rounded-3">
                        <iconify-icon icon="solar:file-bold-duotone" class="fs-36"></iconify-icon>
                        <p class="text-white text-opacity-75 mb-1 text-uppercase">Factures</p>
                        <h3 class="fw-semibold mb-2 fs-20 text-white">Paiement</h3>
                        <h4 class="fw-medium fs-16 mb-1 text-white"><span>{{ $paymentsCount }}</span></h4>
                    </div>
                </div>
            </div>
            <!-- end col -->
        @else
            <div class="col">
                <div class="card border-0 rounded-3 text-white"
                    style="background-image: url({{ asset('assets/images/stock/small-1.jpg') }}); background-size: cover">
                    <div class="card-body bg-gradient bg-primary bg-opacity-90 rounded-3">
                        <iconify-icon icon="solar:user-bold-duotone" class="fs-36"></iconify-icon>
                        <p class="text-white text-opacity-75 mb-1 text-uppercase">Paiement</p>
                        <h3 class="fw-semibold mb-2 fs-20 text-white">Espèce</h3>
                        <h4 class="fw-medium fs-16 mb-1 text-white"><span>{{ $cashPaymentsCount }}</span></h4>
                    </div>
                </div>
            </div>
            <!-- end col -->

            <div class="col">
                <div class="card border-0 rounded-3 text-white"
                    style="background-image: url({{ asset('assets/images/stock/small-2.jpg') }}); background-size: cover">
                    <div class="card-body bg-gradient bg-secondary bg-opacity-90 rounded-3">
                        <iconify-icon icon="solar:user-bold-duotone" class="fs-36"></iconify-icon>
                        <p class="text-white text-opacity-75 mb-1 text-uppercase">Paiement</p>
                        <h3 class="fw-semibold mb-2 fs-20 text-white">Mobile</h3>
                        <h4 class="fw-medium fs-16 mb-1 text-white"><span>{{ $mobilePaymentsCount }}</span></h4>
                    </div>
                </div>
            </div>
            <!-- end col -->

            <div class="col">
                <div class="card border-0 rounded-3 text-white"
                    style="background-image: url({{ asset('assets/images/stock/small-4.jpg') }}); background-size: cover">
                    <div class="card-body bg-gradient bg-danger bg-opacity-90 rounded-3">
                        <iconify-icon icon="solar:file-bold-duotone" class="fs-36"></iconify-icon>
                        <p class="text-white text-opacity-75 mb-1 text-uppercase">Paiement</p>
                        <h3 class="fw-semibold mb-2 fs-20 text-white">Virement</h3>
                        <h4 class="fw-medium fs-16 mb-1 text-white"><span>{{ $transferPaymentsCount }}</span></h4>
                    </div>
                </div>
            </div>
            <!-- end col -->
        @endif
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card border">
                <div class="card-header border-secondary justify-content-between">
                    <h4 class="card-title">Paiements récents</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-custom table-bordered table-nowrap table-centered table-hover mb-0">
                        <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                            <tr class="text-uppercase fs-xxs bg-dark">
                                <th class="text-white">Facture</th>
                                <th class="text-white">Client</th>
                                <th class="text-white">Montant</th>
                                <th class="text-white">Methode de paiement</th>
                                <th class="text-white">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                             @forelse ($payments as $payment)
                                <tr>
                                    <td>
                                        <i class="ti ti-invoice text-danger fs-lg"></i>
                                        <a href="{{ route('payments.show', $payment) }}" class="fw-semibold text-reset">{{ $payment->invoice_number }}</a>
                                    </td>
                                    <td>{{ $payment->client->name }}</td>
                                    <td class="text-success">{{ number_format((float) $payment->amount, 2, ',', ' ') }} {{ $payment->currency }}</td>
                                    <td>{{ str_replace(['cash', 'mobile_money', 'bank_transfer'], ['Espèces', 'Mobile money', 'Virement'], $payment->payment_method) }}</td>
                                    <td>{{ $payment->paid_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Aucun paiement enregistré.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border">
                <div class="card-header border-secondary">
                    <h4 class="card-title">Factures encaissées</h4>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($invoiceTotals as $invoice)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">{{ $invoice->invoice_number }}</h5>
                                    <p class="mb-0 text-muted">{{ $invoice->payments_count }} paiement(s)</p>
                                </div>
                                <strong>{{ number_format((float) $invoice->total_amount, 2, ',', ' ') }}
                                    {{ $invoice->currency }}</strong>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-muted">Aucune facture payée.</div>
                    @endforelse

                    @if ($invoiceTotals->count() > 0)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('payments.index') }}">
                                    Voir les paiements
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.balance-currency').forEach(item => {

                item.addEventListener('click', function (e) {
                    e.preventDefault();

                    const currency = this.dataset.currency;
                    const amount = parseFloat(this.dataset.amount);

                    document.getElementById('selected-currency').textContent = currency;
                    document.getElementById('user-balance-currency').textContent = currency;

                    document.getElementById('user-balance-number').textContent =
                        amount.toLocaleString('fr-FR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                });

            });

        });
    </script>
@endsection
