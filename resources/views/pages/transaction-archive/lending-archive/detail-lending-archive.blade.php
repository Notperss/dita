<div class="table-responsive">
  <form class="form" method="POST" action="{{ route('backsite.approval') }}" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    @can('approval')
      <button type="submit" class="btn btn-primary bg-primary my-2">Submit</button>
    @endcan
    <table class="table table-bordered">
      <thead>
        <tr>
          <th style="width: 1px;">#</th>
          <th>Nomor Arsip</th>
          <th>Perihal</th>
          <th>Divisi</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($lending_archives as $lendings)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $lendings->archiveContainer->number_archive }}</td>
            <td>{{ $lendings->archiveContainer->regarding }}</td>
            <td>{{ $lendings->archiveContainer->division->name }}</td>
            <td>
              @if ($lendings->type_document === 'FISIK')
                <span class="badge bg-light-secondary">Fisik</span>
              @else
                @if ($lendings->approval === 1)
                  <span class="badge bg-light-success">Disetujui</span>
                @elseif ($lendings->approval === 0)
                  <span class="badge bg-light-danger">Ditolak</span>
                @else
                  <span class="badge bg-light-warning">Proses</span>
                @endif
              @endif
            </td>
            <td>
              @can('approval')
                <div class="btn-group">
                  @if ($lendings->type_document == 'DIGITAL')
                    <div class="form-check">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="form-check-input form-check-primary" name="approval[]"
                          value="{{ $lendings->id }}" id="customColorCheck{{ $loop->index }}">
                        <label class="form-check-label" for="customColorCheck{{ $loop->index }}">
                          @if ($lendings->approval == 1)
                            Batal
                          @else
                            Ijinkan
                          @endif
                        </label>
                      </div>
                    </div>
                  @endif
                  {{-- @if ($lendings->period && strtotime($lendings->period) >= strtotime('now'))
                  <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                    data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                    Lihat File
                  </a>
                @endif --}}
                </div>
              @endcan
              @can('view_archive')
                <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                  data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                  Lihat File
                </a>
              @else
                @if ($lendings->period && strtotime($lendings->period) >= strtotime('now'))
                  <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                    data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                    Lihat File
                  </a>
                @endif
              @endcan
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-center" colspan="7" style="color:red;">No data available in table</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </form>
</div>
<style>
  .pdf .fancybox__content {
    z-index: 1052;
  }
</style>
