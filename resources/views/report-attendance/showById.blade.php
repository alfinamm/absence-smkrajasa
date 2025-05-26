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
      Absensi Siswa {{ $student->name }}
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
          <p class="card-title-desc">Daftar Riwayat Absensi {{ $student->name }}.</p>

          <div class="table-responsive mt-2 mb-4">
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
                        <span class="badge text-bg-warning" style="font-size: 4mm">Telat</span>
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
    let academic_year = '{{ request()->get('academic_year_id') }}';

    if (academic_year != '') {
      $('#academic_year_id').val(academic_year).trigger('change');
    }
  </script>
@endsection
