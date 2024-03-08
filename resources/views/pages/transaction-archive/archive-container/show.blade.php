<style>
  .fancybox-container {
    z-index: 1061 !important;
    /* Adjust the value as needed */
  }
</style>
<table class="table table-bordered">
  <tr>
    <th>Tipe Form</th>
    <td>{{ isset($archiveContainers->number_archive) ? $archiveContainers->number_archive : 'N/A' }}</td>
  </tr>
  <tr>
    <th>Tanggal Form</th>
    <td>
      {{ isset($archiveContainers->archive_in) ? Carbon\Carbon::parse($archiveContainers->archive_in)->translatedFormat('l, d F Y') : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Keterangan</th>
    <td>{{ isset($archiveContainers->year) ? $archiveContainers->year : 'N/A' }}</td>
  </tr>
  <tr>
    <th>File</th>
    <td>
      @if ($archiveContainers->file)
        <a type="button" data-fancy data-src="{{ asset('storage/' . $archiveContainers->file) }}"
          class="btn btn-info btn-sm text-white">
          Lihat
        </a>

        <a type="button" href="{{ asset('storage/' . $archiveContainers->file) }}"
          class="btn btn-warning btn-sm text-white " download>Unduh</a>
        <br>

        <p class="mt-1">Latest File : {{ pathinfo($archiveContainers->file, PATHINFO_FILENAME) }}</p>
      @else
        <p>File not found!</p>
      @endif
    </td>
  </tr>
</table>
<script>
  Fancybox.bind('[data-fancy]', {
    // infinite: false,
  });
</script>
