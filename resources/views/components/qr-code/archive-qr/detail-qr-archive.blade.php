@extends('layouts.app')

@section('title', 'Detail Archive')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Detail Archive</h3>
          {{-- <p class="text-subtitle text-muted">List all data from the archive Container.</p> --}}
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">
        {{-- <h5 class="card-title">
          <a href="{{ route('backsite.archive-container.create') }}" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data</a>
          <a onclick="upload()" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data File</a>
        </h5> --}}
      </div>
      <div class="card-body">

        <div style="display: flex;">
          <table class="table table-bordered" style="width: 50%;">

            {{-- Kontainer --}}
            <tr>
              <th>Nama Divisi</th>
              <td>{{ isset($archiveContainers->division->name) ? $archiveContainers->division->name : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Nomor Kontainer</th>
              <td>{{ isset($archiveContainers->number_container) ? $archiveContainers->number_container : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Lokasi Utama</th>
              <td>{{ isset($archiveContainers->main_location) ? $archiveContainers->main_location : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Sub Lokasi</th>
              <td>{{ isset($archiveContainers->sub_location) ? $archiveContainers->sub_location : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Detail Lokasi</th>
              <td>{{ isset($archiveContainers->detail_location) ? $archiveContainers->detail_location : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Keterangan</th>
              <td>{{ isset($archiveContainers->description_location) ? $archiveContainers->description_location : 'N/A' }}
              </td>
            </tr>

            {{-- Klasifikasi --}}
            <tr>
              <th>Klasifikasi Arsip</th>
              <td>
                {{ isset($archiveContainers->mainClassification->name) ? $archiveContainers->mainClassification->name : 'N/A' }}
              </td>
            </tr>
            <tr>
              <th> Sub Klasifikasi Arsip</th>
              <td>
                {{ isset($archiveContainers->subClassification->name) ? $archiveContainers->subClassification->name : 'N/A' }}
              </td>
            </tr>
            <tr>
              <th>Sub Series Arsip</th>
              <td>{{ isset($archiveContainers->subseries) ? $archiveContainers->subseries : 'N/A' }}</td>
            </tr>

            {{-- Retensi --}}
            <tr>
              <th>Masa Aktif</th>
              <td>{{ isset($archiveContainers->period_active) ? $archiveContainers->period_active : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Keterangan Masa Aktif</th>
              <td>{{ isset($archiveContainers->description_active) ? $archiveContainers->description_active : 'N/A' }}
              </td>
            </tr>
            <tr>
              <th>Masa Inaktif</th>
              <td>{{ isset($archiveContainers->period_inactive) ? $archiveContainers->period_inactive : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Keterangan Masa Inaktif</th>
              <td>
                {{ isset($archiveContainers->description_inactive) ? $archiveContainers->description_inactive : 'N/A' }}
              </td>
            </tr>
            <tr>
              <th>Keterangan Tambahan</th>
              <td>
                {{ isset($archiveContainers->description_retention) ? $archiveContainers->description_retention : 'N/A' }}
              </td>
            </tr>
          </table>

          <table class="table table-bordered" style="width: 50%;">

            {{-- Input Data --}}
            <tr>
              <th>Nomor Aplikasi</th>
              <td>{{ isset($archiveContainers->number_app) ? $archiveContainers->number_app : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Nomor Katalog</th>
              <td>{{ isset($archiveContainers->number_catalog) ? $archiveContainers->number_catalog : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Nomor Dokumen</th>
              <td>{{ isset($archiveContainers->number_document) ? $archiveContainers->number_document : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Nomor Arsip</th>
              <td>{{ isset($archiveContainers->number_archive) ? $archiveContainers->number_archive : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Tanggal Arsip Masuk</th>
              <td>
                {{ isset($archiveContainers->archive_in) ? Carbon\Carbon::parse($archiveContainers->archive_in)->translatedFormat('l, d F Y') : 'N/A' }}
              </td>
            </tr>
            <tr>
              <th>Tahun</th>
              <td>{{ isset($archiveContainers->year) ? $archiveContainers->year : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Perihal</th>
              <td>{{ isset($archiveContainers->regarding) ? $archiveContainers->regarding : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Tag</th>
              <td>{{ isset($archiveContainers->tag) ? $archiveContainers->tag : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Bentuk Dokumen</th>
              <td>{{ isset($archiveContainers->document_type) ? $archiveContainers->document_type : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Jenis Arsip</th>
              <td>{{ isset($archiveContainers->archive_type) ? $archiveContainers->archive_type : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Jumlah & Satuan</th>
              <td>{{ isset($archiveContainers->amount) ? $archiveContainers->amount : 'N/A' }}</td>
            </tr>
            <tr>
              <th>File Arsip</th>
              <td style="word-break: break-word;">
                @if ($archiveContainers->file)
                  <a type="button" data-fancy data-src="{{ asset('storage/' . $archiveContainers->file) }}"
                    class="btn btn-info btn-sm text-white">
                    Lihat
                  </a>

                  <a type="button" href="{{ asset('storage/' . $archiveContainers->file) }}"
                    class="btn btn-warning btn-sm text-white " download>Unduh</a>
                  <br>

                  <p class="mt-1">Latest File : {{ pathinfo($archiveContainers->file, PATHINFO_FILENAME) }}</p>
                @else
                  <p>File not found!</p>
                @endif
              </td>
            </tr>
          </table>
        </div>


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
