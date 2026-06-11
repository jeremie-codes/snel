@extends('base')

@section('title', 'Paiements')
@section('subtitle', 'Historique des paiements')

@section('body')
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4">

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <span class="avatar-title bg-primary-subtle rounded-circle" style="width: 50px; height: 50px;">
                            <iconify-icon icon="solar:file-bold-duotone" class="fs-36"></iconify-icon>
                        </span>
                        <div>
                            <p class=" text-opacity-75 mb-1 text-uppercase">Total paiement</p>
                            <h4 class="fw-medium fs-16 mb-1 "><span>{{ $paymentsCount }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <span class="avatar-title bg-primary-subtle rounded-circle" style="width: 50px; height: 50px;">
                            <iconify-icon icon="solar:file-bold-duotone" class="fs-36"></iconify-icon>
                        </span>
                        <div>
                            <p class=" text-opacity-75 mb-1 text-uppercase">Paiement Espèce</p>
                            <h4 class="fw-medium fs-16 mb-1 "><span>{{ $cashCount }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <span class="avatar-title bg-primary-subtle rounded-circle" style="width: 50px; height: 50px;">
                            <iconify-icon icon="solar:file-bold-duotone" class="fs-36"></iconify-icon>
                        </span>
                        <div>
                            <p class=" text-opacity-75 mb-1 text-uppercase">Paiement Mobile</p>
                            <h4 class="fw-medium fs-16 mb-1 "><span>{{ $momoCount }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <span class="avatar-title bg-primary-subtle rounded-circle" style="width: 50px; height: 50px;">
                            <iconify-icon icon="solar:file-bold-duotone" class="fs-36"></iconify-icon>
                        </span>
                        <div>
                            <p class=" text-opacity-75 mb-1 text-uppercase">Paiement Virement</p>
                            <h4 class="fw-medium fs-16 mb-1 "><span>{{ $bankCount }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

    </div>

    <div class="row">
        <div class="col-12">
            <div data-table data-table-rows-per-page="8" class="card">
                <div class="card-header border-light justify-content-between">
                    <form method="GET" action="{{ route('payments.index') }}" class="d-flex gap-2">
                        <div class="app-search">
                            <input type="text" name="search" class="form-control"
                                placeholder="Rechercher numéro facture ..." value="{{ request('search') }}" />
                            <i class="ti ti-search app-search-icon text-muted"></i>
                        </div>

                        <div class="app-search">
                            <select name="payment_method" class="form-select form-control my-1 my-md-0">
                                <option value="">Tous</option>

                                <option value="cash" @selected(request('payment_method') === 'cash')>
                                    Espèce
                                </option>

                                <option value="mobile_money" @selected(request('payment_method') === 'mobile_money')>
                                    Mobile money
                                </option>

                                <option value="bank_transfer" @selected(request('payment_method') === 'bank_transfer')>
                                    Virement
                                </option>
                            </select>

                            <i class="ti ti-circle-check app-search-icon text-muted"></i>
                        </div>

                        <button type="submit" class="btn btn-dark rounded-circle btn-icon">
                            <i class="ti ti-search fs-lg"></i>
                        </button>

                        @if (request()->filled('search') || request()->filled('payment_method'))
                            <a href="{{ route('payments.index') }}" class="btn btn-danger rounded-circle btn-icon">
                                <i class="ti ti-x"></i>
                            </a>
                        @endif

                    </form>

                    <div class="d-flex align-items-center gap-2">
                        @if (auth()->user()->canManagePayments())
                            <a href="{{ route('payments.create') }}" class="btn btn-secondary">
                                <i class="ti ti-plus me-1"></i>Nouveau paiement
                            </a>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap table-custom table-centered table-hover mb-0">
                        <thead class="bg-dark align-middle thead-md">
                            <tr class="text-uppercase fs-xxs">
                                <th class="text-white">Facture</th>
                                <th class="text-white">Client</th>
                                <th class="text-white">Montant</th>
                                <th class="text-white">Moyen</th>
                                <th class="text-white">Agent</th>
                                <th class="text-white">Date</th>
                                <th class="text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <td>
                                        <i class="ti ti-invoice text-danger fs-lg"></i>
                                        <a href="{{ route('payments.show', $payment) }}"
                                            class="fw-semibold text-reset">{{ $payment->invoice_number }}</a>
                                    </td>
                                    <td>{{ $payment->client->name }}</td>
                                    <td class="text-success">{{ number_format((float) $payment->amount, 2, ',', ' ') }}
                                        {{ $payment->currency }}</td>
                                    <td>{{ str_replace(['cash', 'mobile_money', 'bank_transfer'], ['Espèces', 'Mobile money', 'Virement'], $payment->payment_method) }}
                                    </td>
                                    <td>{{ $payment->agent->name }}</td>
                                    <td>{{ $payment->paid_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <a href="{{ route('payments.show', $payment) }}"
                                                class="btn btn-default btn-icon btn-sm"><i class="ti ti-eye fs-lg"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Aucun paiement enregistré.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <!-- end table-body -->
                    </table>
                    <!-- end table -->
                </div>
                <div class="card-footer border-0">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection
