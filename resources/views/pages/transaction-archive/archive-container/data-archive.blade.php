@extends('layouts.app')

@section('title', 'Archives')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Archives</h3>
          <p class="text-subtitle text-muted">List all data from the Archives.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li> --}}
              {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li> --}}
              {{-- <li class="breadcrumb-item active" aria-current="page">Archives</li> --}}
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
          List All Archives
        </h5>
      </div>
      <div class="card-body">

        {{-- search panel --}}
        {{-- <div class="row my-2">
          <div class="col-2">
            <input type="text" class="form-control" name="year" id="yearFilter" data-provide="datepicker"
              data-date-format="yyyy" data-date-min-view-mode="2" placeholder="Cari Tahun" readonly>
          </div>
          <div class="col-3">
            <input type="text" class="form-control" id="regardingSearch" placeholder="Cari Perihal">
          </div>
          <div class="col-3">
            <input type="text" class="form-control" id="tagSearch" placeholder="Cari Tag">
          </div>
          <div class="col-3">
            <select type="text" class="form-control" id="divisionFilter">
              <option value="" selected disabled>Cari Divisi</option>
              @foreach ($divisions as $division)
                <option value="{{ $division->code }}">{{ $division->code }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-1">
            <button id="resetFilter" class="btn btn-primary">Reset</button>
          </div>
        </div> --}}

        <table class="table table-striped" id="container-table" style="word-break: break-all;font-size: 90%">
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
              <th class="text-center" scope="col" style="width: 6%">Action</th>
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
              <th scope="col"><input type="text" class="form-control form-control-sm" id="yearFilter" name="year"
                  data-provide="datepicker" data-date-format="yyyy" data-date-min-view-mode="2" placeholder="Tahun"
                  readonly></th>
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
                <select type="text" id="typeFilter" class="form-control form-control-sm" style="width: 100%">
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
      </div>
    </div>
    <div class="viewmodal" style="display: none;"></div>


  </section>

@endsection
@push('after-script')
  <script>
    jQuery(document).ready(function($) {
      // Initialize the DataTable
      var table = $('#container-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All']
        ],
        lengthChange: true,
        pageLength: 10,
        ajax: {
          url: "{{ route('dataArchive') }}",
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
            className: 'no-print'
          },
        ],
        columnDefs: [{
            className: 'text-center',
            targets: '_all'
          },
          {
            targets: [1, 2, 3],
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
