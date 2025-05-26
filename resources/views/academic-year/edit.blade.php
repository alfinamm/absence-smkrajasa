@extends('layouts.master')
@section('title')
  @lang('Tahun Ajaran')
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
      Tahun Ajaran
    @endslot
    @slot('pagetitle')
      <a href="{{ route('academic-year.index') }}">
        Ubah Data
      </a>
    @endslot
  @endcomponent


  <div class="row">
    <div class="col-lg-12">
      <form method="POST" action="{{ route('academic-year.update', ['academicYear' => $academicYear->id]) }}">
        @csrf

        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-0">Ubah Tahun Ajaran</h4>
            <p class="card-title-desc">Kamu bisa mengubah tahun ajaran bila ada kesalahan. </p>
            <div class="row ">
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Nama</label>
                  <input type="text" value="{{ $academicYear->name }}"
                    class="form-control @error('name') is-invalid @enderror" name="name" />
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Deskripsi</label>
                  <input type="text" value="{{ $academicYear->description }}"
                    class="form-control @error('description') is-invalid @enderror" name="description" />
                  @error('description')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Semester</label>
                  <select name="semester" class="form-control select2 @error('semester') is-invalid @enderror">
                    <option value="1" {{ intval($academicYear->semester) === 1 ? 'selected' : '' }}>Ganjil</option>
                    <option value="2" {{ intval($academicYear->semester) === 2 ? 'selected' : '' }}>Genap</option>
                  </select>
                  @error('semester')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Periode</label>
                  <div class="input-daterange input-group" id="range-semester-2102910" data-date-format="yyyy-mm-dd"
                    data-date-autoclose="true" data-provide="datepicker" data-date-container='#range-semester-2102910'>
                    <input type="text" value="{{ date('Y-m-d', strtotime($academicYear->start_date)) }}"
                      class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                      placeholder="Start Date" />
                    <input type="text" value="{{ date('Y-m-d', strtotime($academicYear->end_date)) }}"
                      class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                      placeholder="End Date" />
                  </div>
                  @error('start_date')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                  @error('end_date')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-control select2 @error('status') is-invalid @enderror"
                    id="form-status">
                    <option value="0" {{ $academicYear->status === 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="1" {{ $academicYear->status === 1 ? 'selected' : '' }}>Aktif</option>
                  </select>
                </div>
                @error('status')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
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
