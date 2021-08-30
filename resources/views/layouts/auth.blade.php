<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'ИА-ГИТ') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>{{env('APP_NAME')}}</b></a>
    </div>
    <div class="login-box-body">
        @foreach(['success', 'warning', 'danger', 'info'] as $msgType)
            @if(Session::has($msgType))
                <div class="alert alert-{{$msgType}} mt-1" role="alert">{{Session::get($msgType)}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        @endforeach

        @yield('content')
    </div>
</div>
</body>
</html>
