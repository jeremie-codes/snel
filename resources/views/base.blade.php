<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>@yield('title', 'Caisse') | Caisse</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('assets/images/snel.png') }}">

        <script src="{{ asset('assets/js/config.js') }}"></script>
        <script src="{{ asset('assets/demo.js') }}"></script>

        <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css">
        <link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="wrapper">
            @include('topbar')
            @include('sidebar')

            <div class="content-page">
                <div class="container-fluid">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">@yield('subtitle', 'Caisse')</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">@yield('title', 'Caisse')</a></li>
                                <li class="breadcrumb-item active">@yield('subtitle', 'Caisse')</li>
                            </ol>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success border border-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger border border-danger alert-dismissible fade show" role="alert">
                            <strong>Veuillez corriger les champs indiqués.</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                        </div>
                    @endif

                    @yield('body')
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="{{ asset('assets/js/pages/custom-table.js') }}"></script>

        @yield('script')
    </body>
</html>
