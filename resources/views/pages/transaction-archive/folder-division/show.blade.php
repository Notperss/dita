@extends('layouts.app')

@section('title', 'Folder Division')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>{{ $folders->name }}</h3>
          {{-- <p class="text-subtitle text-muted">List all data from {{ $folders->name }}.</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            {{-- <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item active" aria-current="page">Folder Divisi</li>
            </ol> --}}
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('backsite.folder.index') }}">Home</a></li>
              @foreach ($ancestors as $ancestor)
                <li class="breadcrumb-item"><a
                    href="{{ route('backsite.folder.show', $ancestor->id) }}">{{ $ancestor->name }}</a>
                </li>
              @endforeach
              <li class="breadcrumb-item active" aria-current="page">{{ $folders->name }}</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    @can('create_folder')
      <a href="#mymodal" data-toggle="modal" data-target="#mymodal" class="btn btn-primary my-2"> <i
          class="bi bi-plus-lg"></i>
        Add Folder</a>
    @endcan

    <div class="row">
      @forelse ($descendants as $descendant)
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
            @canany(['admin', 'super_admin'])
              <div class="container">
                <a href="#" onclick="deleteFolder({{ $descendant->id }})">
                  <i class="bi bi-x"></i>
                </a>
                <form id="deleteForm_{{ $descendant->id }}" action="{{ route('backsite.folder.destroy', $descendant->id) }}"
                  method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                </form>
              </div>
            @endcanany
            <a href="{{ route('backsite.folder.show', $descendant->id ?? $descendants->id) }}">
              <div class="card-body d-flex align-items-center">
                <div class="stats-icon red me-2"> <!-- Added margin to the right -->
                  <i class="ri-folder-6-line"></i>
                </div>
                <div class="folder-name">
                  <h6 class="text-muted font-semibold">
                    {{ $descendant->name ?? $descendants->name }}
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

    <div class="row">
      <div class="container">
        <a href="{{ $folders->parent_id ? route('backsite.folder.show', $folders->parent_id) : url('backsite/folder') }}"
          class="btn btn-outline-primary mb-5"><i class="bi bi-arrow-left"></i>Back</a>
      </div>
    </div>

    <div class="row">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">

            <button type="button" onclick="upload({{ $folders->id }})" class="btn btn-primary"> <i
                class="bi bi-plus-lg"></i>
              Add File</button>
          </h5>
        </div>
        <div class="card-body">
          <h3>File</h3>
          <div class="table-responsive">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Nomor</th>
                  <th class="text-center">Tanggal</th>
                  <th class="text-center">Keterangan</th>
                  <th class="text-center">File</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach ($folders->folder_item as $folderItem)
                  {{ $folderItem->number ?? 'N/A' }}
                @endforeach --}}
                @foreach ($files as $file)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $file->number ?? 'N/A' }}</td>
                    <td class="text-center">{{ $file->date ?? 'N/A' }}</td>
                    <td class="text-center">{{ $file->description ?? 'N/A' }}</td>
                    <td class="text-center"><a type="button" href="{{ asset('storage/' . $file->file) }}"
                        class="btn btn-warning btn-sm text-white " download>Unduh</a>
                      <p class="mt-1"><small>{{ pathinfo($file->file, PATHINFO_FILENAME) }}</small></p>
                    </td>
                    <td class="text-center">
                      @php
                        $fileCreationDate = \Carbon\Carbon::parse($file->created_at);
                        $now = \Carbon\Carbon::now();
                        $isOlderThanThreeDays = $fileCreationDate->diffInDays($now) > 3;

                        // $isOlderThanThreeDays = $fileCreationDate->diffInSeconds($now) > 5;

                      @endphp
                      @canany(['admin', 'super_admin'])
                        <button onclick="deleteFile({{ $file->id }})" class="btn btn-sm btn-danger">
                          </i>Delete</button>

                        <form id="deleteFile_{{ $file->id }}"
                          action="{{ route('backsite.folder.delete_file', $file->id) }}" method="POST"
                          style="display:inline;">
                          @csrf
                          @method('DELETE')
                        </form>
                      @else
                        @if (!$isOlderThanThreeDays)
                          <button onclick="deleteFile({{ $file->id }})" class="btn btn-sm btn-danger">
                            Delete
                          </button>

                          <form id="deleteFile_{{ $file->id }}"
                            action="{{ route('backsite.folder.delete_file', $file->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                          </form>
                          {{-- <p>Time remaining:<br> <small><span id="countdown"></span></small></p> --}}
                        @endif
                      @endcanany
                    </td>
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
          <form class="form" method="POST" action="{{ route('backsite.folder.store') }}"
            enctype="multipart/form-data" id="myForm">
            @csrf
            <div class="modal-body">
              <div class="row">
                <input type="hidden" name="parent" value="{{ $folders->id }}">
                <div class="form-group">
                  <label for="basicInput">Nama Folder <code style="color:red;">*</code></label>
                  <input type="text" class="form-control" id="basicInput" name="name" placeholder="name"
                    required>
                </div>
                <div class="form-group">
                  <label for="basicInput">Keterangan</label>
                  <textarea type="text" class="form-control" id="basicInput" name="description" placeholder="description"></textarea>
                </div>
              </div>
              <div class="modal-footer d-flex justify-content-between">
                <button class="btn btn-warning" style="width:120px;" type="button" data-dismiss="modal"
                  aria-label="Close">
                  Close
                </button>
                <button type="submit" style="width:120px;" class="btn btn-primary">Submit</button>
              </div>
          </form>
        </div>
      </div>
    </div>


  </section>

