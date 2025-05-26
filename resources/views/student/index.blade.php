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
      Daftar
    @endslot
  @endcomponent

  @if (auth()->user()->hasAccess(['student' => 'create']))
    <div class="row">
      <div class="col-lg-12">
        <form method="POST" action="{{ route('student.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-0">Tambah Murid</h4>
              <p class="card-title-desc">Kamu bisa menambahkan murid bila tidak ada. </p>
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
                    <label class="form-label">NISN <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn" />
                    @error('nisn')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                    <select name="class_id" class="form-control select2 @error('class_id') is-invalid @enderror">
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}"> {{ $class->code }} </option>
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
                    <label class="form-label">Foto<span class="text-danger"> (3x4)*</span></label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" />
                    @error('image')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">WhatsApp Orang Tua (+62)<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('wa_ortu') is-invalid @enderror" name="wa_ortu" />
                    @error('wa_ortu')
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
  @endif
  <div class="row">
      <div class="col-lg-12">
        <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-0">Import Data Murid</h4>
              <p class="card-title-desc">Kamu bisa import murid bila tidak ada. </p>
              <div class="row ">
                <div class="form-group">
                <label for="file">CSV File</label>
                <input type="file" name="file" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Import</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-0">Murid</h4>
          <p class="card-title-desc">Daftar murid yang tersedia.</p>
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="table-responsive mb-4">
            {{-- <table class="table table-centered table-nowrap mb-0"> --}}
            <table id="datatable"
              class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed"
              style="border-collapse: collapse; border-spacing: 0rem; width: 100%;" aria-describedby="datatable_info">
              <thead>
                <tr>
                  <th scope="col">Foto</th>
                  <th scope="col">Name</th>
                  <th scope="col">NISN</th>
                  <th scope="col">Kelas</th>
                  <th scope="col">WhatsApp Orang Tua</th>
                  <th scope="col" style="width: 12.5rem;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($students as $item)
                  <tr>
                    <td>
                      <img src="{{ url('storage/images/' . $item->image) }}" alt="Belum Ada Gambar" class="img-thumbnail"
                        style="width:100px" />
                    </td>
                    <td>
                      <a href="#" class="text-body">{{ $item->name }}</a>
                    </td>
                    <td>
                      {{-- <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->nisn, 'C39', 2, 50) }}"
                        alt="barcode" style="width: 150px"> --}}

                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($item->nisn, 'QRCODE', 5, 5) }}"
                            alt="qrcode" style="width: 150px">
                      <p>- {{ $item->nisn }}</p>
                    </td>
                    <td>
                      <a href="#" class="text-body">{{ $item->class?->code ?? 'Belum Ada Kelas' }}</a>
                    </td>
                    <td>
                      <a href="#" class="text-body">{{ $item->wa_ortu }}</a>
                    </td>

                    <td>
                      <ul class="list-inline mb-0">
                        @if (auth()->user()->hasAccess(['student' => 'update']))
                          <li class="list-inline-item">
                            <a href="{{ route('student.edit', ['student' => $item->id]) }}"
                              class="px-2 text-primary"><i class="uil uil-pen font-size-18"></i></a>
                          </li>
                        @endif
                        <li class="list-inline-item">
                          <a href="{{ route('download.barcode', ['nisn' => $item->nisn]) }}"
                            class="px-2 text-primary"><i class="uil uil-arrow-down font-size-18"></i></a>
                        </li>
                        @if (auth()->user()->hasAccess(['student' => 'delete']))
                          <li class="list-inline-item">
                            <button type="button" data-bs-toggle="modal"
                              data-bs-target="#deleteModal-{{ $item->id }}"
                              class="px-2 text-danger border-0 bg-transparent"><i
                                class="uil uil-trash-alt font-size-18"></i></button>
                            <div class="modal" id="deleteModal-{{ $item->id }}" tabindex="-1"
                              aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Hapus Murid</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                      aria-label="Close"></button>
                                  </div>
                                  <form action="{{ route('student.destroy', ['student' => $item->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                      <p>Apakah anda ingin menghapus data <b>{{ $item->name }}</b>?.</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Delete</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </li>
                        @endif
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
