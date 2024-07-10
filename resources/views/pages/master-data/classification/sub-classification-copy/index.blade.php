@extends('layouts.app')

@section('title', 'Sub Classification')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Sub Classification</h3>
          <p class="text-subtitle text-muted">List all data from the sub Classification.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Sub Classification</li>
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
          <a href="{{ route('sub-classification.create') }}" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data</a>
        </h5>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Klasifikasi</th>
              <th class="text-center">Sub Klasifikasi</th>
              <th class="text-center">Kode Sub Klasifikasi</th>
              <th class="text-center">Keterangan</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($subClassifications as $subClassification)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $subClassification->main_classification->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $subClassification->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $subClassification->code ?? 'N/A' }}</td>
                <td class="text-center">{{ $subClassification->description ?? 'N/A' }}</td>
                <td class="text-center">
                  <a href="{{ route('sub-classification.edit', $subClassification->id) }}" class="btn icon btn-primary"
                    title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $subClassification->id }}')"
                    {{-- @if (DB::table('departments')->where('subClassification_id', $subClassification->id)->exists()) style="display: none;" @endif --}}>
                    <i class="bi bi-x-lg"></i>
                  </a>

                  <form id="deleteForm_{{ $subClassification->id }}"
                    action="{{ route('sub-classification.destroy', encrypt($subClassification->id)) }}" method="POST">
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
    function showSweetAlert(subClassificationId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + subClassificationId).submit();
        }
      });
    }
  </script>
@endsection
