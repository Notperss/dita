@extends('layouts.app')

@section('title', 'Lending Archive')
@section('content')

  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Peminjaman Arsip</h3>
        </div>
      </div>
    </div>
  </div>

  <!-- // Basic multiple Column Form section start -->
  <section id="multiple-column-form">

    <div class="row">
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon purple mb-2">
                  <i class="iconly-boldShow"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <a href="{{ route('history') }}">
                  <h6 class="text-muted font-semibold">Riwayat Semua Arsip</h6>
                  <h6 class="font-extrabold mb-0">
                    @can('super_admin')
                      {{ DB::table('lending_archives')->where('status', 3)->count() }}
                    @elsecan('admin')
                      {{ DB::table('lending_archives')->where('status', 3)->where('company_id', auth()->user()->company_id)->count() }}
                    @else
                      {{ DB::table('lending_archives')->where('status', 3)->where('user_id', auth()->user()->id)->count() }}
                    @endcan
                  </h6>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon blue mb-2">
                  <i class="ri-file-paper-line"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Riwayat Fisik</h6>
                <h6 class="font-extrabold mb-0">
                  <a href="{{ route('fisik') }}">
                    @can('super_admin')
                      {{ DB::table('lending_archives')->where('status', 3)->where('document_type', 'FISIK')->count() }}
                    @elsecan('admin')
                      {{ DB::table('lending_archives')->where('status', 3)->where('document_type', 'FISIK')->where('company_id', auth()->user()->company_id)->count() }}
                    @else
                      {{ DB::table('lending_archives')->where('status', 3)->where('document_type', 'FISIK')->where('user_id', auth()->user()->id)->count() }}
                    @endcan
                </h6>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon green mb-2">
                  <i class="ri-remote-control-line"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <a href="{{ route('digital') }}">
                  <h6 class="text-muted font-semibold">Riwayat Digital</h6>
                  <h6 class="font-extrabold mb-0">
                    @can('super_admin')
                      {{ DB::table('lending_archives')->where('status', 3)->where('document_type', 'DIGITAL')->count() }}
                    @elsecan('admin')
                      {{ DB::table('lending_archives')->where('status', 3)->where('document_type', 'DIGITAL')->where('company_id', auth()->user()->company_id)->count() }}
                    @else
                      {{ DB::table('lending_archives')->where('status', 3)->where('document_type', 'DIGITAL')->where('user_id', auth()->user()->id)->count() }}
                    @endcan
                  </h6>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- <a href="#mymodal" data-toggle="modal" data-target="#mymodal" class="btn btn-primary my-2"> <i
        class="bi bi-plus-lg"></i>
      Pinjam Arsip</a> --}}

    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                  aria-controls="home" aria-selected="true">List Semua Arsip</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                  aria-controls="profile" aria-selected="false">Pengajuan Arsip</a>
              </li>
            </ul>
          </div>
          <div class="card-body">

            {{-- <div class="table-responsive">
                <table class="table table-striped mb-0" id="table1">
                  <thead>
                    <tr>
                      <th>Nomor Peminjaman</th>
                      <th>Divisi</th>
                      <th>Tgl Pinjam</th>
                      <th>Keterangan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($lendings as $lending)
                      <tr>
                        <td class="text-bold-500">{{ $lending->lending_number ?? 'N/A' }}</td>
                        <td>{{ $lending->division ?? 'N/A' }}</td>
                        <td>
                          {{ Carbon\Carbon::parse($lending->start_date)->translatedFormat('l, d F Y ') ?? 'N/A' }}
                        </td>
                        <td class="text-bold-500">{{ $lending->description }}</td>
                                          <td>
                          <div class="btn-group mb-1">
                            @can('approval')
                              <a class="btn btn-sm btn-info" onclick="update({{ $lending->id }})">Close</a>
                              <form id="update_{{ $lending->id }}" action="{{ route('closing', $lending->id) }}"
                                method="POST">
                                @method('put')
                                @csrf
                              </form>
                            @endcan
                            <div class="dropdown">
                              <button class="btn btn-primary btn dropdown-toggle me-1" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                </i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="#detailLending"
                                  data-remote="{{ route('lending-archive.show', $lending->id) }}"
                                  data-toggle="modal" data-target="#detailLending" data-title="Detail Peminjaman"
                                  class="dropdown-item">
                                  <i class="bi bi-eye"></i> Detail
                                </a>
                                @can('super_admin')
                                  <a class="dropdown-item" onclick="showSweetAlert({{ $lending->id }})"><i
                                      class="bi bi-x-lg"></i> Delete</a>
                                @else
                                  @foreach ($lending->lendingArchive as $item)
                                    @if ($item->approval === null)
                                      <a class="dropdown-item" onclick="showSweetAlert({{ $lending->id }})"><i
                                          class="bi bi-x-lg"></i> Delete</a>
                                    @break
                                  @endif
                                @endforeach
                              @endcan
                            </div>
                          </div>
                        </div>
                        <form id="deleteForm_{{ $lending->id }}"
                          action="{{ route('lending-archive.destroy', $lending->id) }}" method="POST">
                          @method('DELETE')
                          @csrf
                        </form>

                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div> --}}

            <div class="tab-content" id="myTabContent">

              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h4 class="card-title">List Semua Arsip</h4>
                <table class="table table-striped" id="lending-table" style="word-break: break-all;font-size: 90%">
                  <thead>
                    <tr>
                      <th class="text-center" scope="col">#</th>
                      <th class="text-center" scope="col">No. Katalog/PP</th>
                      <th class="text-center" scope="col">No. Dokumen</th>
                      <th class="text-center" scope="col">No. Arsip</th>
                      <th class="text-center" scope="col">Tahun</th>
                      <th class="text-center" scope="col">Perihal</th>
                      <th class="text-center" scope="col">Tag</th>
                      <th class="text-center" scope="col">Divisi</th>
                      <th class="text-center" scope="col">Tipe</th>
                      <th class="text-center" scope="col">Action</th>
                    </tr>
                    <tr>
                      <th scope="col">Cari:</th>
                      <th scope="col">
                        <textarea type="text" class="form-control form-control-sm" id="catalogSearch" placeholder="No. Katalog/PP"></textarea>
                      </th>
                      <th scope="col">
                        <textarea type="text" class="form-control form-control-sm" id="documentSearch" placeholder="No. Dokumen"></textarea>
                      </th>
                      <th scope="col">
                        <textarea type="text" class="form-control form-control-sm" id="archiveSearch" placeholder="No. Arsip"></textarea>
                      </th>
                      <th scope="col"><input type="text" class="form-control form-control-sm" id="yearFilter"
                          name="year" data-provide="datepicker" data-date-format="yyyy" data-date-min-view-mode="2"
                          placeholder="Tahun" readonly></th>
                      <th scope="col">
                        <textarea type="text" class="form-control form-control-sm" id="regardingSearch" placeholder="Perihal"></textarea>
                      </th>
                      <th scope="col">
                        <textarea type="text" class="form-control form-control-sm" id="tagSearch" placeholder="Tag"></textarea>
                      </th>
                      <th scope="col">
                        <select type="text" class="form-control form-control-sm " id="divisionFilter">
                          <option value="" selected disabled>Divisi</option>
                          @foreach ($divisions as $division)
                            <option value="{{ $division->code }}">{{ $division->name }}</option>
                          @endforeach
                        </select>
                      </th>
                      <th scope="col">
                        <select type="text" id="typeFilter" class="form-control form-control-sm"
                          style="width: 100%">
                          <option value="" disabled selected>Tipe</option>
                          <option value="PROYEK">PROYEK</option>
                          <option value="NON-PROYEK">NON-PROYEK</option>
                        </select>
                      </th>
                      <th scope="col"><button id="resetFilter" class="btn btn-primary btn-sm">Reset</button></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>

                <div class="row match-height">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-content">
                        <div class="card-body">
                          <h4 class="card-title mb-0">List Arsip Yang Ingin Dipinjam</h4>
                        </div>
                        <a href="#mymodal" data-toggle="modal" data-target="#mymodal" class="btn btn-primary my-2"> <i
                            class="bi bi-plus-lg"></i>
                          Pinjam Arsip</a>
                        <div class="card-body">
                          <div class="table-responsive">

                            <table class="table table-striped a">
                              <thead>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">No. Katalog/PP</th>
                                  <th class="text-center">No. Dokumen</th>
                                  <th class="text-center">No. Arsip</th>
                                  <th class="text-center">Tahun</th>
                                  <th class="text-center">Perihal</th>
                                  {{-- <th class="text-center">Tag</th> --}}
                                  <th class="text-center">Divisi</th>
                                  <th class="text-center">Tipe</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                <div class="row match-height">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">List Pengajuan Arsip</h4>
                      </div>
                      <div class="card-body">

                        <div class="table-responsive">
                          <table class="table table-striped mb-0" id="table1">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Nomor Peminjaman</th>
                                <th>Peminjam</th>
                                <th>Divisi</th>
                                <th>Tgl Pinjam</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($lendings as $lending)
                                <tr>
                                  <td class="text-bold-500">{{ $loop->iteration }}</td>
                                  <td class="text-bold-500">{{ $lending->lending_number ?? 'N/A' }}</td>
                                  <td class="text-bold-500">{{ $lending->user->name ?? 'N/A' }}</td>
                                  <td>{{ $lending->division->code ?? 'N/A' }}</td>
                                  <td>
                                    {{ Carbon\Carbon::parse($lending->start_date)->translatedFormat('l, d F Y ') ?? 'N/A' }}
                                  </td>
                                  <td class="text-bold-500">{{ $lending->description }}</td>
                                  <td class="text-bold-500">
                                    @if ($lending->status == 1)
                                      <span class="badge bg-light-success">Selesai</span>
                                    @else
                                      <span class="badge bg-light-warning">Proses</span>
                                    @endif
                                  </td>
                                  <td>
                                    <div class="btn-group mb-1">
                                      @if ($lending->status == null)
                                        @can('approval')
                                          <a class="btn btn-sm btn-info" onclick="update({{ $lending->id }})">Close</a>
                                          <form id="update_{{ $lending->id }}"
                                            action="{{ route('closing', $lending->id) }}" method="POST">
                                            @method('put')
                                            @csrf
                                          </form>
                                        @endcan
                                      @endif

                                      <div class="dropdown">
                                        <button class="btn btn-primary btn dropdown-toggle me-1" type="button"
                                          id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false">
                                          </i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          <a href="#detailLending"
                                            data-remote="{{ route('lending-archive.show', $lending->id) }}"
                                            data-toggle="modal" data-target="#detailLending"
                                            data-title="Detail Peminjaman" class="dropdown-item">
                                            <i class="bi bi-eye"></i> Detail
                                          </a>
                                          @can('super_admin')
                                            <a class="dropdown-item" onclick="showSweetAlert({{ $lending->id }})"><i
                                                class="bi bi-x-lg"></i> Delete</a>
                                          @else
                                            @foreach ($lending->lendingArchive as $item)
                                              @if ($item->approval === null)
                                                <a class="dropdown-item" onclick="showSweetAlert({{ $lending->id }})"><i
                                                    class="bi bi-x-lg"></i> Delete</a>
                                              @break
                                            @endif
                                          @endforeach
                                        @endcan
                                      </div>
                                    </div>
                                  </div>
                                  <form id="deleteForm_{{ $lending->id }}"
                                    action="{{ route('lending-archive.destroy', $lending->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                  </form>

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

              <div class="row match-height">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Arsip Yang Disetujui</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped mb-0" id="table1">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>No Dokumen</th>
                              <th>Perihal</th>
                              <th>Peminjam</th>
                              <th>Divisi</th>
                              <th>Tgl Pinjam</th>
                              <th>Tgl Dikembalikan</th>
                              {{-- <th>Status</th> --}}
                              <th>Tipe</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($lendingArchives as $archives)
                              <tr>
                                <td class="text-bold-500">{{ $loop->iteration }}</td>
                                <td class="text-bold-500">{{ $archives->archiveContainer->number_document ?? 'N/A' }}
                                <td class="text-bold-500">{{ $archives->archiveContainer->regarding ?? 'N/A' }}
                                </td>
                                <td class="text-bold-500">{{ $archives->user->name ?? 'N/A' }}</td>
                                <td>{{ $archives->division->code ?? 'N/A' }}</td>
                                <td>
                                  {{ Carbon\Carbon::parse($archives->lending->start_date)->translatedFormat('l, d F Y ') ?? 'N/A' }}
                                </td>
                                <td>
                                  {{ Carbon\Carbon::parse($archives->period)->translatedFormat('l, d F Y ') ?? 'N/A' }}
                                  <br>
                                  @if ($archives->period && strtotime($archives->period) <= strtotime('now'))
                                    <span style="color: red"><small>(Batas Waktu Peminjaman Habis)</small></span>
                                  @endif
                                </td>
                                {{-- <td class="text-bold-500">
                                  @if ($archives->lending->status == 1)
                                    <span class="badge bg-light-success">Selesai</span>
                                  @else
                                    <span class="badge bg-light-warning">Proses</span>
                                  @endif
                                </td> --}}
                                <td class="text-bold-500">
                                  @if ($archives->document_type == 'FISIK')
                                    <span class="badge bg-light-secondary">FISIK</span>
                                  @elseif ($archives->document_type == 'DIGITAL')
                                    <span class="badge bg-light-info">DIGITAL</span>
                                  @else
                                    <span>N/A</span>
                                  @endif
                                </td>
                                <td>
                                  {{-- <div class="btn-group mb-1">
                                    @if ($archives->lending->status == null)
                                      @can('approval')
                                        <a class="btn btn-sm btn-info"
                                          onclick="update({{ $archives->lending->id }})">Close</a>
                                        <form id="update_{{ $archives->lending->id }}"
                                          action="{{ route('closing', $archives->lending->id) }}"
                                          method="POST">
                                          @method('put')
                                          @csrf
                                        </form>
                                      @endcan
                                    @endif

                                    <div class="dropdown">
                                      <button class="btn btn-primary btn dropdown-toggle me-1" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        </i>
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="#detailLending"
                                          data-remote="{{ route('lending-archive.show', $archives->lending->id) }}"
                                          data-toggle="modal" data-target="#detailLending"
                                          data-title="Detail Peminjaman" class="dropdown-item">
                                          <i class="bi bi-eye"></i> Detail
                                        </a>
                                        @can('super_admin')
                                          <a class="dropdown-item"
                                            onclick="showSweetAlert({{ $archives->lending->id }})"><i
                                              class="bi bi-x-lg"></i> Delete</a>
                                        @else
                                          @if ($item->approval === null)
                                            <a class="dropdown-item"
                                              onclick="showSweetAlert({{ $archives->lending->id }})"><i
                                                class="bi bi-x-lg"></i> Delete</a>
                                          @break
                                        @endif
                                      @endcan
                                    </div>
                                  </div>
                                </div>
                                <form id="deleteForm_{{ $archives->lending->id }}"
                                  action="{{ route('lending-archive.destroy', $archives->lending->id) }}"
                                  method="POST">
                                  @method('DELETE')
                                  @csrf
                                </form> --}}

                                  @if ($archives->period && strtotime($archives->period) >= strtotime('now'))
                                    @if ($archives->archiveContainer->file && $archives->document_type == 'DIGITAL')
                                      <a type="button" class="btn btn-sm btn-success mx-1" data-fancy
                                        data-custom-class="pdf"
                                        data-src="{{ asset('storage/' . $archives->archiveContainer->file) }}"
                                        class="dropdown-item">
                                        Lihat File
                                      </a>
                                    @else
                                      <span><small>"N/A"</small></span>
                                    @endif
                                    {{-- @else
                                    <span style="color: red"> Batas Waktu Peminjaman Habis</span>
                                    <button class="btn btn-sm btn-primary">Sudah Dikembalikan</button> --}}
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
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
<!-- // Basic multiple Column Form section end -->

