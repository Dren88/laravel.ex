<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title')</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="{{ asset('public/assets/front/images/favicon.ico') }}" type="image/x-icon" />
<link rel="apple-touch-icon" href="{{ asset('public/assets/front/images/apple-touch-icon.png') }}">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('public/assets/front/css/front.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/front/css/select2.min.css') }}">

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<div id="wrapper">

    @include('layouts.navbar')

    @yield('header')

    <section class="section lb @if(!Request::is('/')) m3rem @endif">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    @include('layouts.alert')

                    @yield('content')

                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section>
</div><!-- end wrapper -->


<script src="{{ asset('public/assets/front/js/front.js') }}"></script>
<script src="{{ asset('public/assets/front/js/select2.min.js') }}"></script>

</body>
</html>
