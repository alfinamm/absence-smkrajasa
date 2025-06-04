
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Scan QR untuk Absen</h2>
    <div id="reader" width="600px"></div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const scanner = new Html5Qrcode("reader");
    scanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        (decodedText, decodedResult) => {
            fetch("{{ route('qr.scan') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ nisn: decodedText })
            })
            .then(res => res.json())
            .then(data => alert(data.message));
        },
        errorMessage => {
            // ignore scan errors
        }
    );
</script>
@endsection
