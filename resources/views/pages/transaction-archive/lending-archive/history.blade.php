@extends('layouts.app')

@section('title', 'Lending Archive')
@section('content')
  <div class="page-heading">

    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>History Arsip</h3>
        </div>
      </div>
    </div>
  </div>

  <!-- // Basic multiple Column Form section start -->
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">List Data Peminjaman Arsip</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped mb-0" id="table1">
                  <thead>
                    <tr>
                      <th>Nomor Dokumen</th>
                      <th>Divisi</th>
                      <th>Jangka Peminjaman</th>
                      <th>Tipe</th>
                      <th>status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($lendingArchives as $lending)
                      <tr>
                        <td class="text-bold-500">{{ $lending->archiveContainer->number_document ?? 'N/A' }}</td>
                        <td>{{ $lending->archiveContainer->division->name ?? 'N/A' }}</td>
                        <td>
                          {{ isset($lending->period) ? Carbon\Carbon::parse($lending->period)->translatedFormat('l, d F Y') : '-' }}
                        </td>
                        <td>
                          @if ($lending->type_document == 'DIGITAL')
                            <span class="badge bg-light-info">DIGITAL</span>
                          @elseif ($lending->type_document == 'FISIK')
                            <span class="badge bg-light-secondary">FISIK</span>
                          @else
                            <span class="badge bg-light-warning">-</span>
                          @endif
                        </td>
                        <td>
                          @if ($lending->approval === 1)
                            <span class="badge bg-light-success">Di Setujui</span>
                          @elseif ($lending->approval === 0)
                            <span class="badge bg-light-danger">Ditolak</span>
                          @else
                            <span class="badge bg-light-warning">-</span>
                          @endif
                        </td>
                        <td>
                          <div class="btn-group mb-1">
                            {{-- @can('approval')
                              <a class="btn btn-sm btn-info" onclick="update({{ $lending->id }})">Close</a>
                              <form id="update_{{ $lending->id }}" action="{{ route('backsite.closing', $lending->id) }}"
                                method="POST">
                                @method('put')
                                @csrf
                              </form>
                            @endcan --}}
                            {{-- <a href="#historyDetail"
                            data-remote="{{ route('backsite.lending-archive.show', $lending->id) }}" data-toggle="modal"
                            data-target="#historyDetail" data-title="Detail Peminjaman" class="btn btn-success">
                            a
                          </a> --}}

                            <div class="dropdown">
                              <button class="btn btn-primary btn dropdown-toggle me-1" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                </i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="#historyDetail" data-remote="{{ route('backsite.historyDetail', $lending->id) }}"
                                  data-toggle="modal" data-target="#historyDetail" data-title="Detail Peminjaman"
                                  class="dropdown-item">
                                  <i class="bi bi-eye"></i> Detail
                                </a>
                                {{-- @can('super_admin')
                                  <a class="dropdown-item" onclick="showSweetAlert({{ $lending->id }})"><i
                                      class="bi bi-x-lg"></i> Delete</a>
                                @else
                                  @foreach ($lending->lendingArchive as $item)
                                    @if ($item->approval === null)
                                      <a class="dropdown-item" onclick="showSweetAlert({{ $lending->id }})"><i
                                          class="bi bi-x-lg"></i> Delete</a>
                                    @break
                                  @endif
                                @endforeach
                              @endcan --}}
                              </div>
                            </div>
                          </div>
                          {{-- <form id="deleteForm_{{ $lending->id }}"
                          action="{{ route('backsite.lending-archive.destroy', $lending->id) }}" method="POST">
                          @method('DELETE')
                          @csrf
                        </form> --}}

                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- // Basic multiple Column Form section end -->

@endsection
@push('after-script')
  <script>
    function showSweetAlert(lendingId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + lendingId).submit();
        }
      });
    }

    function update(lendingId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, update it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('update_' + lendingId).submit();
        }
      });
    }
  </script>

  {{-- modal --}}
  <script>
    jQuery(document).ready(function($) {
      $('#historyDetail').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var modal = $(this);

        modal.find('.modal-body').load(button.data("remote"));
        modal.find('.modal-title').html(button.data("title"));
      });
    });
  </script>

  {{-- Fancybox --}}
  <script>
    Fancybox.bind('[data-fancy]', {
      infinite: false,
      zIndex: 2100
    });
  </script>

  <div class="modal fade " data-backdrop="false" id="historyDetail" role="dialog">
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
@push('after-style')
  <style>
    #historyDetail {
      z-index: 1001;
      background-color: rgba(0, 0, 0, 0.5);
    }
  </style>
@endpush
