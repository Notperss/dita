@extends('layouts.app')

@section('title', 'Retention Archives')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Retention Archives</h3>
          <p class="text-subtitle text-muted">List all data from the retention Archives.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item active" aria-current="page">Retention Archives</li>
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
          <a href="{{ route('backsite.retention.create') }}" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
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
              <th class="text-center">Sub Series</th>
              <th class="text-center">Masa Retensi</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($retentions as $retention)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $retention->main_classification->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $retention->sub_classification->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $retention->sub_series ?? 'N/A' }}</td>
                <td class="text-center">
                  @if (isset($retention->retention_period))
                    @if ($retention->retention_period == 'PERMANEN')
                      Permanen
                    @elseif($retention->retention_period == 1)
                      1 Tahun
                    @elseif($retention->retention_period == 2)
                      2 Tahun
                    @elseif($retention->retention_period == 3)
                      3 Tahun
                    @elseif($retention->retention_period == 4)
                      4 Tahun
                    @elseif($retention->retention_period == 5)
                      5 Tahun
                    @else
                      {{ $retention->retention_period }} Tahun
                    @endif
                  @else
                    N/A
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ route('backsite.retention.edit', $retention->id) }}" class="btn icon btn-primary"
                    title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $retention->id }}')"
                    {{-- @if (DB::table('departments')->where('retention_id', $retention->id)->exists()) style="display: none;" @endif --}}>
                    <i class="bi bi-x-lg"></i>
                  </a>

                  <form id="deleteForm_{{ $retention->id }}"
                    action="{{ route('backsite.retention.destroy', encrypt($retention->id)) }}" method="POST">
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
    function showSweetAlert(retentionId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + retentionId).submit();
        }
      });
    }
  </script>
@endsection
