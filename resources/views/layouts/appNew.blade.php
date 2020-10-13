<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name', 'Manager') }} - {{ $pageTitle }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/css/fontawesome.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/sb-admin-2.min.css') }}" rel="stylesheet">

    @livewireStyles
</head>

<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">
    <x-sidebar/>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <x-topbar/>
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">{{ $pageTitle }}</h1>
                    @yield('titleButton')
                </div>

                @if(\Illuminate\Support\Facades\Session::exists('successMessage'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ \Illuminate\Support\Facades\Session::get('successMessage') }}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(\Illuminate\Support\Facades\Session::exists('errorMessage'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ \Illuminate\Support\Facades\Session::get('errorMessage') }}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Lars Riße 2020</span>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('/js/jquery.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('/js/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('/js/Chart.min.js') }}"></script>
<script src="{{ asset('/js/moment.js') }}"></script>

<!-- High Stock -->
<script src="{{ asset('/highchart/highcharts.js') }}"></script>
<script src="{{ asset('/highchart/modules/data.js') }}"></script>

@livewireScripts
@yield('customJS')

</body>
</html>
