<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Танцующая женщина</title>
</head>
<body>
<style>
    .wrap {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        flex-direction: column;
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
                title: "Здесь танцующая женщина",
                showConfirmButton: false,
            });
        }, 6000)

        setTimeout(function () {
            Swal.fire({
                title: "Трансляция недоступна",
                icon: "error",
                showConfirmButton: false
            });
        }, 10000)

        setTimeout(function () {
            Swal.fire({
                title: "Хотите продолжить просмотр?",
                showDenyButton: true,
                confirmButtonText: "Да",
                denyButtonText: "Нет",
                showCancelButton: false
            })
        }, 12000)





    });
</script>
<div class="wrap">
    <div style="display: flex; gap: 20px;">
        <iframe
            referrerpolicy="origin"
            width="50%"
            height="500"
            style="background: #FFFFFF;padding: 10px; border: none; border-radius: 5px; box-shadow:0 2px 4px 0 rgba(0,0,0,.2)"
            src="https://jika.io/embed/area-chart?symbol=AAPL&selection=one_year&closeKey=close&boxShadow=true&graphColor=1652f0&textColor=161c2d&backgroundColor=FFFFFF&fontFamily=Nunito"
        ></iframe>

        <iframe
            referrerpolicy="origin"
            width="50%"
            height="500"
            style="background: #FFFFFF;padding: 10px; border: none; border-radius: 5px; box-shadow:0 2px 4px 0 rgba(0,0,0,.2)"
            src="https://jika.io/embed/area-chart?symbol=AMZN&selection=one_year&closeKey=close&boxShadow=true&graphColor=1652f0&textColor=161c2d&backgroundColor=FFFFFF&fontFamily=Nunito"
        ></iframe>
    </div>

    <div style="display: flex; gap: 20px;">
        <iframe
            referrerpolicy="origin"
            width="50%"
            height="500"
            style="background: #FFFFFF;padding: 10px; border: none; border-radius: 5px; box-shadow:0 2px 4px 0 rgba(0,0,0,.2)"
            src="https://jika.io/embed/area-chart?symbol=TSLA&selection=one_year&closeKey=close&boxShadow=true&graphColor=1652f0&textColor=161c2d&backgroundColor=FFFFFF&fontFamily=Nunito"
        ></iframe>
        <iframe
            referrerpolicy="origin"
            width="50%"
            height="500"
            style="background: #FFFFFF;padding: 10px; border: none; border-radius: 5px; box-shadow:0 2px 4px 0 rgba(0,0,0,.2)"
            src="https://jika.io/embed/area-chart?symbol=META&selection=one_year&closeKey=close&boxShadow=true&graphColor=1652f0&textColor=161c2d&backgroundColor=FFFFFF&fontFamily=Nunito"
        ></iframe>
    </div>


</div>
</body>
</html>

