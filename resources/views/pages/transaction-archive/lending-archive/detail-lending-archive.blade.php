<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width: 1px;">#</th>
        <th>Nomor Arsip</th>
        <th>Perihal</th>
        <th>Divisi</th>
        <th>Status</th>
        {{-- <th>File</th> --}}
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
            @if ($lendings->approval === 1)
              <span class="badge bg-light-success">Disetujui</span>
            @elseif ($lendings->approval === 0)
              <span class="badge bg-light-danger">Ditolak</span>
            @else
              <span class="badge bg-light-warning">Proses</span>
            @endif
          </td>
          {{-- <td>
            <a type="button" data-fancybox data-src="{{ asset('storage/' . $lendings->file) }}"
              class="btn btn-info btn-sm text-white ">
              Lihat
            </a> <a type="button" href="{{ asset('storage/' . $lendings->file) }}" class="btn btn-warning btn-sm text-white"
              download>Unduh</a>
          </td> --}}
          <td>
            <div class="btn-group">

              <li class="d-inline-block me-2 mb-1">
                <div class="form-check">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="form-check-input form-check-primary" name="approval"
                      id="customColorCheck1">
                    <label class="form-check-label" for="customColorCheck1">Ijinkan</label>
                  </div>
                </div>
              </li>

              <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Action</button>
              {{-- <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                @if ($lendings->file)
                  <a type="button" data-fancybox data-src="{{ asset('storage/' . $lendings->file) }}"
                    class="dropdown-item">
                    Lihat File
                  </a> <a type="button" href="{{ asset('storage/' . $lendings->file) }}" class="dropdown-item"
                    download>Unduh File</a>
                @endif
                <form action="{{ route('backsite.maintenance.delete_lendings', $lendings->id ?? '') }}" method="POST"
                  onsubmit="return confirm('Anda yakin ingin menghapus data ini ?');">
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="submit"id="delete_file" class="dropdown-item" value="Delete"
                    {{ $isAdmin || $lendings->maintenance->stats == 1 ? '' : 'hidden' }}>
                </form>

              </div> --}}
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
</div>
