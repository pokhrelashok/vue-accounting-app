<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="noindex, nofollow">

    <title>{{ config('app.name') ? config('app.name') : '' }}</title>

    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        integrity="sha256-nbyata2PJRjImhByQzik2ot6gSHSU4Cqdz5bNYL2zcU=" crossorigin="anonymous" />
    <style>
        #toast-container {
            margin-top: 10px !important;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <div id="app">

        <div class="col-10 offset-1 mb-5">
            <div class="d-flex align-items-center py-4 header">

                <img src="https://image.flaticon.com/icons/png/512/458/458961.png" width="40">

                <h4 class="mb-0 ml-3"><strong>{{ config('app.name') ? config('app.name') : '' }}</strong></h4>
            </div>


            @if (Session::has('message'))
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-success">
                        <strong>{!! Session::get('message') !!}</strong>
                    </div>
                </div>
            </div>
            @endif

            <div class="row mt-4">
                <div class="col-2 sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/home"
                                class="{{ Route::is('home*') ? 'active ' : '' }}nav-link d-flex align-items-center pt-0">
                                <i class="fas fa-home"></i> &nbsp;&nbsp;
                                <span>Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/companies"
                                class="{{ Route::is('compan*') ? 'active ' : '' }}nav-link d-flex align-items-center">
                                <i class="fas fa-building"></i> &nbsp;&nbsp;
                                <span>Companies</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/users"
                                class="{{ Route::is('user*') ? 'active ' : '' }}nav-link d-flex align-items-center">
                                <i class="fas fa-user"></i> &nbsp;&nbsp;
                                <span>Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                class="nav-link d-flex align-items-center">
                                <i class="fas fa-sign-out-alt"></i> &nbsp;&nbsp;
                                <span>Log Out</span>
                            </a>
                            @include('forms.logout')
                        </li>
                        <li class="nav-item pt-5" style="font-size: 13px;">
                            <strong><a href="/">&copy; {{ date('Y') }} Anysale</a></strong><br>
                        </li>
                    </ul>
                </div>

                <div class="col-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset(mix('js/app.js'))}}"></script>
    <script type="text/javascript">
        $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    </script>
    <script src="https://kit.fontawesome.com/f550a22a37.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "positionClass" : "toast-top-center",
                "closeButton" : true,
                "debug" : false,
                "newestOnTop" : true,
                "progressBar" : true,
                "preventDuplicates" : false,
                "onclick" : null,
                "showDuration" : "300",
                "hideDuration" : "1000",
                "timeOut" : "5000",
                "extendedTimeOut" : "1000",
                "showEasing" : "swing",
                "hideEasing" : "linear",
                "showMethod" : "fadeIn",
                "hideMethod" : "fadeOut"
            }

            @if(Session::has('success'))
                toastr['success']("{{ Session::get('success') }}")
            @endif
                @if(Session::has('warning'))
                toastr['warning']("{{ Session::get('warning') }}")
            @endif
                @if(Session::has('error'))
                toastr['error']("{{ Session::get('error') }}")
            @endif
        });

        $(document).ready(function() {
            $('.select2-default').select2({
                theme: 'bootstrap',
            });
        });

        autosize($('textarea'));
    </script>
    @yield('scripts')
    @yield('footer')
</body>

</html>
