@extends('layouts.admin')

@section('title'){{$staff['yc_name']}}@endsection

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
                <div class="align-items-center gap-3 d-flex">
                    <h1 class="ml-2">@yield('title')</h1>
                    <img style="border-radius: 50%; max-width: 50px;" src="{{$staff['yc_avatar']}}" alt="">
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @livewire('admin.staff.staff-edit', ['staff_id' => $staff->id])
        </div>
    </section>

@endsection
