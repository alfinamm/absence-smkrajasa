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
      Murid
    @endslot
    @slot('pagetitle')
      <a href="{{ route('student.index') }}">
        Ubah Data
      </a>
    @endslot
  @endcomponent


  <div class="row">
    <div class="col-lg-12">
      <form method="POST" action="{{ route('student-attendance.update', ['class' => $class->id,'student' => $student->id]) }}">
        @csrf

        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-0">Ubah Kehadiran</h4>
            <p class="card-title-desc">Kamu bisa mengubah murid bila ada kesalahan. </p>
            <div class="row ">
              <div class="col-lg-4">
                <div class="mb-3">
                <input type="hidden" name="id" value="{{$studentAttendance->id}}">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-control select2 @error('status') is-invalid @enderror">
                    <option value="" >--Pilih status--</option>
                    <option value="0" {{$studentAttendance->status==0?"selected":""}}>Alfa</option>
                    <option value="1" {{$studentAttendance->status==1?"selected":""}}>Hadir</option>
                    <option value="2" {{$studentAttendance->status==2?"selected":""}}>Telat</option>
                    <option value="3" {{$studentAttendance->status==3?"selected":""}}>Izin</option>
                    <option value="4" {{$studentAttendance->status==4?"selected":""}}>Sakit</option>

                  </select>
                  @error('status')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>


  <!-- end row -->
@endsection
@section('script')
  <script>
    $("#lang").select2().select2('val', 'asp');
  </script>
  <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
@endsection
