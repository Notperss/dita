@extends('layouts.app')

@section('title', 'Sub Location')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Sub Location</h3>
          <p class="text-subtitle text-muted">List all data from the Sub location.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item active" aria-current="page">Sub Location</li>
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
          <a href="{{ route('backsite.sub-location.create') }}" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data</a>
        </h5>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Lokasi Utama</th>
              <th class="text-center">Sub Lokasi</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($subLocations as $subLocation)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $subLocation->mainLocation->name }}</td>
                <td class="text-center">{{ $subLocation->name }}</td>
                <td class="text-center">
                  <a href="{{ route('backsite.sub-location.edit', $subLocation->id) }}" class="btn icon btn-primary"
                    title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $subLocation->id }}')"
                    @if (DB::table('location_details')->where('sub_location_id', $subLocation->id)->exists()) style="display: none;" @endif>
                    <i class="bi bi-x-lg"></i>
                  </a>

                  <form id="deleteForm_{{ $subLocation->id }}"
                    action="{{ route('backsite.sub-location.destroy', encrypt($subLocation->id)) }}" method="POST">
                    @method('DELETE')
                    @csrf
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
    function showSweetAlert(subLocationId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + subLocationId).submit();
        }
      });
    }
  </script>
@endsection
