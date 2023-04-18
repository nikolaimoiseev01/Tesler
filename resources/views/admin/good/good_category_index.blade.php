@extends('layouts.admin')

@section('title')Категории товаров@endsection

@section('page-style')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div style="align-items: flex-start;" class="row mb-2">
                <div class="d-flex">
                    <h1 class="ml-2">@yield('title')</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @livewire('admin.good.category.category-index')
        </div>
    </section>

@endsection
