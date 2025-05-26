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
      Absensi Siswa
    @endslot
    @slot('pagetitle')
      <a href="{{ route('student-attendance.index') }}">
        Daftar
      </a>
    @endslot
  @endcomponent

   <div class="row">
      <form action="{{ route('report-attendance.show.by.token') }}" method="GET">
      <div class="col-lg-12">
        <div class="card ">
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
      </form>
      </div>
    </div>

  <div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                  @php
                    $status = -1;
                    $attend = 0;
                    $late = 0;
                    $permit = 0;
                    $sick = 0;
                    $alpha = 0;

                    $attendance = $students->attendanceForDate($date);
                    $summaries = $students->attendancePerAcademic($academic_year_id);
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
                <div class="text-center">
                    <div class="clearfix"></div>
                    <div>
                        <img src="{{ asset('storage/images/' . $students->image) }}" alt="" class="avatar-lg rounded-circle img-thumbnail" style="object-fit: contain">
                    </div>
                    <h5 class="mt-3 mb-1">{{ $students->name }}</h5>
                    <p class="text-muted">{{ $students->nisn}}</p>
                </div>

                <hr class="my-4">

                <div class="text-muted">
                    <div class="table-responsive mt-4">
                        <div>
                            <p class="mb-1">Hadir :</p>

                            <span class="badge bg-success" style="font-size: 4mm">{{ $attend }}</span>
                        </div>
                        <div>
                            <p class="mt-4">Telat :</p>
                            <span class="badge bg-warning" style="font-size: 4mm">{{ $late }}</span>
                        </div>
                        <div class="mt-4">
                            <p class="mb-1">Izin :</p>
                            <span class="badge bg-secondary" style="font-size: 4mm">{{ $permit }}</span>
                        </div>
                        <div class="mt-4">
                            <p class="mb-1">Sakit :</p>
                            <span class="badge bg-info" style="font-size: 4mm">{{ $sick }}</span>
                        </div>
                        <div class="mt-4">
                            <p class="mb-1">Alpha :</p>
                            <span class="badge bg-danger" style="font-size: 4mm">{{ $alpha }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
      <div class="card">
        <div class="card-body">
          <p class="card-title-desc">Daftar Riwayat Absensi.</p>
          <div class="table-responsive">
            {{-- <table class="table table-centered table-nowrap mb-0"> --}}
            <table id="datatable"
              class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed"
              style="border-collapse: collapse; border-spacing: 0rem; width: 100%;" aria-describedby="datatable_info">
              <thead>
                <tr>
                  <th scope="col">Periode</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Check-In</th>
                  <th scope="col">Check-Out</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($historyAttandance as $item)
                  <tr>
                    <td><p>{{ $item->academicYear->name }}</p></td>
                    <td><p>{{ $item->date }}</p></td>
                    <td><p class="badge bg-soft-success" style="font-size: 4mm">{{ Carbon\Carbon::parse($item->clock_in )->format('H:i:s') ?? "-"}}</p></td>
                    <td><p class="badge bg-soft-danger" style="font-size: 4mm">{{ Carbon\Carbon::parse($item->clock_out )->format('H:i:s') ?? "-"}}</p></td>
                    <td>
                         @if ($item->status === 1)
                        <span class="badge text-bg-success" style="font-size: 4mm">Hadir</span>
                      @elseif($item->status === 2)
                        <span class="badge text-bg-warning" style="font-size: 4mm">Izin</span>
                      @elseif($item->status === 3)
                        <span class="badge text-bg-secondary" style="font-size: 4mm">Izin</span>
                      @elseif($item->status === 4)
                        <span class="badge text-bg-info" style="font-size: 4mm">Sakit</span>
                      @else
                        <span class="badge text-bg-danger" style="font-size: 4mm">Alfa</span>
                      @endif
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
    // let academic_year = '{{ request()->get('academic_year_id') }}';

    // if (academic_year != '') {
    //   $('#academic_year_id').val(academic_year).trigger('change');
    // }
  </script>
@endsection
