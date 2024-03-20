<style>
  .fancybox-container {
    z-index: 1061 !important;
    /* Adjust the value as needed */
  }
</style>
<div style="display: flex;">
  <table class="table table-bordered" style="width: 50%;">

    {{-- Kontainer --}}
    <tr>
      <th>Nama Divisi</th>
      <td>{{ isset($archiveContainers->division->name) ? $archiveContainers->division->name : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Nomor Kontainer</th>
      <td>{{ isset($archiveContainers->number_container) ? $archiveContainers->number_container : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Lokasi Utama</th>
      <td>{{ isset($archiveContainers->main_location) ? $archiveContainers->main_location : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Sub Lokasi</th>
      <td>{{ isset($archiveContainers->sub_location) ? $archiveContainers->sub_location : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Detail Lokasi</th>
      <td>{{ isset($archiveContainers->detail_location) ? $archiveContainers->detail_location : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Keterangan</th>
      <td>{{ isset($archiveContainers->description_location) ? $archiveContainers->description_location : 'N/A' }}</td>
    </tr>

    {{-- Klasifikasi --}}
    <tr>
      <th>Klasifikasi Arsip</th>
      <td>
        {{ isset($archiveContainers->mainClassification->name) ? $archiveContainers->mainClassification->name : 'N/A' }}
      </td>
    </tr>
    <tr>
      <th> Sub Klasifikasi Arsip</th>
      <td>{{ isset($archiveContainers->subClassification->name) ? $archiveContainers->subClassification->name : 'N/A' }}
      </td>
    </tr>
    <tr>
      <th>Sub Series Arsip</th>
      <td>{{ isset($archiveContainers->subseries) ? $archiveContainers->subseries : 'N/A' }}</td>
    </tr>

    {{-- Retensi --}}
    <tr>
      <th>Masa Aktif</th>
      <td>{{ isset($archiveContainers->period_active) ? $archiveContainers->period_active : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Keterangan Masa Aktif</th>
      <td>{{ isset($archiveContainers->description_active) ? $archiveContainers->description_active : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Masa Inaktif</th>
      <td>{{ isset($archiveContainers->period_inactive) ? $archiveContainers->period_inactive : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Keterangan Masa Inaktif</th>
      <td>{{ isset($archiveContainers->description_inactive) ? $archiveContainers->description_inactive : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Keterangan Tambahan</th>
      <td>{{ isset($archiveContainers->description_retention) ? $archiveContainers->description_retention : 'N/A' }}
      </td>
    </tr>
  </table>

  <table class="table table-bordered" style="width: 50%;">

    {{-- Input Data --}}
    <tr>
      <th>Nomor Aplikasi</th>
      <td>{{ isset($archiveContainers->number_app) ? $archiveContainers->number_app : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Nomor Katalog</th>
      <td>{{ isset($archiveContainers->number_catalog) ? $archiveContainers->number_catalog : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Nomor Dokumen</th>
      <td>{{ isset($archiveContainers->number_document) ? $archiveContainers->number_document : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Nomor Arsip</th>
      <td>{{ isset($archiveContainers->number_archive) ? $archiveContainers->number_archive : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Tanggal Arsip Masuk</th>
      <td>
        {{ isset($archiveContainers->archive_in) ? Carbon\Carbon::parse($archiveContainers->archive_in)->translatedFormat('l, d F Y') : 'N/A' }}
      </td>
    </tr>
    <tr>
      <th>Tahun</th>
      <td>{{ isset($archiveContainers->year) ? $archiveContainers->year : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Perihal</th>
      <td>{{ isset($archiveContainers->regarding) ? $archiveContainers->regarding : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Tag</th>
      <td>{{ isset($archiveContainers->tag) ? $archiveContainers->tag : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Bentuk Dokumen</th>
      <td>{{ isset($archiveContainers->document_type) ? $archiveContainers->document_type : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Jenis Arsip</th>
      <td>{{ isset($archiveContainers->archive_type) ? $archiveContainers->archive_type : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Jumlah & Satuan</th>
      <td>{{ isset($archiveContainers->amount) ? $archiveContainers->amount : 'N/A' }}</td>
    </tr>
    <tr>
      <th>File Arsip</th>
      <td style="word-break: break-word;">
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
</div>
<script>
  Fancybox.bind('[data-fancy]', {
    // infinite: false,
  });
</script>
