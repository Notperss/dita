@extends('layouts.app')

@section('title', 'Destruction Archive')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Pemusnahan Arsip</h3>
          <p class="text-subtitle text-muted">List all data from the Destruction Archive.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pemusnahan Arsip</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <section class="section">

    <div class="row">
      <h5>Arsip Inaktif Divisi</h5>
      @foreach ($divisions as $division)
        <div class="col-6 col-lg-2 col-md-6">
          <div class="card">
            <div class="card-body ">
              <div class="row">
                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                  <h6 class="text-muted font-semibold">
                    {{ $division->code }}
                  </h6>
                  <h6 class="font-extrabold mb-0">
                    @php
                      $expirationDate = 0; // Reset the variable for each division
                      $archivesContainer = $division->archive_container;
                      // Assuming $archivesContainer is a collection
                      $expirationDate += $archivesContainer
                          ->filter(function ($archive) {
                              return $archive->expiration_active < now()->toDateString();
                          })
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
    </div>


    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          {{-- <a href="{{ route('backsite.archive-container.create') }}" class="btn btn-primary"> <i
              class="bi bi-plus-lg"></i>
            Add data</a> --}}
          {{-- <a onclick="upload()" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data File</a> --}}
        </h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <form class="form" method="POST" action="{{ route('backsite.approvalDestruction') }}"
            enctype="multipart/form-data" id="myForm">
            @csrf
            @method('PUT')
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  {{-- <th class="text-center">No. Container</th> --}}
                  <th class="text-center">Nomor Dokumen</th>
                  <th class="text-center">Divisi</th>
                  <th class="text-center">Masa Retensi</th>
                  <th class="text-center">Perihal</th>
                  {{-- <th class="text-center">keterangan</th> --}}
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($archives as $archive)
                  <input type="hidden" name="id[]" id="id" value="{{ $archive->id }}">
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $archive->number_document ?? 'N/A' }}</td>
                    <td class="text-center">{{ $archive->division->name ?? 'N/A' }}</td>
                    <td class="text-center">
                      {{ Carbon\Carbon::parse($archive->expiration_active)->translatedFormat('l, d F Y') ?? 'N/A' }}</td>
                    {{-- <td class="text-center">{{ $archive->detail_location ?? 'N/A' }}</td> --}}
                    <td class="text-center"><a data-bs-toggle="modal" data-bs-target="#modal-content-{{ $archive->id }}"
                        class="btn icon btn-primary" title="Edit"><i class="bi bi-eye"></i></a></td>
                    <td class="text-center">

                      @can('user')
                        <li class="d-inline-block me-2 mb-1">
                          <div class="form-check">
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="form-check-input form-check-danger"
                                name="approval[{{ $archive->id }}]" id="customColorCheck{{ $loop->index }}">
                              <label class="form-check-label" for="customColorCheck{{ $loop->index }}">Musnahkan</label>
                            </div>
                          </div>
                        </li>
                      @else
                        @if ($archive->status == 10)
                          <span style="color: red">Dimusnahkan</span>
                        @endif
                      @endcan



                      @include('pages.transaction-archive.destruction-archive.content-show')
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            @if ($archives->isNotEmpty())
              <button type="button" onclick="submitForm()"
                class="btn btn-primary bg-primary my-2 float-right">Submit</button>
            @endif
          </form>
        </div>
      </div>
      <div class="viewmodal" style="display: none;"></div>
    </div>

  </section>

@endsection
@push('after-script')
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
