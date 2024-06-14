@extends('layouts.app')

@section('title')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Archives</li>
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
              <th class="text-center">Masa Inaktif</th>
              <th class="text-cen-++ter">Action</th>
              <th class="text-cen-++ter">Keterangan</th>
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
                <td class="text-center">
                  @if ($archive->status == 10)
                    <span style="color: red">Dimusnahkan</span>
                  @else
                    <span style="color: green">Disimpan</span>
                  @endif
                </td>
                <td class="text-center">
                  <a class="btn icon btn-primary" title="Cancel" onclick="showSweetAlert('{{ $archive->id }}')">
                    Cancel
                  </a>
                  <form id="updateForm_{{ $archive->id }}" method="POST"
                    action="{{ route('backsite.cancelDestroy', $archive->id) }}" enctype="multipart/form-data"
                    style="display: none;">
                    @csrf
                    @method('PUT')
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </section>
  <script>
    function showSweetAlert(archiveId) {
      Swal.fire({
        title: 'Are you sure?',
        // text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, update it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('updateForm_' + archiveId).submit();
        }
      });
    }
  </script>
@endsection
