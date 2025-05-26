@extends('layouts.master')
@section('title')
  @lang('Absensi')
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
    @slot('pagetitle')
      Scanner
    @endslot
    @slot('title')
      Absensi
    @endslot
  @endcomponent

  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="card h-80">
        <div class="card-body">
          <form action="{{ route('absence.index') }}" method="GET">
            <div class="mb-3" style="margin-right: 20px; width: 100;">
              <h5 style="text-align: center;">Tahun Ajaran</h5>
              <select name="academic_year_id" class="form-control select2 @error('academic_year_id') is-invalid @enderror"
                id="academic_year_id">
                <option value="">Pilih tahun ajaran</option>
                @foreach ($academicYears as $academicYear)
                  <option @if ($academic_year_id === $academicYear->id) selected @endif value="{{ $academicYear->id }}"
                    data-start="{{ Carbon\Carbon::parse($academicYear->start_date)->format('Y-m-d') }}"
                    data-end="{{ Carbon\Carbon::parse($academicYear->end_date)->format('Y-m-d') }}">
                    {{ $academicYear->name }} </option>
                @endforeach
              </select>
            </div>
            <div class="mb-3" style="margin-right: 20px;">
              <h5 style="text-align: center;">Tanggal</h5>
              <div class="" id="datepicker1" style="display: flex;">
                <div style="flex: 1;">
                  {{-- <input type="text" name="date" class="form-control" value="{{ $date }}" id="date-filter"
                    placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd " data-date-container='#datepicker1'
                    data-provide="datepicker" readonly> --}}
                    <input type="text" name="date" class="form-control" value="{{ $date }}" id="date-filter" placeholder="yyyy-mm-dd" >
                </div>
                <div>
                  <span class="form-control" id="date-icon"><i class="fas fa-calendar-alt"></i></span>
                </div>
              </div><!-- input-group -->
            </div>
            <div class="" style="margin-top: 13px">
              <button style="width:100%" type="submit" class="btn btn-secondary ">Buka Absen</button>
            </div>
          </form>
          <hr class="my-4">
        </div>
      </div>
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
  <script>
    flatpickr('#date-filter', {
        dateFormat: "d-m-Y",
        defaultDate: new Date()
    });
</script>
@endsection
