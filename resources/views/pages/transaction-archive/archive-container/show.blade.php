<style>
  .fancybox-container {
    z-index: 1061 !important;
    /* Adjust the value as needed */
  }
</style>
<div class="table-container">

  {{-- Container --}}
  <div class="table-wrapper">
    <h4 class="text-center">Kontainer</h4>
    <table class="table table-bordered">

      {{-- Kontainer --}}
      <tr>
        <th>Nama Divisi</th>
        <td>{{ isset($archiveContainers->division->name) ? $archiveContainers->division->name : 'N/A' }}</td>
      </tr>
      <tr>
        <th>Nomor Kontainer</th>
        <td>
          {{ isset($archiveContainers->locationContainer->number_container) ? str_pad($archiveContainers->locationContainer->number_container, 3, '0', STR_PAD_LEFT) : 'N/A' }}
        </td>
      </tr>
      <tr>
        <th>Lokasi Utama</th>
        <td>
          {{ isset($archiveContainers->locationContainer->mainLocation->name) ? $archiveContainers->locationContainer->mainLocation->name : 'N/A' }}
        </td>
      </tr>
      <tr>
        <th>Sub Lokasi</th>
        <td>
          {{ isset($archiveContainers->locationContainer->subLocation->name) ? $archiveContainers->locationContainer->subLocation->name : 'N/A' }}
        </td>
      </tr>
      <tr>
        <th>Detail Lokasi</th>
        <td>
          {{ isset($archiveContainers->locationContainer->detailLocation->name) ? $archiveContainers->locationContainer->detailLocation->name : 'N/A' }}
        </td>
      </tr>
      <tr>
        <th>Keterangan</th>
        <td>
          {{ isset($archiveContainers->locationContainer->description) ? $archiveContainers->locationContainer->description : 'N/A' }}
        </td>
      </tr>


    </table>
  </div>

  {{-- Classification --}}
  <div class="table-wrapper">
    <h4 class="text-center">Klasifikasi</h4>
    <table class="table table-bordered">
      <tr>
        <th>Klasifikasi Arsip</th>
        <td>
          {{ isset($archiveContainers->mainClassification->name) ? $archiveContainers->mainClassification->name : 'N/A' }}
        </td>
      </tr>
      <tr>
        <th> Sub Klasifikasi Arsip</th>
        <td>
          {{ isset($archiveContainers->subClassification->name) ? $archiveContainers->subClassification->name : 'N/A' }}
        </td>
      </tr>
      {{-- <tr>
        <th>Sub Series Arsip</th>
        <td>{{ isset($archiveContainers->subseries) ? $archiveContainers->subseries : 'N/A' }}</td>
      </tr> --}}
    </table>
  </div>

  {{-- Retention --}}
  <div class="table-wrapper">
    <h4 class="text-center">Masa Retensi</h4>
    <table class="table table-bordered">
      <tr>
        <th>Masa Aktif</th>
        <td>
          {{ isset($archiveContainers->subClassification->period_active) ? $archiveContainers->subClassification->period_active : 'N/A' }}
          {{ $archiveContainers->subClassification->period_active == 'PERMANEN' ? '' : 'Tahun' }}
        </td>
      </tr>
      <tr>
        <th>Keterangan Masa Aktif</th>
        <td>
          {{ isset($archiveContainers->subClassification->description_active) ? $archiveContainers->subClassification->description_active : 'N/A' }}
        </td>
      </tr>
      <tr>
        <th>Masa Inaktif</th>
        <td>
          {{ isset($archiveContainers->subClassification->period_inactive) ? $archiveContainers->subClassification->period_inactive : 'N/A' }}
          {{ $archiveContainers->subClassification->period_inactive == 'PERMANEN' ? '' : 'Tahun' }}
        </td>
      </tr>
      <tr>
        <th>Keterangan Masa Inaktif</th>
        <td>
          {{ isset($archiveContainers->subClassification->description_inactive) ? $archiveContainers->subClassification->description_inactive : 'N/A' }}
        </td>
      </tr>
      <tr>
        <th>Keterangan Tambahan</th>
        <td>
          {{ isset($archiveContainers->subClassification->description) ? $archiveContainers->subClassification->description : 'N/A' }}
        </td>
      </tr>
    </table>
  </div>

  {{-- Detail Archzive --}}
  {{-- <div class="table-wrapper">
    <table class="table table-bordered">

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
  </div> --}}

  {{-- Detail Archive --}}
  <div class="table-wrapper">
    <h4 class="text-center">Detail Arsip</h4>
    <table class="table table-bordered" style="width: 100%;">

      {{-- Input Data --}}
      <tr>
        <th scope="col">Tanggal Arsip Masuk</th>
        <td colspan="3" class="text-center h6" style="width: 50%;">
          {{ isset($archiveContainers->archive_in) ? Carbon\Carbon::parse($archiveContainers->archive_in)->translatedFormat('l, d F Y') : 'N/A' }}
        </td>
      </tr>
      <tr>
        <th scope="col" style="width: 25%;">Nomor Aplikasi</th>
        <td style="width: 25%;">{{ isset($archiveContainers->number_app) ? $archiveContainers->number_app : 'N/A' }}
        </td>
        <th scope="col">Tahun</th>
        <td style="width: 25%;">{{ isset($archiveContainers->year) ? $archiveContainers->year : 'N/A' }}</td>
      </tr>
      <tr>
        <th scope="col" style="width: 25%;">Nomor Dokumen</th>
        <td style="width: 25%;">
          {{ isset($archiveContainers->number_document) ? $archiveContainers->number_document : 'N/A' }}</td>
        <th scope="col">Tag</th>
        <td style="width: 25%;">{{ isset($archiveContainers->tag) ? $archiveContainers->tag : 'N/A' }}</td>
      </tr>
      <tr>
        <th scope="col" style="width: 25%;">Nomor Katalog</th>
        <td style="width: 25%;">
          {{ isset($archiveContainers->number_catalog) ? $archiveContainers->number_catalog : 'N/A' }}</td>
        <th scope="col">Perihal</th>
        <td style="width: 25%;">{{ isset($archiveContainers->regarding) ? $archiveContainers->regarding : 'N/A' }}</td>
      </tr>
      <tr>
        <th scope="col" style="width: 25%;">Nomor Arsip</th>
        <td style="width: 25%;">
          {{ isset($archiveContainers->number_archive) ? $archiveContainers->number_archive : 'N/A' }}</td>
        <th scope="col">Bentuk Dokumen</th>
        <td style="width: 25%;">
          {{ isset($archiveContainers->document_type) ? $archiveContainers->document_type : 'N/A' }}</td>
      </tr>
      <tr>
        <th scope="col">Jenis Arsip</th>
        <td style="width: 25%;">
          {{ isset($archiveContainers->archive_type) ? $archiveContainers->archive_type : 'N/A' }}</td>
        <th scope="col">Jumlah & Satuan</th>
        <td style="width: 25%;">{{ isset($archiveContainers->amount) ? $archiveContainers->amount : 'N/A' }}</td>
      </tr>
      <tr>
        <th scope="col">File Arsip</th>
        <td colspan="3" style="word-break: break-word; width: 50%;">
          @if ($archiveContainers->file && Storage::disk('d_drive')->exists($archiveContainers->file))
            <div class="row">
              <div class="col-auto">
                <form action="{{ route('view.file', $archiveContainers->id) }}" method="post" target="_blank">
                  @csrf
                  <button type="submit" class="btn btn-info btn-sm text-white">
                    Lihat
                  </button>
                </form>
                <p>
                  x{{ DB::table('archive_container_logs')->where('action', 'viewed')->where('archive_container_id', $archiveContainers->id)->count() }}
                  viewed</p>
              </div>

              <div class="col-auto">
                <a href="{{ route('download.file', $archiveContainers->id) }}"
                  class="btn btn-warning btn-sm text-white" download>
                  Unduh
                </a>
                <p>
                  x{{ DB::table('archive_container_logs')->where('action', 'download')->where('archive_container_id', $archiveContainers->id)->count() }}
                  downloaded</p>
              </div>
            </div>
            <p class="mt-1">Latest File : {{ pathinfo($archiveContainers->file, PATHINFO_FILENAME) }}</p>
          @else
            <p class="text-danger h6"><strong>No File Found.</strong></p>
          @endif
        </td>
      </tr>
    </table>
  </div>
</div>

{{-- <script>
  Fancybox.bind('[data-fancy]', {
    // infinite: false,
  });
</script> --}}
<style>
  .table-container {
    display: flex;
    flex-wrap: wrap;
  }

  .table-wrapper {
    flex: 1 1 calc(25% - 20px);
    /* Adjust the width of each table */
    margin-right: 20px;
    /* Adjust the space between tables */
  }
</style>

{{-- Klasifikasi --}}
{{-- <tr>
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
    </tr> --}}

{{-- Retensi --}}
{{-- <tr>
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
    </tr> --}}
