<table class="table table-bordered">
  <input type="hidden" name="id" id="id" value="{{ $lendings->id }}">
  <tr>
    <th>Nomor Peminjaman</th>
    <td>{{ isset($lendings->lending_number) ? $lendings->lending_number : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Peminjam</th>
    <td>{{ isset($lendings->user->name) ? $lendings->user->name : 'N/A' }}</td>
  </tr>
  <tr>
    <th>Tanggal Pinjam</th>
    <td>
      {{ isset($lendings->start_date) ? Carbon\Carbon::parse($lendings->start_date)->translatedFormat('l, d F Y ') : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Tanggal Dikembalikan</th>
    <td>
      {{ isset($lendings->start_date) ? Carbon\Carbon::parse($lendings->start_date)->translatedFormat('l, d F Y ') : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Keterangan</th>
    <td>{!! isset($lendings->description) ? $lendings->description : 'N/A' !!}</td>
  </tr>
  <tr>
    <th>Status</th>
    <td>
      @php
        $hasAccepted = false;
        $allRejected = true;

        foreach ($lendings->lendingArchive as $approval) {
            if ($approval->is_approve === 1) {
                $hasAccepted = true;
                $allRejected = false;
                break; // No need to continue checking, as we found an accepted approval
            } elseif ($approval->is_approve !== 0) {
                $allRejected = false;
            }
        }
      @endphp

      @if ($lendings->has_finished)
        <span class="badge bg-light-success">Selesai</span>
      @elseif ($hasAccepted)
        <span class="badge bg-light-info">Diterima</span>
      @elseif ($allRejected)
        <span class="badge bg-light-danger">Ditolak</span>
      @else
        <span class="badge bg-light-warning">Pengajuan</span>
      @endif
    </td>
  </tr>
</table>
<table class="table table-bordered tampildata">
</table>

<script>
  function tampilDataFile() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    let id = $('#id').val();
    $.ajax({
      type: "get",
      url: "{{ route('show_file') }}",
      data: {
        id: id
      },
      dataType: "json",
      beforeSend: function() {
        $('.tampildata').html('<i class="bx bx-balloon bx-flasing"></i>');
      },
      success: function(response) {
        if (response.data) {
          $('.tampildata').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  $(document).ready(function() {
    tampilDataFile();
  });
</script>
