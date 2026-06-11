@extends('base')

@section('title', 'Profile')
@section('subtitle', 'Mon Profile')

@section('body')
    <div class="px-3 mt-4">
        <div class="row">
            <div class="col-xl-4">
                <div class="card card-top-sticky">
                    <div class="flex-grow-1">
                        <h5 class="mb-3 text-uppercase px-3 py-2 text-white bg-dark d-flex justify-content-start align-items-center gap-1">
                            Information Personelle
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="me-3 position-relative">
                                <span class="avatar-title bg-primary-subtle rounded-circle" style="width: 65px; height: 65px; overflow: hidden;">
                                    <iconify-icon icon="solar:user-bold-duotone" class="fs-72"></iconify-icon>
                                </span>
                            </div>
                            <div>
                                <h5 class="mb-0 d-flex align-items-center">
                                    <a href="#!" class="link-reset">{{ $user->name }}</a>
                                    {{-- <img src="assets/images/flags/us.svg" alt="US" class="ms-2 rounded-circle"
                                        height="16" /> --}}
                                </h5>
                                {{-- <p class="text-muted mb-2">{{ $user->role }}</p> --}}
                                <span class="badge text-bg-light badge-label">{{ $user->role }}</span>
                            </div>
                        </div>

                        <div class="">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div
                                    class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                    <i class="ti ti-mail fs-xl"></i>
                                </div>
                                <p class="mb-0 fs-sm">
                                    Email:
                                    <a href="mailto:hello&#64;example.com"
                                        class="text-primary fw-semibold">{{ $user->email ?? 'N/A' }}</a>
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
                        <!---->
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header card-tabs d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-3 text-uppercase bg-light p-1 border-dashed rounded d-flex justify-content-center align-items-center gap-1">
                                Modifier le profile
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <!-- end About Me data-->
                            <div class="tab-pane show active" id="settings">
                                <form method="POST" action="{{ route('profile.update', $user) }}">
                                        {{-- @method('PUT') --}}
                                        <div class="modal-body">
                                            @include('users._form', ['user' => $user, 'communes' => $communes])
                                        </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-success"><i class="ti ti-device-floppy me-1"></i>Enregistrer les modifications</button>
                                    </div>
                                </form>
                            </div>
                            <!-- end settings Data-->
                        </div>
                        <!-- end tab content-->
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->
    </div>
@endsection

@section('script')

@endsection
