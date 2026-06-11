@extends('base')

@section('title', 'Clients')

@section('body')
    <div class="row justify-content-center mb-4">
    <form class="d-flex gap-2">
            <div class="app-search">
                <input data-tablesearch type="text" class="form-control" placeholder="Nom ou code du client ..." />
                <i class="ti ti-search app-search-icon text-muted"></i>
            </div>
            <div class="app-search">
                <select data-table-filter="status" class="form-select form-control my-1 my-md-0">
                    <option value="All">Tous</option>
                    <option value="active">Actif</option>
                    <option value="inactive">Inactif</option>
                </select>
                <i class="ti ti-circle-check app-search-icon text-muted"></i>
            </div>

            <button class="btn btn-dark"> <i class="ti ti-filter fs-lg"></i> Filtrer</button>
        </form>
    </div>

    <div class="card">
        <div class="card-header border-light justify-content-between">
            <h4 class="card-title">Clients enregistrés</h4>
            <a  data-bs-toggle="modal" data-bs-target="#addClientModal" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Nouveau client</a>
        </div>
        <div class="table-responsive">
            <table class="table table-custom table-bordered table-centered table-hover mb-0">
                <thead class="bg-dark align-middle">
                    <tr class="text-uppercase fs-xxs">
                        <th class="text-white">Code client</th>
                        <th class="text-white">Nom</th>
                        <th class="text-white">Contact</th>
                        <th class="text-white">Paiements</th>
                        <th class="text-white">Statut</th>
                        <th class="text-white text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr>
                            <td class="fw-semibold">
                                <a href="{{ route('clients.show', $client) }}">
                                    #{{ $client->reference }}</td>
                                </a>
                            <td>{{ $client->name }}</td>
                            <td>
                                <div>{{ $client->phone ?: '-' }}</div>
                                <small class="text-muted">{{ $client->address ?: '-' }}</small>
                            </td>
                            <td>{{ $client->payments_count }}</td>
                            <td><span class="badge px-4 py-2 border {{ $client->status === 'active' ? 'bg-success-subtle text-success border-success' : 'bg-danger-subtle text-danger border-danger' }}">{{ $client->status === 'active' ? 'Actif' : 'Inactif' }}</span></td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-dark btn-icon btn-sm"><i class="ti ti-eye fs-lg"></i></a>
                                    <a  data-bs-toggle="modal" data-bs-target="#updateClientModal{{ $client->id }}"  class="btn btn-warning btn-icon btn-sm"><i class="ti ti-edit fs-lg"></i></a>
                                    <form method="POST" action="{{ route('clients.destroy', $client) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-icon btn-sm" onclick="return confirm('Supprimer ce client ?')"><i class="ti ti-trash fs-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

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
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Aucun client enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer border-0">{{ $clients->links() }}</div>
    </div>

     <!-- Add Client Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Ajouter un nouvel client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('clients.store') }}">
                    <div class="modal-body">
                        @include('clients._form', ['client' => null])
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
