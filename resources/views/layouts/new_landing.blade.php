<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="/fonts/fonts.css">

    <link rel="apple-touch-icon" sizes="180x180" href="/media/media_fixed/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/media/media_fixed/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/media/media_fixed/favicon/favicon-16x16.png">
    <link rel="manifest" href="/media/media_fixed/favicon/site.webmanifest">
    <link rel="mask-icon" href="/media/media_fixed/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Scripts -->
    @vite([
    'resources/sass/new_landing.scss',
    'resources/js/app.js'
    ])

    {{--    @vite(['resources/sass/portal.scss','public/build'])--}}

    @livewireStyles

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(96375595, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/96375595" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    @yield('styles')
    <title>Tesler | @yield('title')</title>
</head>
<body>


<div class="content-wrapper">
    @yield('content')
</div>


<!-- include jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@livewireScripts


@stack('scripts')


</body>
</html>
