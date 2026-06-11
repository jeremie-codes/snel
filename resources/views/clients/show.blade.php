@extends('base')

@section('title', 'Détail client')

@section('body')
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4>informations du client</h4>
                    <div class="bg-light p-2">
                        <span class="badge bg-primary-subtle text-primary mb-2">{{ $client->reference }}</span>
                        <h4>{{ $client->name }}</h4>
                        <p class="text-muted mb-0">Téléphone: {{ $client->phone ?: 'N/A' }}</p>
                        <p class="text-muted mb-1">Adresse: {{ $client->address ?: 'N/A' }}</p>
                        <p class="mb-1">Status:<span class="mb-1 {{ $client->status == 'active' ? 'text-success': 'text-danger' }}"> {{ $client->status ?: 'Inactive' }}</span></p>
                    </div>

                    <a data-bs-toggle="modal" data-bs-target="#updateClientModal{{ $client->id }}" class="btn btn-dark mt-4">
                        <i class="ti ti-edit me-1"></i>Modifier
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body px-4">
                    <!-- Invoice Header -->
                    <div
                        class="d-flex align-items-center justify-content-between mb-3 border-dashed border-bottom border-dark pb-3">
                        <div class="auth-brand mb-0">
                            <a href="index.html" class="logo-dark">
                                <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                            </a>
                            <a href="index.html" class="logo-light">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                            </a>
                        </div>
                        <div class="text-end">
                            <h4 class="fw-bold text-dark m-0">Paiements du client</h4>
                        </div>
                    </div>

                    <!-- Product Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-nowrap text-center align-middle">
                            <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                <tr class="text-uppercase fs-xxs">
                                    <th colspan="5">Paiements liés à ce client</th>
                                </tr>
                                <tr class="text-uppercase fs-xxs bg-dark">
                                    <th class="text-white" style="width: 50px">#</th>
                                    <th class="text-white">Facture</th>
                                    <th class="text-white">Montant</th>
                                    <th class="text-white">Agent</th>
                                    <th class="text-white">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoicePayments as $invoicePayment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ number_format((float) $invoicePayment->amount, 2, ',', ' ') }}
                                            {{ $invoicePayment->currency }}</td>
                                        <td>{{ str_replace(['cash', 'mobile_money', 'bank_transfer'], ['Espèces', 'Mobile money', 'Virement'], $invoicePayment->payment_method) }}
                                        </td>
                                        <td>{{ $invoicePayment->agent->name }}</td>
                                        <td>{{ $invoicePayment->paid_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Aucun paiement pour ce
                                            client.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Table -->
                    <div class="d-flex justify-content-end">
                        <table class="table w-auto table-borderless text-end">
                            <tbody>
                                <tr class="border-top pt-2 fs-5 fw-bold">
                                    <td>Total</td>
                                    <td>{{ number_format((float) $invoiceTotals->total_cdf, 2, ',', ' ') }} CDF</td>
                                    <td>{{ number_format((float) $invoiceTotals->total_usd, 2, ',', ' ') }} USD</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- update Client Modal -->
    <div class="modal fade" id="updateClientModal{{ $client->id }}" tabindex="-1" aria-labelledby="updateClientModalLabel{{ $client->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateClientModalLabel{{ $client->id }}">Modifier {{ $client->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('clients.update', $client) }}">
                    <div class="modal-body">
                        @method('PUT')
                        @include('clients._form', ['client' => $client])
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-dark"><i class="ti ti-device-floppy me-1"></i>Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