{{-- Modal --}}
<div class="modal fade" id="mymodal" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Data</h5>
        <button class="btn close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <i class="fa fa-spinner fa spin"></i>
        <p>Isi input <code>Required (*)</code>, Sebelum menekan tombol submit. </p>
        <form class="form" method="POST" action="{{ route('lending-archive.store') }}"
          enctype="multipart/form-data" id=myForm>
          @csrf
          <div class="row">
            <div class="col-md-6 col-12 mx-auto">
              <div class="form-group">
                <label for="lending_number">Nomor Peminjaman <code>*</code></label>
                <input type="text" id="lending_number" class="form-control" name="lending_number"
                  value="{{ $newLendingNumber }}" readonly>
              </div>
              <div class="form-group">
                <label for="user_id">Peminjam <code>*</code></label>
                <input type="text" id="user_id" class="form-control" value="{{ auth()->user()->name }}"
                  readonly>
              </div>
              <div class="form-group" hidden>
                <label for="start_date">Tanggal <code>*</code></label>
                <input type="text" id="start_date" class="form-control" name="start_date"
                  value="{{ now()->toDateString() }}">
              </div>
              <div class="form-group">
                {{-- @php
                  $divisionId = auth()->user()->division_id;
                  $division = DB::table('divisions')->find($divisionId); // Assuming Division is your model representing divisions

                  if ($division) {
                      $divisionName = $division->name;
                  } else {
                      $divisionName = ''; // Provide a default value or handle the case where the division is not found
                  }
                @endphp --}}
                <label for="division">Divisi <code>*</code></label>
                <input type="text" class="form-control" value="{{ auth()->user()->division->name ?? '' }}"
                  readonly>
              </div>
              <div class="form-group">
                <label for="description">keterangan</label>
                <textarea type="text" id="description" class="form-control" name="description"></textarea>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
              <button type="button" class="btn btn-light-secondary me-1 mb-1" data-dismiss="modal">Cancel</button>
            </div>

            <div class="form-group row">
              <table class="table col-md-12 lending-temp-table">
                <thead>
                  <tr style="font-size:80%;">
                    <th class="text-center" scope="col">#</th>
                    <th class="text-center" scope="col">No. Katalog/PP</th>
                    <th class="text-center" scope="col">No. Dokumen</th>
                    <th class="text-center" scope="col">No. Arsip</th>
                    <th class="text-center" scope="col">Tahun</th>
                    <th class="text-center" scope="col">Perihal</th>
                    {{-- <th class="text-center" scope="col">Tag</th> --}}
                    <th class="text-center" scope="col">Divisi</th>
                    <th class="text-center" scope="col">Tipe</th>
                    <th class="text-center" scope="col">Kategori<span style="color:red;">*</span>
                    </th>
                    <th class="text-center" scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

            {{-- <input type="hidden" id="archive_container_id" name="archive_container_id"> --}}
        </form>
      </div>
    </div>
  </div>
