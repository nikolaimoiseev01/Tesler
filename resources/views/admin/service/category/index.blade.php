@extends('layouts.admin')

@section('title')Категории@endsection

@section('page-style')
@endsection
<style>
    .min-h-screen  {
        display: flex !important;
        align-items: center !important;;
    }
</style>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div style="align-items: flex-start;" class="row mb-2">
                <div class="d-flex">
                    <h1 class="m-0">@yield('title')</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @livewire('admin.service.category.category-index')
        </div>
    </section>

@endsection