@endsection
@push('after-script')
  <script>
    function deleteFolder(folderId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'Jika menghapus folder semua data didalam akan terhapus!',
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

    function deleteFile(folderId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteFile_' + folderId).submit();
        }
      });
    }
  </script>

  {{-- Countdown --}}
  {{-- <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      const fileCreationDate = new Date('{{ $fileCreationDate->toIso8601String() }}');
      const countdownElement = document.getElementById('countdown');

      function updateCountdown() {
        const now = new Date();
        const diffTime = Math.abs(now - fileCreationDate);
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
        const diffHours = Math.floor((diffTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const diffMinutes = Math.floor((diffTime % (1000 * 60 * 60)) / (1000 * 60));
        const diffSeconds = Math.floor((diffTime % (1000 * 60)) / 1000);

        if (diffDays > 3) {
          countdownElement.innerHTML = 'The file is older than three days.';
        } else {
          countdownElement.innerHTML =
            `${2 - diffDays}d ${23 - diffHours}h ${59 - diffMinutes}m ${59 - diffSeconds}s`;
        }
      }

      setInterval(updateCountdown, 1000);
    });
  </script> --}}

  {{-- <script>
    function buttonSweet() {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('myForm').submit();
        }
      });
    }
  </script> --}}

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
          url: "{{ route('backsite.archive-container.index') }}",
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

  --}}
  <script>
    function upload(id) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: "post",
        url: "{{ route('backsite.folder.form_upload') }}",
        data: {
          id: id
        },
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

    // jQuery(document).ready(function($) {
    //   console.log('Document is ready');

    //   $('#mymodal').on('show.bs.modal', function(e) {
    //     var button = $(e.relatedTarget);
    //     var modal = $(this);

    //     modal.find('.modal-body').load(button.data("remote"));
    //     modal.find('.modal-title').html(button.data("title"));
    //   });
    // });
  </script>
  <div class="modal fade" data-backdrop="false" id="mymodal" tabindex="-1" dialog>
    <div class="modal-dialog modal-xl" document>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add File</h5>
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
  </div>

  <style>
    #mymodal {
      z-index: 1001;
      background-color: rgba(0, 0, 0, 0.5);
    }
  </style>
@endpush
