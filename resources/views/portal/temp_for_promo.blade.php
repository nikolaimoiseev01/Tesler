<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Танцующая женщина</title>
    <link rel="stylesheet" href="/fonts/fonts.css">
</head>
<body>
<style>

    body {
        font-family: 'Inter Tight';
        font-style: normal;
        font-weight: 400;
        letter-spacing: -0.03em;
        color: black;
        background: black;
    }

    .swal2-popup {
        font-family: 'Inter Tight', serif !important;
    }

    body {
        background: black;
    }
    .wrap {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        flex-direction: column;
        height: 100vh;
    }

    .row {
        display: flex;
        gap: 20px;
    }

    @media (max-width: 1024px) {
        .row {
            flex-direction: column;
        }
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" rel="stylesheet"
      type="text/css">

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            Swal.fire({
                html: "<iframe width='90%' height='400' style='padding: 20px;' src='https://www.youtube.com/embed/dQw4w9WgXcQ' title='Rick Astley - Never Gonna Give You Up (Official Music Video)' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' allowfullscreen></iframe>",
                showConfirmButton: false,
                width: '50%',
                showCloseButton: true
            });
        }, 6000)

        setTimeout(function () {
            Swal.fire({
                title: "Трансляция недоступна",
                icon: "error",
                showConfirmButton: false,
                showCloseButton: true
            });
        }, 10000)

        setTimeout(function () {
            Swal.fire({
                title: "Хотите продолжить просмотр?",
                showDenyButton: true,
                confirmButtonText: "Да",
                denyButtonText: "Нет",
                showCancelButton: false,
                showCloseButton: true
            })
        }, 12000)





    });
</script>
<div class="wrap">
{{--    <div class="row">--}}
{{--        <iframe--}}
{{--            referrerpolicy="origin"--}}
{{--            width="50%"--}}
{{--            height="500"--}}
{{--            style="background: #FFFFFF;padding: 10px; border: none; border-radius: 5px; box-shadow:0 2px 4px 0 rgba(0,0,0,.2)"--}}
{{--            src="https://jika.io/embed/area-chart?symbol=AAPL&selection=one_year&closeKey=close&boxShadow=true&graphColor=1652f0&textColor=161c2d&backgroundColor=FFFFFF&fontFamily=Nunito"--}}
{{--        ></iframe>--}}

{{--        <iframe--}}
{{--            referrerpolicy="origin"--}}
{{--            width="50%"--}}
{{--            height="500"--}}
{{--            style="background: #FFFFFF;padding: 10px; border: none; border-radius: 5px; box-shadow:0 2px 4px 0 rgba(0,0,0,.2)"--}}
{{--            src="https://jika.io/embed/area-chart?symbol=AMZN&selection=one_year&closeKey=close&boxShadow=true&graphColor=1652f0&textColor=161c2d&backgroundColor=FFFFFF&fontFamily=Nunito"--}}
{{--        ></iframe>--}}
{{--    </div>--}}

{{--    <div class="row">--}}
{{--        <iframe--}}
{{--            referrerpolicy="origin"--}}
{{--            width="50%"--}}
{{--            height="500"--}}
{{--            style="background: #FFFFFF;padding: 10px; border: none; border-radius: 5px; box-shadow:0 2px 4px 0 rgba(0,0,0,.2)"--}}
{{--            src="https://jika.io/embed/area-chart?symbol=TSLA&selection=one_year&closeKey=close&boxShadow=true&graphColor=1652f0&textColor=161c2d&backgroundColor=FFFFFF&fontFamily=Nunito"--}}
{{--        ></iframe>--}}
{{--        <iframe--}}
{{--            referrerpolicy="origin"--}}
{{--            width="50%"--}}
{{--            height="500"--}}
{{--            style="background: #FFFFFF;padding: 10px; border: none; border-radius: 5px; box-shadow:0 2px 4px 0 rgba(0,0,0,.2)"--}}
{{--            src="https://jika.io/embed/area-chart?symbol=META&selection=one_year&closeKey=close&boxShadow=true&graphColor=1652f0&textColor=161c2d&backgroundColor=FFFFFF&fontFamily=Nunito"--}}
{{--        ></iframe>--}}
{{--    </div>--}}


    <!-- TradingView Widget BEGIN -->
    <div class="tradingview-widget-container" style="height:100%;width:100%">
        <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
            {
                "autosize": true,
                "symbol": "NASDAQ:AAPL",
                "interval": "D",
                "timezone": "Etc/UTC",
                "theme": "dark",
                "style": "1",
                "locale": "en",
                "enable_publishing": false,
                "allow_symbol_change": true,
                "support_host": "https://www.tradingview.com"
            }
        </script>
    </div>
    <!-- TradingView Widget END -->

</div>
</body>
</html>

