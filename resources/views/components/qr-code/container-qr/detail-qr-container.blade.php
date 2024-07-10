@extends('layouts.app')

@section('title', 'Archive Container')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Detail Container</h3>
          {{-- <p class="text-subtitle text-muted">List all data from the archive Container.</p> --}}
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">
        {{-- <h5 class="card-title">
          <a href="{{ route('archive-container.create') }}" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data</a>
          <a onclick="upload()" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data File</a>
        </h5> --}}
      </div>
      <div class="card-body">

        <table class="table table-bordered">
          <tr>
            <th>Nomor Kontainer</th>
            <td>
              {{ isset($containerLocation->number_container) ? str_pad($containerLocation->number_container, 3, '0', STR_PAD_LEFT) : 'N/A' }}
            </td>
          </tr>
          <tr>
            <th>Divisi</th>
            <td>
              {{ isset($containerLocation->division->name) ? $containerLocation->division->name : 'N/A' }}
            </td>
          </tr>
          <tr>
            <th>Lokasi utama</th>
            <td>
              {{ isset($containerLocation->mainLocation->name) ? $containerLocation->mainLocation->name : 'N/A' }}
            </td>
          </tr>

          <tr>
            <th>Sub utama</th>
            <td>
              {{ isset($containerLocation->subLocation->name) ? $containerLocation->subLocation->name : 'N/A' }}
            </td>
          </tr>

          <tr>
            <th>Detail utama</th>
            <td>
              {{ isset($containerLocation->detailLocation->name) ? $containerLocation->detailLocation->name : 'N/A' }}
            </td>
          </tr>

          <tr>
            <th>Keterangan</th>
            <td>
              {{ isset($containerLocation->description) ? $containerLocation->description : 'N/A' }}
            </td>
          </tr>
        </table>


      </div>
    </div>

    <div class="viewmodal" style="display: none;"></div>

  </section>

@endsection
@push('after-script')
  {{-- <script>
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
  </script> --}}
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
