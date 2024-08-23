@extends('layouts.app')

@section('title', 'Folder Division')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Folder Divisi</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Folder Divisi</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    @can('create_folder')
      <a href="#mymodal" data-toggle="modal" data-target="#mymodal" class="btn btn-primary my-2">
        <i class="bi bi-plus-lg"></i>
        Add Folder</a>
    @endcan

    {{-- <div class="row">
      <form class="form" method="POST" action="{{ route('folder.store') }}" enctype="multipart/form-data"
        id="myForm">
        @csrf
        <div class="form-group">
          <label for="basicInput">Name</label>
          <input type="text" class="form-control" id="basicInput" name="name" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="basicInput">Description</label>
          <textarea type="text" class="form-control" id="basicInput" name="description" placeholder="Enter email"></textarea>
        </div>

        <div class="form-group">
          <label for="helperText">Parent</label>
          <select type="text" id="helperText" class="form-control" name="parent">
            <option value="none">No Parent</option>
            @foreach ($folders as $folder)
              <option value="{{ $folder->id }}">{{ $folder->name }}</option>
            @endforeach
          </select>
          <p><small class="text-muted">Find helper text here for given textbox.</small></p>
        </div>
        <button type="submit" class="btn btn-info">OK</button>
      </form>
    </div> --}}

    {{-- <div class="row">
      @forelse ($folders as $folder)
        <div class="col-6 col-lg-2 col-md-6">
          <div class="card">
            @canany(['admin', 'super_admin'])
              <div class="container">
                <a href="#" onclick="showSweetAlert({{ $folder->id }})"><i class="bi bi-x"></i></a>
                <form id="deleteForm_{{ $folder->id }}" action="{{ route('folder.destroy', $folder->id) }}"
                  method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                </form>
              </div>
            @endcanany
            <div class="card-body ">
              <div class="row">
                <a href="{{ route('folder.show', $folder->id ?? $folders->id) }}">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                    <div class="stats-icon red mb-2">
                      <i class="ri-folder-6-line"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">
                      <small>
                        {{ $folder->name ?? $folders->name }}
                      </small>
                    </h6>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="container">
          <div class="card">
            <div class="card-body ">
              <h6 class="font-extrabold mb-0 text-center">
                Folder Empty
              </h6>
            </div>
          </div>
        </div>
      @endforelse
    </div> --}}

    <div class="row">
      @forelse ($folders as $folder)
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            @canany(['admin', 'super_admin'])
              <div class="container d-flex justify-content-between">
                @if ($folder->is_lock == false)
                  <a href="#" onclick="showSweetAlert({{ $folder->id }})" title="Delete folder">
                    <i class="bi bi-x"></i>
                  </a>

                  <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-menu-{{ $folder->id }}" class="ms-auto"
                    title="Edit folder"> <i class="bi bi-three-dots"></i></a>
                  @include('pages.transaction-archive.folder-division.edit')

                  <form id="deleteForm_{{ $folder->id }}" action="{{ route('folder.destroy', $folder->id) }}"
                    method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                  </form>

                  <a href="{{ route('lockFolder', $folder->id) }}" class="position-absolute"
                    style="bottom: 10px; right: 10px;" title="Kunci Folder"
                    onclick="return confirm('Apakah anda yakin mengunci folder?')">
                    <i class="bi bi-unlock"></i>
                  </a>
                @else
                  @can('super_admin')
                    <a href="{{ route('lockFolder', $folder->id) }}" class="position-absolute"
                      style="bottom: 10px; right: 10px;" title="Buka Folder"
                      onclick="return confirm('Apakah anda yakin membuka folder?')">
                      <i class="bi bi-lock"></i>
                    </a>
                  @else
                    <a href="#" class="position-absolute" style="bottom: 10px; right: 10px;" title="Buka Folder"
                      onclick="alert('Hubungi Administrator untuk membuka kunci!')">
                      <i class="bi bi-lock"></i>
                    </a>
                  @endcan
                @endif

              </div>
            @endcanany
            <a href="{{ route('folder.show', $folder->id ?? $folders->id) }}">
              <div class="card-body d-flex align-items-center">
                <div class="stats-icon red me-2 col-1"> <!-- Added margin to the right -->
                  <i class="ri-folder-6-line"></i>
                </div>
                <div class="folder-name">
                  <h6 class="text-muted font-semibold" style="font-size: 80%">
                    {{ $folder->name ?? $folders->name }}
                  </h6>
                </div>
              </div>
            </a>
          </div>
        </div>
      @empty
        <div class="container">
          <div class="card">
            <div class="card-body text-center">
              <h6 class="font-extrabold mb-0">
                Folder Empty
              </h6>
            </div>
          </div>
        </div>
      @endforelse
    </div>

    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Notification</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Nomor</th>
                <th class="text-center">Tanggal Notifikasi</th>
                <th class="text-center">Pengingat</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Folder</th>
                {{-- <th class="text-center">File</th> --}}
                {{-- <th class="text-center">Action</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($notifications as $notif)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td class="text-center">{{ $notif->number ?? 'N/A' }}</td>
                  <td class="text-center">
                    {{ Carbon\Carbon::parse($notif->date_notifikasi)->translatedFormat('l, d F Y') ?? 'N/A' }}
                  </td>
                  <td class="text-center">{{ $notif->notification ?? 'N/A' }}</td>
                  <td class="text-center">{{ $notif->description ?? 'N/A' }}</td>
                  <td class="text-center">
                    @if ($notif->folder->ancestors->count() > 3)
                      .../
                    @endif
                    @forelse ($notif->folder->ancestors->slice(-3) as $ancestor)
                      <small>{{ $ancestor->name }}</small> /
                    @empty
                    @endforelse
                    <strong>
                      <a href="{{ route('folder.show', $notif->folder->id) }}">{{ $notif->folder->name }}</a>
                    </strong>
                  </td>
                  {{-- <td class="text-center"><a type="button" href="{{ asset('storage/' . $file->file) }}"
                      class="btn btn-warning btn-sm text-white " download>Unduh</a>
                    <p class="mt-1"><small>{{ pathinfo($file->file, PATHINFO_FILENAME) }}</small></p>
                  </td> --}}
                  {{-- <td class="text-center">Action</td> --}}
                  {{-- <td class="text-center">
                    @foreach ($file->ancestors as $ances)
                      {{ $ances->name }},
                    @endforeach
                  </td> --}}
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="viewmodal" style="display: none;"></div>
    </div>

    <!--Recent-->
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Recent File</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Nomor</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Folder</th>
                {{-- <th class="text-center">File</th> --}}
                {{-- <th class="text-center">Action</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($folderFiles as $file)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td class="text-center">{{ $file->number ?? 'N/A' }}</td>
                  <td class="text-center">{{ Carbon\Carbon::parse($file->date)->translatedFormat('l, d F Y') ?? 'N/A' }}
                  </td>
                  <td class="text-center">{{ $file->description ?? 'N/A' }}</td>
                  <td class="text-center">
                    @if ($file->folder->ancestors->count() > 3)
                      .../
                    @endif
                    @forelse ($file->folder->ancestors->slice(-3) as $ancestor)
                      <small>{{ $ancestor->name }}</small> /
                    @empty
                    @endforelse
                    <strong>
                      <a href="{{ route('folder.show', $file->folder->id) }}">{{ $file->folder->name }}</a>
                    </strong>
                  </td>
                  {{-- <td class="text-center"><a type="button" href="{{ asset('storage/' . $file->file) }}"
                      class="btn btn-warning btn-sm text-white " download>Unduh</a>
                    <p class="mt-1"><small>{{ pathinfo($file->file, PATHINFO_FILENAME) }}</small></p>
                  </td> --}}
                  {{-- <td class="text-center">Action</td> --}}
                  {{-- <td class="text-center">
                    @foreach ($file->ancestors as $ances)
                      {{ $ances->name }},
                    @endforeach
                  </td> --}}
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="viewmodal" style="display: none;"></div>
    </div>

    <div class="modal fade" data-backdrop="false" id="mymodal" tabindex="-1" dialog>
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Folder</h5>
            <button class="btn close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form" method="POST" action="{{ route('folder.store') }}" enctype="multipart/form-data"
            id="myForm">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="form-group">
                  <label for="basicInput">Nama Folder <code style="color:red;">*</code></label>
                  <input type="text" class="form-control" id="basicInput" name="name" placeholder="name"
                    required>
                </div>
                <div class="form-group">
                  <label for="basicInput">Keterangan</label>
                  <textarea type="text" class="form-control" id="basicInput" name="description" placeholder="description"></textarea>
                </div>

                {{-- <div class="form-group">
                  <label for="helperText">Parent</label>
                  <select type="text" id="helperText" class="form-control" name="parent">
                    <option value="none">No Parent</option>
                    @foreach ($folders as $folder)
                      <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                    @endforeach
                  </select>
                  <p><small class="text-muted">Find helper text here for given textbox.</small></p>
                </div> --}}

              </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button class="btn btn-warning" style="width:120px;" type="button" data-dismiss="modal"
                aria-label="Close">
                Close
              </button>
              <button type="submit" style="width:120px;" class="btn btn-info">Submit</button>
            </div>
          </form>

        </div>
      </div>
    </div>

  </section>

@endsection
@push('after-script')
  <script>
    function showSweetAlert(folderId) {
      Swal.fire({
        title: 'Are you sure?',
        html: 'Jika menghapus folder, semua data di dalamnya akan terhapus!<br><small class="text-danger">Pastikan folder kosong sebelum dihapus!</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + folderId).submit();
        }
      });
    }
  </script>

  {{-- <script>
    jQuery(document).ready(function($) {
      $('#container-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All']
        ],
        lengthChange: true,
        pageLength: 15,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'copy',
            className: "btn btn-info"
          },
          {
            extend: 'excel',
            className: "btn btn-info"
          },
          {
            extend: 'print',
            className: "btn btn-info",
            exportOptions: {
              columns: ':not(.no-print)' // Exclude elements with class 'no-print'
            }
          },
        ],
        ajax: {
          url: "{{ route('archive-container.index') }}",
        },

        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%',
          },
          {
            data: 'number_container',
            name: 'number_container',
          },
          {
            data: 'number_document',
            name: 'number_document',
          },
          {
            data: 'regarding',
            name: 'regarding',
          },
          {
            data: 'division.name',
            name: 'division.name',
          },
          {
            data: 'detail_location',
            name: 'detail_location',
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            className: 'no-print' // Add this class to exclude the column from printing
          },
        ],
        columnDefs: [{
          className: 'text-center',
          targets: '_all'
        }, ],
      });
    });
  </script>
  <script>
    function upload() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: "get",
        url: "{{ route('form_upload') }}",
        dataType: "json",
        success: function(response) {
          $('.viewmodal').html(response.data).show();
          $('#modalupload').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    }

    jQuery(document).ready(function($) {
      console.log('Document is ready');

      $('#mymodal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var modal = $(this);

        modal.find('.modal-body').load(button.data("remote"));
        modal.find('.modal-title').html(button.data("title"));
      });
    });
  </script>
  <div class="modal fade" data-backdrop="false" id="mymodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
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
        <div style="text-align: right;">
          <button class="btn btn-warning mb-2 mx-2" style="width: 10%" type="button" data-dismiss="modal"
            aria-label="Close">
            Close
          </button>
        </div>
      </div>
    </div>
  </div> --}}

  <style>
    #mymodal {
      z-index: 1001;
      background-color: rgba(0, 0, 0, 0.5);
    }
  </style>
@endpush
