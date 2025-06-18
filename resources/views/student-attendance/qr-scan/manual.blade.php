@extends('layouts.master-without-nav')
@section('title', 'Scan QR')

@section('content')
<div class="account-pages my-5 pt-sm-5">
  <div class="container">
    {{-- Logo --}}
    <div class="row">
      <div class="col-lg-12 text-center">
        <a href="{{ url('/') }}" class="mb-5 d-block auth-logo">
          <img src="{{ asset('assets/images/logo-dark.png') }}" alt="SMK Rajasa" width="200" class="logo logo-dark">
          <img src="{{ asset('assets/images/logo-light.png') }}" alt="SMK Rajasa" width="200" class="logo logo-light">
        </a>
      </div>
    </div>

    {{-- Card --}}
    <div class="row align-items-center justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card">
          <div class="card-body p-4">

            <div class="text-center mt-2">
              <h5 class="text-primary">Scan QR Siswa</h5>
              <p class="text-muted">
                Silakan scan QR Code dari kartu siswa menggunakan alat scanner.
              </p>
            </div>

            <div class="p-2 mt-4">
              @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
              @endif
              @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
              @endif

              {{-- === FORM SCAN === --}}
              <form id="scanForm" action="{{ route('scan-qrcode.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-3">
                  <label for="nisn" class="form-label">NISN</label>
                  <input  type="text"
                          name="nisn"
                          id="nisn"
                          class="form-control"
                          placeholder="Scan QR di sini"
                          minlength="8"
                          autofocus>
                </div>
              </form>
            </div>

          </div>
        </div>

        {{-- footer --}}
        <div class="mt-5 text-center">
          <p>© <script>document.write(new Date().getFullYear())</script> <i>SMK Rajasa.</i></p>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ===================== --}}
{{--  AUTO‑SUBMIT SCRIPT   --}}
{{-- ===================== --}}
<script>
(() => {
  const form  = document.getElementById('scanForm');
  const input = document.getElementById('nisn');

  // fokus kembali setiap reload
  window.onload = () => input.focus();

  // 1. Tangkap ENTER yang biasanya dikirim scanner
  input.addEventListener('keypress', e => {
    if (e.key === 'Enter') {
      e.preventDefault();   // cegah post bawaan
      form.submit();        // kirim manual
    }
  });

  // 2. Jika scanner TIDAK kirim Enter → submit setelah jeda
  const doneDelay   = 150;  // ms
  const minLength   = 10;   // panjang NISN
  let typingTimer;

  input.addEventListener('input', () => {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
      if (input.value.trim().length >= minLength) form.submit();
    }, doneDelay);
  });
})();
</script>
@endsection
