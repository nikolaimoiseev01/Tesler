<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="Tue, 14 Aug 2017 12:12:12 GMT">
    <meta http-equiv="Pragma" content="no-cache">
    <title>Tesler | Админ | @yield('title')</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">


    <link rel="stylesheet" href="/plugins/adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <link rel="stylesheet" href="/plugins/adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="/plugins/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/plugins/adminlte/dist/css/adminlte.min.css?v=3.2.0">

    <link rel="stylesheet" href="/plugins/filepond/filepond.css">
    <link rel="stylesheet" href="/plugins/filepond/filepond-plugin-image-preview.min.css">

    <link rel="stylesheet" href="/plugins/powergrid/powergrid.css">

    <link rel="apple-touch-icon" sizes="180x180" href="/media/media_fixed/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/media/media_fixed/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/media/media_fixed/favicon/favicon-16x16.png">
    <link rel="manifest" href="/media/media_fixed/favicon/site.webmanifest">
    <link rel="mask-icon" href="/media/media_fixed/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="/plugins/filepond/filepond-plugin-image-edit.css"
          filepond-plugin-image-edit.css
          rel="stylesheet">
    <link href="/plugins/adminlte/plugins/sweetalert2/sweetalert2.css" rel="stylesheet">
    <link  href="/plugins/cropperjs/cropper.css" rel="stylesheet">

    <style>
        .content {
            padding-bottom: 40px !important;
        }

        .filepond--item {
            width: fit-content;
        }
    </style>

    <style>
        .min-h-screen  {
            display: flex !important;
            align-items: center !important;;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/admin.scss', 'resources/js/app.js'])
    @livewireStyles
{{--    @powerGridStyles--}}
    <powerGrid:styles/>

    <style>
        .power-grid-table .form-check-input {
            position: inherit;
        }
    </style>

</head>
<body class="hold-transition sidebar-mini">

<div class="page-preloader-wrap">
    <div class="spinner">
        <span class="spinner-inner-1"></span>
        <span class="spinner-inner-2"></span>
        <span class="spinner-inner-3"></span>
    </div>
</div>


<div class="wrapper">


    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="{{route('home')}}" target="_blank" class="brand-link">
            <div class="logo">

                <svg id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127.91 28">
                    <defs>
                        <style>.cls-1 {
                                fill: #fff;
                            }</style>
                    </defs>
                    <path class="cls-1"
                          d="M115.63,16.55c.06.12.09.22.14.3l1,1.54c.49.74,1,1.49,1.46,2.23s.9,1.29,1.36,1.92.93,1.3,1.43,1.91c.36.44.77.81,1.15,1.22a4.48,4.48,0,0,0,2.17,1.24,3.34,3.34,0,0,0,2.16-.09l.87-.35c.15-.07.31-.13.48-.19a.29.29,0,0,1-.12.44,5.45,5.45,0,0,1-1.5.81l-.81.21a.5.5,0,0,0-.13,0,6.89,6.89,0,0,1-2.86.16,3.85,3.85,0,0,1-1.56-.55,7.48,7.48,0,0,1-2.24-2.1c-1.07-1.35-2.07-2.76-3-4.2-.74-1.11-1.46-2.22-2.18-3.34a.65.65,0,0,0-.65-.36c-.92,0-1.84,0-2.76,0l-.44,0c0,.16,0,.29,0,.41v8.09a2.92,2.92,0,0,0,.14,1,.85.85,0,0,0,.7.55,4,4,0,0,1,.5.1s.09.08.15.14c-.15.15-.31.1-.46.1h-4.87a2.16,2.16,0,0,1-.29-.08.54.54,0,0,1,.51-.25.89.89,0,0,0,.94-.82,4.89,4.89,0,0,0,.08-.85q0-6.88,0-13.76c0-1.36,0-2.73,0-4.09a3.47,3.47,0,0,0-.19-1.05.83.83,0,0,0-.74-.51c-.21,0-.43,0-.58-.23,0,0,.09-.08.14-.09a1.51,1.51,0,0,1,.3,0c2.6,0,5.2,0,7.8,0a8,8,0,0,1,2.37.31,4.73,4.73,0,0,1,2.55,1.71,3.74,3.74,0,0,1,.7,1.86,10.34,10.34,0,0,1,.07,1.11,5.45,5.45,0,0,1-.64,2.37,7.07,7.07,0,0,1-1.67,2.09,11.17,11.17,0,0,1-1,.77l-.38.27Zm-6.08-9.83v9.76c0,.25,0,.29.31.3.6,0,1.21,0,1.81,0a8.09,8.09,0,0,0,2-.18,4,4,0,0,0,3-2.32,4.52,4.52,0,0,0,.41-1.52,5.9,5.9,0,0,0-.28-2.32,8.26,8.26,0,0,0-.9-1.84,4.06,4.06,0,0,0-2.59-1.69,7,7,0,0,0-2.09-.19c-.52,0-1,0-1.62,0Z"/>
                    <path class="cls-1"
                          d="M28,17.23c0,.14,0,.24,0,.34v7.18a4.24,4.24,0,0,0,.21,1.18,1.39,1.39,0,0,0,1.39,1c.86,0,1.72.06,2.58.07h3.1c.41,0,.84-.09,1.24-.05a2,2,0,0,0,1.06-.25,1.44,1.44,0,0,0,.76-1c.08-.29.15-.58.24-.91.09.05.19.08.2.14a.93.93,0,0,1,.06.37c0,.7,0,1.41,0,2.11,0,.38,0,.4-.42.41h-14c-.17,0-.37.07-.52-.09.05-.21.21-.22.36-.24a2.74,2.74,0,0,0,.58-.15.89.89,0,0,0,.52-1c0-.14,0-.29,0-.43V8.58c0-.35,0-.69,0-1a3.87,3.87,0,0,0-.2-.83c-.08-.25-.32-.31-.55-.35s-.37,0-.55-.08-.1-.08-.19-.15a.81.81,0,0,1,.53-.1H37.45a14.91,14.91,0,0,1,0,3c-.18,0-.24-.14-.29-.3-.11-.37-.21-.74-.35-1.1s-.22-.57-.55-.66A1.36,1.36,0,0,0,36,6.9c-.43,0-.86-.07-1.29-.07H28.05c-.15.16-.1.32-.1.47V16c0,.15,0,.3,0,.5h6.27a10.86,10.86,0,0,0,1.28-.09c.33,0,.52-.26.6-.63.09.08.18.11.19.17a2,2,0,0,1,0,.43v1.29c0,.12,0,.22-.23.18L36,17.65a.65.65,0,0,0-.6-.42l-.6,0H28.35l-.38,0Z"/>
                    <path class="cls-1"
                          d="M84.51,6.12c.42-.1,13.3-.1,13.67,0a16,16,0,0,1,.07,2.69,1.92,1.92,0,0,1-.09.32c-.21-.09-.25-.26-.31-.42-.13-.41-.28-.81-.41-1.22a.79.79,0,0,0-.78-.56c-.53,0-1.06-.07-1.59-.07H88.66c0,.2,0,.35,0,.5v9c0,.2.06.24.27.26h6.29a7.72,7.72,0,0,0,1.07-.09.55.55,0,0,0,.49-.42c0-.13.11-.2.27-.14,0,0,0,.1,0,.15v1.59a.32.32,0,0,1,0,.17.18.18,0,0,1-.13.09s-.1,0-.13-.07,0-.11-.06-.16a.74.74,0,0,0-.62-.41l-.51,0H89l-.32,0a1.57,1.57,0,0,0,0,.3c0,2.43,0,4.87,0,7.31a3,3,0,0,0,.42,1.51.83.83,0,0,0,.29.3,2.39,2.39,0,0,0,.76.27,9.59,9.59,0,0,0,1.42.09H96c.51,0,1,0,1.54-.07A1.57,1.57,0,0,0,99,25.81c.07-.26.12-.53.19-.8a2,2,0,0,1,.1-.21c.2,0,.22.14.23.27v2.37c0,.31,0,.34-.35.36H85.05c-.17,0-.37.07-.53-.11a.54.54,0,0,1,.44-.23,3.41,3.41,0,0,0,.46-.1c.45-.13.55-.5.61-.89a4,4,0,0,0,0-.6q0-9,0-18.1a3.21,3.21,0,0,0-.19-1,.7.7,0,0,0-.65-.42,2.74,2.74,0,0,1-.5-.08s-.09-.09-.17-.18Z"/>
                    <path class="cls-1"
                          d="M62.8,6.12c.3-.07,5.4-.13,5.75-.07a.64.64,0,0,1,.16.1c-.07.07-.11.13-.17.14a4.54,4.54,0,0,1-.51.09,1,1,0,0,0-1,1c0,.27,0,.54,0,.81V23.39a6.52,6.52,0,0,0,.09,1.32,2.84,2.84,0,0,0,.64,1.34,2.17,2.17,0,0,0,.77.53,4.32,4.32,0,0,0,1.66.37c1,0,2,.06,3,.06a12.1,12.1,0,0,0,1.59-.08,3,3,0,0,0,1.7-.76A2.58,2.58,0,0,0,77.25,25a7.15,7.15,0,0,0,.34-2.1c0-.12,0-.24.15-.27s.18.08.18.28v4.69a1.68,1.68,0,0,1,0,.18,1.5,1.5,0,0,1-.29.06H63.39l-.59,0c.12-.12.16-.21.22-.22a3.53,3.53,0,0,1,.55-.1,1,1,0,0,0,.87-1q0-8.88,0-17.75a14.13,14.13,0,0,0-.07-1.46c0-.51-.25-.76-.88-.87-.18,0-.37,0-.55-.09s-.09-.08-.18-.17Z"/>
                    <path class="cls-1"
                          d="M1,8C.9,7.74.78,7.5.68,7.26.45,6.72.3,6.15,0,5.63a.21.21,0,0,1,.08-.29c.11.12.22.23.31.35A.87.87,0,0,0,1.09,6H16.63a2.43,2.43,0,0,0,.47,0,1,1,0,0,0,.82-.48c0-.07.12-.11.21-.21,0,.12,0,.19,0,.25a13.52,13.52,0,0,1-1,2.39C17,7.9,17,7.76,17,7.64c0-.71-.1-.82-.81-.83H10.79c-.36,0-.38,0-.39.4V25.13c0,.32,0,.63,0,.95a1.82,1.82,0,0,0,.17.83.78.78,0,0,0,.74.55,4.14,4.14,0,0,1,.6.09.8.8,0,0,1,.21.12.8.8,0,0,1-.21.12H6.62l-.44,0c.05-.27.24-.28.4-.31s.31,0,.46-.07c.57-.16.71-.62.76-1.12a8.23,8.23,0,0,0,0-.86V7.32c0-.15,0-.31,0-.48l-.36,0H2.17c-.24,0-.48,0-.72.07a.28.28,0,0,0-.28.32v.55a.65.65,0,0,1,0,.2L1,8Z"/>
                    <path class="cls-1"
                          d="M44.33,27.77V21.55s.05-.06.1-.12a1.23,1.23,0,0,1,.15.66,7.51,7.51,0,0,0,.28,1.77A3.73,3.73,0,0,0,46.36,26a5,5,0,0,0,1.93.76c.14,0,.28.06.42.09a1.89,1.89,0,0,0,.67.07c.4,0,.8.06,1.2.06a9.19,9.19,0,0,0,2.16-.26,4.54,4.54,0,0,0,3-2.51,3.85,3.85,0,0,0,.29-2.35A3.89,3.89,0,0,0,54,19.2a19.5,19.5,0,0,0-2.19-1c-.59-.26-1.22-.38-1.81-.65s-1.47-.62-2.19-1A4.49,4.49,0,0,1,46,14.9a7.2,7.2,0,0,1-.8-1.74A5.68,5.68,0,0,1,45,10.7a5.67,5.67,0,0,1,.82-2.23,5.75,5.75,0,0,1,2.56-2.22,6.69,6.69,0,0,1,2.79-.56A12.06,12.06,0,0,1,54,6a7.34,7.34,0,0,0,.84.18.57.57,0,0,1,.48.42L56,8.33c.06.14.12.29.17.44a1.29,1.29,0,0,1,0,.28,1.17,1.17,0,0,1-.25-.12l-.66-.68A5.73,5.73,0,0,0,53,6.79a6.09,6.09,0,0,0-2.75-.28,5.37,5.37,0,0,0-1.53.38,4.16,4.16,0,0,0-2.35,2.59,3.91,3.91,0,0,0-.08,2.32,3,3,0,0,0,1.16,1.71,7.88,7.88,0,0,0,1.87,1c.94.33,1.89.63,2.83,1,.67.25,1.32.54,2,.83a5.21,5.21,0,0,1,1.35,1,5.53,5.53,0,0,1,1.46,1.89,4.7,4.7,0,0,1,.44,1.68c0,.45,0,.89,0,1.34A4.56,4.56,0,0,1,57,24a6.43,6.43,0,0,1-2.42,2.94,4.28,4.28,0,0,1-1.54.58c-.67.12-1.34.17-2,.27a3,3,0,0,1-.43.05h-6l-.27,0Z"/>
                    <path class="cls-1"
                          d="M29.15,4.55c.13-.26.23-.48.34-.69.66-1.2,1.32-2.39,2-3.59A.4.4,0,0,1,31.85,0H34a.82.82,0,0,1,.22.06.76.76,0,0,1-.09.16c-.33.36-.64.73-1,1.06-1.05,1-2,2.05-3,3.05a.92.92,0,0,1-.93.21Z"/>
                    <path class="cls-1"
                          d="M94.93.11,93.19,1.87,91.37,3.74c-.16.16-.33.32-.48.49a.87.87,0,0,1-1,.32.83.83,0,0,1,.07-.27c.34-.62.69-1.24,1-1.86s.59-1.07.89-1.61c.1-.18.2-.37.29-.56A.4.4,0,0,1,92.53,0h2.15c.06,0,.12,0,.25.11Z"/>
                </svg>
            </div>

        </a>

        <div class="sidebar">

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Модель услуг
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left:30px; display: none;">
                            <li class=" nav-item">
                                <a href="{{route('scope.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Сферы</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('category.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Категории</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('group.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Группы</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('service.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Услуги</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Модель товаров
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left:30px; display: none;">
                            <li class=" nav-item">
                                <a href="{{route('good_category.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Категории товаров</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('good.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Товары</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('order.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-percent"></i>
                            <p>
                                Заказы
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{route('staff.index')}}" class="nav-link">
                            <i class="nav-icon fa-solid fa-user-nurse"></i>
                            <p>
                                Сотрудники
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{route('promo.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-percent"></i>
                            <p>
                                Промо-акции
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{route('iterior_photo.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-image"></i>
                            <p>
                                Фото интерьера
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('consultationy.index')}}" class="nav-link">
                            <i class="nav-icon fa-brands fa-rocketchat"></i>
                            <p>
                                Консультации
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Калькуляторы
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left:30px; display: none;">
                            <li class="nav-item">
                                <a href="{{route('calc_cosmetic.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Косметология</p>
                                </a>
                            </li>

                            <li class=" nav-item">
                                <a href="vk.com" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Сферы</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                            Выход
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>

        </div>

    </aside>

    <div class="content-wrapper">


        @yield('content')

    </div>

</div>


<!-- include jQuery library -->
<script src="/plugins/adminlte/plugins/jquery/jquery.min.js"></script>

<!-- include jQuery UI library -->
<script src="/plugins/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- include Main ADMIN LTE -->
<script src="/plugins/adminlte/dist/js/adminlte.min.js?v=3.2.0"></script>

<!-- include Main ADMIN LTE -->
{{--<script src="/plugins/jquery.js"></script>--}}


@livewireScripts
{{--@powerGridScripts--}}
@livewire('livewire-ui-modal')

<!-- include BOOTSTRAP JS -->
<script src="/plugins/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- include Custom-file-input -->
<script src="/plugins/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- include SELECT2  -->
<script src="/plugins/adminlte/plugins/select2/js/select2.full.min.js"></script>


{{--<!--  Сторонние JS -->--}}
<script src="/plugins/adminlte/plugins/sweetalert2/sweetalert2.js"></script>
<script src="/plugins/alpinejs/alpinejs.js" defer></script>
<script src="/plugins/powergrid/powergrid.js"></script>
<script src="/plugins/cropperjs/cropper.js"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    // Общее обознаение вызова SWAL (LIVEWIRE)
    window.addEventListener('toast_fire', event => {
        Toast.fire({
            icon: event.detail.type,
            title: event.detail.title
        })
    })

    // Общее обознаение вызова SWAL (LIVEWIRE)
    window.addEventListener('swal_fire', event => {
        Swal.fire({
            title: event.detail.title,
            icon: event.detail.type,
            html: '<p>' + event.detail.text + '</p>',
            showDenyButton: event.detail.showDenyButton,
            showConfirmButton: event.detail.showConfirmButton,
            showCancelButton: false,
            confirmButtonText: `Все верно`,
            denyButtonText: `Отменить`,
        }).then((result) => {
            if (result.isConfirmed) {
                window.livewire.emit(event.detail.swal_function_to_confirm,
                    event.detail.swal_detail_id)
            }
        })
    })

    // Общее обознаение вызова SWAL (REFRESH PAGE)
    @if (session('swal_fire') == 'yes')
    Swal.fire({
        type: '{{session('swal_type')}}',
        title: '{{session('swal_title')}}',
        icon: '{{session('swal_type')}}',
        html: '<p>{{session('swal_text')}}</p>',
        showDenyButton: false,
        showCancelButton: false,
        showConfirmButton: false,
    })
    @endif


</script>
<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>

<!-- ---------- FILEPOND ---------- -->
<!-- include FilePond library -->
<script src="/plugins/filepond/filepond.js"></script>
<!-- include FilePond jQuery adapter -->
<script src="/plugins/filepond/filepond.jquery.js"></script>
<!-- include FilePond plugins -->
<script src="/plugins/filepond/filepond-plugin-image-preview.js"></script>
<script src="/plugins/filepond/filepond-plugin-image-validate-size.js"></script>
<script src="/plugins/filepond/filepond-plugin-file-validate-size.js"></script>
<script src="/plugins/filepond/filepond-plugin-file-validate-type.js"></script>
<script src="/plugins/filepond/filepond-plugin-image-resize.js"></script>
<script src="/plugins/filepond/filepond-plugin-image-transform.js"></script>
<script src="/plugins/filepond/filepond-plugin-image-edit.js"></script>


<script>

    // First register any plugins
    FilePond.registerPlugin(
        FilePondPluginFileValidateType, // для определения типа файла
        FilePondPluginImagePreview, // для создания превью изображения
        FilePondPluginImageValidateSize, // для определения размера изображения
        FilePondPluginFileValidateSize, // для определения размера файла в целом
        FilePondPluginImageResize, // для изменения размера изображения
        FilePondPluginImageTransform // для изменения размера изображения
        // FilePondPluginImageEdit,
        // FilePondPluginImageExifOrientation,
    );
</script>
<!-- ---------- ////////  FILEPOND ---------- -->

<!-- include CUSTOM ADMIN JS -->
<script src="/js/admin.js"></script>

@stack('scripts')

</body>
</html>
