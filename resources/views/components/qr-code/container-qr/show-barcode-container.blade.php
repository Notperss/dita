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

      table .text-center.no-margin {
        margin: 0 !important;
        padding: 0 !important;
      }

      @media print {
        body {
          margin: 5mm;
        }

        .description-cell {
          width: 20px;
          /* Set the width of the cell */
          padding: -3mm;
          margin: -3mm;
          /* Adjust padding to reduce space inside the cell */
          font-size: 18pt;
          /* Optionally adjust font size for print */
          text-align: center;
        }

        .number-container-cell {
          font-size: 77pt;

        }

        .container {
          width: auto;
          /* Adjust width for print if necessary */
          padding: 0;
          /* Adjust padding for print if necessary */
        }

        .btn {
          display: none;
          /* Hide buttons on print */
        }

        .width-50 {
          width: 50%;
          word-break: break-all;
        }

        .leeft {
          text-align: left;
        }
      }
    </style>


    <table class="table table-borderless text-left table-no-gap width-50">
      <tr>
        <th class="text-center" colspan="2">
          <img src="{{ asset('storage/' . (auth()->user()->company->logo ?? 'assets/logo-default.png')) }}"
            alt="Current Logo" style="max-width: 40px; margin-right: 2pt">
          {{ auth()->user()->company->name ?? '' }}
        </th>
      </tr>
      <tr class="leeft">
        <th class="text-center no-margin" style="width: 30%">{{ $qr }} </th>
        <td class="no-margin" style="text-align: left">
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
          <div class="row">Divisi</div>
          <div class="row">
            <strong>
              {{ isset($location_container->division->name) ? $location_container->division->name : 'N/A' }}
            </strong>
          </div>
        </td>
      </tr>
      <tr>
        <th class="text-center font-semibold number-container-cell"colspan="2">
          {{ isset($location_container->number_container) ? str_pad($location_container->number_container, 3, '0', STR_PAD_LEFT) : 'N/A' }}
        </th>
      </tr>
      <tr>
        <td class="text-center description-cell" colspan="2">
          {{ isset($location_container->description) ? $location_container->description : 'N/A' }}
        </td>
      </tr>
    </table>

  </div>
</div>
<a href="{{ route('show-qr', $location_container->id) }}">.</a>
<div class="row justify-content-center mt-1">
  <button class="btn btn-info text-center" style="width: 20%" value='Print' onclick='printDiv();'>Print</button>
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
