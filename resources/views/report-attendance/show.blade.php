@extends('layouts.master')
@section('title')
  @lang('Rekap Absensi')
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
      Absensi Kelas {{ $class->name }}
    @endslot
    @slot('pagetitle')
      <a href="{{ route('student-attendance.index') }}">
        Daftar
      </a>
    @endslot
  @endcomponent
  <div class="row">
    <form action="{{ route('report-attendance.show', ['class' => $class->id]) }}" method="GET">
    <div class="col-lg-12">
      <div class="card h-80">
        <div class="card-body">
            <div class="row">
              <div class="col-lg-4 " style="display: flex; align-items: center">
                <div class="mb-3" style="margin-right: 20px; width: 100;">
                  <div class="input-group" id="academicYearpicker1">
                    <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                    <select name="academic_year_id"
                      class="form-control select2 @error('academic_year_id') is-invalid @enderror" id="academic_year_id">
                      <option value="">Pilih tahun ajaran</option>
                      @foreach ($academicYears as $academicYear)
                        <option @if ($academic_year_id === $academicYear->id) selected @endif value="{{ $academicYear->id }}"
                          data-start="{{ Carbon\Carbon::parse($academicYear->start_date)->format('Y-m-d') }}"
                          data-end="{{ Carbon\Carbon::parse($academicYear->end_date)->format('Y-m-d') }}">
                          {{ $academicYear->name }} </option>
                      @endforeach
                    </select>
                  </div><!-- input-group -->
                </div>
                <div class="" style="margin-top: 13px">
                  <button type="submit" class="btn btn-secondary">Filter</button>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>

  </div>
  <div class="row">

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Chart Absensi </h4>
          <div id="chart-student" data-colors='["--bs-success", "--bs-warning", "--bs-secondary", "--bs-primary", "--bs-danger"]'
            class="apex-charts" dir="ltr"></div>
        </div>
      </div>
      <!--end card-->
    </div>
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-0">Daftar Siswa</h4>
          <p class="card-title-desc">Daftar siswa yang ada di kelas {{ $class->name }}.</p>

          </form>

          <div class="table-responsive mt-2 mb-4">
            {{-- <table class="table table-centered table-nowrap mb-0"> --}}
            <table id="datatable"
              class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed"
              style="border-collapse: collapse; border-spacing: 0rem; width: 100%;" aria-describedby="datatable_info">
              <thead>
                <tr>
                  <th scope="col">Nama</th>
                  <th scope="col">Hadir</th>
                  <th scope="col">Telat</th>
                  <th scope="col">Izin</th>
                  <th scope="col">Sakit</th>
                  <th scope="col">Alpha</th>
                  <th scope="col" style="width: 200px;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($students as $item)
                  @php
                    $status = -1;
                    $attend = 0;
                    $late = 0;
                    $permit = 0;
                    $sick = 0;
                    $alpha = 0;

                    $attendance = $item->attendanceForDate($date);
                    $summaries = $item->attendancePerAcademic($academic_year_id);
                    if ($attendance) {
                        $status = $attendance->status;
                    }
                    if ($summaries) {
                        $summaries = json_decode(json_encode($summaries), true);
                        $alpha = current(array_filter($summaries, fn($data) => $data['status'] == 0))['total'] ?? 0;
                        $attend = current(array_filter($summaries, fn($data) => $data['status'] == 1))['total'] ?? 0;
                        $late = current(array_filter($summaries, fn($data) => $data['status'] == 2))['total'] ?? 0;
                        $permit = current(array_filter($summaries, fn($data) => $data['status'] == 3))['total'] ?? 0;
                        $sick = current(array_filter($summaries, fn($data) => $data['status'] == 4))['total'] ?? 0;
                    }
                  @endphp
                  <tr>
                    <td>
                      <a href="#" class="text-body">{{ $item->name }}</a>
                    </td>
                    <td>
                      <span class="badge bg-success" style="font-size: 4mm">{{ $attend }}</span>
                    </td>
                    <td>

                      <span class="badge bg-warning " style="font-size: 4mm">{{ $late }}</span>
                    </td>
                    <td>

                      <span class="badge bg-secondary " style="font-size: 4mm">{{ $permit }}</span>
                    </td>
                    <td>

                      <span class="badge bg-info" style="font-size: 4mm">{{ $sick }}</span><br>
                    </td>
                    <td>

                      <span class="badge bg-danger" style="font-size: 4mm">{{ $alpha }}</span>
                    </td>
                    <td>
                      <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                          <a href="{{ route('report-attendance.show.by.student', ['class' => $class->id, 'student' => $item->id]) }}"
                            class="px-2 text-primary"><i class="uil uil-eye font-size-18"></i></a>
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
  <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ URL::asset('/assets/js/pages/apexcharts.init.js') }}"></script>
  <script>
    let academic_year = '{{ request()->get('academic_year_id') }}';

    if (academic_year != '') {
      $('#academic_year_id').val(academic_year).trigger('change');
    }

    function getChartColorsArray(chartId) {
      if (document.getElementById(chartId) !== null) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");

        if (colors) {
          colors = JSON.parse(colors);
          return colors.map(function(value) {
            var newValue = value.replace(" ", "");

            if (newValue.indexOf(",") === -1) {
              var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
              if (color) return color;
              else return newValue;;
            } else {
              var val = value.split(',');

              if (val.length == 2) {
                var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                return rgbaColor;
              } else {
                return newValue;
              }
            }
          });
        }
      }
    }


    var chartColors = getChartColorsArray("chart-student");


    const apiUrl = "/api/charts/{{ $class->id }}?&academic_year_id={{ $academic_year_id }}";
    fetch(apiUrl, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        },
      })
      .then(response => response.json())
      .then(data => {
        console.log(data)
        var options = {
          chart: {
            height: 350,
            type: 'bar',
            toolbar: {
              show: false
            }
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '45%',
              endingShape: 'rounded'
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
          },
          series: data.series,
          colors: chartColors,
          xaxis: {
            categories: data.items,
          },
          yaxis: {
            title: {
              text: 'Rangkuman Kehadiran Siswa'
            }
          },
          grid: {
            borderColor: '#f1f1f1'
          },
          fill: {
            opacity: 1
          },
          tooltip: {
            y: {
              formatter: function formatter(val) {
                return val + " Kali";
              }
            }
          }
        };
        var chart = new ApexCharts(document.querySelector("#chart-student"), options);
        chart.render();

      })
      .catch((error) => {
        console.error('Error:', error);

      });
  </script>

  <script>

</script>
@endsection
