@extends('layouts.master')
@section('title')
  @lang('Absensi')
@endsection

@section('content')
  @component('common-components.breadcrumb')
    @slot('pagetitle')
      Scanner
    @endslot
    @slot('title')
      Absensi
    @endslot
  @endcomponent

  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="card h-80">
        <div class="card-body">
          <div class="text-center">

            <div class="clearfix"></div>
            <div>
              <img src="{{ URL::asset('/assets/images/users/avatar-6.jpg') }}" alt=""
                class="avatar-lg rounded-circle img-thumbnail" id="student-image" style="object-fit: contain">
            </div>
            <h5 class="mt-3 mb-1" id="student-name">Nama Siswa</h5>
            NISN :
            <p class="text-muted" id="student-nisn"></p>
          </div>
          <hr class="my-4">
        </div>
      </div>
    </div>

    <div class="col-lg-12">
      <div class="card mb-0">
        <!-- Tab content -->
        <div class="tab-content p-4">
          <div class="tab-pane active" id="about" role="tabpanel">
            <div>
              <div class="">
                <ul class="verti-timeline list-unstyled">
                  <li class="event-list">
                    <div class="event-date text-primar">Check-In</div>
                    <h5 id="student-check-in" class="badge bg-soft-success" style="font-size: 4mm">Waktu Check In</h5>
                  </li>
                  <li class="event-list">
                    <div class="event-date text-primar" >Check-Out</div>
                    <h5 id="student-check-out" class="badge bg-soft-danger" style="font-size: 4mm">Waktu Check Out</h5>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    let barcode = '';
    let lastKeyTime = Date.now();

    document.addEventListener('keydown', (event) => {
      const currentTime = Date.now();

      // Check if the key is part of a barcode scan (usually input within milliseconds)
      if (currentTime - lastKeyTime > 100) {
        barcode = ''; // Reset the barcode if too much time has passed
      }
      lastKeyTime = currentTime;
      if (event.key === 'Shift' || event.key === 'ArrowRight') {
        return;
      }
      // Check for Enter key which usually signifies the end of the barcode scan
      if (event.key === 'Enter') {
        if (barcode.length > 0) {
          processBarcode(barcode);
          barcode = ''; // Reset the barcode
        }
      } else {
        barcode += event.key;
      }
    });

    function processBarcode(barcode) {
      // Implement your barcode processing logic here
      const apiUrl = "/api/find-student?nisn=" + barcode + "&academic_year_id=" + "{{ $academic_year_id }}" + "&date=" +
        "{{ $date }}";
      fetch(apiUrl, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json'
          },
        })
        .then(response => response.json())
        .then(data => {
            console.log(document.getElementById('student-image'));
          document.getElementById('student-name').textContent = data.name;
          document.getElementById('student-image').src = '{{url('')}}' + data.image;
          document.getElementById('student-nisn').textContent = data.nisn;
          document.getElementById('student-check-in').textContent = data.clock_in;
          document.getElementById('student-check-out').textContent = data.clock_out;

        })
        .catch((error) => {
          console.error('Error:', error);

        });

    }
  </script>
  <!-- end row -->
@endsection
