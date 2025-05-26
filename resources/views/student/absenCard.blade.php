<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    body {
      background-color: transparent;
      font-family: 'verdana';
    }

    .id-card-holder {
      width: 225px;
      padding: 4px;
      margin: 0 auto;
    }

    .id-card {
      height: 280px;
      background-image: url('../public/assets/images/bg-card2.jpg');
      background-size: cover;
      background-color: #cccccc;
      padding: 10px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 0 1.5px 0px #b9b9b9;
    }

    .id-card img {
      margin: 0 auto;
    }

    .header img {
      width: 100px;
      margin-top: 15px;
    }

    .photo img {
      border: 2px solid;
      box-shadow: 5px 10px 8px #000000;
      border-radius: 10%;
      width: 90px;
      margin-top: 15px;
      margin-bottom: 15px;
    }

    h2 {
      font-size: 15px;
      margin: 5px 0;
    }

    h3 {
      font-size: 12px;
      margin: 2.5px 0;
      font-weight: 300;
    }

    p {
      font-size: 5px;
      margin: 2px;
    }

    .center-container {
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="id-card-holder">
    <div class="id-card">
      <div class="header">
        <img src="{{ $logo }}">
      </div>
      <div class="photo">
        <img src="{{ $image }}">
      </div>
      <b style="font-size: 3mm">{{ $student->name }}</b>
      <p style="font-size: 2mm">nisn-{{ $student->nisn }}</p>
      <p style="font-size: 3mm">{{ $student->class?->code }}</p>


      <hr>
      <p><strong>"SMK Rajasa Surabaya"</strong>Sekolah,4th Floor
      <p>
      <p>Jl. Genteng Kali No.27, Genteng, Kec. Genteng, Surabaya, Jawa Timur Indonesia <strong>60275</strong></p>
      <p>Ph: (031) 5344810 | E-mail: smkrjs.sby@smkrajasa.sch.id</p>

    </div>
  </div>

  <div class="id-card-holder">
    <div class="id-card">
      <p style="margin-bottom: 15px"><b style="font-size: 4mm; "> Kartu Absensi</b></p>
      <ol style="padding-left: 20px;">
        <li style="font-size: 3mm; text-align: justify; margin-bottom: 5px; ">Kartu ini berlaku selama pemegang menjadi
          siswa di SMK Rajasa Surabaya</li>
        <li style="font-size: 3mm; text-align: justify; margin-bottom: 5px; ">Kartu ini jangan sampai hilang atau di
          titipkan kepada teman</li>
        <li style="font-size: 3mm; text-align: justify; margin-bottom: 5px; ">Jika Kartu ini hilang/rusak harap segera
          melapor ke Petugas Absensi SMK Rajasa Surabaya</li>
        <li style="font-size: 3mm; text-align: justify; margin-bottom: 30px; ">Terimakasih bagi yang menemukan kartu ini
          mihon di kembalikan ke petugas absensi SMK Rajasa Surabaya</li>
      </ol>
      <hr style="margin-bottom: 15px;">
      <div class="center-container">
        <img style="width: 180px" src="data:image/png;base64,{{ DNS1D::getBarcodePNG($student->nisn, 'C39', 2, 50) }}"
          alt="barcode">
      </div>
    </div>
  </div>
</body>

</html>