</div>

<div class="viewmodal" style="display: none;"></div>


@endsection
@push('after-script')
<script>
  function showSweetAlert(lendingId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteForm_' + lendingId).submit();
      }
    });
  }

  function update(lendingId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, update it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('update_' + lendingId).submit();
      }
    });
  }
</script>

<script>
  jQuery(document).ready(function($) {
    // Initialize the DataTable
    var table = $('#lending-table').DataTable({
      processing: true,
      serverSide: true,
      ordering: false,
      lengthMenu: [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, 'All']
      ],
      lengthChange: true,
      pageLength: 5,
      ajax: {
        url: "{{ route('lending-archive.index') }}",
        data: function(d) {
          // Add the year filter to the AJAX request data
          d.catalog = $('#catalogSearch').val();
          d.document = $('#documentSearch').val();
          d.archive = $('#archiveSearch').val();
          d.regarding = $('#regardingSearch').val();
          d.tag = $('#tagSearch').val();
          d.division = $('#divisionFilter').val();
          d.year = $('#yearFilter').val();
          d.type = $('#typeFilter').val();
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          width: '5%'
        },
        {
          data: 'number_catalog',
          name: 'number_catalog',
          width: '12%'
        },
        {
          data: 'number_document',
          name: 'number_document',
          width: '12%'
        },
        {
          data: 'number_archive',
          name: 'number_archive',
          width: '12%'
        },
        {
          data: 'year',
          name: 'year',
          width: '10%'
        },
        {
          data: 'regarding',
          name: 'regarding'
        },
        {
          data: 'tag',
          name: 'tag'
        },
        {
          data: 'division.code',
          name: 'division.code',
          width: '10%'
        },
        {
          data: 'archive_type',
          name: 'archive_type',
          width: '10%'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false,
          className: 'no-print',
          width: '10%',
          // render: function(data, type, row) {
          //   return '<button class="btn btn-primary lend-btn" data-row-id="' + row.id + '">Pilih</button>';
          // }
        },
      ],
      columnDefs: [{
          className: 'text-center',
          targets: '_all'
        },
        {
          targets: '_all',
          createdCell: function(td) {
            $(td).css('font-size', '80%');
          }
        }
      ],
    });

    // Event listener for the year filter dropdown
    $('#yearFilter').change(function() {
      table.draw();
    });
    // Event listener for the regarding search input
    $('#regardingSearch').keyup(function() {
      table.draw();
    });
    // Event listener for the regarding search input
    $('#catalogSearch').keyup(function() {
      table.draw();
    });

    $('#documentSearch').keyup(function() {
      table.draw();
    });

    $('#archiveSearch').keyup(function() {
      table.draw();
    });

    // Event listener for the regarding search input
    $('#tagSearch').keyup(function() {
      table.draw();
    });
    // Event listener for the regarding search input
    $('#divisionFilter').change(function() {
      table.draw();
    });
    $('#typeFilter').change(function() {
      table.draw();
    });
    // Event listener for the reset button
    $('#resetFilter').click(function() {
      $('#catalogSearch').val(''); // Clear the regarding search input
      $('#documentSearch').val(''); // Clear the regarding search input
      $('#archiveSearch').val(''); // Clear the regarding search input
      $('#regardingSearch').val(''); // Clear the regarding search input
      $('#tagSearch').val(''); // Clear the regarding search input
      $('#yearFilter').val(''); // Clear the year filter
      $('#divisionFilter').val(''); // Clear the regarding search input
      $('#typeFilter').val(''); // Clear the regarding search input
      table.draw(); // Redraw the table
    });

    // Event listener for the Lend button
    $('#lending-table').on('click', '.lend-btn', function() {
      var rowId = $(this).data('row-id');
      var rowData = table.row(function(idx, data, node) {
        return data.id === rowId;
      }).data();

      if (rowData) {
        // Check if the row already exists in the lending-temp-table
        var exists = false;
        $('.lending-temp-table tbody tr').each(function() {
          if ($(this).data('row-id') === rowId) {
            exists = true;
            return false; // Exit the loop
          }
        });

        // Check if the item does not already exist
        if (!exists) {
          // Calculate the current row count in the table
          var rowCount = $('.lending-temp-table tbody tr').length + 1;

          // Common row HTML
          var commonRowHtml = '<tr data-row-id="' + rowId + '" style="font-size:80%;">' +
            '<td class="text-center"> <input type="hidden" name="inputs[' + rowId +
            '][archive_container_id]" value="' + rowId +
            '" readonly hidden>' + rowCount + '</td>' + // Auto-incremented number
            '<td class="text-center">' + rowData.number_catalog + '</td>' +
            '<td class="text-center">' + rowData.number_document + '</td>' +
            '<td class="text-center">' + rowData.number_archive + '</td>' +
            '<td class="text-center">' + rowData.year + '</td>' +
            '<td class="text-center">' + rowData.regarding + '</td>' +
            // '<td class="text-center">' + rowData.tag + '</td>' +
            '<td class="text-center">' + rowData.division.code + '</td>' +
            '<td class="text-center">' + rowData.archive_type + '</td>';

          // Complete row HTML for lending-temp-table
          var lendingRowHtml = commonRowHtml +
            '<td class="text-center">' +
            '<select name="inputs[' + rowId + '][document_type]" class="form-control" required>' +
            '<option value="" selected disabled>Choose</option>' +
            '<option value="FISIK">FISIK</option>' +
            '<option value="DIGITAL">DIGITAL</option>' +
            '</select>' +
            '</td>' +
            '<td class="text-center no-print">' +
            '<a class="btn btn-danger cancel-btn" data-row-id="' + rowId + '"><i class="bi bi-x"></i></a>' +
            '</td>' +
            '</tr>';

          // Complete row HTML for another-table-class (without document_type and action columns)
          var anotherRowHtml = commonRowHtml + '</tr>';

          // Append the new row to both tables
          $('.lending-temp-table tbody').append(lendingRowHtml);
          $('.a tbody').append(anotherRowHtml);
        } else {
          alert('This item has already been added.');
        }
      }
    });

    // Event listener for the Cancel button
    $(document).on('click', '.cancel-btn', function() {
      var rowId = $(this).data('row-id');
      $('tr[data-row-id="' + rowId + '"]').remove();
    });


    // Collect only the IDs from the lending-temp-table before form submission
    // $('#myForm').submit(function(event) {
    //   var lendingItems = [];
    //   $('.lending-temp-table tbody tr').each(function() {
    //     var rowId = $(this).data('row-id');
    //     var typeDocument = $(this).find('select[name="inputs[' + rowId + ']"]')
    //       .val(); // Get the selected copy type
    //     lendingItems.push({
    //       id: rowId,
    //       document_type: typeDocument,
    //     });
    //   });
    //   $('#archive_container_id').val(JSON.stringify(lendingItems));
    // });
  });
