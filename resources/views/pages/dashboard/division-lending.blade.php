@extends('layouts.app')

@section('title', $divisions->name)
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Peminjaman {{ $divisions->name }}</h3>
          <p class="text-subtitle text-muted">List all archive from {{ $divisions->name }}.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $divisions->name }}</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-body">
        <table class="table table-striped" id="table1">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">No.Kontainer</th>
              <th class="text-center">No.Dokumen</th>
              <th class="text-center">Perihal</th>
              {{-- <th class="text-center">Detail Lokasi</th>
              <th class="text-center">Status</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($lendingArchives as $lend)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $lend->archiveContainer->number_container ?? 'N/A' }}</td>
                <td class="text-center">{{ $lend->archiveContainer->number_document ?? 'N/A' }}</td>
                <td class="text-center">{{ $lend->archiveContainer->regarding ?? 'N/A' }}</td>
                {{-- <td class="text-center">{{ $archiveContainer->detail_location ?? 'N/A' }}</td> --}}
                {{-- <td class="text-center">{{ $archiveContainer->status ?? 'N/A' }}</td> --}}
              </tr>
            @endforeach
          </tbody>
        </table>
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
