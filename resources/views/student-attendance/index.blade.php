@extends('layouts.master')
@section('title')
  @lang('Kehadiran Murid')
@endsection
@section('css')
  <!-- plugin css -->
  <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ URL::asset('/assets/libs/datepicker/datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
  @component('common-components.breadcrumb')
    @slot('title')
      Kehadiran
    @endslot
    @slot('pagetitle')
      Daftar
    @endslot
  @endcomponent

  <div class="row">
    @foreach ($classes as $item)
      <div class="col-lg-4">
        <div class="card">
          <h4 class="card-header">{{ $item->name }} <span>({{ $item->code}})</span></h4>
          <div class="card-body">
            <h4 class="card-title">Cek Absensi Siswa</h4>
            <p class="card-text">Jumlah siswa di kelas ini {{ sizeof($item->students) }}.</p>
            <a href="{{ route('student-attendance.show', ['class' => $item->id]) }}" class="btn btn-primary">Lihat
              Data</a>
          </div><!-- end cardbody -->
        </div><!-- end card -->
      </div><!-- end col -->
    @endforeach
    <div class="col-lg-12">
      {{ $classes->links('pagination::bootstrap-4') }}
    </div>
  </div>
  <!-- end row -->
@endsection
@section('script')
  <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
@endsection
