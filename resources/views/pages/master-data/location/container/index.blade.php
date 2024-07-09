@extends('layouts.app')

@section('title', 'Container Location')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Container Location</h3>
          <p class="text-detailtitle text-muted">List all data from the Container location.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Container Location</li>
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
          <a href="{{ route('backsite.container-location.create') }}" class="btn btn-primary"> <i
              class="bi bi-plus-lg"></i>
            Add data</a>
        </h5>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="location-container-table">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Container</th>
              <th class="text-center">Divisi</th>
              <th class="text-center">Lokasi Utama</th>
              <th class="text-center">Sub Lokasi</th>
              <th class="text-center">Detail Lokasi</th>
              {{-- <th class="text-center">Keterangan</th> --}}
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            {{-- @foreach ($containerLocations as $containerLocation)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $containerLocation->mainLocation->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $containerLocation->subLocation->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $containerLocation->detailLocation->name ?? 'N/A' }}</td>
                <td class="text-center">
                  {{ isset($containerLocation->number_container) ? str_pad($containerLocation->number_container, 3, '0', STR_PAD_LEFT) : 'N/A' }}
                </td>
                <td class="text-center">{{ $containerLocation->division->name ?? 'N/A' }}</td>
                <td class="text-center">
                  <a href="{{ route('backsite.container-location.edit', $containerLocation->id) }}"
                    class="btn icon btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $containerLocation->id }}')">
                    <i class="bi bi-x-lg"></i>
                  </a>

                  <form id="deleteForm_{{ $containerLocation->id }}"
                    action="{{ route('backsite.container-location.destroy', encrypt($containerLocation->id)) }}"
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

  </section>
  {{-- <script>
    function showSweetAlert(containerLocationId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + containerLocationId).submit();
        }
      });
    }
  </script> --}}

@endsection

@push('after-script')
  <script>
    function showSweetAlert(containerLocationId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + containerLocationId).submit();
        }
      });
    }
  </script>

  <script>
    jQuery(document).ready(function($) {
      $('#location-container-table').DataTable({
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
          url: "{{ route('backsite.container-location.index') }}",
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
            data: 'main_location_id',
            name: 'main_location_id',
          },
          {
            data: 'sub_location_id',
            name: 'sub_location_id',
          },
          {
            data: 'detail_location_id',
            name: 'detail_location_id',
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
