<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Events - Around Saudia Arabia</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{asset('dist/img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="{{ asset('dist/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Data Table JS
    ============================================ -->
    <link rel="stylesheet" href="{{ asset('dist/css/jquery.dataTables.min.css')}}">
     <!-- Notika icon CSS
    ============================================ -->
    <link rel="stylesheet" href="{{ asset('dist/css/notika-custom-icon.css')}}">

    <!-- Template Stylesheet -->
    <link href="{{ asset('dist/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles


</head>

<body>
<div class="container-xxl bg-white p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
       

        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="{{ route('home', ['locale' => App::getLocale()]) }}" class="navbar-brand d-flex align-items-center text-center">
                    <div class="icon p-2 me-2">
                        <img class="img-fluid" src="{{ asset('dist/img/icon-deal.png')}}" alt="Icon" style="width: 30px; height: 30px;">
                    </div>
                    <h1 class="m-0 text-info">{{ __('strings.Events Around You') }}</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="{{ route('home', ['locale' => App::getLocale()]) }}" class="nav-item nav-link active">{{ __('strings.HOME') }}</a>
                        <a href="{{route('contact', ['locale' => App::getLocale()])}}" class="nav-item nav-link">{{ __('strings.CONTACT') }}</a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                @if(app()->getLocale()=='ar')
                                <i> 
                                    <img class="img-fluid" src="{{ asset('dist/img/icons_lang/world.png')}}" alt="Icon" style="width: 30px; height: 30px; padding-right:8px;"><span>العربية</span>
                                </i>
                                
                                @else
                                <i> 
                                    <img class="img-fluid" src="{{ asset('dist/img/icons_lang/united-kingdom.png')}}" alt="Icon" style="width: 30px; height: 30px; padding-right:8px;"><span>English</span>
                                </i>
                               
                                @endif
                                
                            </a>
                            <div class="dropdown-menu rounded-0 m-0">
                                 <a href="{{ route(Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'en'])) }}" class="dropdown-item">English
                                     <i> 
                                    <img class="img-fluid" src="{{ asset('dist/img/icons_lang/united-kingdom.png')}}" alt="Icon" style="width: 30px; height: 30px;"/>
                                    </i>
                                </a>
                                <a href="{{ route(Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => 'ar'])) }}" class="dropdown-item">العربية
                                    <i> 
                                    <img class="img-fluid" src="{{ asset('dist/img/icons_lang/world.png')}}" alt="Icon" style="width: 30px; height: 30px;"/>
                                    </i>
                                </a>
                               
                               
                            </div>
                        </div>

                    @if(Route::has('login'))
                        @auth
                          @if(Auth::user()->utype ==='ADM')
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> {{ __('strings.My Account') }}({{Auth::user()->name}})</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a title="categories" class="dropdown-item"  href="{{route('admin.categories')}}">{{ __('strings.All Categories') }}</a>
                                    <a title="events"  class="dropdown-item" href="{{route('admin.events')}}">{{ __('strings.All Events') }}</a>
                                    <a title="services"  class="dropdown-item" href="{{route('admin.services')}}">{{ __('strings.All Services') }}</a>
                                    <a title="settings"  class="dropdown-item" href="{{route('admin.settings')}}"> {{ __('strings.Settings') }}</a>
                                    <li class="dropdown-item" >
                                        <a  href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form') .submit();">{{ __('strings.logout') }}</a>
                                    </li>
                                    <form action="{{route('logout')}}" id="logout-form" method="post">
                                        @csrf

                                    </form>
                                </div>
                            </div>

                          @else
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ __('strings.My Account') }}({{Auth::user()->name}})</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a title="Dashboard" class="dropdown-item" href="{{route('user.dashboard')}}">{{ __('strings.My Dashboard') }}</a>
                                    <a title="My Profile" class="dropdown-item" href="{{route('user.profile')}}">{{ __('strings.My Profile') }}</a>
                                    <a title="change Password" class="dropdown-item" href="{{route('user.changePassword')}}">{{ __('strings.change Password') }}</a>
                                    <a title="manage Supscription" class="dropdown-item" href="{{route('user.manageSupscription')}}">{{ __('strings.manage Supscription') }}</a>
                                    <li class="dropdown-item" >
                                        <a  href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form') .submit();">{{ __('strings.logout') }}</a>
                                    </li>
                                    <form action="{{route('logout')}}" id="logout-form" method="post">
                                        @csrf

                                    </form>
                                </div>
                            </div>
                            <?php 
                            $userSupscriptions = Auth::user()->supscriptions()->latest('created_at')->first();
                            
                            ?>  
                            @if ($userSupscriptions != null) 

                                @if ($userSupscriptions->ends_at < now()) 
                                  <a href="{{route('subscribe', ['locale' => App::getLocale()])}}" class="btn btn-primary d-block mt-3 mb-3 pt-2 px-2" >Renew Supscription</a>
                                @else
                                  <div class="alert alert-success " role="alert" style="font-size:14px;">supscription ends at {{ \Carbon\Carbon::parse($userSupscriptions->ends_at)->format('Y-m-d') }}</div>


                                @endif

                            @else 
                              <a href="{{route('subscribe', ['locale' => App::getLocale()])}}" class="btn btn-primary d-block mt-3 mb-3 pt-2 px-2" >{{ __('strings.subscribe now') }}</a>
                            @endif    




                          @endif
                    @else

                        <a title="Register or Login" class="btn btn-primary d-block  mt-3 mb-3 pt-2 px-2  " href="{{route('login')}}">{{ __('strings.LOGIN') }}</a>
                        <a title="Register or Login" class="btn btn-primary d-block mt-3 mb-3 pt-2 px-2 " href="{{ route('register-form', ['locale' => App::getLocale()]) }}">{{ __('strings.REGISTER') }}</a>
                        <a href="{{route('subscribe', ['locale' => App::getLocale()])}}" class="btn btn-primary d-block mt-3 mb-3 pt-2 px-2" >{{ __('strings.subscribe now') }}</a>

                    @endif
                    @endif






                    </div>
                </div>
            </nav>
        </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  





        {{$slot}}
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Get In Touch</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Quick Links</h5>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Photo Gallery</h5>
                        <div class="row g-2 pt-2">
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-1.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-2.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-3.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-4.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-5.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-6.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Newsletter</h5>
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

							Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('dist/lib/wow/wow.min.js')}}"></script>
    <script src="{{ asset('dist/lib/easing/easing.min.js')}}"></script>
    <script src="{{ asset('dist/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{ asset('dist/lib/owlcarousel/owl.carousel.min.js')}}"></script>
  
    <!-- Data Table JS
    ============================================ -->
    <script src="{{ asset('dist/js/data-table/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('dist/js/data-table/data-table-act.js')}}"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('dist/js/main.js')}}"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
