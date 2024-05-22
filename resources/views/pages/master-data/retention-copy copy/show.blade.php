<div style="display: flex;">
  <table class="table table-bordered" style="width: 50%;">

    {{-- Kontainer --}}
    <tr>
      <th>Nama Klasifikasi</th>
      <td>{{ isset($retentions->main_classification->name) ? $retentions->main_classification->name : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Nama Sub Klasifikasi</th>
      <td>{{ isset($retentions->sub_classification->name) ? $retentions->sub_classification->name : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Kode Sub Series</th>
      <td>{{ isset($retentions->code) ? $retentions->code : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Nama Sub Series</th>
      <td>{{ isset($retentions->sub_series) ? $retentions->sub_series : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Tipe Dokumen</th>
      <td>{{ isset($retentions->document_type) ? $retentions->document_type : 'N/A' }}</td>
    </tr>
  </table>

  <table class="table table-bordered" style="width: 50%;">

    {{-- Input Data --}}
    <tr>
      <th>Masa Aktif</th>
      <td>{{ isset($retentions->period_active) ? $retentions->period_active : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Keterangan Masa Aktif</th>
      <td>{{ isset($retentions->description_active) ? $retentions->description_active : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Masa Inaktif</th>
      <td>{{ isset($retentions->period_inactive) ? $retentions->period_inactive : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Keterangan Masa Inaktif</th>
      <td>{{ isset($retentions->description_inactive) ? $retentions->description_inactive : 'N/A' }}</td>
    </tr>
    <tr>
      <th>Keterangan Tambahan</th>
      <td>{{ isset($retentions->description) ? $retentions->description : 'N/A' }}</td>
    </tr>
  </table>
</div>
