@extends('layouts.master')
@section('title')
  @lang('translation.Profile')
@endsection

@section('content')
  @component('common-components.breadcrumb')
    @slot('pagetitle')
      Contacts
    @endslot
    @slot('title')
      Profile
    @endslot
  @endcomponent

  <div class="row mb-4">
    <div class="col-xl-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="text-center">
            <div class="dropdown float-end">
              <a class="text-body dropdown-toggle font-size-18" href="#" role="button" data-bs-toggle="dropdown"
                aria-haspopup="true">
                <i class="uil uil-ellipsis-v"></i>
              </a>

              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="#">Edit</a>
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Remove</a>
              </div>
            </div>
            <div class="clearfix"></div>
            <div>
              <img src="{{ URL::asset('/assets/images/users/avatar-4.jpg') }}" alt=""
                class="avatar-lg rounded-circle img-thumbnail">
            </div>
            <h5 class="mt-3 mb-1">{{ $user->name }}</h5>
              ({{ $user->student?->name ?? ($user->employee?->name ?? 'Admin Sekolah') }})
            </p>
          </div>

          <hr class="my-4">

          <div class="text-muted">
            <div class="table-responsive mt-4">
              <div>
                <p class="mb-1">Name :</p>
                <h5 class="font-size-16">{{ $user->name }}</h5>
              </div>
              <div class="mt-4">
                <p class="mb-1">E-mail :</p>
                <h5 class="font-size-16">{{ $user->email }}</h5>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-8">
      <div class="card mb-0">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tasks" role="tab">
              <i class="uil uil-clipboard-notes font-size-20"></i>
              <span class="d-none d-sm-block">Ubah Password</span>
            </a>
          </li>
        </ul>
        <!-- Tab content -->
        <div class="tab-content p-4">
          <div class="tab-pane active" id="tasks" role="tabpanel">
            <form method="POST" action="{{ route('user.profile-edit') }}">
              @csrf
              <h4 class="card-title mb-0">Ubah Password</h4>
              <p class="card-title-desc">Anda bisa rubah password anda dengan masukan beberapa input dibawah. </p>
              <div class="row ">
                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Password Lama <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                      name="old_password" />
                    @error('old_password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" />
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Validasi Password Baru <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                      name="password_confirmation" />
                    @error('password_confirmation')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->
@endsection
