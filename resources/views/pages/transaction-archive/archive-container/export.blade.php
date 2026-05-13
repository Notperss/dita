<table>
  <thead>
    <tr>
      <th style="width: 30;">Division</th>
      <th style="width: 30;">Number Container</th>
      <th style="width: 30;">Lokasi Utama</th>
      <th style="width: 30;">Sub Lokasi</th>
      <th style="width: 30;">Detail Lokasi</th>
      <th style="width: 30;">Keterangan</th>

      <th style="width: 30;">Masa Aktif</th>
      <th style="width: 30;">Keterangan Masa Aktif</th>
      <th style="width: 30;">Masa Inaktif</th>
      <th style="width: 30;">Keterangan Masa Inaktif</th>
      <th style="width: 30;">Keterangan Tambahan</th>

      <th style="width: 30;">Main Classification</th>
      <th style="width: 30;">Sub Classification</th>
      <th style="width: 30;">Arsip Masuk</th>

      <th style="width: 30;">Nomor Aplikasi</th>
      <th style="width: 30;">Nomor Dokumen</th>
      <th style="width: 30;">Nomor Katalog</th>
      <th style="width: 30;">Nomor Arsip</th>
      <th style="width: 30;">Jenis Arsip</th>
      <th style="width: 30;">Tahun</th>
      <th style="width: 30;">Perihal</th>
      <th style="width: 30;">Bentuk Dokumen</th>
      <th style="width: 30;">Jumlah / Satuan</th>

    </tr>
  </thead>
  <tbody>
    @foreach ($archiveContainers as $archiveContainer)
      <tr>
        <td>{{ optional($archiveContainer->division)->name ?? '-' }}</td>
        <td>
          {{ optional($archiveContainer->locationContainer)->number_container
              ? str_pad($archiveContainer->locationContainer->number_container, 3, '0', STR_PAD_LEFT)
              : '-' }}
        </td>

        <td>{{ optional(optional($archiveContainer->locationContainer)->mainLocation)->name ?? '-' }}</td>
        <td>{{ optional(optional($archiveContainer->locationContainer)->subLocation)->name ?? '-' }}</td>
        <td>{{ optional(optional($archiveContainer->locationContainer)->detailLocation)->name ?? '' }}</td>
        <td>{{ optional($archiveContainer->locationContainer)->description ?? '' }}</td>

        <td>
          {{ optional($archiveContainer->subClassification)->period_active ?? '' }}
          {{ optional($archiveContainer->subClassification)->period_active == 'PERMANEN' ? '' : 'Tahun' }}
        </td>
        <td>{{ optional($archiveContainer->subClassification)->description_active ?? '' }}</td>
        <td>
          {{ optional($archiveContainer->subClassification)->period_inactive ?? '' }}
          {{ optional($archiveContainer->subClassification)->period_inactive == 'PERMANEN' ? '' : 'Tahun' }}
        </td>
        <td>{{ optional($archiveContainer->subClassification)->description_inactive ?? '' }}</td>
        <td>{{ optional($archiveContainer->subClassification)->description ?? '' }}</td>

        <td>{{ optional($archiveContainer->mainClassification)->name ?? '-' }}</td>
        <td>{{ optional($archiveContainer->subClassification)->name ?? '-' }}</td>
        <td>
          {{ $archiveContainer->archive_in ? \Carbon\Carbon::parse($archiveContainer->archive_in)->format('d-m-Y') : '-' }}
        </td>

        <td>{{ $archiveContainer->number_app ?? '' }}</td>
        <td>{{ $archiveContainer->number_document ?? '' }}</td>
        <td>{{ $archiveContainer->number_catalog ?? '' }}</td>
        <td>{{ $archiveContainer->number_archive ?? '' }}</td>
        <td>{{ $archiveContainer->document_type ?? '' }}</td>
        <td>{{ $archiveContainer->year ?? '' }}</td>
        <td>{{ $archiveContainer->regarding ?? '' }}</td>
        <td>{{ $archiveContainer->archive_type ?? '' }}</td>
        <td>{{ $archiveContainer->amount ?? '' }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
