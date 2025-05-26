@extends('layouts.master')
@section('title')
  @lang('Role')
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
      Role
    @endslot
    @slot('pagetitle')
      <a href="{{ route('role.index') }}">
        Ubah Data
      </a>
    @endslot
  @endcomponent


  <div class="row">
    <div class="col-lg-12">
      <form method="POST" action="{{ route('role.update', ['role' => $role->id]) }}">
        @csrf

        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-0">Ubah Role</h4>
            <p class="card-title-desc">Kamu bisa mengubah role bila ada kesalahan. </p>
            <div class="row ">
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Nama</label>
                  <input type="text" value="{{ $role->name }}"
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
                  <input type="text" value="{{ $role->description }}"
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
                  <label class="form-label">Subjek</label>
                  <input type="text" value="{{ $role->subject }}"
                    class="form-control @error('subject') is-invalid @enderror" name="subject" />
                  @error('subject')
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
