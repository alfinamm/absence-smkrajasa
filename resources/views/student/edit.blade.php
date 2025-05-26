@extends('layouts.master')
@section('title')
  @lang('Murid')
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
      <form method="POST" action="{{ route('student.update', ['student' => $student->id]) }}" enctype="multipart/form-data">
        @csrf

        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-0">Ubah Murid</h4>
            <p class="card-title-desc">Kamu bisa mengubah murid bila ada kesalahan. </p>
            <div class="row ">
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Nama</label>
                  <input type="text" value="{{$student->name}}" class="form-control @error('name') is-invalid @enderror" name="name" />
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">NISN</label>
                  <input type="text" value="{{$student->nisn}}" class="form-control @error('nisn') is-invalid @enderror" name="nisn" />
                  @error('nisn')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Kelas</label>
                  <select name="class_id" class="form-control select2 @error('class_id') is-invalid @enderror">
                    @foreach ($classes as $class)
                    <option value="{{$class->id}}" @if($class->id == $student->class_id) selected @endif> {{$class->code}} </option>
                    @endforeach
                  </select>
                  @error('user_id')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" value="{{ $student->image }}" class="form-control @error('image') is-invalid @enderror" name="image" />
                    @error('image')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                    @if($student->image)
                      <img src="{{ asset('storage/images/' . $student->image) }}" class="img-thumbnail" style="width:100px" />
                    @endif
                  </div>
                </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">WhatsApp Orang Tua</label>
                  <input type="text" name="wa_ortu" value="{{ old('wa_ortu', $student->wa_ortu) }}" class="form-control @error('wa_ortu') is-invalid @enderror" placeholder="Contoh: +6281234567890">
                  @error('wa_ortu')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
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
    $(document).ready(function () {
        $('#lang').select2({}); // Initialize select2
    })
  </script>
  <script>
    $("#lang").val('asp').trigger('change');
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