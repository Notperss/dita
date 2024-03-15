@extends('layouts.app')

@section('title', 'Archive Container')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Archive Container</h3>
          <p class="text-subtitle text-muted">List all data from the archive Container.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item active" aria-current="page">Archive Container</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          <a href="{{ route('backsite.archive-container.create') }}" class="btn btn-primary"> <i
              class="bi bi-plus-lg"></i>
            Add data</a>
          {{-- <a onclick="upload()" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data File</a> --}}
        </h5>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="container-table">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">No. Container</th>
              <th class="text-center">Divisi</th>
              <th class="text-center">Lokasi Utama</th>
              <th class="text-center">Sub Lokasi</th>
              <th class="text-center">Detail Lokasi</th>
              {{-- <th class="text-center">keterangan</th> --}}
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            {{-- @foreach ($archiveContainers as $archiveContainer)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $archiveContainer->number_container ?? 'N/A' }}</td>
                <td class="text-center">{{ $archiveContainer->division->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $archiveContainer->main_location ?? 'N/A' }}</td>
                <td class="text-center">{{ $archiveContainer->sub_location ?? 'N/A' }}</td>
                <td class="text-center">{{ $archiveContainer->detail_location ?? 'N/A' }}</td>
                <td class="text-center">
                  <a type="button" title="Tambah File" class="btn icon btn-sm btn-info" onclick=""><i
                      class="bi bi-files"></i></a>
                  <div class="btn-group mb-1">
                    <div class="dropdown">
                      <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Option 2</a>
                        <a class="dropdown-item"
                          href="{{ route('backsite.archive-container.edit', $archiveContainer->id) }}">Edit</a>
                        <a class="dropdown-item" onclick="showSweetAlert('{{ $archiveContainer->id }}')">Delete</a>
                      </div>
                    </div>
                  </div>
                  <form id="deleteForm_{{ $archiveContainer->id }}"
                    action="{{ route('backsite.archive-container.destroy', encrypt($archiveContainer->id)) }}"
                    method="POST">
                    @method('DELETE')
                    @csrf
                  </form>
                </td>
              </tr>
            @endforeach --}}
          </tbody>
        </table>
      </div>
    </div>
    <div class="viewmodal" style="display: none;"></div>


  </section>

@endsection
@push('after-script')
  <script>
    function showSweetAlert(archiveContainerId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + archiveContainerId).submit();
        }
      });
    }
  </script>

  <script>
    jQuery(document).ready(function($) {
      $('#container-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
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
            data: 'division.name',
            name: 'division.name',
          },
          {
            data: 'main_location',
            name: 'main_location',
          },
          {
            data: 'sub_location',
            name: 'sub_location',
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
        url: "{{ route('backsite.form_upload') }}",
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
  <div class="modal fade" id="mymodal" tabindex="-1" role="dialog">
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
