@extends('base')

@section('title', 'Profils')
@section('subtitle', 'Liste des Utilisateurs')

@section('body')
    <div class="row row-cols-1 row-cols-md-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="avatar-title bg-primary-subtle rounded-circle" style="width: 50px; height: 50px;">
                            <iconify-icon icon="solar:user-bold-duotone" class="fs-36"></iconify-icon>
                        </span>
                        <div>
                            <h5 class="mb-1 text-capitalize">Tout</h5>
                            <p class="mb-0 text-muted">{{ $users->count() }} profil(s)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($roles as $role)
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <span class="avatar-title bg-primary-subtle rounded-circle" style="width: 50px; height: 50px;">
                                <iconify-icon icon="solar:user-bold-duotone" class="fs-36"></iconify-icon>
                            </span>
                            <div>
                                <h5 class="mb-1 text-capitalize">{{ $role }}</h5>
                                <p class="mb-0 text-muted">{{ $users->where('role', $role)->count() }} profil(s)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header border-light justify-content-between">
            <h4 class="card-title">Profils utilisateurs</h4>
            {{-- <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Nouveau profil</a> --}}
            <button type="button" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-secondary"><i class="ti ti-plus me-1"></i>Nouvel utilisateur</button>
        </div>
        <div class="table-responsive">
            <table class="table table-custom table-bordered table-centered table-hover mb-0">
                <thead class="bg-dark align-middle">
                    <tr class="text-uppercase fs-xxs">
                        <th class="text-white">N°</th>
                        <th class="text-white">Nom</th>
                        <th class="text-white">point de vente</th>
                        <th class="text-white">Rôle</th>
                        <th class="text-white">Statut</th>
                        <th class="text-white text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="fw-semibold">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $user->name ?? 'N/A' }}</td>
                            <td>{{ $user->point_vente ?? 'N/A' }}</td>
                            <td><span class="badge bg-dark-subtle text-dark text-uppercase px-4 py-2 border border-dark">{{ $user->role ?? 'N/A' }}</span></td>
                            <td><span class="badge px-4 py-2 border {{ $user->status === 'active' ? 'bg-success-subtle text-success border-success' : 'bg-danger-subtle text-danger border-danger' }}">{{ $user->status === 'active' ? 'Actif' : 'Inactif' }}</span></td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a  data-bs-toggle="modal" data-bs-target="#viewUserModal{{ $user->id }}"  class="btn btn-dark btn-icon btn-sm"><i class="ti ti-eye fs-lg"></i></a>
                                    <a data-bs-toggle="modal" data-bs-target="#addUserModal{{ $user->id }}" class="btn btn-warning btn-icon btn-sm"><i class="ti ti-edit fs-lg"></i></a>
                                    <form method="POST" action="{{ route('users.destroy', $user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-icon btn-sm" onclick="return confirm('Supprimer ce profil ?')"><i class="ti ti-trash fs-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="viewUserModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewUserModalLabel">Details de {{ $user->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="avatar-title bg-primary-subtle rounded-circle" style="width: 50px; height: 50px;">
                                                <iconify-icon icon="solar:user-bold-duotone" class="fs-36"></iconify-icon>
                                            </span>
                                            <div>
                                                <h5 class="mb-1 text-capitalize">{{ $user->name }}</h5>
                                                <p class="mb-0 text-muted">{{ $user->point_vente }}</p>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div
                                                    class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                                    <i class="ti ti-mail fs-xl"></i>
                                                </div>
                                                <p class="mb-0 fs-sm">
                                                    Point de vente:
                                                    <a
                                                        class="text-primary fw-semibold">{{ $user->point_vente ?? 'N/A' }}</a>
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div
                                                    class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                                    <i class="ti ti-briefcase fs-xl"></i>
                                                </div>
                                                Téléphone:
                                                <p class="mb-0 fs-sm fw-semibold">{{ ucfirst($user->phone) ?? 'N/A' }}</p>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div
                                                    class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                                    <i class="ti ti-briefcase fs-xl"></i>
                                                </div>
                                                Rôle:
                                                <p class="mb-0 fs-sm fw-semibold">{{ ucfirst($user->role) ?? 'N/A' }}</p>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div
                                                    class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                                    <i class="ti ti-map-pin fs-xl"></i>
                                                </div>
                                                Adresse:
                                                <p class="mb-0 fs-sm">
                                                    <span class="text-dark fw-semibold">{{ ucfirst($user->adresse) ?? 'N/A' }}</span>
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <div
                                                    class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                                    <i class="ti ti-world fs-xl"></i>
                                                </div>
                                                <p class="mb-0 fs-sm">
                                                    Statut:
                                                    <span class="{{  $user->status === 'active' ? 'text-success' : 'text-danger' }} fw-semibold">{{ ucfirst($user->status) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button data-bs-toggle="modal" data-bs-target="#addUserModal{{ $user->id }}"  class="btn btn-warning"><i class="ti ti-edit me-1"></i>Modifier</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="addUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="addUserModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addUserModalLabel">Modifier {{ $user->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form method="POST" action="{{ route('users.update', $user) }}">
                                        @method('PUT')
                                        <div class="modal-body">
                                            @include('users._form', ['user' => $user])
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
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucun profil.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer border-0">{{ $users->links() }}</div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Ajouter un nouvel utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="addUserForm" action="{{ route('users.store') }}" method="POST">
                    <div class="modal-body">
                        @include('users._form', ['user' => null])
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
