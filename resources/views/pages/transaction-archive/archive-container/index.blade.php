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
        <div class="d-flex justify-content-between align-items-center my-2">
          <div>
            <label for="start-date" class="me-2">Start Date:</label>
            <input type="date" id="start-date" class="form-control form-control-sm" placeholder="Start Date"
              style="width: 150px; display: inline-block;">

            <label for="end-date" class="me-2">End Date:</label>
            <input type="date" id="end-date" class="form-control form-control-sm me-2" placeholder="End Date"
              style="width: 150px; display: inline-block;">

            {{-- <label for="employee-status" class="me-2">Status:</label> --}}
            <select id="number-box" class="form-select form-select-sm " style="width: 100px; display: inline-block;">
              <option value="">Pilih Box</option>
              @foreach ($containerNumber as $number)
                <option value="{{ $number->id }}">{{ str_pad($number->number_container, 3, '0', STR_PAD_LEFT) }}
                </option>
              @endforeach
            </select>
            <select id="division" class="form-select form-select-sm " style="width: 150px; display: inline-block;">
              <option value="">Pilih Divisi</option>
              @foreach ($divisions as $division)
                <option value="{{ $division->id }}">{{ $division->name }}
                </option>
              @endforeach
            </select>
            <button id="filter-date" class="btn btn-primary btn-sm ms-2">Filter</button>
            {{-- button print semua box pilihan --}}
          </div>
          {{-- <a class="btn btn-success btn-md" href="#">Export</a> --}}
          <a href="{{ route('container.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
            class="btn btn-success btn-md" id="export-button">
            Export
          </a>
        </div>
        {{-- Tombol membuka modal --}}
        <button id="print-selected" type="button" class="btn btn-info btn-sm ms-2" data-bs-toggle="modal"
          data-bs-target="#printModal">
          Print Selected Box
        </button>

        {{-- Modal Print --}}
        <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">

          <div class="modal-dialog">
            <div class="modal-content">

              <form action="{{ route('container.print') }}" method="POST" target="_blank">
                @csrf

                <div class="modal-header">
                  <h5 class="modal-title" id="printModalLabel">
                    Print Selected Container
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  {{-- <p>Print Selected Container</p> --}}

                  <div class="mb-3">
                    <label for="number_container_id" class="form-label">
                      Pilih Box
                    </label>

                    <select id="number_container_id" name="number_container_id" class="form-select" required>
                      <option value="">Pilih Box</option>
                      @foreach ($containerNumber as $number)
                        <option value="{{ $number->id }}">
                          {{ str_pad($number->number_container, 3, '0', STR_PAD_LEFT) }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  {{-- Menyimpan satu ID container yang dipilih --}}
                  <input type="hidden" name="selected_id" id="selected_id">
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                  </button>

                  <button type="submit" class="btn btn-primary" id="confirm-print">
                    Print
                  </button>
                </div>
              </form>

            </div>
          </div>
        </div>





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
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="printModalLabel">Print Selected Containers</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to print the selected containers?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="confirm-print">Print</button>
          </div>
        </div>
      </div>
    </div>
    <div class="viewmodal" style="display: none;"></div>


  </section>

@endsection
@push('after-script')
  <script>
    $('#print-selected').on('click', function(e) {
      const checked = $('.select-container:checked');

      // Harus memilih tepat 1 checkbox
      if (checked.length !== 1) {
        e.preventDefault();
        // alert('Please select exactly one container to print.');

        // Batalkan pembukaan modal
        const modal = bootstrap.Modal.getInstance(
          document.getElementById('printModal')
        );

        if (modal) {
          modal.hide();
        }

        return false;
      }

      // Simpan ID yang dipilih ke hidden input
      $('#selected_id').val(checked.val());
    });
  </script>




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
    $(document).on('click', '.qr-button', function() {
      var button = $(this);

      // Tandai sudah diklik (misalnya dengan class atau teks)
      button.removeClass('btn-info').addClass('btn-outline-secondary');
      // button.html('<i class="bi bi-qr-code-scan"></i>');

      // Optional: Disable button untuk cegah klik ulang
      // button.prop('disabled', true);
    });
  </script>


  <script>
    jQuery(document).ready(function($) {
      const table = $('#container-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        lengthMenu: [
          [10, 15, 25, 50, -1],
          [10, 15, 25, 50, 'All']
        ],
        lengthChange: true,
        pageLength: 15,
        ajax: {
          url: "{{ route('archive-container.index') }}",
          data: function(d) {
            d.start_date = $('#start-date').val();
            d.end_date = $('#end-date').val();
            d.numberBox = $('#number-box').val();
            d.division = $('#division').val();
          }
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

      // Reload table on filter button click
      $('#filter-date').on('click', function() {
        table.ajax.reload();

        // Update export button URL
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();
        const numberBox = $('#number-box').val();
        const division = $('#division').val();

        let exportUrl = "{{ route('container.export') }}";
        const params = [];

        if (startDate) params.push(`start_date=${startDate}`);
        if (endDate) params.push(`end_date=${endDate}`);
        if (numberBox) params.push(`numberBox=${numberBox}`);
        if (division) params.push(`division=${division}`);

        if (params.length) exportUrl += `?${params.join('&')}`;

        $('.btn-success').attr('href', exportUrl);
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
