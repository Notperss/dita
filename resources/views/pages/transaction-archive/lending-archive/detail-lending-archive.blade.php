<div class="table-responsive">
  <form class="form" method="POST" action="{{ route('approval') }}" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')

    @php
      $hasAccepted = false;
      $allRejected = true;

      foreach ($lending_archives as $lendings) {
          if ($lendings->is_approve === 1) {
              $hasAccepted = true;
              $allRejected = false;
              break; // No need to continue checking, as we found an accepted approval
          } elseif ($lendings->is_approve !== 0) {
              $allRejected = false;
          }
      }
    @endphp
    @can('super_admin')
      @if (!$id->has_finished)
        <button type="submit" class="btn btn-primary bg-primary my-2">Submit</button>
      @endif
    @elsecan('approval')
      @if (!$id->has_finished && $lendings->is_approve === null)
        <button type="submit" class="btn btn-primary bg-primary my-2">Submit</button>
      @elseif ($lendings->lending->has_finished == false && $hasAccepted && !$lendings->has_finished)
        <button type="submit" class="btn btn-primary bg-primary my-2">Submit</button>

        <div class="mb-1" id="uploadFile" style="display: none">
          <label for="formFileSm" class="form-label">Upload :</label>
          <input class="form-control form-control-sm" name="file" id="formFileSm" type="file">
        </div>
        {{-- @if ($lendings->file)
            <p>Latest File : {{ pathinfo($lendings->file, PATHINFO_FILENAME) }}</p>
            <a type="button" data-fancybox data-src="{{ asset('storage/' . $lendings->file) }}"
              class="btn btn-info btn-sm text-white mb-1">
              Lihat File
            </a>
          @endif
        </div> --}}
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
          @can('super_admin')
            @if (!$id->has_finished)
              <th style="width: 13%; text-align: center">Action</th>
            @elseif ($lendings->lending->has_finished == false && $lendings->is_approve === null)
              <th style="width: 13%; text-align: center">Action</th>
            @else
              <th style="width: 13%; text-align: center">Keadaan Arsip</th>
            @endif
          @endcan
          @if ($lendings->has_finished || $lendings->is_approve)
            <th>Kondisi Arsip</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse ($lending_archives as $lendings)
          <input type="hidden" name="id[]" id="id" value="{{ $lendings->id }}">
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $lendings->archiveContainer->number_document ?? 'N/A' }}</td>
            <td>{{ $lendings->archiveContainer->regarding ?? 'N/A' }}</td>
            <td>{{ $lendings->archiveContainer->division->name ?? 'N/A' }}</td>
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
              @if ($lendings->is_approve === 1)
                <span class="badge bg-light-success">Disetujui</span>
              @elseif ($lendings->is_approve === 0)
                <span class="badge bg-light-danger">Ditolak</span>
              @else
                <span class="badge bg-light-warning">Pengajuan</span>
              @endif
            </td>
            @if ($lendings->has_finished)
              <td>
                <span class="badge bg-light-primary">{{ $lendings->damage_status }}</span>
              </td>
            @endif

            @can('super_admin')
              @if ($lendings->lending->has_finished == false)
                <td>

                  @can('approval')
                    <div class="form-check">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="form-check-input form-check-primary"
                          name="approval[{{ $lendings->id }}]" id="customColorCheck{{ $loop->index }}"
                          @if ($lendings->is_approve == 1) checked @endif>
                        <label class="form-check-label mx-1" for="customColorCheck{{ $loop->index }}">
                          Ijinkan
                        </label>
                      </div>
                    </div>
                  @endcan

                  <div class="btn-group">
                    @if ($lendings->document_type == 'DIGITAL')
                      @can('view_archive')
                        @if ($lendings->archiveContainer->file)
                          <a type="button" class="btn btn-sm btn-success mx-1" data-fancy data-custom-class="pdf"
                            data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                            <small>Lihat File</small>
                          </a>
                        @else
                          <span><small>"No file found."</small> </span>
                        @endif
                      @else
                        @if ($lendings->period && strtotime($lendings->period) >= strtotime('now'))
                          @if ($lendings->archiveContainer->file)
                            <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                              data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                              <small>Lihat File</small>
                            </a>
                          @else
                            <span><small>"No file found."</small></span>
                          @endif
                        @endif
                      @endcan
                    @endif
                  </div>

                </td>
              @endif
            @else
              @if ($lendings->lending->has_finished == false && $lendings->is_approve === null)
                <td>

                  @can('approval')
                    <div class="form-check">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="form-check-input form-check-primary"
                          name="approval[{{ $lendings->id }}]" id="customColorCheck{{ $loop->index }}"
                          @if ($lendings->is_approve == 1) checked @endif>
                        <label class="form-check-label mx-1" for="customColorCheck{{ $loop->index }}">
                          Ijinkan
                        </label>
                      </div>
                    </div>
                  @endcan

                  <div class="btn-group">
                    @if ($lendings->document_type == 'DIGITAL')
                      @can('view_archive')
                        @if ($lendings->archiveContainer->file)
                          <a type="button" class="btn btn-sm btn-success mx-1" data-fancy data-custom-class="pdf"
                            data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                            <small>Lihat File</small>
                          </a>
                        @else
                          <span><small>"No file found."</small> </span>
                        @endif
                      @else
                        @if ($lendings->period && strtotime($lendings->period) >= strtotime('now'))
                          @if ($lendings->archiveContainer->file)
                            <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                              data-src="{{ asset('storage/' . $lendings->archiveContainer->file) }}" class="dropdown-item">
                              <small>Lihat File</small>
                            </a>
                          @else
                            <span><small>"No file found."</small></span>
                          @endif
                        @endif
                      @endcan
                    @endif
                  </div>

                </td>
              @elseif ($lendings->lending->has_finished == false && $lendings->is_approve && !$lendings->has_finished)
                <td>
                  @can('approval')
                    <div class="form-check" hidden>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="form-check-input form-check-primary"
                          name="approval[{{ $lendings->id }}]" id="customColorCheck{{ $loop->index }}"
                          @if ($lendings->is_approve == 1) checked @endif>
                        <label class="form-check-label mx-1" for="customColorCheck{{ $loop->index }}">
                          Ijinkan
                        </label>
                      </div>
                    </div>
                    <div class="form-check" style="font-size:125%">
                      <input class="form-check-input" type="radio" name="damage_status[{{ $lendings->id }}]"
                        id="defect{{ $loop->index }}" value="rusak" @if ($lendings->damage_status == 'rusak') checked @endif>
                      <label class="form-check-label" for="defect{{ $loop->index }}">
                        Arsip Rusak
                      </label>
                    </div>
                    <div class="form-check" style="font-size:125%">
                      <input class="form-check-input" type="radio" name="damage_status[{{ $lendings->id }}]"
                        id="lost{{ $loop->index }}" value="hilang" @if ($lendings->damage_status == 'hilang') checked @endif>
                      <label class="form-check-label" for="lost{{ $loop->index }}">
                        Arsip Hilang
                      </label>
                    </div>
                    <div class="form-check" style="font-size:125%">
                      <input class="form-check-input" type="radio" name="damage_status[{{ $lendings->id }}]"
                        id="baik{{ $loop->index }}" value="baik" @if ($lendings->damage_status == 'baik') checked @endif>
                      <label class="form-check-label" for="baik{{ $loop->index }}">
                        Baik
                      </label>
                    </div>
                    <input type="hidden" name="has_finished" value="1">

                    {{-- <div class="mb-1">
                      <label for="formFileSm{{ $lendings->id }}" class="form-label">Upload</label>
                      <input class="form-control form-control-sm" name="files[{{ $lendings->id }}]"
                        id="formFileSm{{ $lendings->id }}" type="file"
                        onchange="updateFileName('{{ $lendings->id }}')">
                      <br>
                      @if ($lendings->file)
                        <p>Latest File : {{ pathinfo($lendings->file, PATHINFO_FILENAME) }}</p>
                        <a type="button" data-fancybox data-src="{{ asset('storage/' . $lendings->file) }}"
                          class="btn btn-info btn-sm text-white mb-1">
                          Lihat File
                        </a>
                        <br>
                        <span id="fileName{{ $lendings->id }}" class="form-text mt-2" style="font-size: 110%"></span>
                      @else
                        <span id="fileName{{ $lendings->id }}" class="form-text mt-2" style="font-size: 110%"></span>
                      @endif
                    </div> --}}

                    <script>
                      $(document).ready(function() {
                        // Function to toggle the file upload visibility
                        function toggleFileUpload() {
                          // Check if the "Baik" radio button is selected
                          if ($("#baik{{ $loop->index }}").is(':checked')) {
                            $("#uploadFile").hide(); // Hide file input if "Baik" is selected
                          } else {
                            $("#uploadFile").show(); // Show file input otherwise
                          }
                        }

                        // Bind change event to the radio buttons
                        $("input[name='damage_status[{{ $lendings->id }}]']").change(toggleFileUpload);

                        // Call the function on page load to set the initial state
                        toggleFileUpload();
                      });
                    </script>
                  @endcan
                </td>
              @endif
            @endcan

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
<script>
  // function updateFileName(id) {
  //   var input = document.getElementById('formFileSm' + id);
  //   if (input.files.length > 0) {
  //     var fileName = input.files[0].name;
  //     document.getElementById('fileName' + id).textContent = 'File Update : ' + fileName;
  //   } else {
  //     document.getElementById('fileName' + id).textContent = 'No file chosen';
  //   }
  // }

  // // Optional: Ensure the script runs after the DOM has fully loaded
  // document.addEventListener('DOMContentLoaded', function() {
  //   // Code to ensure functionality is applied
  // });

  Fancybox.bind('[data-fancybox]', {
    infinite: false
  });
</script>
<style>
  .pdf .fancybox__content {
    z-index: 1052;
  }
</style>
