@extends('layouts.master-without-nav')
@section('title')
  Scan QR
@endsection

@section('content')
  <div class="account-pages my-5 pt-sm-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <a href="{{ url('/') }}" class="mb-5 d-block auth-logo">
            <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" width="200" class="logo logo-dark">
            <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" width="200" class="logo logo-light">
          </a>
          </div>
        </div>
      </div>

      <div class="row align-items-center justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card">
            <div class="card-body p-4">

              <div class="text-center mt-2">
                <h5 class="text-primary">Scan QR Siswa</h5>
                <p class="text-muted">Silakan scan QR Code dari kartu siswa menggunakan alat scanner.</p>
              </div>

              <div class="p-2 mt-4">
                @if(session('success'))
                  <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                  <div class="alert alert-danger text-center">{{ session('error') }}</div>
                @endif

                <form action="{{ route('scan-qrcode.store') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" name="nisn" id="nisn" class="form-control" placeholder="Scan QR di sini" autofocus autocomplete="off">
                  </div>
                </form>
              </div>

            </div>
          </div>

          <div class="mt-5 text-center">
            <p>© <script>document.write(new Date().getFullYear())</script> <i>SMK Rajasa.</i></p>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script>
    // Fokus otomatis ke input setiap kali halaman dimuat
    document.getElementById('nisn').focus();
  </script>
@endsection