</script>

{{-- <script>
    $(document).ready(function() {
      // Array to store selected IDs
      let selectedIds = [];

      // Event listener for change event on select element
      $(document).on('change', 'select[name^="inputs["]:not([name$="[document_type]"])', function() {
        // Get the selected ID
        let selectedId = $(this).val();

        // Check if the selected ID already exists in the array
        if (selectedIds.includes(selectedId)) {
          alert("This ID is already selected. Please choose a different one.");
          $(this).val(""); // Clear the selected value
          return; // Exit function
        }

        // Add the selected ID to the array
        selectedIds.push(selectedId);

        // Disable the option with the selected ID in all other select elements
        $('select[name^="inputs["]:not([name$="[document_type]"])').not(this).find('option').prop('disabled',
          function() {
            return $(this).val() === selectedId;
          });
      });

      $('#add-archive').click(function() {
        // Check if the select value is filled
        let selectValueFilled = true;
        $('select[name^="inputs["]:not([name$="[document_type]"])').each(function() {
          if ($(this).val() === "") {
            selectValueFilled = false;
            return false; // Exit the loop early if any select value is not filled
          }
        });

        // If select value is not filled, alert the user and return
        if (!selectValueFilled) {
          alert("Please fill all select values before adding more rows.");
          return;
        }

        // Increment index for unique IDs
        let a = selectedIds.length + 1;

        // Append a new row
        $('#table-archive').append(`
          <tr>
            <td class="text-center text-primary">${a}</td>
            <td>
               <select name="inputs[${a}][archive_container_id]" class="form-control select2 choices" style="width: 100%">
            <option value="" disabled selected>Choose</option>
            @foreach ($archiveContainers as $app)
              <option value="{{ $app->id }}" data-value="{{ $app->regarding }}" data-value2="{{ $app->division->name }}" data-app="{{ $app->id }}">{{ $app->number_document }}</option>
            @endforeach
          </select>
            </td>
            <td><input type="text" class="form-control version" id="version_${a}" readonly></td>
            <td><input type="text" class="form-control product" id="product_${a}" readonly></td>
            <td><select type="text" class="form-control" name="inputs[${a}][document_type]" readonly>
              <option value="" selected disabled>Choose</option>
              <option value="FISIK">Fisik</option>
              <option value="DIGITAL">Digital</option>
              </select></td>
            <td>
              <button type="button" class="btn btn-danger remove-row">Remove</button></td>
          </tr>
        `);

        // Initialize Select2 for the newly added select element
        $('.select2').select2({
          dropdownParent: $("#mymodal"),
          theme: 'classic', // Apply the 'classic-dark' theme
        });

        // Disable options that have been selected in other rows
        $('select[name^="inputs["]:not([name$="[document_type]"]').each(function() {
          let selectedId = $(this).val();
          $(this).find('option').prop('disabled', function() {
            return selectedIds.includes($(this).val()) && $(this).val() !== selectedId;
          });
        });
      });

      $(document).on('change', 'select[name^="inputs["]:not([name$="[document_type]"])', function() {
        var selectedOption = $(this).find(':selected');
        var versionValue = selectedOption.data('value') || '';
        var productValue = selectedOption.data('value2') || '';

        $(this).closest('tr').find('.version').val(versionValue);
        $(this).closest('tr').find('.product').val(productValue);
      });

      $(document).on('click', '.remove-row', function() {
        // Get the removed ID
        let removedId = $(this).closest('tr').find('select').val();

        // Remove the ID from the array
        selectedIds = selectedIds.filter(id => id !== removedId);

        // Remove the entire row when the "Remove" button is clicked
        $(this).closest('tr').remove();

        // Enable the option with the removed ID in all other select elements
        $('select[name^="inputs["]:not([name$="[document_type]"])').find('option').prop('disabled', false);
        $('select[name^="inputs["]:not([name$="[document_type]"])').each(function() {
          let selectedId = $(this).val();
          $(this).find('option').prop('disabled', function() {
            return selectedIds.includes($(this).val()) && $(this).val() !== selectedId;
          });
        });
      });
    });
  </script> --}}

