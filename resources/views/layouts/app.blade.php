<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ config('app.name', 'Xero Project') }}</title>
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="icon" type="image/x-icon" href="img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style type="text/css">
            .bg-warning {
        background-color: #f4a100 !important;
    }
            .plan-tab{
  padding:0px 11px;
  border-radius: 5px;
}

.planContainer{
  padding:0px 5px;
}

.plans{
  border:  1px solid #e2e2e2;
  padding:10px;
  font-size: 18px;

}

.plans{
  color:#545454;
}

.plans:hover{
 background: rgba(234,167,33,0.6) !important;
  color:#fff;
}

.no-padding {
  padding-left: 0;
  padding-right: 0;
}

.img-fluid{
  background-size: cover;
  width: 100%
}

.productHover:hover{
    background: rgba(234,167,33,0.6);
    color:#fff;
    cursor: pointer;
  }

  .activeItem{
    background-color:#000;
    color:#fff;
    cursor: pointer;
  }

  .bordered{
    border: 2px solid #3490dc;
  }
        </style>
    </head>
    <body class="nav-fixed">
        <span id="app">
            <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
                <a class="navbar-brand d-none d-sm-block container" href="/">
                    <div class="row">
                        <img class="col-sm-4 row" src="/img/welcome-page/logo-4.png" style="height: 3.8rem"><h1 class="col-sm-6 row" style="padding-top:2.5%;color:#eb5a54">dinq</h1>
                    </div>
                </a>

                <ul class="navbar-nav align-items-center ml-auto">
                    <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                        <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- <img class="img-fluid" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"/> -->
                            <i class="fa fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                            <h6 class="dropdown-header d-flex align-items-center">
                                <!-- <img class="dropdown-user-img" src="https://source.unsplash.com/QAB-WJcbgJk/60x60" /> -->
                                <div class="dropdown-user-details">
                                    <div class="dropdown-user-details-name">{{ Auth::user()->name }}</div>
                                    <div class="dropdown-user-details-email">{{ Auth::user()->email }}</div>
                                </div>
                            </h6>
                            <div class="dropdown-divider"></div>
                            <!-- <a class="dropdown-item" href="#!">
                                <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                                Account
                            </a> -->
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="dropdown-item-icon">
                                    <i data-feather="log-out"></i>
                                </div>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                    <nav class="sidenav shadow-right sidenav-light">
                        <div class="sidenav-menu">
                            @if(Auth::user()->user_type == 0)
                                <div class="nav accordion" id="accordionSidenav">
                                    <div class="sidenav-menu-heading">&nbsp;</div>
                                    <a class="nav-link" href="/dashboard">
                                        <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                        Dashboard
                                    </a>
                                    <a class="nav-link" href="/admin-venue">
                                        <div class="nav-link-icon"><i data-feather="database"></i></div>
                                        Venue
                                    </a>
                                    <a class="nav-link" href="/admin-supplier">
                                        <div class="nav-link-icon"><i data-feather="database"></i></div>
                                        Supplier
                                    </a>

                                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#vouchers" aria-expanded="false" aria-controls="vouchers"
                                        ><div class="nav-link-icon"><i data-feather="layout"></i></div>
                                        Menu
                                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="vouchers" data-parent="#accordionSidenav">
                                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                            <a class="nav-link" href="/menu/category">Categories</a>
                                            <a class="nav-link" href="/admin-menu-items">Items</a>
                                            <a class="nav-link" href="/menu/add-on">Add-on Details</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link" href="/orders">
                                        <div class="nav-link-icon"><i class="fa fa-cart-plus"></i></div>
                                        Orders
                                    </a>

                                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#social_media" aria-expanded="false" aria-controls="social_media"
                                        ><div class="nav-link-icon"><i data-feather="heart"></i></div>
                                        Social Media
                                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="social_media" data-parent="#accordionSidenav">
                                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                            <a class="nav-link" href="/social-media/checkins">Checkins</a>
                                            <a class="nav-link" href="/social-media/feeds">Feeds</a>
                                        </nav>
                                    </div>

                                    <a class="nav-link" href="/customers">
                                        <div class="nav-link-icon"><i class="fa fa-users"></i></div>
                                        Customers
                                    </a>
                                    <a class="nav-link" href="/waiter">
                                        <div class="nav-link-icon"><i class="fa fa-user"></i></div>
                                        Waiter
                                    </a>
                                    <a class="nav-link" href="/reports">
                                        <div class="nav-link-icon"><i data-feather="file"></i></div>
                                        Reports
                                    </a>

                                    @if(Auth::user()->user_type == '0')
                                        <a class="nav-link" href="/tax-rates">
                                            <div class="nav-link-icon"><i data-feather="file"></i></div>
                                            Tax Rates
                                        </a>
                                        <a class="nav-link" href="/activities">
                                            <div class="nav-link-icon"><i data-feather="file"></i></div>
                                            Activities
                                        </a>
                                    @endif
                                </div>
                            @endif

                            @if(Auth::user()->user_type == 1)
                                <div class="nav accordion" id="accordionSidenav">
                                    <div class="sidenav-menu-heading">&nbsp;</div>
                                    <a class="nav-link" href="/dashboard">
                                        <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                        Dashboard
                                    </a>
                                    <a class="nav-link" href="/venue">
                                        <div class="nav-link-icon"><i data-feather="database"></i></div>
                                        Venue
                                    </a>

                                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#vouchers" aria-expanded="false" aria-controls="vouchers"
                                        ><div class="nav-link-icon"><i data-feather="layout"></i></div>
                                        Menu
                                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="vouchers" data-parent="#accordionSidenav">
                                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                            <a class="nav-link" href="/menu/category">Categories</a>
                                            <a class="nav-link" href="/menu/items">Items</a>
                                            <a class="nav-link" href="/menu/add-on">Add-on Details</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link" href="/orders">
                                        <div class="nav-link-icon"><i class="fa fa-cart-plus"></i></div>
                                        Orders
                                    </a>

                                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#social_media" aria-expanded="false" aria-controls="social_media"
                                        ><div class="nav-link-icon"><i data-feather="heart"></i></div>
                                        Social Media
                                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="social_media" data-parent="#accordionSidenav">
                                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                            <a class="nav-link" href="/social-media/checkins">Checkins</a>
                                            <a class="nav-link" href="/social-media/feeds">Feeds</a>
                                        </nav>
                                    </div>

                                    <a class="nav-link" href="/customers">
                                        <div class="nav-link-icon"><i class="fa fa-users"></i></div>
                                        Customers
                                    </a>
                                    <a class="nav-link" href="/waiter">
                                        <div class="nav-link-icon"><i class="fa fa-user"></i></div>
                                        Waiter
                                    </a>
                                    <a class="nav-link" href="/reports">
                                        <div class="nav-link-icon"><i data-feather="file"></i></div>
                                        Reports
                                    </a>

                                    @if(Auth::user()->user_type == '0')
                                        <a class="nav-link" href="/tax-rates">
                                            <div class="nav-link-icon"><i data-feather="file"></i></div>
                                            Tax Rates
                                        </a>
                                    @endif
                                </div>
                            @endif

                            @if(Auth::user()->user_type == 2)
                                <div class="nav accordion" id="accordionSidenav">
                                    <div class="sidenav-menu-heading">&nbsp;</div>
                                    <a class="nav-link" href="/dashboard">
                                        <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                        Dashboard
                                    </a>
                                    <a class="nav-link" href="/supplier">
                                        <div class="nav-link-icon"><i data-feather="database"></i></div>
                                        Supplier Info
                                    </a>

                                    <a class="nav-link" href="/orders">
                                        <div class="nav-link-icon"><i class="fa fa-cart-plus"></i></div>
                                        Orders
                                    </a>

                                    <a class="nav-link" href="/customers">
                                        <div class="nav-link-icon"><i class="fa fa-users"></i></div>
                                        Customers
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="sidenav-footer">
                            <div class="sidenav-footer-content">
                                <div class="sidenav-footer-subtitle">Logged in as:</div>
                                <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
                            </div>
                        </div>
                    </nav>
                </div>
                <div id="layoutSidenav_content" style="padding-top:2rem;">
                    <main>
                        @yield('content')
                    </main>
                    <footer class="footer mt-auto footer-light">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 small">Copyright &copy; Slingtheworld {{date('Y')}}</div>
                                <div class="col-md-6 text-md-right small">
                                    <a href="#!">Privacy Policy</a>
                                    &middot;
                                    <a href="#!">Terms &amp; Conditions</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </span>
        <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script> -->

        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!--  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> -->
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="/js/toast.min.js"></script>
        <script src="/js/script.js" defer></script>
        <!-- <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script> -->

    </body>
</html>
