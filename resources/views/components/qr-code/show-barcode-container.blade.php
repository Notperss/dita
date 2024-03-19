<div class="container" id='DivIdToPrint'>
  <div class="col-md-12">
    <style>
      .table-no-gap {
        border-collapse: collapse;
        margin-bottom: 0;
      }

      .table-no-gap th {
        padding: 0.0rem;
        /* Adjust the padding as needed */
      }
    </style>
    <table class="table table-borderless text-left table-no-gap ">
      <tr>
        <th class="text-center">{{ $qr }}</th>
      </tr>
      <tr>
        <th class="text-center" style="font-size: 130%;">
          {{ isset($archiveContainer->number_container) ? str_pad($archiveContainer->number_container, 3, '0', STR_PAD_LEFT) : 'N/A' }}
        </th>
      </tr>
      <tr>
        <th class="text-center">
          {{ isset($archiveContainer->main_location) ? $archiveContainer->main_location : 'N/A' }}</th>
      </tr>
      <tr>
        <th class="text-center">
          {{ isset($archiveContainer->sub_location) ? $archiveContainer->sub_location : 'N/A' }}</th>
      </tr>
      <tr>
        <th class="text-center">
          {{ isset($archiveContainer->detail_location) ? $archiveContainer->detail_location : 'N/A' }}
        </th>
      </tr>
      <tr>
        <th class="text-center">
          {{ isset($archiveContainer->division->name) ? $archiveContainer->division->name : 'N/A' }}</th>
      </tr>
    </table>
    <a href="{{ route('show-qr', $archiveContainer->id) }}">.</a>
  </div>
</div>
<div class="row justify-content-center mt-1">
  <button class="btn btn-info text-center" value='Print' onclick='printDiv();'>Print</button>
</div>
<script>
  function printDiv() {

    var divToPrint = document.getElementById('DivIdToPrint');

    var newWin = window.open('', 'Print-Window');

    newWin.document.open();

    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

    newWin.document.close();

    setTimeout(function() {
      newWin.close();
    }, 10);

  }
</script>
