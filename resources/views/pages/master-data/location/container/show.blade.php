<table class="table table-bordered">
  <tr>
    <th>Nomor Kontainer</th>
    <td>{{ isset($containerLocation->number_container) ? $containerLocation->number_container : 'N/A' }}</td>
  </tr>
  <tr>
    <th>Divisi</th>
    <td>
      {{ isset($containerLocation->division->name) ? $containerLocation->division->name : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Lokasi utama</th>
    <td>
      {{ isset($containerLocation->mainLocation->name) ? $containerLocation->mainLocation->name : 'N/A' }}
    </td>
  </tr>

  <tr>
    <th>Sub utama</th>
    <td>
      {{ isset($containerLocation->subLocation->name) ? $containerLocation->subLocation->name : 'N/A' }}
    </td>
  </tr>

  <tr>
    <th>Detail utama</th>
    <td>
      {{ isset($containerLocation->detailLocation->name) ? $containerLocation->detailLocation->name : 'N/A' }}
    </td>
  </tr>

  <tr>
    <th>Keterangan</th>
    <td>
      {{ isset($containerLocation->description) ? $containerLocation->description : 'N/A' }}
    </td>
  </tr>

</table>
