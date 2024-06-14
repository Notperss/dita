@extends('layouts.app')

@section('title', 'Destruction Archive')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Activity Log</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <section class="section">

    {{-- <div class="row">
      <h5>Arsip Inaktif Divisi</h5>
      @foreach ($divisions as $division)
        <div class="col-6 col-lg-2 col-md-6">
          <div class="card">
            <div class="card-body ">
              <div class="row">
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-muted font-semibold">
                    <a href="{{ route('backsite.division-destruct', encrypt($division->id)) }}">{{ $division->code }}</a>
                  </h6>
                  <h6 class="font-extrabold mb-0">
                    @php
                      $expirationDate = 0; // Reset the variable for each division
                      $archivesContainer = $division->archive_container;
                      // Assuming $archivesContainer is a collection
                      $expirationDate += $archivesContainer
                          ->filter(function ($archive) {
                              return $archive->expiration_inactive < now()->toDateString();
                          })
                          ->where('status', 1)
                          ->count();
                    @endphp
                    {{ $expirationDate }}
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div> --}}


    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          {{-- <a href="{{ route('backsite.archive-container.create') }}" class="btn btn-primary">
            Pratinjau Pemusnahan Arsip
          </a> --}}
          {{-- <a href="{{ route('backsite.archive-not-destroy', encrypt($division->id)) }}" class="btn btn-primary">
            Arsip yang tidak Dimusnahkan
          </a> --}}
          {{-- <a onclick="upload()" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data File</a> --}}
        </h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="log-table">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Log Name</th>
                <th class="text-center">User</th>
                <th class="text-center">Description</th>
                <th class="text-center">Created At</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              {{-- @foreach ($activities as $activity)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td class="text-center">{{ $activity->log_name ?? 'N/A' }}</td>
                  <td class="text-center">{{ $activity->causer->name ?? 'N/A' }}</td>
                  <td class="text-center">{{ $activity->description ?? 'N/A' }}</td>
                  <td class="text-center">
                    {{ optional($activity->created_at)->diffForHumans() ?? 'N/A' }}
                </tr>
              @endforeach --}}

            </tbody>
          </table>
        </div>
      </div>
      <div class="viewmodal" style="display: none;"></div>
    </div>

  </section>

@endsection
@push('after-script')
  <script>
    jQuery(document).ready(function($) {
      $('#log-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        pageLength: 10, // Show all records by default
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, 'All']
        ], // Add 'All' option to the length menu
        ajax: {
          url: "{{ route('activity-log.index') }}",
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            width: '5%',
          },
          {
            data: 'log_name',
            name: 'log_name',
          },
          {
            data: 'causer',
            name: 'causer',
          },
          {
            data: 'description',
            name: 'description',
          },
          {
            data: 'created_at',
            name: 'created_at',
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
  {{-- 
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
