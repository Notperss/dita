@extends('layouts.app')

@section('title', $divisions->name)
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>{{ $divisions->name }}</h3>
          {{-- <p class="text-subtitle text-muted">List archive Inaktif from {{ $divisions->name }}.</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('destruction-archive.index') }}">Pemusnahan Arsip</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">{{ $divisions->name }}</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    <a href="{{ route('archive-destroy') }}" class="btn btn-primary">
      Arsip yang Dimusnahkan
    </a>
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('checkNotDestroy', $divisions->id) }}" enctype="multipart/form-data"
          id="myForm">
          @csrf
          @method('PUT')
          <table class="table table-striped" id="destroy-archive">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">No.Kontainer</th>
                <th class="text-center">No.Dokumen</th>
                <th class="text-center">Perihal</th>
                <th class="text-center">Masa Inaktif</th>
                @can('admin')
                  <th class="text-center no-print">Action</th>
                @endcan
                {{-- <th class="text-center">Keterangan</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($archiveContainers as $archive)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td class="text-center">{{ $archive->number_container ?? 'N/A' }}</td>
                  <td class="text-center">{{ $archive->number_document ?? 'N/A' }}</td>
                  <td class="text-center">{{ $archive->regarding ?? 'N/A' }}</td>
                  <td class="text-center">
                    {{ Carbon\Carbon::parse($archive->expiration_inactive)->translatedFormat('l, d F Y') ?? 'N/A' }}</td>
                  @can('admin')
                    <td class="text-center">
                      <li class="d-inline-block me-2 mb-1 no-print">
                        <div class="form-check">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-check-input form-check-danger"
                              name="approvals[{{ $archive->id }}]" id="customColorCheck{{ $archive->id }}">
                            <label class="form-check-label" for="customColorCheck{{ $archive->id }}">
                              Tidak Musnahkan
                            </label>
                          </div>
                        </div>
                      </li>
                    </td>
                  @endcan
                  {{-- <td class="text-center">
                  @if ($archive->status == 10)
                    <span style="color: red">Dimusnahkan</span>
                  @else
                    <span style="color: green">Disimpan</span>
                  @endif
                </td> --}}
                </tr>
              @endforeach
            </tbody>
          </table>
          @can('admin')
            @if ($archiveContainers->isNotEmpty())
              <button type="button" onclick="submitForm()"
                class="btn btn-primary bg-primary my-2 float-right">Submit</button>
            @endif
          @endcan
        </form>
      </div>
    </div>

  </section>
  <script>
    function showSweetAlert(divisionId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + divisionId).submit();
        }
      });
    }
  </script>
@endsection
@push('after-script')
  <script>
    $(document).ready(function() {
      var table = $('#destroy-archive').DataTable({
        pageLength: -1, // Show all records by default
        dom: 'Bfrtip',
        buttons: [{
            extend: 'print',
            className: "btn btn-info",
            exportOptions: {
              columns: ':not(.no-print)' // Exclude elements with class 'no-print'
            }
          },
          @can('admin')
            {
              text: 'Check All',
              className: 'btn btn-primary',
              action: function() {
                $('input[type="checkbox"].form-check-input').prop('checked', true);
              }
            }
          @endcan
        ]
      });

      // Check all checkboxes when the header checkbox is clicked
      $('#checkAll').on('click', function() {
        var isChecked = $(this).prop('checked');
        $('input[type="checkbox"].form-check-input').prop('checked', isChecked);
      });
    });
  </script>
@endpush