{{-- modal --}}
<script>
  jQuery(document).ready(function($) {
    $('#detailLending').on('show.bs.modal', function(e) {
      var button = $(e.relatedTarget);
      var modal = $(this);

      modal.find('.modal-body').load(button.data("remote"));
      modal.find('.modal-title').html(button.data("title"));
    });
  });
</script>

{{-- Fancybox --}}
<script>
  Fancybox.bind('[data-fancy]', {
    infinite: false,
    zIndex: 2100
  });
</script>

<div class="modal fade " data-backdrop="false" id="detailLending" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button class="btn close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <i class="fa fa-spinner fa spin"></i>
      </div>
    </div>
  </div>
</div>
@endpush
@push('after-style')
<style>
  #detailLending {
    z-index: 1001;
    background-color: rgba(0, 0, 0, 0.5);
  }

  /* .modal-backdrop {
                                                                                                                                                                                                                                                                                                                                        z-index: 991;
                                                                                                                                                                                                                                                                                                                                        display: none;
                                                                                                                                                                                                                                                                                                                                      } */

  /* Dark theme for Select2 with hover effect */
  html[data-bs-theme="dark"] .select2-container--classic .select2-selection--single,
  html[data-bs-theme="dark"] .select2-container--classic .select2-selection--multiple {
    background-color: #1b1b29 !important;
    border-color: #1b1b29 !important;
    color: #fff !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-selection__arrow b {
    border-color: #1b1b29 transparent transparent transparent !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-selection__placeholder {
    color: #aaa !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-selection__rendered {
    color: #fff !important;
    background-color: #1b1b29 !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-dropdown {
    background-color: #1b1b29 !important;
    border-color: #1b1b29 !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-results__option {
    background-color: #1b1b29 !important;
    color: #fff !important;
    transition: background-color 0.1s;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-results__option:hover {
    background-color: #28283c !important;
    color: #fff !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-results__option[aria-selected="true"] {
    background-color: #28283c !important;
    color: #fff !important;
  }
</style>
@endpush
