<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'Tiger') }} :: @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/skins.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @stack('styles')
</head>
<body
    class="hold-transition skin-blue sidebar-mini {{isset($sidebarCollapse) ? 'sidebar-collapse' : null}}">
<!-- Site wrapper -->
<div class="wrapper">

    @include('partials.header')

    @include('partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            @yield('header')
        </section>

        <!-- Main content -->
        <section class="content">

            @foreach(['success', 'warning', 'danger', 'info'] as $msgType)
                @if(Session::has($msgType))
                    <div class="alert alert-{{$msgType}} mt-1" role="alert">{!! Session::get($msgType) !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            @endforeach

            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('partials.footer')

</div>

<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')

</body>
</html>
