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
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li>
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
              <th class="text-center">Masa Aktif</th>
              <th class="text-center">Masa Inaktif</th>
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
                  @if ($retention->period_active == 'PERMANEN')
                    Permanen
                  @elseif ($retention->period_active == 1)
                    1 Tahun
                  @elseif($retention->period_active == 2)
                    2 Tahun
                  @elseif($retention->period_active == 3)
                    3 Tahun
                  @elseif($retention->period_active == 4)
                    4 Tahun
                  @elseif($retention->period_active == 5)
                    5 Tahun
                  @else
                    N/A
                  @endif
                </td>
                <td class="text-center">
                  @if ($retention->period_inactive == 'PERMANEN')
                    Permanen
                  @elseif ($retention->period_inactive == 1)
                    1 Tahun
                  @elseif($retention->period_inactive == 2)
                    2 Tahun
                  @elseif($retention->period_inactive == 3)
                    3 Tahun
                  @elseif($retention->period_inactive == 4)
                    4 Tahun
                  @elseif($retention->period_inactive == 5)
                    5 Tahun
                  @else
                    N/A
                  @endif
                </td>
                <td class="text-center">
                  <div class="btn-group mb-1">
                    <div class="dropdown">
                      <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon">
                        <a href="#mymodal" data-remote="{{ route('backsite.retention.show', $retention->id) }}"
                          data-toggle="modal" data-target="#mymodal" data-title="Detail Data" class="dropdown-item">
                          <i class="bi bi-eye"></i> Show
                        </a>
                        <a href="{{ route('backsite.retention.edit', $retention->id) }}" class="dropdown-item"
                          title="Edit"><i class="bi bi-pencil"></i> Edit</a>
                        <a class="dropdown-item" title="Delete" onclick="showSweetAlert('{{ $retention->id }}')"
                          {{-- @if (DB::table('departments')->where('retention_id', $retention->id)->exists()) style="display: none;" @endif --}}>
                          <i class="bi bi-x-lg"> Delete</i>
                        </a>
                      </div>
                    </div>
                  </div>


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

@endsection
@push('after-script')
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
    jQuery(document).ready(function($) {
      console.log('Document is ready');

      $('#mymodal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var modal = $(this);

        modal.find('.modal-body').load(button.data("remote"));
        modal.find('.modal-title').html(button.data("title"));
      });
    });
  </script>
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
