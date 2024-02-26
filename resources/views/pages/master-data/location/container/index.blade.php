@extends('layouts.app')

@section('title', 'Container Location')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Container Location</h3>
          <p class="text-detailtitle text-muted">List all data from the Container location.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item active" aria-current="page">Container Location</li>
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
          <a href="{{ route('backsite.container-location.create') }}" class="btn btn-primary"> <i
              class="bi bi-plus-lg"></i>
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
              <th class="text-center">Detail Lokasi</th>
              <th class="text-center">Container</th>
              <th class="text-center">Divisi</th>
              {{-- <th class="text-center">Keterangan</th> --}}
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($containerLocations as $containerLocation)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                {{-- <td class="text-center">{{ $containerLocation->mainLocation->name }}</td> --}}
                <td class="text-center">{{ $containerLocation->mainLocation->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $containerLocation->subLocation->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $containerLocation->detailLocation->name ?? 'N/A' }}</td>
                <td class="text-center">
                  {{ isset($containerLocation->number_container) ? str_pad($containerLocation->number_container, 3, '0', STR_PAD_LEFT) : 'N/A' }}
                </td>
                <td class="text-center">{{ $containerLocation->division->name ?? 'N/A' }}</td>
                {{-- <td class="text-center">{{ $containerLocation->description ?? 'N/A' }}</td> --}}
                <td class="text-center">
                  <a href="{{ route('backsite.container-location.edit', $containerLocation->id) }}"
                    class="btn icon btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $containerLocation->id }}')">
                    <i class="bi bi-x-lg"></i>
                  </a>

                  <form id="deleteForm_{{ $containerLocation->id }}"
                    action="{{ route('backsite.container-location.destroy', encrypt($containerLocation->id)) }}"
                    method="POST">
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
    function showSweetAlert(containerLocationId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + containerLocationId).submit();
        }
      });
    }
  </script>

@endsection
