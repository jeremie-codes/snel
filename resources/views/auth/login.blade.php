<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Connexion | Caisse</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <script src="{{ asset('assets/js/config.js') }}"></script>
        <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css">
        <link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">

        <style>
            .btn-gradient-dark {
                background-image: linear-gradient(to right, #4b6cb7, #182848);
                color: #fff;
            }

            .btn-gradient-dark:hover {
                background-image: linear-gradient(to right, #3b5697, #0e182c);
                color: #fff;
            }
        </style>
    </head>
    <body>

        <div class="position-absolute top-0 end-0">
            <img src="{{ asset('assets/images/auth-card-bg.svg') }}" class="auth-card-bg-img" alt="auth-card-bg" />
        </div>
        <div class="position-absolute bottom-0 start-0" style="transform: rotate(180deg)">
            <img src="{{ asset('assets/images/auth-card-bg.svg') }}" class="auth-card-bg-img" alt="auth-card-bg" />
        </div>
        <div class="auth-box px-0 d-flex align-items-center">
            <div class="container-xxl">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-9 ">
                        <div class="card">
                            <div class="row justify-content-between g-0">
                                <div class="col-lg-6">
                                    <div class="card-body pb-5">
                                        <div class="auth-brand text-center mb-4">
                                            <a href="{{ route('login') }}" class="logo- dark">
                                                <img src="{{ asset('assets/images/icon.png') }}" width="220" height="100" alt="logo">
                                            </a>
                                            <h4 class="fw-bold text-dark mt-3">Espace de connexion</h4>
                                            <p class="text-muted w-lg-75 mx-auto">Connectez-vous avec vos identifiants.</p>
                                        </div>

                                        @if ($errors->any())
                                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                                        @endif

                                        <form method="POST" action="{{ route('login.store') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Nom d'utilisateur</label>
                                                <div class="app-search">
                                                    <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control" placeholder="Nom d'utilisateur" required autofocus>
                                                    <i class="ti ti-user app-search-icon text-muted"></i>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Mot de passe</label>
                                                <div class="app-search">
                                                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                                                    <i class="ti ti-lock-password app-search-icon text-muted"></i>
                                                </div>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input form-check-input-light fs-14" type="checkbox" name="remember" id="remember">
                                                <label class="form-check-label" for="remember">Garder ma session ouverte</label>
                                            </div>

                                            <div class="d-grid mb-5">
                                                <button type="submit" class="btn btn-gradient-dark fw-semibold py-2">Se connecter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-6 d-none d-lg-block">
                                    <div class="h-100 position-relative card-side-img rounded-end overflow-hidden" style="background-image: url({{ asset('assets/images/login.png') }}); background-size: cover; background-position: left">
                                        <div class="p-4 card-img-overlay rounded-end auth-overlay d-flex align-items-end justify-content-center" style="opacity: .5"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
    </body>
</html>
