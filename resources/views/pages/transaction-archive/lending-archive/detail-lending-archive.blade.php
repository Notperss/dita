<div class="table-responsive">
  <form class="form" method="POST" action="{{ route('approval') }}" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    @can('approval')
      @if (!$id->status)
        <button type="submit" class="btn btn-primary bg-primary my-2">Submit</button>
      @endif
    @endcan
    <table class="table table-bordered">
      <thead>
        <tr>
          <th style="width: 1px;">#</th>
          <th>No.Dokumen</th>
          <th>Perihal</th>
          <th>Divisi</th>
          <th>Tipe</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($lending_archives as $lendings)
          <input type="hidden" name="id[]" id="id" value="{{ $lendings->id }}">
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $lendings->archiveContainer->number_document }}</td>
            <td>{{ $lendings->archiveContainer->regarding }}</td>
            <td>{{ $lendings->archiveContainer->division->name }}</td>
            <td>
              @if ($lendings->document_type === 'DIGITAL')
                <span class="badge bg-light-info">Digital</span>
              @elseif ($lendings->document_type === 'FISIK')
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
              @if ($lendings->lending->status == null)
                @can('approval')
                  {{-- <div class="form-check">
                  <input class="form-check-input" type="radio" name="approval[{{ $lendings->id }}]"
                    id="izinkan{{ $lendings->id }}" value="1">
                  <label class="form-check-label" for="izinkan{{ $lendings->id }}">
                    Izinkan
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="approval[{{ $lendings->id }}]"
                    id="tolak{{ $lendings->id }}">
                  <label class="form-check-label" for="tolak{{ $lendings->id }}">
                    Tolak
                  </label>
                </div> --}}
                  <div class="form-check">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="form-check-input form-check-primary"
                        name="approval[{{ $lendings->id }}]" id="customColorCheck{{ $loop->index }}"
                        @if ($lendings->approval == 1) checked @endif>
                      <label class="form-check-label mx-1" for="customColorCheck{{ $loop->index }}">
                        Ijinkan
                      </label>
                    </div>
                  </div>

                  <div class="btn-group">
                    {{-- @if ($lendings->document_type == 'DIGITAL')
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
                    {{-- @if ($lendings->period && strtotime($lendings->period) >= strtotime('now'))
                  <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                    data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                    Lihat File
                  </a>
                @endif --}}
                  @endcan
                  @if ($lendings->document_type == 'DIGITAL')
                    @can('view_archive')
                      @if ($lendings->archiveContainer->file)
                        <a type="button" class="btn btn-sm btn-success mx-1" data-fancy data-custom-class="pdf"
                          data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                          Lihat File
                        </a>
                      @else
                        <span><small>"No file found."</small> </span>
                      @endif
                    @else
                      @if ($lendings->period && strtotime($lendings->period) >= strtotime('now'))
                        @if ($lendings->archiveContainer->file)
                          <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                            data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                            Lihat File
                          </a>
                        @else
                          <span><small>"No file found."</small></span>
                        @endif
                      @endif
                    @endcan
                  @endif
                </div>
              @endif

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
{{-- <script>
  function downloadWatermarkedPDF() {
    // Make an AJAX request to fetch the watermarked PDF
    fetch('/download-watermarked-pdf?id={{ $id }}')
      .then(response => response.blob())
      .then(blob => {
        // Create a URL for the PDF blob
        const pdfUrl = URL.createObjectURL(blob);

        // Create a temporary <a> element to trigger the download
        const a = document.createElement('a');
        a.href = pdfUrl;
        a.download = 'watermarked-document.pdf';

        // Append the <a> element to the document and trigger the download
        document.body.appendChild(a);
        a.click();

        // Cleanup: remove the <a> element and revoke the URL
        document.body.removeChild(a);
        URL.revokeObjectURL(pdfUrl);
      })
      .catch(error => {
        console.error('Error fetching watermarked PDF:', error);
      });
  }
</script> --}}
