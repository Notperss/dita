@extends('layouts.app')
@section('title', 'Dahsboard')
@section('breadcrumb')
  <x-breadcrumb title="Dashboard" page="Dashboard" active="Dashboard" route="{{ route('dashboard.index') }}" />
@endsection
@section('content')

  <div class="page-content">
    <section class="row">
      <div class="col-12 col-lg-12">

        {{-- ARCHIVES --}}
        <div class="row">
          <div class="col-6 col-lg-2 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
                    <div class="stats-icon purple mb-2">
                      <i class="ri-archive-stack-line"></i>
                    </div>
                  </div>
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <h6 class="text-muted font-semibold">Total Semua Arsip</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->count() }}
                      @else
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->where('company_id', $companyId)->count() }}
                      @endcan
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-lg-2 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
                    <div class="stats-icon blue mb-2">
                      <i class="ri-file-text-fill"></i>
                    </div>
                  </div>
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <h6 class="text-muted font-semibold">Arsip Tahun Ini</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->whereYear('created_at', now()->year)->count() }}
                      @else
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->where('company_id', $companyId)->whereYear('created_at', now()->year)->count() }}
                      @endcan
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-lg-2 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
                    <div class="stats-icon green mb-2">
                      <i class="ri-file-text-line"></i>
                    </div>
                  </div>
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <h6 class="text-muted font-semibold">Arsip Bulan Ini</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->whereMonth('created_at', now()->month)->count() }}
                      @else
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->where('company_id', $companyId)->whereMonth('created_at', now()->month)->count() }}
                      @endcan
                    </h6>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-lg-2 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
                    <div class="stats-icon mb-2">
                      <i class="ri-file-check-line"></i>
                    </div>
                  </div>
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <h6 class="text-muted font-semibold">Total Arsip Aktif</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->whereDate('expiration_active', '>=', now()->toDateString())->count() }}
                      @else
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->where('company_id', $companyId)->whereDate('expiration_active', '>=', now()->toDateString())->count() }}
                      @endcan
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-lg-2 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
                    <div class="stats-icon red mb-2">
                      <i class="ri-file-close-line"></i>
                    </div>
                  </div>
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <h6 class="text-muted font-semibold">Total Arsip Inaktif</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->whereDate('expiration_active', '<', now()->toDateString())->count() }}
                      @else
                        {{ DB::table('archive_containers')->whereNull('deleted_at')->where('company_id', $companyId)->whereDate('expiration_active', '<', now()->toDateString())->count() }}
                      @endcan
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- BOX CONTAINER --}}
        <div class="row">
          <div class="col-6 col-lg-4 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
                    <div class="stats-icon blue mb-2">
                      <i class="ri-box-3-fill"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Total Box Container</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('location_containers')->count() }}
                      @else
                        {{ DB::table('location_containers')->where('company_id', $companyId)->count() }}
                      @endcan
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-lg-4 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
                    <div class="stats-icon green mb-2">
                      <i class="ri-archive-fill"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Total Box Tahun Ini</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('location_containers')->whereYear('created_at', now()->year)->count() }}
                      @else
                        {{ DB::table('location_containers')->where('company_id', $companyId)->whereYear('created_at', now()->year)->count() }}
                      @endcan
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-lg-4 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 d-flex justify-content-start ">
                    <div class="stats-icon red mb-2">
                      <i class="ri-archive-line"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Total Box Bulan Ini</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('location_containers')->whereMonth('created_at', now()->month)->count() }}
                      @else
                        {{ DB::table('location_containers')->where('company_id', $companyId)->whereMonth('created_at', now()->month)->count() }}
                      @endcan
                    </h6>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        @foreach ($workUnits as $company)
          <div class="row">
            <h5>Data Arsip {{ $company->name }}</h5>
            @forelse($company->division as $division)
              <div class="col-6 col-lg-2 col-md-6">
                <div class="card">
                  <div class="card-body ">
                    <div class="row">
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold"><a href="{{ route('division-archive', $division->id) }}">
                            {{ $division->code }}</a>
                        </h6>
                        <h6 class="font-extrabold mb-0">
                          {{ $division->archive_container->count() }}
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 col-lg-12 col-md-12">
                <div class="card">
                  <div class="card-body ">
                    <div class="row">
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted text-center font-semibold">
                          Empty
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforelse
          </div>
        @endforeach

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                  <h4>Data Input Arsip Per Bulan (<span id="chart-year">{{ date('Y') }}</span>)</h4>

                  <div class="col-md-2">
                    <label for="year-select">Pilih Tahun</label>
                    <input type="text" class="form-control" name="year" id="year"
                      data-provide="datepicker" data-date-format="yyyy" data-date-min-view-mode="2" autocomplete="off"
                      readonly>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div id="chart"></div>
              </div>
            </div>
          </div>
        </div>

        @foreach ($workUnits as $company)
          <div class="row">
            <h5>Data Peminjaman Arsip {{ $company->name }}</h5>
            @forelse($company->division as $division)
              <div class="col-6 col-lg-2 col-md-6">
                <div class="card">
                  <div class="card-body ">
                    <div class="row">
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">
                          <a href="{{ route('division-lending', $division->id) }}"> {{ $division->code }} </a>
                        </h6>
                        <h6 class="font-extrabold mb-0">
                          {{ $division->lendingArchive->count() }}
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 col-lg-12 col-md-12">
                <div class="card">
                  <div class="card-body ">
                    <div class="row">
                      <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted text-center font-semibold">
                          Empty
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforelse
          </div>
        @endforeach

        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                  <h4>Data Peminjaman Arsip Per Bulan (<span id="chart-lending-year">{{ date('Y') }}</span>)</h4>

                  <div class="col-md-2">
                    <label for="year-select">Pilih Tahun</label>
                    <input type="text" class="form-control" name="year-lending" id="year-lending"
                      data-provide="datepicker" data-date-format="yyyy" data-date-min-view-mode="2" autocomplete="off"
                      readonly>
                  </div>

                </div>
              </div>
              <div class="card-body">
                <div id="lending-chart"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-xl-6">
            <div class="card">
              <div class="card-header">
                <h4>10 Peminjaman Terakhir</h4>
              </div>
              <div class="card-body" style="word-break: break-all">
                <div class="container">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col" style="width: 10%">#</th>
                          <th scope="col">No. Dokumen</th>
                          <th scope="col" style="width: 20%">Divisi</th>
                          <th scope="col">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($lendingTopten as $lending)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                              {{ $lending->archiveContainer->number_document ?? 'N/A' }}
                            </td>
                            <td>{{ $lending->archiveContainer->division->code ?? 'N/A' }}</td>
                            <td>
                              @if ($lending->archiveContainer)
                                @if ($lending->archiveContainer)
                                  <span class="badge bg-light-warning">Dipinjam</span>
                                @else
                                  <span class="badge bg-light-info">Dikembalikan</span>
                                @endif
                              @else
                                <span>
                                  @can('super_admin')
                                    <small> ID : {{ $lending->archive_container_id }}</small>
                                  @else
                                    -
                                  @endcan
                                </span>
                              @endif
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td class="text-center" colspan="4">No data available in table</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-6">
            <div class="card">
              <div class="card-header">
                <h4>10 Arsip Terakhir</h4>
              </div>
              <div class="card-body" style="word-break: break-all">
                <div class="container">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col" style="width: 10%">#</th>
                        <th scope="col">No. Dokumen</th>
                        <th scope="col" style="width:20%">Divisi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($archiveContainers as $archive)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $archive->number_document ?? 'N/A' }}</td>
                          <td>{{ $archive->division->code ?? 'N/A' }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="3" class="text-center">No data available in table</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

  {{-- <script>
    var monthCounts = [
      @foreach ($monthCounts as $count)
        {{ $count }},
      @endforeach
    ];

    var options = {
      chart: {
        type: 'bar',
        height: 300,
      },
      series: [{
        name: 'Total Arsip',
        data: monthCounts
      }],
      xaxis: {
        categories: [
          @foreach (range(1, 12) as $month)
            '{{ date('F', mktime(0, 0, 0, $month, 1)) }}',
          @endforeach
        ]
      },
      // Annotations or any other chart options...
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
  </script> --}}

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const currentYear = new Date().getFullYear();
      $('#year').val(currentYear);

      let chart;

      function renderChart(monthCounts) {
        const options = {
          chart: {
            type: 'bar',
            height: 300,
          },
          series: [{
            name: 'Total Arsip',
            data: monthCounts
          }],
          xaxis: {
            categories: [
              'January', 'February', 'March', 'April', 'May', 'June',
              'July', 'August', 'September', 'October', 'November', 'December'
            ]
          }
        };

        chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      }

      function loadChartData(year) {
        $.ajax({
          url: 'dita/arsip/chart-data',
          type: 'GET',
          data: {
            year: year
          },
          success: function(response) {
            $('#chart-year').text(year);
            chart.updateSeries([{
              name: 'Total Arsip',
              data: response.data
            }]);
          },
          error: function() {
            alert('Gagal memuat data arsip untuk tahun ' + year);
          }
        });
      }

      // Load awal
      $.ajax({
        url: 'dita/arsip/chart-data',
        type: 'GET',
        data: {
          year: currentYear
        },
        success: function(response) {
          renderChart(response.data);
        }
      });

      // Saat tahun diganti
      $('#year').on('change', function() {
        const selectedYear = $(this).val();
        loadChartData(selectedYear);
      });
    });
  </script>

  {{-- <script>
    var totalLendingCounts = [
      @foreach ($lendingMonthCounts as $count)
        {{ $count }},
      @endforeach
    ];

    var digitalLendingCounts = [
      @foreach ($digitalLendingMonthCounts as $count)
        {{ $count }},
      @endforeach
    ];

    var physicLendingCounts = [
      @foreach ($physicLendingMonthCounts as $count)
        {{ $count }},
      @endforeach
    ];

    var options = {
      chart: {
        type: 'bar',
        height: 300,
      },
      series: [{
          name: 'Total Peminjaman Arsip',
          data: totalLendingCounts,
        },
        {
          name: 'Total Peminjaman Digital',
          data: digitalLendingCounts
        },
        {
          name: 'Total Peminjaman Fisik',
          data: physicLendingCounts
        }
      ],
      xaxis: {
        categories: [
          @foreach (range(1, 12) as $month)
            '{{ date('F', mktime(0, 0, 0, $month, 1)) }}',
          @endforeach
        ]
      },
      // Annotations or any other chart options...
    };

    var chart = new ApexCharts(document.querySelector("#lending-chart"), options);
    chart.render();
  </script> --}}

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const currentYear = new Date().getFullYear();
      $('#year-lending').val(currentYear);

      let lendingChart;

      function renderLendingChart(total, digital, physic) {
        const options = {
          chart: {
            type: 'bar',
            height: 300,
          },
          series: [{
              name: 'Total Peminjaman Arsip',
              data: total,
            },
            {
              name: 'Total Peminjaman Digital',
              data: digital
            },
            {
              name: 'Total Peminjaman Fisik',
              data: physic
            }
          ],
          xaxis: {
            categories: [
              'January', 'February', 'March', 'April', 'May', 'June',
              'July', 'August', 'September', 'October', 'November', 'December'
            ]
          }
        };

        lendingChart = new ApexCharts(document.querySelector("#lending-chart"), options);
        lendingChart.render();
      }

      function loadLendingChartData(year) {
        $.ajax({
          url: 'dita/arsip/lending-chart-data',
          type: 'GET',
          data: {
            year: year
          },
          success: function(response) {
            $('#chart-lending-year').text(year);
            lendingChart.updateSeries([{
                name: 'Total Peminjaman Arsip',
                data: response.total
              },
              {
                name: 'Total Peminjaman Digital',
                data: response.digital
              },
              {
                name: 'Total Peminjaman Fisik',
                data: response.physic
              }
            ]);
          },
          error: function() {
            alert('Gagal memuat data peminjaman arsip untuk tahun ' + year);
          }
        });
      }

      // Load awal
      $.ajax({
        url: 'dita/arsip/lending-chart-data',
        type: 'GET',
        data: {
          year: currentYear
        },
        success: function(response) {
          renderLendingChart(response.total, response.digital, response.physic);
        }
      });

      $('#year-lending').on('change', function() {
        const selectedYear = $(this).val();
        loadLendingChartData(selectedYear);
      });
    });
  </script>

@endsection
<script src="{{ asset('/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
@push('after-script')
@endpush
