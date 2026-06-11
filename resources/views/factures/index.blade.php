@extends('base')

@section('title', 'Factures')
@section('subtitle', 'Liste des factures')

@section('body')

    <div class="row">
        <div class="col-12">
            <div data-table data-table-rows-per-page="8" class="card">
                <div class="card-header border-light justify-content-between">
                    <form method="GET" action="{{ route('factures.index') }}" class="d-flex gap-2">
                        <div class="app-search">
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Rechercher numéro facture ..."
                                value="{{ request('search') }}"
                            />
                            <i class="ti ti-search app-search-icon text-muted"></i>
                        </div>

                        <button type="submit" class="btn btn-dark rounded-circle btn-icon">
                            <i class="ti ti-search fs-lg"></i>
                        </button>

                        @if(request()->filled('search'))
                            <a href="{{ route('factures.index') }}"
                            class="btn btn-danger rounded-circle btn-icon">
                                <i class="ti ti-x"></i>
                            </a>
                        @endif

                    </form>

                    <div class="d-flex align-items-center gap-2">
                        @if (auth()->user()->canManagePayments())
                            <a data-bs-toggle="modal" data-bs-target="#generateInvoicerModal" class="btn btn-secondary">
                                <i class="ti ti-plus me-1"></i>Nouvelle facture
                            </a>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap table-custom table-centered table-hover mb-0">
                        <thead class="bg-dark align-middle thead-md">
                            <tr class="text-uppercase fs-xxs">
                                <th class="text-white">Numrero</th>
                                <th class="text-white">Client</th>
                                <th class="text-white">Montant</th>
                                <th class="text-white">Date</th>
                                <th class="text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($factures as $facture)
                                <tr>
                                    <td>
                                        <i class="ti ti-invoice text-danger fs-lg"></i>
                                        <a href="{{ route('factures.show', $facture) }}"
                                            class="fw-semibold text-reset">{{ $facture->code }}</a>
                                    </td>
                                    <td>{{ $facture->client->name }}</td>
                                    <td class="text-success">{{ number_format((float) $facture->amount, 2, ',', ' ') }}
                                        {{ $facture->currency }}</td>
                                    </td>
                                    <td>{{ $facture->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <a href="{{ route('factures.show', $facture) }}"
                                                class="btn btn-default btn-icon btn-sm"><i class="ti ti-eye fs-lg"></i>
                                            </a>
                                            <form method="POST" action="{{ route('factures.destroy', $facture) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-icon btn-sm" onclick="return confirm('Supprimer cete facture ?')"><i class="ti ti-trash fs-lg"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Aucun facture générée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <!-- end table-body -->
                    </table>
                    <!-- end table -->
                </div>
                <div class="card-footer border-0">
                    {{ $factures->links() }}
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

      <!-- Add User Modal -->
    <div class="modal fade" id="generateInvoicerModal" tabindex="-1" aria-labelledby="generateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateModalLabel">
                        <h4 class="fw-bold text-dark m-0">
                            GENERER UNE NOUVELLE FACTURE
                        </h4>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('factures.store') }}">
                    @csrf
                    <div class="modal-body">
                        @include('factures._form', ['clients' => $clients])
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-dark"><i class="ti ti-device-floppy me-1"></i>Générer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
