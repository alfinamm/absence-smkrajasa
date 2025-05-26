@extends('layouts.master')
@section('title')
  @lang('Kehadiran Murid')
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
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">

          <h4 class="card-title mb-0">Daftar Siswa</h4>
          <p class="card-title-desc">Daftar siswa yang ada di kelas {{ $class->name }}.</p>
          <form action="{{ route('student-attendance.show', ['class' => $class->id]) }}" method="GET">
            <div class="row">
              <div class="col-lg-4 " style="display: flex;">
                <div class="mb-3" style="margin-right: 20px; width: 150px">
                  <div class="" id="academicYearpicker1">
                    <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                    <select name="academic_year_id"
                      class="form-control select2 @error('academic_year_id') is-invalid @enderror" id="academic_year_id">
                      <option value="">Pilih tahun ajaran</option>
                      @foreach ($academicYears as $aca)
                        <option value="{{ $aca->id }}"
                            @if($aca->id === $academicYear->id) selected @endif
                          data-start="{{ Carbon\Carbon::parse($aca->start_date)->format('Y-m-d') }}"
                          data-end="{{ Carbon\Carbon::parse($aca->end_date)->format('Y-m-d') }}">
                          {{ $aca->name }} </option>
                      @endforeach
                    </select>
                  </div><!-- input-group -->
                </div>
                <div class="mb-3" style="margin-right: 20px;">
                  <div class="" id="datepicker1" style="display: flex;">
                    <div>
                        {{-- <p>@dd($date)</p> --}}
                      <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="text"  style="width: 120px" name="date" class="form-control" value="" id="date-filter" placeholder="yyyy-mm-dd" >

                    </div>
                    <div>
                      <label class="form-label"><span class="" style="color: #fff">Icon</span></label>
                      <span class="form-control" id="date-icon"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                  </div><!-- input-group -->
                </div>
                <div class="mb-3">
                  <label class="form-label"><span class="" style="color: #fff">Filter</span></label>
                  <button type="submit" class="btn btn-secondary">Filter</button>
                </div>
              </div>
            </div>
          </form>

          <div class="table-responsive mt-2 mb-4">
            {{-- <table class="table table-centered table-nowrap mb-0"> --}}
            <table id="datatable"
              class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed"
              style="border-collapse: collapse; border-spacing: 0rem; width: 100%;" aria-describedby="datatable_info">
              <thead>
                <tr>
                  <th scope="col">Nama</th>
                  <th scope="col">Check-In</th>
                  <th scope="col">Check-Out</th>
                  <th scope="col">Kehadiran</th>
                  <th scope="col" style="width: 200px;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($students as $item)
                  @php
                    $status = -1;
                    $attendance = $item->attendanceForDate($date);
                    if ($attendance) {
                        $status = $attendance->status;
                    }
                  @endphp
                  <tr>
                    <td>
                      <a href="#" class="text-body">{{ $item->name }}</a>
                    </td>
                    <td>
                      <p class="badge bg-soft-success" style="font-size: 4mm">{{ $attendance?->clock_in->format('d-F-Y H:i:s') ?? '-' }}</p>
                    </td>
                    <td>
                      <p class="badge bg-soft-danger" style="font-size: 4mm" >{{ $attendance?->clock_out->format('d-F-Y H:i:s') ?? '-' }}</p>
                    </td>
                    <td>
                      @if ($status === 1)
                        <span class="badge text-bg-success" style="font-size: 4mm">Hadir</span>
                      @elseif($status === 2)
                        <span class="badge text-bg-warning" style="font-size: 4mm">Telat</span>
                      @elseif($status === 3)
                        <span class="badge text-bg-secondary" style="font-size: 4mm">Izin</span>
                      @elseif($status === 4)
                        <span class="badge text-bg-info" style="font-size: 4mm">Sakit</span>
                      @else
                        <span class="badge text-bg-danger" style="font-size: 4mm">Alfa</span>
                      @endif
                    </td>
                    <td>
                      <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                          <a href="{{ route('student-attendance.edit', ['student-attendance' => $attendance->id ?? 0, 'class' => $class->id, 'student' => $item->id]) }}"
                            class="px-2 text-primary"><i class="uil uil-pen font-size-18"></i></a>
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
  <script>
    let date = '{{ $date }}';
    if (date != '') {
        flatpickr('#date-filter', {
            dateFormat: "d-m-Y",
            defaultDate: new Date(date)
        });
    } else {
        flatpickr('#date-filter', {
            dateFormat: "d-m-Y",
            defaultDate: new Date()
        });
    }

    $('#academic_year_id').change(function() {
      let start = $('#academic_year_id').find(":selected").data("start");
      let end = $('#academic_year_id').find(":selected").data("end");

      console.log(start, end);

      $('#date-filter').removeAttr("disabled");
      $('#date-filter').datepicker('destroy').datepicker({
        format: 'yyyy-mm-dd',
        startDate: start,
        endDate: end
      });
    });

    let academic_year = '{{ request()->get("academic_year_id") ?? ($academic_year->id ?? "") }}';

    if (academic_year != '') {
      $('#academic_year_id').val(academic_year).trigger('change');
    }

    $('#academic_year_id_input').change(function() {
      let start = $('#academic_year_id_input').find(":selected").data("start");
      let end = $('#academic_year_id_input').find(":selected").data("end");

      console.log(start, end);

      $('#date-input').removeAttr("disabled");
      $('#date-input').datepicker('destroy').datepicker({
        format: 'yyyy-mm-dd',
        startDate: start,
        endDate: end
      });
    });



    $(document).ready(function() {
      // Initialize Select2 on the dropdown
      $('#name_input').select2({
        dropdownParent: $('#exampleModal')
      });
      $('#status_input').select2({
        dropdownParent: $('#exampleModal')
      });
      $('#academic_year_id_input').select2({
        dropdownParent: $('#exampleModal')
      });
    });
  </script>
@endsection
