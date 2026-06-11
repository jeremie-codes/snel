 <header class="app-topbar border">
     <div class="container-fluid topbar-menu">
         <div class="d-flex align-items-center gap-2">
             <!-- Topbar Brand Logo -->
             <div class="logo-topbar">
                 <!-- Logo light -->
                 <a href="{{ route('dashboard') }}w" class="logo-light">
                     <span class="logo-lg">
                         <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                     </span>
                     <span class="logo-sm">
                         <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                     </span>
                 </a>

                 <!-- Logo Dark -->
                 <a href="{{ route('dashboard') }}w" class="logo-dark">
                     <span class="logo-lg">
                         <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                     </span>
                     <span class="logo-sm">
                         <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                     </span>
                 </a>
             </div>

             <!-- Sidebar Menu Toggle Button -->
             <button class="sidenav-toggle-button btn btn-primary btn-icon">
                 <i class="ti ti-menu-4"></i>
             </button>

             <!-- Horizontal Menu Toggle Button -->
             <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu">
                 <i class="ti ti-menu-4"></i>
             </button>
         </div>


         <div class="d-flex align-items-center gap-2">
             <div id="theme-dropdown" class="topbar-item dnone d-sm-flex">
                 <div class="dropdown">
                     <button class="topbar-link" data-bs-toggle="dropdown" type="button" aria-haspopup="false"
                         aria-expanded="false">
                         <i class="ti ti-sun topbar-link-icon d-none" id="theme-icon-light"></i>
                         <i class="ti ti-moon topbar-link-icon d-none" id="theme-icon-dark"></i>
                         <i class="ti ti-sun-moon topbar-link-icon d-none" id="theme-icon-system"></i>
                     </button>
                     <div class="dropdown-menu dropdown-menu-end" data-thememode="dropdown">
                         <label class="dropdown-item cursor-pointer">
                             <input class="form-check-input" type="radio" name="data-bs-theme" value="light"
                                 style="display: none" />
                             <i class="ti ti-sun align-middle me-1 fs-16"></i>
                             <span class="align-middle">Light</span>
                         </label>
                         <label class="dropdown-item cursor-pointer">
                             <input class="form-check-input" type="radio" name="data-bs-theme" value="dark"
                                 style="display: none" />
                             <i class="ti ti-moon align-middle me-1 fs-16"></i>
                             <span class="align-middle">Dark</span>
                         </label>
                         <label class="dropdown-item cursor-pointer">
                             <input class="form-check-input" type="radio" name="data-bs-theme" value="system"
                                 style="display: none" />
                             <i class="ti ti-sun-moon align-middle me-1 fs-16"></i>
                             <span class="align-middle">System</span>
                         </label>
                     </div>
                     <!-- end dropdown-menu-->
                 </div>
                 <!-- end dropdown-->
             </div>

             <div id="fullscreen-toggler" class="topbar-item d-none d-md-flex">
                 <button class="topbar-link" type="button" data-toggle="fullscreen">
                     <i class="ti ti-maximize topbar-link-icon"></i>
                     <i class="ti ti-minimize topbar-link-icon d-none"></i>
                 </button>
             </div>

             <div id="user-dropdown-detailed" class="topbar-item nav-user">
                 <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" href="#!" aria-haspopup="false" aria-expanded="false">
                        <span class="avatar-title bg-primary-subtle rounded-circle" style="width: 32px; height: 32px;">
                            <iconify-icon icon="solar:user-bold-duotone" class="fs-32"></iconify-icon>
                        </span>
                        <div class="d-lg-flex align-items-center gap-1 d-none">
                            <span>
                                <h5 class="my-0 lh-1 pro-username">
                                     {{ strlen(auth()->user()->name) > 15 ? substr(auth()->user()->name, 0, 15) . '...' : auth()->user()->name }}
                                 </h5>
                                 <span class="fs-xs lh-1">{{ auth()->user()->role }}</span>
                             </span>
                             <i class="ti ti-chevron-down align-middle"></i>
                         </div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end">
                         <!-- Header -->
                         <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Bienvenue {{ auth()->user()->name }}</h6>
                         </div>

                         <!-- Settings -->
                         <a href="{{ route('profile.index') }}" class="dropdown-item">
                             <i class="ti ti-user me-1 fs-lg align-middle"></i>
                             <span class="align-middle">Mon Profile</span>
                         </a>

                         <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" title="Déconnexion">
                                <i class="ti ti-logout me-1 fs-lg align-middle"></i>
                                <span class="align-middle">Déconnexion</span>
                            </button>
                        </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </header>
 <!-- Topbar End -->
