<table class="table table-bordered">
  <input type="hidden" name="id" id="id" value="{{ $lendingArchives->lending_id }}">
  <tr>
    <th>Nomor Peminjaman</th>
    <td>{{ isset($lendingArchives->lending->lending_number) ? $lendingArchives->lending->lending_number : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Divisi</th>
    <td>{{ isset($lendingArchives->lending->divisi) ? $lendingArchives->lending->divisi : 'N/A' }}</td>
  </tr>
  <tr>
    <th>Tanggal Pinjam</th>
    <td>
      {{ isset($lendingArchives->lending->start_date) ? Carbon\Carbon::parse($lendingArchives->lending->start_date)->translatedFormat('l, d F Y H:i') : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Tanggal Dikembalikan</th>
    <td>
      {{ isset($lendingArchives->lending->start_date) ? Carbon\Carbon::parse($lendingArchives->lending->start_date)->translatedFormat('l, d F Y H:i') : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Keterangan</th>
    <td>{!! isset($lendingArchives->lending->description) ? $lendingArchives->lending->description : 'N/A' !!}</td>
  </tr>
  <tr>
    <th>Status</th>
    <td>
      @if ($lendingArchives->lending->status === 1)
        <span class="badge bg-light-success">Selesai</span>
      @elseif ($lendingArchives->lending->status === 0)
        <span class="badge bg-light-danger">Proses</span>
      @else
        <span class="badge bg-light-warning">Proses</span>
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
      url: "{{ route('backsite.show_file') }}",
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
