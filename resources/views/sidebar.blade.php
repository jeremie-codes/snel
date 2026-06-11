<div class="sidenav-menu">
    <a href="{{ route('dashboard') }}" class="logo pt-2">
        <span class="logo logo-light">
            <span class="logo-lg">
                <span class="d-flex align-item-end">
                    <img src="{{ asset('assets/images/snel.jpg') }}" style="height:50px !important" alt="logo">
                    <span class="fw-bold text-white fs-4 ms-2">SNEL</span>
                </span>
            </span>
            <span class="logo-sm"><img src="{{ asset('assets/images/snel.jpg') }}" alt="logo"></span>
        </span>
        <span class="logo logo-dark">
            <span class="logo-lg">
                <img src="{{ asset('assets/images/snel.jpg') }}" style="height:50px !important" alt="logo">
                <span class="fw-bold text-white fs-4 ms-2">SNEL</span>
            </span>
            <span class="logo-sm"><img src="{{ asset('assets/images/snel.jpg') }}" alt="logo"></span>
        </span>
    </a>

    <button class="button-on-hover"><span class="btn-on-hover-icon"></span></button>
    <button class="button-close-offcanvas"><i class="ti ti-menu-4 align-middle"></i></button>

    <div class="scrollbar" data-simplebar>
        <div id="user-profile-settings" class="sidenav-user" style="background: url({{ asset('assets/images/user-bg-pattern.svg') }})">
            <div>
                <span class="sidenav-user-name fw-bold">{{ auth()->user()->name }}</span>
                <span class="fs-12 fw-semibold text-uppercase">{{ auth()->user()->role }}</span>
            </div>
        </div>

        <div id="sidenav-menu">
            <ul class="side-nav">
                <li class="side-nav-title mt-2">Menu</li>
                <li class="side-nav-item py-1" style="border-bottom: 1px solid #232735">
                    <a href="{{ route('dashboard') }}" class="side-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                        <span class="menu-text">Tableau de bord</span>
                    </a>
                </li>
                <li class="side-nav-item py-1" style="border-bottom: 1px solid #232735">
                    <a href="{{ route('payments.index') }}" class="side-nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-wallet"></i></span>
                        <span class="menu-text">Paiements</span>
                    </a>
                </li>
                <li class="side-nav-item py-1" style="border-bottom: 1px solid #232735">
                    <a href="{{ route('factures.index') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-plus"></i></span>
                        <span class="menu-text">Générer une facture</span>
                    </a>
                </li>
                @if (auth()->user()->canManagePayments())
                    <li class="side-nav-item py-1" style="border-bottom: 1px solid #232735">
                        <a href="{{ route('payments.create') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-plus"></i></span>
                            <span class="menu-text">Nouveau paiement</span>
                        </a>
                    </li>
                @endif
                <li class="side-nav-title mt-2">Administration</li>
                <li class="side-nav-item py-1" style="border-bottom: 1px solid #232735">
                    <a href="{{ route('clients.index') }}" class="side-nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-users"></i></span>
                        <span class="menu-text">Clients</span>
                    </a>
                </li>
                @if (auth()->user()->isAdmin())
                <li class="side-nav-item py-1" style="border-bottom: 1px solid #232735">
                    <a href="{{ route('users.index') }}" class="side-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-user-cog"></i></span>
                        <span class="menu-text">Utilisateurs</span>
                    </a>
                </li>
                <li class="side-nav-item py-1" style="border-bottom: 1px solid #232735">
                    <a data-bs-toggle="modal" data-bs-target="#fixTauxModal" class="side-nav-link cursor-pointer">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-basket-dollar">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M17 10l-2 -6" />
                                <path d="M7 10l2 -6" />
                                <path d="M13 20h-5.756a3 3 0 0 1 -2.965 -2.544l-1.255 -7.152a2 2 0 0 1 1.977 -2.304h13.999a2 2 0 0 1 1.977 2.304" />
                                <path d="M10 14a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                <path d="M19 21v1m0 -8v1" />
                            </svg>
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-coin">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                                <path d="M12 7v10" />
                            </svg></ --}}
                        </span>

                        <span class="menu-text">Taux</span>
                    </a>
                </li>
                @endif
                <li class="side-nav-item py-1" style="border-bottom: 1px solid #232735">
                    <a href="{{ route('profile.index') }}" class="side-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-user"></i></span>
                        <span class="menu-text">Mon Profil</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="fixTauxModal" tabindex="-1" aria-labelledby="fixTauxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fixTauxModalLabel">Configuration du taux de change</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('rate.store') }}">
                @csrf
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <div class="col-md-10">
                        <label for="value" class="form-label">Taux de change en CDF pour 1$</label>
                        <input id="value" name="value" value="{{ old('value', $rate->value ?? '') }}" class="form-control" placeholder="ex: 22 500..." type="number" required>
                        <small class="text-muted">2 250 FC par défaut</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button class="btn btn-dark"><i class="ti ti-device-floppy me-1"></i>Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
