<table class="table table-bordered ">
  <tr>
    <th>Log Name</th>
    <td>
      {{ isset($item->log_name) ? $item->log_name : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>User (Causer)</th>
    <td>
      {{ isset($item->causer->name) ? $item->causer->name : 'N/A' }}
      {{ optional($item->causer)->getRoleNames() ?? 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Description</th>
    <td>{{ isset($item->description) ? $item->description : 'N/A' }}</td>
  </tr>
  <tr>
    <th>User (Subject)</th>
    <td>
      {{ isset($item->subject->name) ? $item->subject->name : 'N/A' }}
    </td>
  </tr>
  <tr>
    <th>Properties</th>
    <td>{{ isset($item->properties) ? $item->properties : 'N/A' }}</td>
  </tr>
  <tr>
    <th>Created At</th>
    <td>
      {{ isset($item->created_at) ? Carbon\Carbon::parse($item->created_at)->translatedFormat(' H:i:s - l, d F Y') : 'N/A' }}
    </td>
  </tr>
</table>
