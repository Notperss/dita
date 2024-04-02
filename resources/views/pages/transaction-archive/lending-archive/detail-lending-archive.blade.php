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
          <th>Tipe</th>
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
              @if ($lendings->type_document === 'DIGITAL')
                <span class="badge bg-light-info">Digital</span>
              @elseif ($lendings->type_document === 'FISIK')
                <span class="badge bg-light-secondary">Fisik</span>
              @else
                <span class="badge bg-light-warning"> - </span>
              @endif
            </td>
            <td>
              @if ($lendings->approval === 1)
                <span class="badge bg-light-success">Disetujui</span>
              @elseif ($lendings->approval === 0)
                <span class="badge bg-light-danger">Ditolak</span>
              @else
                <span class="badge bg-light-warning">Proses</span>
              @endif
            </td>
            <td>
              @can('approval')
                <div class="btn-group">
                  {{-- @if ($lendings->type_document == 'DIGITAL')
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $loop->index }}"
                        name="approval[]" value="{{ $lendings->id }}" @checked($lendings->approval == 1 ?? 0)>
                      <label class="form-check-label" for="flexSwitchCheckDefault{{ $loop->index }}">
                        @if ($lendings->approval == 1)
                          Izinkan
                        @else
                          Tolak
                        @endif
                      </label>
                    </div>
                @endif --}}
                  <div class="form-check">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="form-check-input form-check-primary" name="approval[]"
                        value="{{ $lendings->id }}" id="customColorCheck{{ $loop->index }}">
                      <label class="form-check-label mx-1" for="customColorCheck{{ $loop->index }}">
                        @if ($lendings->approval == 1)
                          Tolak
                        @else
                          Ijinkan
                        @endif
                      </label>
                    </div>
                  </div>
                  {{-- @if ($lendings->period && strtotime($lendings->period) >= strtotime('now'))
                  <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                    data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                    Lihat File
                  </a>
                @endif --}}
                @endcan
                @if ($lendings->type_document == 'DIGITAL')
                  @can('view_archive')
                    @if ($lendings->archiveContainer->file)
                      <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                        data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                        Lihat File
                      </a>
                    @else
                      <span> "No file found."</span>
                    @endif
                  @else
                    @if ($lendings->period && strtotime($lendings->period) >= strtotime('now'))
                      @if ($lendings->archiveContainer->file)
                        <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                          data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                          Lihat File
                        </a>
                      @else
                        <span>"No file found."</span>
                      @endif
                    @endif
                  @endcan
                @endif
              </div>
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
{{-- <script>
  $(document).ready(function() {
    $('.form-check-input').change(function() {
      var label = $(this).siblings('.form-check-label');
      if ($(this).is(':checked')) {
        label.text('Izinkan');
      } else {
        label.text('Tolak');
      }
    });
  });
</script> --}}
