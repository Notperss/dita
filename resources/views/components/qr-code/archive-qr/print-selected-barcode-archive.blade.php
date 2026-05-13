{{-- Letakkan CSS sekali saja di bagian atas file --}}
<style>
  .table-no-gap {
    border-collapse: collapse;
    margin-bottom: 0;
  }

  .table-no-gap th {
    padding: 0;
  }

  @media print {
    .word-break {
      word-break: break-word;
      overflow-wrap: break-word;
    }

    .width-50 {
      width: 50%;
    }

    .page-break {
      page-break-after: always;
      break-after: page;
    }
  }
</style>
@foreach ($containerBox->archiveContainer as $archiveContainer)
  @php
    $qr = QrCode::size(150)->style('round')->margin(1)->generate($archiveContainer->number_app);
  @endphp
  <div class="container justify-content-center">
    <div class="col-md-7 mx-auto">
      {{-- <style>
          .table-no-gap {
            border-collapse: collapse;
            margin-bottom: 0;
          }

          .table-no-gap th {
            padding: 0.0rem;
            /* Adjust the padding as needed */
          }
        </style>
        <style>
          @media print {
            .word-break {
              word-break: break-word;
              overflow-wrap: break-word;
              /* width: 100%; */
            }

            .width-50 {
              width: 50%;
            }

            /* Center */
            /* .width-50 {
          width: 40%;
          margin-left: auto;
          margin-right: auto;
        } */
          }
        </style> --}}
      <table class="table table-borderless text-left table-no-gap width-50">
        <tr>
          <th class="text-center" colspan="2">
            <img src="{{ asset('storage/' . (auth()->user()->company->logo ?? 'assets/logo-default.png')) }}"
              alt="Current Logo" style="max-width: 40px; margin-right: 2pt">
            {{ auth()->user()->company->name ?? '' }}
          </th>
        </tr>
        <tr>
          <th class="text-center" style="width: 30%">
            {{ $qr }}
          </th>
          <td class="word-break">
            <div class="row">Nomor Katalog</div>
            <div class="row mb-3"><strong>
                {{ isset($archiveContainer->number_catalog) ? $archiveContainer->number_catalog : '-' }}</th>
              </strong>
            </div>
            <div class="row">Nomor Dokumen</div>
            <div class="row mb-3"><strong>
                {{ isset($archiveContainer->number_document) ? $archiveContainer->number_document : '-' }}</th>
              </strong>
            </div>
            <div class="row">Nomor Arsip</div>
            <div class="row mb-3"><strong>
                {{ isset($archiveContainer->number_archive) ? $archiveContainer->number_archive : '-' }}</th>
              </strong>
            </div>
          </td>
        </tr>
        <tr>
          <th class="text-center" style="font-size: 150%;" colspan="2">
            {{ isset($archiveContainer->number_container) ? str_pad($archiveContainer->number_container, 3, '0', STR_PAD_LEFT) : 'N/A' }}</br>
            {{ isset($archiveContainer->number_app) ? str_pad($archiveContainer->number_app, 3, '0', STR_PAD_LEFT) : 'N/A' }}
          </th>
        </tr>
      </table>
    </div>
  </div>
  {{-- <hr>
     --}}
  {{-- Page break setiap 3 data --}}
  @if (!$loop->last)
    <div style="page-break-after: always;"></div>
  @endif
@endforeach

<script>
  window.addEventListener('load', function() {
    window.print();

    // Optional: tutup tab otomatis setelah print selesai
    window.onafterprint = function() {
      window.close();
    };
  });
</script>

{{-- <div class="row justify-content-center mt-1">
  <button class="btn btn-info text-center " style="width: 20%" value='Print' onclick='printDiv();'>Print</button>
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
</script> --}}
