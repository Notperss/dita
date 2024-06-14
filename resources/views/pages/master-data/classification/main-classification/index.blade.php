@extends('layouts.app')

@section('title', 'Main Classification')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Main Classification</h3>
          <p class="text-subtitle text-muted">List all data from the main Classification.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item active" aria-current="page">Main Classification</li>
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
          <a href="{{ route('backsite.main-classification.create') }}" class="btn btn-primary"> <i
              class="bi bi-plus-lg"></i>
            Add data</a>
        </h5>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Kode</th>
              <th class="text-center">Nama Klasifikasi</th>
              <th class="text-center">Divisi</th>
              <th class="text-center">Keterangan</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($mainClassifications as $mainClassification)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $mainClassification->code ?? 'N/A' }}</td>
                <td class="text-center">{{ $mainClassification->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $mainClassification->division->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $mainClassification->description ?? 'N/A' }}</td>
                <td class="text-center">
                  <a href="{{ route('backsite.main-classification.edit', $mainClassification->id) }}"
                    class="btn icon btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $mainClassification->id }}')"
                    {{-- @if (DB::table('classification_subs')->where('main_classification_id', $mainClassification->id)->exists()) style="display: none;" @endif> --}}>
                    <i class="bi bi-x-lg"></i>
                  </a>

                  <form id="deleteForm_{{ $mainClassification->id }}"
                    action="{{ route('backsite.main-classification.destroy', encrypt($mainClassification->id)) }}"
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
    function showSweetAlert(mainClassificationId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + mainClassificationId).submit();
        }
      });
    }
  </script>
@endsection
