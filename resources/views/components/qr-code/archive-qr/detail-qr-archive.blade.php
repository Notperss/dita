@extends('layouts.app')

@section('title', 'Detail Archive')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Detail Archive</h3>
          <!-- <p class="text-subtitle text-muted">List all data from the archive Container.</p> -->
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    <!--<h1>QR Code Scanner</h1>
                                            <div id="reader" style="width: 300px; height: 300px;"></div>
                                            <p id="result">Scanning...</p> -->
    <div class="card">
      <div class="card-header">

        <div class="row mx-auto">
          <div class="col-md-6">
            <div class="form-group">
              <label for="searchQuery">Cari Arsip</label>
              <form action="{{ route('archives.search') }}" method="GET">
                <input type="text" id="searchQuery" name="query" class="form-control" placeholder=""
                  value="{{ request()->input('query') }}">
                <p><small class="text-muted">Find helper text here for given textbox.</small></p>
                <button type="submit" class="mt-2 btn btn-info text-white">Search</button>
              </form>
            </div>
          </div>
        </div>

      </div>

      <div class="card-body">

        @if (isset($results))
          <p>Results for "{{ request()->input('query') }}":</p>
          <ul>
            @forelse($results as $result)
              <div style="display: flex;">
                <table class="table table-bordered" style="width: 50%;">

                  <!-- Kontainer -->
                  <tr>
                    <th>Nama Divisi</th>
                    <td>{{ isset($result->division->name) ? $result->division->name : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Nomor Kontainer</th>
                    <td>{{ isset($result->number_container) ? $result->number_container : 'N/A' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Lokasi Utama</th>
                    <td>{{ isset($result->main_location) ? $result->main_location : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Sub Lokasi</th>
                    <td>{{ isset($result->sub_location) ? $result->sub_location : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Detail Lokasi</th>
                    <td>{{ isset($result->detail_location) ? $result->detail_location : 'N/A' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Keterangan</th>
                    <td>
                      {{ isset($result->description_location) ? $result->description_location : 'N/A' }}
                    </td>
                  </tr>

                  <!-- Klasifikasi -->
                  <tr>
                    <th>Klasifikasi Arsip</th>
                    <td>
                      {{ isset($result->mainClassification->name) ? $result->mainClassification->name : 'N/A' }}
                    </td>
                  </tr>
                  <tr>
                    <th> Sub Klasifikasi Arsip</th>
                    <td>
                      {{ isset($result->subClassification->name) ? $result->subClassification->name : 'N/A' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Sub Series Arsip</th>
                    <td>{{ isset($result->subseries) ? $result->subseries : 'N/A' }}</td>
                  </tr>

                  <!-- Retensi -->
                  <tr>
                    <th>Masa Aktif</th>
                    <td>{{ isset($result->period_active) ? $result->period_active : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Keterangan Masa Aktif</th>
                    <td>
                      {{ isset($result->description_active) ? $result->description_active : 'N/A' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Masa Inaktif</th>
                    <td>{{ isset($result->period_inactive) ? $result->period_inactive : 'N/A' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Keterangan Masa Inaktif</th>
                    <td>
                      {{ isset($result->description_inactive) ? $result->description_inactive : 'N/A' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Keterangan Tambahan</th>
                    <td>
                      {{ isset($result->description_retention) ? $result->description_retention : 'N/A' }}
                    </td>
                  </tr>
                </table>

                <table class="table table-bordered" style="width: 50%;">

                  <!-- Input Data -->
                  <tr>
                    <th>Nomor Aplikasi</th>
                    <td>{{ isset($result->number_app) ? $result->number_app : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Nomor Katalog</th>
                    <td>{{ isset($result->number_catalog) ? $result->number_catalog : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Nomor Dokumen</th>
                    <td>{{ isset($result->number_document) ? $result->number_document : 'N/A' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Nomor Arsip</th>
                    <td>{{ isset($result->number_archive) ? $result->number_archive : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Tanggal Arsip Masuk</th>
                    <td>
                      {{ isset($result->archive_in) ? Carbon\Carbon::parse($result->archive_in)->translatedFormat('l, d F Y') : 'N/A' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Tahun</th>
                    <td>{{ isset($result->year) ? $result->year : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Perihal</th>
                    <td>{{ isset($result->regarding) ? $result->regarding : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Tag</th>
                    <td>{{ isset($result->tag) ? $result->tag : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Bentuk Dokumen</th>
                    <td>{{ isset($result->document_type) ? $result->document_type : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Jenis Arsip</th>
                    <td>{{ isset($result->archive_type) ? $result->archive_type : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>Jumlah & Satuan</th>
                    <td>{{ isset($result->amount) ? $result->amount : 'N/A' }}</td>
                  </tr>
                  <tr>
                    <th>File Arsip</th>
                    <td style="word-break: break-word;">
                      @if ($result->file)
                        <a type="button" data-fancy data-src="{{ asset('storage/' . $result->file) }}"
                          class="btn btn-info btn-sm text-white">
                          Lihat
                        </a>

                        <a type="button" href="{{ asset('storage/' . $result->file) }}"
                          class="btn btn-warning btn-sm text-white " download>Unduh</a>
                        <br>

                        <p class="mt-1">Latest File : {{ pathinfo($result->file, PATHINFO_FILENAME) }}</p>
                      @else
                        <p>File not found!</p>
                      @endif
                    </td>
                  </tr>
                </table>
              </div>
            @empty
              <li>No results found.</li>
            @endforelse
          </ul>
        @endif

        {{-- <table class="table table-striped" id="table1">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>City</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Graiden</td>
              <td>vehicula.aliquet@semconsequat.co.uk</td>
              <td>076 4820 8838</td>
              <td>Offenburg</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Dale</td>
              <td>fringilla.euismod.enim@quam.ca</td>
              <td>0500 527693</td>
              <td>New Quay</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Nathaniel</td>
              <td>mi.Duis@diam.edu</td>
              <td>(012165) 76278</td>
              <td>Grumo Appula</td>
              <td>
                <span class="badge bg-danger">Inactive</span>
              </td>
            </tr>
            <tr>
              <td>Darius</td>
              <td>velit@nec.com</td>
              <td>0309 690 7871</td>
              <td>Ways</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Oleg</td>
              <td>rhoncus.id@Aliquamauctorvelit.net</td>
              <td>0500 441046</td>
              <td>Rossignol</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Kermit</td>
              <td>diam.Sed.diam@anteVivamusnon.org</td>
              <td>(01653) 27844</td>
              <td>Patna</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Jermaine</td>
              <td>sodales@nuncsit.org</td>
              <td>0800 528324</td>
              <td>Mold</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Ferdinand</td>
              <td>gravida.molestie@tinciduntadipiscing.org</td>
              <td>(016977) 4107</td>
              <td>Marlborough</td>
              <td>
                <span class="badge bg-danger">Inactive</span>
              </td>
            </tr>
            <tr>
              <td>Kuame</td>
              <td>Quisque.purus@mauris.org</td>
              <td>(0151) 561 8896</td>
              <td>Tresigallo</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Deacon</td>
              <td>Duis.a.mi@sociisnatoquepenatibus.com</td>
              <td>07740 599321</td>
              <td>Karapınar</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Channing</td>
              <td>tempor.bibendum.Donec@ornarelectusante.ca</td>
              <td>0845 46 49</td>
              <td>Warrnambool</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Aladdin</td>
              <td>sem.ut@pellentesqueafacilisis.ca</td>
              <td>0800 1111</td>
              <td>Bothey</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Cruz</td>
              <td>non@quisturpisvitae.ca</td>
              <td>07624 944915</td>
              <td>Shikarpur</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Keegan</td>
              <td>molestie.dapibus@condimentumDonecat.edu</td>
              <td>0800 200103</td>
              <td>Assen</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Ray</td>
              <td>placerat.eget@sagittislobortis.edu</td>
              <td>(0112) 896 6829</td>
              <td>Hofors</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Maxwell</td>
              <td>diam@dapibus.org</td>
              <td>0334 836 4028</td>
              <td>Thane</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Carter</td>
              <td>urna.justo.faucibus@orci.com</td>
              <td>07079 826350</td>
              <td>Biez</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Stone</td>
              <td>velit.Aliquam.nisl@sitametrisus.com</td>
              <td>0800 1111</td>
              <td>Olivar</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Berk</td>
              <td>fringilla.porttitor.vulputate@taciti.edu</td>
              <td>(0101) 043 2822</td>
              <td>Sanquhar</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Philip</td>
              <td>turpis@euenimEtiam.org</td>
              <td>0500 571108</td>
              <td>Okara</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Kibo</td>
              <td>feugiat@urnajustofaucibus.co.uk</td>
              <td>07624 682306</td>
              <td>La Cisterna</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Bruno</td>
              <td>elit.Etiam.laoreet@luctuslobortisClass.edu</td>
              <td>07624 869434</td>
              <td>Rocca d"Arce</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Leonard</td>
              <td>blandit.enim.consequat@mollislectuspede.net</td>
              <td>0800 1111</td>
              <td>Lobbes</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
            <tr>
              <td>Hamilton</td>
              <td>mauris@diam.org</td>
              <td>0800 256 8788</td>
              <td>Sanzeno</td>
              <td>
                <span class="badge bg-success">Active</span>
              </td>
            </tr>
          </tbody>
        </table> --}}




        {{-- <div style="display: flex;">
          <table class="table table-bordered" style="width: 50%;">

            <!-- Kontainer -->
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
              <td>{{ isset($archiveContainers->description_location) ? $archiveContainers->description_location : 'N/A' }}
              </td>
            </tr>

            <!-- Klasifikasi -->
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
            <tr>
              <th>Sub Series Arsip</th>
              <td>{{ isset($archiveContainers->subseries) ? $archiveContainers->subseries : 'N/A' }}</td>
            </tr>

            <!-- Retensi -->
            <tr>
              <th>Masa Aktif</th>
              <td>{{ isset($archiveContainers->period_active) ? $archiveContainers->period_active : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Keterangan Masa Aktif</th>
              <td>{{ isset($archiveContainers->description_active) ? $archiveContainers->description_active : 'N/A' }}
              </td>
            </tr>
            <tr>
              <th>Masa Inaktif</th>
              <td>{{ isset($archiveContainers->period_inactive) ? $archiveContainers->period_inactive : 'N/A' }}</td>
            </tr>
            <tr>
              <th>Keterangan Masa Inaktif</th>
              <td>
                {{ isset($archiveContainers->description_inactive) ? $archiveContainers->description_inactive : 'N/A' }}
              </td>
            </tr>
            <tr>
              <th>Keterangan Tambahan</th>
              <td>
                {{ isset($archiveContainers->description_retention) ? $archiveContainers->description_retention : 'N/A' }}
              </td>
            </tr>
          </table>

          <table class="table table-bordered" style="width: 50%;">

            <!-- Input Data -->
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


      </div>
    </div>

    <div class="viewmodal" style="display: none;"></div>

  </section>

@endsection
@push('after-script')
  {{-- <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <script>
    function onScanSuccess(decodedText, decodedResult) {
      // handle the scanned code as you like, for example:
      console.log(`Code matched = ${decodedText}`, decodedResult);
    }

    let config = {
      fps: 10,
      qrbox: {
        width: 100,
        height: 100
      },
      rememberLastUsedCamera: true,
      // Only support camera scan type.
      supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
    };

    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", config, /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess);
  </script> --}}

  <script>
    Fancybox.bind('[data-fancy]', {
      // infinite: false,
    });
  </script>
  <div class="modal fade" id="mymodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button class="btn close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <i class="fa fa-spinner fa spin"></i>
        </div>
      </div>
    </div>
  </div>
@endpush
