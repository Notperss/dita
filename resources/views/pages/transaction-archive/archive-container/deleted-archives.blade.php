@extends('layouts.app')

@section('title', 'Deleted Archives')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3> Deleted Archives</h3>
          <p class="text-subtitle text-muted">List all archive from Deleted Archives.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Deleted Archives</li>
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
              <th class="text-center">No.Cont</th>
              <th class="text-center">No.Doc</th>
              <th class="text-center">Perihal</th>
              <th class="text-center">Tag</th>
              <th class="text-center">PT</th>
              <th class="text-center">Deleted At</th>
              <th class="text-center" style="width: 9%">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($deletedArchives as $deletedArchive)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $deletedArchive->number_container ?? 'N/A' }}</td>
                <td class="text-center">{{ $deletedArchive->number_document ?? 'N/A' }}</td>
                <td class="text-center">{{ $deletedArchive->regarding ?? 'N/A' }}</td>
                <td class="text-center">{{ $deletedArchive->tag ?? 'N/A' }}</td>
                <td class="text-center">{{ $deletedArchive->company->name ?? 'N/A' }}</td>
                <td class="text-center">
                  {{ Carbon\Carbon::parse($deletedArchive->deleted_at)->translatedFormat('l, d F Y H:i:s') ?? 'N/A' }}
                </td>
                <td class="text-center">
                  {{-- <a class="btn btn-sm btn-primary restore-btn"
                    href="{{ route('restoreArchives', $deletedArchive->id) }}">Restore</a> --}}
                  <button class="restore-btn btn btn-primary" title="Restore" data-id="{{ $deletedArchive->id }}">
                    <i class="bi bi-reply-all-fill"></i></button>
                  <a class="force-delete-btn btn btn-danger" title="Permanently Delete"
                    onclick="forceDelete({{ $deletedArchive->id }})"><i class="bi bi-x-lg"></i></a>

                  <form id="deleteForm_{{ $deletedArchive->id }}"
                    action="{{ route('forceDelete', $deletedArchive->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                  </form>

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </section>
  {{-- <script>
    function restore(archiveId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('restore_' + archiveId).submit();
        }
      });
    }
  </script> --}}

  <script>
    // Restore button click event
    $('.restore-btn').click(function() {
      var id = $(this).data('id');
      Swal.fire({
        title: 'Are you sure?',
        text: "You want to restore this data!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = route('restoreArchives', id);
        }
      })
    });

    function forceDelete(archiveId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + archiveId).submit();
        }
      });
    }
  </script>
@endsection
