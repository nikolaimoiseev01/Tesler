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

    .modal_wrap svg {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 20px;
    }

    .video-container {
        display: flex;
        flex-direction: row;
        gap: 5px;
        justify-content: space-around;

        position: fixed;
        top: 50%;
        left: 50%;
        background: white;
        padding: 40px;
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
            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 384.2">
                <defs>
                    <style>
                        .cls-1 {
                            fill: #c6c6c6;
                        }
                    </style>
                </defs>
                <path class="cls-1" d="m379.65,322.9l-131.2-131.7L379.95,61.2c5.4-5.4,5.4-14.2,0-19.6l-37.4-37.6c-2.6-2.6-6.1-4-9.8-4s-7.2,1.5-9.8,4l-130.9,129.6L60.95,4.1C58.35,1.5,54.85.1,51.15.1s-7.2,1.5-9.8,4L4.05,41.7c-5.4,5.4-5.4,14.2,0,19.6l131.5,130L4.45,322.9c-2.6,2.6-4.1,6.1-4.1,9.8s1.4,7.2,4.1,9.8l37.4,37.6c2.7,2.7,6.2,4.1,9.8,4.1s7.1-1.3,9.8-4.1l130.6-131.2,130.7,131.1c2.7,2.7,6.2,4.1,9.8,4.1s7.1-1.3,9.8-4.1l37.4-37.6c2.6-2.6,4.1-6.1,4.1-9.8-.1-3.6-1.6-7.1-4.2-9.7Z"/>
            </svg>
            <div class="video-wrapper">
                <video muted="muted" style="height: 400px;" id="video1" class="video" controls>
                    <source src="/media/media_fixed/temp_video_1.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="video-wrapper">
                <video muted="muted" style="height: 400px;" id="video2" class="video" controls>
                    <source src="/media/media_fixed/temp_video_2.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="video-wrapper">
                <video muted="muted" style="height: 400px;" id="video3" class="video" controls>
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
            document.getElementById('video1').play()
            document.getElementById('video2').play()
            document.getElementById('video3').play()
        }, 6000)

        setTimeout(function () {
            $('.modal_wrap').hide('slow')
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
        }, 13000)


    //     document.getElementById('video1').addEventListener('ended', myHandler, false);
    //
    //     function myHandler(e) {
    //         document.getElementById('video2').play()
    //
    //         document.getElementById('video2').addEventListener('ended', myHandler, false);
    //
    //         function myHandler(e) {
    //             document.getElementById('video3').play()
    //
    //             setTimeout(function () {
    //                 $('.modal_wrap').hide('slow')
    //                 Swal.fire({
    //                     title: "Трансляция недоступна",
    //                     icon: "error",
    //                     showConfirmButton: false,
    //                     showCloseButton: true
    //                 });
    //             }, 3000)
    //
    //             setTimeout(function () {
    //                 Swal.fire({
    //                     title: "Хотите продолжить просмотр?",
    //                     showDenyButton: true,
    //                     confirmButtonText: "Да",
    //                     denyButtonText: "Нет",
    //                     showCancelButton: false,
    //                     showCloseButton: true
    //                 })
    //             }, 6000)
    //
    //         }
    //     }
    //
    //
    });
</script>


</body>
</html>

