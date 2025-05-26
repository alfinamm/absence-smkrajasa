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
      Daftar
    @endslot
  @endcomponent


  <div class="row">
    <div class="col-lg-12">
      <form method="POST" action="{{ route('academic-year.store') }}">
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
                  <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('description') is-invalid @enderror"
                    name="description" />
                  @error('description')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Semester <span class="text-danger">*</span></label>
                  <select name="semester" class="form-control select2 @error('semester') is-invalid @enderror">
                    <option value="1">Ganjil</option>
                    <option value="2">Genap</option>
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
                  <label class="form-label">Periode <span class="text-danger">*</span></label>
                  <div class="input-daterange input-group" id="range-semester-2102910" data-date-format="yyyy-mm-dd"
                    data-date-autoclose="true" data-provide="datepicker" data-date-container='#range-semester-2102910'>
                    <input type="text" class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                      placeholder="Start Date" />
                    <input type="text" class="form-control @error('end_date') is-invalid @enderror" name="end_date"
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
                  <select name="status" class="form-control select2 @error('status') is-invalid @enderror">
                    <option value="0">Tidak Aktif</option>
                    <option value="1">Aktif</option>
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
        </div>
      </form>
    </div>
  </div>



  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-0">Tahun Ajaran</h4>
          <p class="card-title-desc">Daftar tahun ajaran yang tersedia.</p>
          <div class="table-responsive mb-4">
            {{-- <table class="table table-centered table-nowrap mb-0"> --}}
            <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" style="border-collapse: collapse; border-spacing: 0rem; width: 100%;" aria-describedby="datatable_info">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Periode</th>
                  <th scope="col">Semester</th>
                  <th scope="col">Status</th>
                  <th scope="col" style="width: 200px;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($academicYears as $item)
                  <tr>
                    <td>
                      <a href="#" class="text-body">{{ $item->name }}</a>
                    </td>
                    <td>
                      {{ date('d M Y', strtotime($item->start_date)) }} s/d
                      {{ date('d M Y', strtotime($item->end_date)) }}
                    </td>
                    <td>
                      @if ($item->semester === 1)
                        <span class="badge text-bg-warning">Ganjil</span>
                      @else
                        <span class="badge text-bg-info">Genap</span>
                      @endif
                    </td>
                    <td>
                      @if ($item->status === 1)
                        <span class="badge text-bg-success">Aktif</span>
                      @else
                        <span class="badge text-bg-secondary">Tidak Aktif</span>
                      @endif
                    </td>

                    <td>
                      <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                          <a href="{{ route('academic-year.edit', ['academicYear' => $item->id]) }}"
                            class="px-2 text-primary"><i class="uil uil-pen font-size-18"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id}}"
                            class="px-2 text-danger border-0 bg-transparent"><i class="uil uil-trash-alt font-size-18"></i></button>
                            <div class="modal" id="deleteModal-{{ $item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Tahun Ajaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                        <form action="{{ route('academic-year.destroy', ['academicYear' => $item->id]) }}" method="POST">
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
