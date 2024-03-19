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
        <th class="text-center">{{ $qr }} </th>
        <td>

          <div class="row">Lokasi Utama</div>
          <div class="row mb-3">
            <strong>
              {{ isset($location_container->mainLocation->name) ? $location_container->mainLocation->name : 'N/A' }}
            </strong>
          </div>
          <div class="row">Sub Lokasi</div>
          <div class="row mb-3">
            <strong>
              {{ isset($location_container->subLocation->name) ? $location_container->subLocation->name : 'N/A' }}
            </strong>
          </div>
          <div class="row">Detail Lokasi</div>
          <div class="row">
            <strong>
              {{ isset($location_container->detailLocation->name) ? $location_container->detailLocation->name : 'N/A' }}
            </strong>
          </div>

        </td>
      </tr>
      <tr>
        <th class="text-center" style="font-size: 130%;">
          {{ isset($location_container->number_container) ? str_pad($location_container->number_container, 3, '0', STR_PAD_LEFT) : 'N/A' }}
        </th>
      </tr>
      <tr>
        <th class="text-center">
          {{ isset($location_container->description) ? $location_container->description : 'N/A' }}
          <a href="{{ route('show-qr', $location_container->id) }}">.</a>
        </th>
      </tr>
    </table>

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
