@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Войти в панель администратора</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Запомнить меня
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Войти
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Забыли пароль?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



{{--    <!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <title>AdminLTE 3 | Log in (v2)</title>--}}

{{--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">--}}

{{--    <link rel="stylesheet" href="/plugins/adminlte/plugins/fontawesome-free/css/all.min.css">--}}

{{--    <link rel="stylesheet" href="/plugins/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">--}}

{{--    <link rel="stylesheet" href="/plugins/adminlte/dist/css/adminlte.min.css?v=3.2.0">--}}
{{--    <script nonce="abec9f18-81fb-4f2e-9187-6604f71612c4">(function(w,d){!function(bv,bw,bx,by){bv[bx]=bv[bx]||{};bv[bx].executed=[];bv.zaraz={deferred:[],listeners:[]};bv.zaraz.q=[];bv.zaraz._f=function(bz){return function(){var bA=Array.prototype.slice.call(arguments);bv.zaraz.q.push({m:bz,a:bA})}};for(const bB of["track","set","debug"])bv.zaraz[bB]=bv.zaraz._f(bB);bv.zaraz.init=()=>{var bC=bw.getElementsByTagName(by)[0],bD=bw.createElement(by),bE=bw.getElementsByTagName("title")[0];bE&&(bv[bx].t=bw.getElementsByTagName("title")[0].text);bv[bx].x=Math.random();bv[bx].w=bv.screen.width;bv[bx].h=bv.screen.height;bv[bx].j=bv.innerHeight;bv[bx].e=bv.innerWidth;bv[bx].l=bv.location.href;bv[bx].r=bw.referrer;bv[bx].k=bv.screen.colorDepth;bv[bx].n=bw.characterSet;bv[bx].o=(new Date).getTimezoneOffset();if(bv.dataLayer)for(const bI of Object.entries(Object.entries(dataLayer).reduce(((bJ,bK)=>({...bJ[1],...bK[1]})))))zaraz.set(bI[0],bI[1],{scope:"page"});bv[bx].q=[];for(;bv.zaraz.q.length;){const bL=bv.zaraz.q.shift();bv[bx].q.push(bL)}bD.defer=!0;for(const bM of[localStorage,sessionStorage])Object.keys(bM||{}).filter((bO=>bO.startsWith("_zaraz_"))).forEach((bN=>{try{bv[bx]["z_"+bN.slice(7)]=JSON.parse(bM.getItem(bN))}catch{bv[bx]["z_"+bN.slice(7)]=bM.getItem(bN)}}));bD.referrerPolicy="origin";bD.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(bv[bx])));bC.parentNode.insertBefore(bD,bC)};["complete","interactive"].includes(bw.readyState)?zaraz.init():bv.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>--}}
{{--<body class="hold-transition login-page">--}}
{{--<div class="login-box">--}}

{{--    <div class="card ">--}}
{{--        <div style="background: black;" class="card-header text-center">--}}
{{--            <a href="{{route('home')}}" class="h1">--}}
{{--                <x-logo></x-logo>--}}
{{--            </a>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--            <p class="login-box-msg">Войти в панель администратора</p>--}}
{{--            <form method="POST" action="{{ route('login') }}">--}}
{{--                @csrf--}}
{{--                <div class="input-group mb-3">--}}
{{--                    <input id="email" name="email" type="email" class="form-control" placeholder="Email">--}}
{{--                    <div class="input-group-append">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <span class="fas fa-envelope"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    @error('email')--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--                <div class="input-group mb-3">--}}
{{--                    <input type="password" class="form-control" placeholder="Password">--}}
{{--                    <div class="input-group-append">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <span class="fas fa-lock"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    @error('password')--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-8">--}}
{{--                        <div class="icheck-primary">--}}
{{--                            <input type="checkbox" id="remember">--}}
{{--                            <label for="remember">--}}
{{--                                Запомнить меня--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-4">--}}
{{--                        <button type="submit" class="btn btn-primary btn-block">Войти</button>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </form>--}}
{{--            <p class="mb-1">--}}
{{--                <a href="forgot-password.html">I forgot my password</a>--}}
{{--            </p>--}}
{{--            <p class="mb-0">--}}
{{--                <a href="register.html" class="text-center">Register a new membership</a>--}}
{{--            </p>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--</div>--}}


{{--<script src="/plugins/adminlte/plugins/jquery/jquery.min.js"></script>--}}

{{--<script src="/plugins/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>--}}

{{--<script src="/plugins/adminlte/dist/js/adminlte.min.js?v=3.2.0"></script>--}}
{{--</body>--}}
{{--</html>--}}

