@extends('layouts.app')

@section('title', 'Penyimpanan Arsip')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Penyimpanan Arsip</h3>
          <p class="text-subtitle text-muted">List all data from the archive.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Penyimpanan Arsip</li>
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
          <a href="{{ route('archive-container.create') }}" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data</a>
          @can('super_admin')
            <a href="{{ route('deletedArchives') }}" class="btn btn-danger">Deleted Archives</a>
          @endcan
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
              <th class="text-center" style="word-break: break-all">Nomor Dokumen</th>
              <th class="text-center">Perihal</th>
              <th class="text-center">Divisi</th>
              <th class="text-center">Detail Lokasi</th>
              <th class="text-center">Lock</th>
              {{-- <th class="text-center">keterangan</th> --}}
              <th class="text-center" style="width: 15%">Action</th>
            </tr>
          </thead>
          <tbody>

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
        ordering: false,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All']
        ],
        lengthChange: true,
        pageLength: 15,
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
            createdCell: function(td, cellData, rowData, row, col) {
              $(td).css('word-break', 'break-all');
            }
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
            data: 'is_lock',
            name: 'is_lock',
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
  </div>

  <style>
    #mymodal {
      z-index: 1001;
      background-color: rgba(0, 0, 0, 0.5);
    }
  </style>
@endpush
