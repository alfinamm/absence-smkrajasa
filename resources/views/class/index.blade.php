@extends('layouts.master')
@section('title')
  @lang('Kelas')
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
      Kelas
    @endslot
    @slot('pagetitle')
      Daftar
    @endslot
  @endcomponent


  <div class="row">
    <div class="col-lg-12">
      <form method="POST" action="{{ route('class.store') }}">
        @csrf

        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-0">Tambah Tahun Ajaran Baru</h4>
            <p class="card-title-desc">Kamu bisa menambahkan tahun ajaran baru bila tidak ada. </p>
            <div class="row ">
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Nama <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" />
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Kode Kelas <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" />
                  @error('code')
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



  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-0">Kelas</h4>
          <p class="card-title-desc">Daftar kelas yang tersedia.</p>
          <div class="table-responsive mb-4">
            {{-- <table class="table table-centered table-nowrap mb-0"> --}}
            <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" style="border-collapse: collapse; border-spacing: 0rem; width: 100%;" aria-describedby="datatable_info">
              <thead>
                <tr>
                  <th scope="col">Nama</th>
                  <th scope="col">Kelas</th>
                  <th scope="col" style="width: 200px;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($classes as $item)
                  <tr>
                    <td>
                      <a href="#" class="text-body">{{ $item->name }}</a>
                    </td>
                    <td>
                      <a href="#" class="text-body">{{ $item->code }}</a>
                    </td>

                    <td>
                      <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                          <a href="{{ route('class.edit', ['class' => $item->id]) }}"
                            class="px-2 text-primary"><i class="uil uil-pen font-size-18"></i></a>
                        </li>
                        <li class="list-inline-item">
                          <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id}}"
                            class="px-2 text-danger border-0 bg-transparent"><i class="uil uil-trash-alt font-size-18"></i></button>
                            <div class="modal" id="deleteModal-{{ $item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Kelas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                        <form action="{{ route('class.destroy', ['class' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                            <p>Apakah anda ingin menghapus data <b>{{$item->name}}</b>?.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Delete</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                      </ul>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

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
@endsection
