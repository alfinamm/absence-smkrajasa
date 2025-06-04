<h2>Scan QR (via alat scanner)</h2>

@if(session('success'))
    <div style="color:green">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="color:red">{{ session('error') }}</div>
@endif

<form action="{{ route('scan-qrcode.store') }}" method="POST">
    @csrf
    <input type="text" name="nisn" id="nisn" autofocus autocomplete="off" placeholder="Scan QR di sini">
</form>

<script>
    // Fokus ulang otomatis setiap kali input selesai
    document.getElementById('nisn').focus();
</script>
