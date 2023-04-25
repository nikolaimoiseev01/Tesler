@extends('layouts.admin')

@section('title')Курсы@endsection

@section('page-style')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div style="align-items: flex-start;" class="row mb-2">
                <div class="d-flex">
                    <h1 class="ml-3">@yield('title')</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">


            <div style="max-width: 1000px;" class="card">
                <a onclick='Livewire.emit("openModal", "admin.course.course-create")'
                   class="w-100 btn btn-outline-secondary">
                <span>
                    <i class="mr-2 fa fa-plus"></i>
                        Добавить
                </span>
                </a>
                <div class="card-body p-0">
                    <ul wire:sortable="updateOrder" class="products-list product-list-in-card pl-2 pr-2" tabindex="0">
                        @foreach($courses as $course)
                            <li x-data="{ open_2: false }" wire:sortable.item="2" wire:key="promo-2" class="item"
                                tabindex="0">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 product-img">
                                        <img style="width: auto;"
                                             src="{{$course->getFirstMediaUrl('course_main_pic')}}"
                                             alt="">
                                    </div>

                                    <div class="ml-0 mr-3 product-info">
                                        <a href="{{route('course.edit', $course['id'])}}" class="product-title">{{$course['title']}}</a>
                                        <span style="white-space: inherit;" class="product-description">{{$course['desc_small']}}</span>
                                    </div>
                                    <div class="ml-auto mr-3">
                                        <a href="{{route('course.edit', $course['id'])}}" class="mr-3">
                                            <i style="font-size: 18px;" class="fa-solid grey_icon fa-pen-to-square"></i>
                                        </a>
{{--                                        <a>--}}
{{--                                            <i style="font-size: 18px;" wire:click.prevent="delete_confirm(2)"--}}
{{--                                               class="fas grey_icon fa-trash-alt"></i>--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </section>

@endsection
