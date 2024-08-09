@extends('layouts.app')
@section('title', 'Dahsboard')
@section('breadcrumb')
  <x-breadcrumb title="Dashboard" page="Dashboard" active="Dashboard" route="{{ route('dashboard.index') }}" />
@endsection
@section('content')
  {{-- <div class="page-heading">
    <h3>Dashboard</h3>
  </div> --}}
  <div class="page-content">
    <section class="row">
      <div class="col-12 col-lg-12">

        <div class="row">
          <div class="col-6 col-lg-2 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                    <div class="stats-icon purple mb-2">
                      <i class="ri-archive-stack-line"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Total Semua Arsip</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->count() }}
                      @else
                        {{ DB::table('archive_containers')->where('company_id', $companies)->count() }}
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
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                    <div class="stats-icon blue mb-2">
                      <i class="ri-archive-fill"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Total Arsip Tahun Ini</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->whereYear('created_at', now()->year)->count() }}
                      @else
                        {{ DB::table('archive_containers')->where('company_id', $companies)->whereYear('created_at', now()->year)->count() }}
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
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                    <div class="stats-icon green mb-2">
                      <i class="ri-archive-line"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Total Arsip Bulan Ini</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->whereMonth('created_at', now()->month)->count() }}
                      @else
                        {{ DB::table('archive_containers')->where('company_id', $companies)->whereMonth('created_at', now()->month)->count() }}
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
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                    <div class="stats-icon mb-2">
                      <i class="ri-file-check-line"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Total Arsip Aktif</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->whereDate('expiration_active', '>=', now()->toDateString())->count() }}
                      @else
                        {{ DB::table('archive_containers')->where('company_id', $companies)->whereDate('expiration_active', '>=', now()->toDateString())->count() }}
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
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                    <div class="stats-icon red mb-2">
                      <i class="ri-file-close-line"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Total Arsip Inaktif</h6>
                    <h6 class="font-extrabold mb-0">
                      @can('super_admin')
                        {{ DB::table('archive_containers')->whereDate('expiration_active', '<', now()->toDateString())->count() }}
                      @else
                        {{ DB::table('archive_containers')->where('company_id', $companies)->whereDate('expiration_active', '<', now()->toDateString())->count() }}
                      @endcan
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

        {{-- <div class="row">
          <h5>Total Arsip Divisi</h5>
          @foreach ($divisions as $division)
            <div class="col-6 col-lg-2 col-md-6">
              <div class="card">
                <div class="card-body ">
                  <div class="row">
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                      <h6 class="text-muted font-semibold"><a
                          href="{{ route('division-archive', $division->id) }}"> {{ $division->code }}</a>
                      </h6>
                      <h6 class="font-extrabold mb-0">
                        {{ $division->archive_container->count() }}
                      </h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div> --}}

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Data Arsip Per Bulan ({{ date('Y') }})</h4>
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
                <h4>Data Peminjaman Arsip Per Bulan ({{ date('Y') }})</h4>
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
                          {{-- <th scope="col">Tipe</th> --}}
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($lendingTopten as $lending)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lending->archiveContainer->number_document ?? 'N/A' }}</td>
                            <td>{{ $lending->archiveContainer->division->code ?? 'N/A' }}</td>
                            <td>
                              @if ($lending->archiveContainer->is_lend)
                                <span class="badge bg-light-warning">Dipinjam</span>
                              @else
                                <span class="badge bg-light-info">Dikembalikan</span>
                              @endif
                            </td>
                            {{-- <td>{{ $lending->document_type }}</td> --}}
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
                        {{-- <th scope="col">Perihal</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($archiveContainers as $archive)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $archive->number_document ?? 'N/A' }}</td>
                          <td>{{ $archive->division->code ?? 'N/A' }}</td>
                          {{-- <td>{{ $archive->tag }}</td> --}}
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

      {{-- <div class="col-12 col-lg-3">
        <div class="card">
          <div class="card-body py-4 px-4">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-xl">
                <img src="../assets/compiled/jpg/1.jpg" alt="Face 1">
              </div>
              <div class="ms-3 name">
                <h5 class="font-bold">John Duck</h5>
                <h6 class="text-muted mb-0">@johnducky</h6>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h4>Recent Messages</h4>
          </div>
          <div class="card-content pb-4">
            <div class="recent-message d-flex px-4 py-3">
              <div class="avatar avatar-lg">
                <img src="../assets/compiled/jpg/4.jpg">
              </div>
              <div class="name ms-4">
                <h5 class="mb-1">Hank Schrader</h5>
                <h6 class="text-muted mb-0">@johnducky</h6>
              </div>
            </div>
            <div class="recent-message d-flex px-4 py-3">
              <div class="avatar avatar-lg">
                <img src="../assets/compiled/jpg/5.jpg">
              </div>
              <div class="name ms-4">
                <h5 class="mb-1">Dean Winchester</h5>
                <h6 class="text-muted mb-0">@imdean</h6>
              </div>
            </div>
            <div class="recent-message d-flex px-4 py-3">
              <div class="avatar avatar-lg">
                <img src="../assets/compiled/jpg/1.jpg">
              </div>
              <div class="name ms-4">
                <h5 class="mb-1">John Dodol</h5>
                <h6 class="text-muted mb-0">@dodoljohn</h6>
              </div>
            </div>
            <div class="px-4">
              <button class='btn btn-block btn-xl btn-outline-primary font-bold mt-3'>Start Conversation</button>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h4>Visitors Profile</h4>
          </div>
          <div class="card-body">
            <div id="chart-visitors-profile"></div>
          </div>
        </div>
      </div> --}}
    </section>
  </div>
  <script>
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
  </script>

  <script>
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
  </script>


@endsection
<script src="{{ asset('/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
@push('after-script')
@endpush
