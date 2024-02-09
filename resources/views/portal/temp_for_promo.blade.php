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

    .modal_wrap {
        width: 100%;
        height: 100%;
        position:fixed;
        display: none;
    }

    .video-container {
        display: flex;
        flex-direction: row;
        gap: 10px;
        justify-content: space-around;

        position: fixed;
        top: 50%;
        left: 50%;
        background: white;
        padding: 20px;
        transform: translate(-50%, -50%);
        border-radius: 10px;
    }

    video {
        /*width: 25%;*/
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" rel="stylesheet"
      type="text/css">

<div class="wrap">

    <div class="modal_wrap">
        <div class="video-container">
            <div class="video-wrapper">
                <video style="height: 400px;" id="video1" class="video" controls>
                    <source src="/media/media_fixed/temp_video_1.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="video-wrapper">
                <video style="height: 400px;" id="video2" class="video" controls>
                    <source src="/media/media_fixed/temp_video_2.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="video-wrapper">
                <video style="height: 400px;" id="video3" class="video" controls>
                    <source src="/media/media_fixed/temp_video_3.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

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

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>
<script>

    $(document).ready(function () {

        setTimeout(function() {
            $('.modal_wrap').show('slow')
        }, 6000)


        document.getElementById('video1').addEventListener('ended', myHandler, false);

        function myHandler(e) {
            document.getElementById('video2').play()

            document.getElementById('video2').addEventListener('ended', myHandler, false);

            function myHandler(e) {
                document.getElementById('video3').play()

                setTimeout(function () {
                    $('.modal_wrap').hide('slow')
                    Swal.fire({
                        title: "Трансляция недоступна",
                        icon: "error",
                        showConfirmButton: false,
                        showCloseButton: true
                    });
                }, 3000)

                setTimeout(function () {
                    Swal.fire({
                        title: "Хотите продолжить просмотр?",
                        showDenyButton: true,
                        confirmButtonText: "Да",
                        denyButtonText: "Нет",
                        showCancelButton: false,
                        showCloseButton: true
                    })
                }, 6000)

            }
        }


    });
</script>


</body>
</html>

