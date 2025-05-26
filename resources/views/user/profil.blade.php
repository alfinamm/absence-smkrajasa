@extends('layouts.master')
@section('title')
  @lang('User')
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
      Profil
    @endslot
    @slot('pagetitle')
      View
    @endslot
  @endcomponent

  <div class="row mb-4">
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-center">
                    <div class="clearfix"></div>
                    <div>
                        <img src="{{ URL::asset('/assets/images/users/avatar-4.jpg') }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                    </div>
                    <h5 class="mt-3 mb-1">Marcus</h5>
                    <p class="text-muted">UI/UX Designer</p>
                </div>

                <hr class="my-4">

                <div class="text-muted">
                    <div class="table-responsive mt-4">
                        <div>
                            <p class="mb-1">Name :</p>
                            <h5 class="font-size-16"></h5>
                        </div>
                        <div class="mt-4">
                            <p class="mb-1">Mobile :</p>
                            <h5 class="font-size-16">012-234-5678</h5>
                        </div>
                        <div class="mt-4">
                            <p class="mb-1">E-mail :</p>
                            <h5 class="font-size-16"></h5>
                        </div>
                        <div class="mt-4">
                            <p class="mb-1">Location :</p>
                            <h5 class="font-size-16">California, United States</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card mb-0">
            <!-- Tab content -->
            <form action="">
                <div class="tab-content p-4">
                    <div class="tab-pane active" id="about" role="tabpanel">
                        <div>
                            <div>
                                <h5 class="font-size-16 mb-4">Update Password</h5>
                                <div class="row ">
                                    <div class="col-lg-10">
                                        <div class="mb-3">
                                        <label class="form-label">Last Password <span class="text-danger">*</span></label>
                                        <input type="password" value="" class="form-control @error('password') is-invalid @enderror" name="password" />
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="mb-3">
                                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                                        <input type="password" value="" class="form-control @error('password') is-invalid @enderror" name="password" />
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>

            </form>
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
