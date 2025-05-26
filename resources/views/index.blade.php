@extends('layouts.master')
@section('title') @lang('Dashboard') @endsection
@section('content')
@component('common-components.breadcrumb')
@slot('pagetitle') Absensi @endslot
@slot('title') Dashboard @endslot
@endcomponent

@if (auth()->user()->hasAccess(['student' => 'update']))
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $academicYear }}</span></h4>
                    <p class="text-muted mb-0">Total Tahun Ajaran</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="orders-chart" data-colors='["--bs-success"]'> </div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $student }}</span></h4>
                    <p class="text-muted mb-0">Total Murid</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="customers-chart" data-colors='["--bs-primary"]'> </div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $employee }}</span></h4>
                    <p class="text-muted mb-0">Total Pengguna</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">

        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="growth-chart" data-colors='["--bs-warning"]'></div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $class }}</span></h4>
                    <p class="text-muted mb-0">Total Kelas</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
    @endif

</div> <!-- end row-->
 <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h1 style="text-align: center">Selamat Datang</h1>
                </div>
                <div class="">
                    <img src="{{URL::asset('assets/images/rajasa.png')}}" class="img-fluid" style="width: 1200px; padding: 20px" alt="Responsive image">
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
