@extends('layouts.app')

@section('title', 'Lending Archive')
@section('content')
  <div class="page-heading">

    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Peminjaman Arsip</h3>
        </div>
      </div>
    </div>
  </div>

  <!-- // Basic multiple Column Form section start -->
  <section id="multiple-column-form">

    <div class="row">
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon purple mb-2">
                  <i class="iconly-boldShow"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <a href="{{ route('backsite.history') }}">
                  <h6 class="text-muted font-semibold">Riwayat Semua Arsip</h6>
                  <h6 class="font-extrabold mb-0">
                    @can('super_admin')
                      {{ DB::table('lending_archives')->where('status', 2)->count() }}
                    @else
                      {{ DB::table('lending_archives')->where('status', 2)->where('user_id', auth()->user()->id)->count() }}
                    @endcan
                  </h6>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon blue mb-2">
                  <i class="iconly-boldProfile"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Riwayat Fisik</h6>
                <h6 class="font-extrabold mb-0">
                  <a href="{{ route('backsite.fisik') }}">
                    @can('super_admin')
                      {{ DB::table('lending_archives')->where('status', 2)->where('type_document', 'FISIK')->count() }}
                    @else
                      {{ DB::table('lending_archives')->where('status', 2)->where('type_document', 'FISIK')->where('user_id', auth()->user()->id)->count() }}
                    @endcan
                </h6>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon green mb-2">
                  <i class="iconly-boldAdd-User"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <a href="{{ route('backsite.digital') }}">
                  <h6 class="text-muted font-semibold">Riwayat Digital</h6>
                  <h6 class="font-extrabold mb-0">
                    @can('super_admin')
                      {{ DB::table('lending_archives')->where('status', 2)->where('type_document', 'DIGITAL')->count() }}
                    @else
                      {{ DB::table('lending_archives')->where('status', 2)->where('type_document', 'DIGITAL')->where('user_id', auth()->user()->id)->count() }}
                    @endcan
                  </h6>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a href="#mymodal" data-toggle="modal" data-target="#mymodal" class="btn btn-primary my-2"> <i
        class="bi bi-plus-lg"></i>
      Pinjam Arsip</a>

    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">List Data Peminjaman Arsip</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped mb-0" id="table1">
                  <thead>
                    <tr>
                      <th>Nomor Peminjaman</th>
                      <th>Divisi</th>
                      <th>Tgl Pinjam</th>
                      {{-- <th>Tgl Dikembalikan</th> --}}
                      <th>Keterangan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($lendings as $lending)
                      <tr>
                        <td class="text-bold-500">{{ $lending->lending_number ?? 'N/A' }}</td>
                        <td>{{ $lending->division ?? 'N/A' }}</td>
                        <td>
                          {{ Carbon\Carbon::parse($lending->start_date)->translatedFormat('l, d F Y ') ?? 'N/A' }}
                        </td>
                        {{-- <td>{{ $lending->end_date ?? 'N/A' }}</td> --}}
                        <td class="text-bold-500">{{ $lending->description }}</td>
                        {{-- <td>
                          @if ($lending->approval === 1)
                            <span class="badge bg-light-success">Selesai</span>
                          @elseif ($lending->approval === 0)
                            <span class="badge bg-light-danger">Proses</span>
                          @else
                            <span class="badge bg-light-warning">Proses</span>
                          @endif
                        </td> --}}
                        <td>
                          <div class="btn-group mb-1">
                            @can('approval')
                              <a class="btn btn-sm btn-info" onclick="update({{ $lending->id }})">Close</a>
                              <form id="update_{{ $lending->id }}" action="{{ route('backsite.closing', $lending->id) }}"
                                method="POST">
                                @method('put')
                                @csrf
                              </form>
                            @endcan
                            {{-- <a href="#detailLending"
                            data-remote="{{ route('backsite.lending-archive.show', $lending->id) }}" data-toggle="modal"
                            data-target="#detailLending" data-title="Detail Peminjaman" class="btn btn-success">
                            a
                          </a> --}}

                            <div class="dropdown">
                              <button class="btn btn-primary btn dropdown-toggle me-1" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                </i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="#detailLending"
                                  data-remote="{{ route('backsite.lending-archive.show', $lending->id) }}"
                                  data-toggle="modal" data-target="#detailLending" data-title="Detail Peminjaman"
                                  class="dropdown-item">
                                  <i class="bi bi-eye"></i> Detail
                                </a>
                                @can('super_admin')
                                  <a class="dropdown-item" onclick="showSweetAlert({{ $lending->id }})"><i
                                      class="bi bi-x-lg"></i> Delete</a>
                                @else
                                  @foreach ($lending->lendingArchive as $item)
                                    @if ($item->approval === null)
                                      <a class="dropdown-item" onclick="showSweetAlert({{ $lending->id }})"><i
                                          class="bi bi-x-lg"></i> Delete</a>
                                    @break
                                  @endif
                                @endforeach
                              @endcan
                            </div>
                          </div>
                        </div>
                        <form id="deleteForm_{{ $lending->id }}"
                          action="{{ route('backsite.lending-archive.destroy', $lending->id) }}" method="POST">
                          @method('DELETE')
                          @csrf
                        </form>

                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row match-height">
    <div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <h4 class="card-title mb-0">Arsip Yang Disetujui</h4>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="container-table">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">No.Dokumen</th>
                  <th class="text-center">Perihal</th>
                  <th class="text-center">Divisi</th>
                  <th class="text-center">Tipe</th>
                  <th class="text-center">Tgl Pengembalian/Berakhir</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($lendingArchives as $lendingArchive)
                  @if (
                      ($lendingArchive->period && strtotime($lendingArchive->period) >= strtotime('now')) ||
                          ($lendingArchive->type_document == 'FISIK' && $lendingArchive->lending->status == null))
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td class="text-center">{{ $lendingArchive->archiveContainer->number_document ?? 'N/A' }}</td>
                      <td class="text-center">{{ $lendingArchive->archiveContainer->regarding ?? 'N/A' }}</td>
                      <td class="text-center">{{ $lendingArchive->archiveContainer->division->name ?? 'N/A' }}</td>
                      <td class="text-center">
                        @if ($lendingArchive->type_document === 'DIGITAL')
                          <span class="badge bg-light-info">Digital</span>
                        @elseif ($lendingArchive->type_document === 'FISIK')
                          <span class="badge bg-light-secondary">Fisik</span>
                        @else
                          <span class="badge bg-light-warning"> - </span>
                        @endif
                      </td>
                      <td class="text-center">
                        {{ Carbon\Carbon::parse($lendingArchive->period)->translatedFormat('l, d F Y ') ?? 'N/A' }}
                      </td>
                      <td class="text-center">
                        @if ($lendingArchive->type_document == 'DIGITAL')
                          <a type="button" class="btn btn-success mx-1" data-fancy data-custom-class="pdf"
                            data-src="{{ asset('storage/' . $lendingArchive->archiveContainer->file) }}"
                            class="dropdown-item">
                            Lihat File
                          </a>
                        @else
                          @if (strtotime($lendingArchive->period) <= strtotime('now'))
                            <i class="bi bi-exclamation-diamond-fill text-danger"> <br>
                              sudah melewati masa pinjam</i>
                          @endif
                        @endif
                      </td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- // Basic multiple Column Form section end -->

{{-- Modal --}}
<div class="modal fade" id="mymodal" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Data</h5>
        <button class="btn close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <i class="fa fa-spinner fa spin"></i>
        <p>Isi input <code>Required (*)</code>, Sebelum menekan tombol submit. </p>
        <form class="form" method="POST" action="{{ route('backsite.lending-archive.store') }}"
          enctype="multipart/form-data" id=myForm>
          @csrf
          <div class="row">
            <div class="col-md-6 col-12 mx-auto">
              <div class="form-group">
                <label for="lending_number">Nomor Peminjaman <code>*</code></label>
                <input type="text" id="lending_number" class="form-control" name="lending_number"
                  value="{{ $newLendingNumber }}" readonly>
              </div>
              <div class="form-group">
                <label for="user_id">Peminjam <code>*</code></label>
                <input type="text" id="user_id" class="form-control" value="{{ auth()->user()->name }}"
                  readonly>
              </div>
              <div class="form-group" hidden>
                <label for="start_date">Tanggal <code>*</code></label>
                <input type="text" id="start_date" class="form-control" name="start_date"
                  value="{{ now()->toDateString() }}">
              </div>
              <div class="form-group">
                @php
                  $divisionId = auth()->user()->division_id;
                  $division = DB::table('divisions')->find($divisionId); // Assuming Division is your model representing divisions

                  if ($division) {
                      $divisionName = $division->name;
                  } else {
                      $divisionName = ''; // Provide a default value or handle the case where the division is not found
                  }
                @endphp
                <label for="division">Divisi <code>*</code></label>
                <input type="text" id="division" name="division" class="form-control"
                  value="{{ $divisionName }}" readonly>
              </div>
              <div class="form-group">
                <label for="description">keterangan</label>
                <textarea type="text" id="description" class="form-control" name="description"></textarea>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
              <button type="button" class="btn btn-light-secondary me-1 mb-1" data-dismiss="modal">Cancel</button>
            </div>
            {{-- APlikasi --}}
            <div class="form-group row">
              <div class="col-md-4">
                <button type="button" id="add-archive" class="btn btn-success addRow mb-1">Cari Arsip</button>
              </div>
              <table id="table-archive" class=" table col-md-12">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center" style="width: 25%">Nomor Arsip/Nomor Dokumen <code>*</code></th>
                    <th class="text-center">Perihal</th>
                    <th class="text-center">Divisi</th>
                    <th class="text-center">Tipe Dokumen <code>*</code></th>
                    <th style="text-align:center; width:10px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="viewmodal" style="display: none;"></div>


@endsection
@push('after-script')
<script>
  function showSweetAlert(lendingId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('deleteForm_' + lendingId).submit();
      }
    });
  }

  function update(lendingId) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, update it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('update_' + lendingId).submit();
      }
    });
  }
</script>

{{-- <script>
  $(document).ready(function() {
    // Array to store selected IDs
    let selectedIds = [];

    // Event listener for change event on select element
    $(document).on('change', 'select[name^="inputs["]:not([name$="[type_document]"])', function() {
      // Get the selected ID
      let selectedId = $(this).val();

      // Check if the selected ID already exists in the array
      if (selectedIds.includes(selectedId)) {
        alert("This ID is already selected. Please choose a different one.");
        $(this).val(""); // Clear the selected value
        return; // Exit function
      }

      // Add the selected ID to the array
      selectedIds.push(selectedId);

      // Disable the option with the selected ID in all other select elements
      $('select[name^="inputs["]:not([name$="[type_document]"])').not(this).find('option').prop('disabled',
        function() {
          return $(this).val() === selectedId;
        });
    });

    $('#add-archive').click(function() {
      // Increment index for unique IDs
      let a = selectedIds.length + 1;

      // Append a new row
      $('#table-archive').append(`
      <tr>
        <td class="text-center text-primary">${a}</td>
        <td>
          <select name="inputs[${a}][archive_container_id]" class="form-control select2 choices" style="width: 100%">
            <option value="" disabled selected>Choose</option>
            @foreach ($archiveContainers as $app)
              <option value="{{ $app->id }}" data-value="{{ $app->regarding }}" data-value2="{{ $app->division->name }}" data-app="{{ $app->id }}">{{ $app->number_archive }} -> {{ $app->number_document }}</option>
            @endforeach
          </select>
        </td>
        <td><input type="text" class="form-control version" id="version_${a}" readonly></td>
        <td><input type="text" class="form-control product" id="product_${a}" readonly></td>
        <td><select type="text" class="form-control" name="inputs[${a}][type_document]" readonly>
          <option value="" selected disabled>Choose</option>
          <option value="FISIK">Fisik</option>
          <option value="DIGITAL">Digital</option>
          </select></td>
        <td>
          <button type="button" class="btn btn-danger remove-row">Remove</button></td>
      </tr>
    `);
      // Initialize Select2 for the newly added select element
      $('.select2').select2({
        dropdownParent: $("#mymodal"),
        theme: 'classic', // Apply the 'classic-dark' theme
      });

      // Disable options that have been selected in other rows
      $('select[name^="inputs["]:not([name$="[type_document]').each(function() {
        let selectedId = $(this).val();
        $(this).find('option').prop('disabled', function() {
          return selectedIds.includes($(this).val()) && $(this).val() !== selectedId;
        });
      });
    });

    $(document).on('change', 'select[name^="inputs["]:not([name$="[type_document]"])', function() {
      var selectedOption = $(this).find(':selected');
      var versionValue = selectedOption.data('value') || '';
      var productValue = selectedOption.data('value2') || '';

      $(this).closest('tr').find('.version').val(versionValue);
      $(this).closest('tr').find('.product').val(productValue);
    });



    $(document).on('click', '.remove-row', function() {
      // Get the removed ID
      let removedId = $(this).closest('tr').find('select').val();

      // Remove the ID from the array
      selectedIds = selectedIds.filter(id => id !== removedId);

      // Remove the entire row when the "Remove" button is clicked
      $(this).closest('tr').remove();

      // Enable the option with the removed ID in all other select elements
      $('select[name^="inputs["]:not([name$="[type_document]"])').find('option').prop('disabled', false);
      $('select[name^="inputs["]:not([name$="[type_document]"])').each(function() {
        let selectedId = $(this).val();
        $(this).find('option').prop('disabled', function() {
          return selectedIds.includes($(this).val()) && $(this).val() !== selectedId;
        });
      });
    });
  });
</script> --}}


<script>
  $(document).ready(function() {
    // Array to store selected IDs
    let selectedIds = [];

    // Event listener for change event on select element
    $(document).on('change', 'select[name^="inputs["]:not([name$="[type_document]"])', function() {
      // Get the selected ID
      let selectedId = $(this).val();

      // Check if the selected ID already exists in the array
      if (selectedIds.includes(selectedId)) {
        alert("This ID is already selected. Please choose a different one.");
        $(this).val(""); // Clear the selected value
        return; // Exit function
      }

      // Add the selected ID to the array
      selectedIds.push(selectedId);

      // Disable the option with the selected ID in all other select elements
      $('select[name^="inputs["]:not([name$="[type_document]"])').not(this).find('option').prop('disabled',
        function() {
          return $(this).val() === selectedId;
        });
    });

    $('#add-archive').click(function() {
      // Check if the select value is filled
      let selectValueFilled = true;
      $('select[name^="inputs["]:not([name$="[type_document]"])').each(function() {
        if ($(this).val() === "") {
          selectValueFilled = false;
          return false; // Exit the loop early if any select value is not filled
        }
      });

      // If select value is not filled, alert the user and return
      if (!selectValueFilled) {
        alert("Please fill all select values before adding more rows.");
        return;
      }

      // Increment index for unique IDs
      let a = selectedIds.length + 1;

      // Append a new row
      $('#table-archive').append(`
          <tr>
            <td class="text-center text-primary">${a}</td>
            <td>
               <select name="inputs[${a}][archive_container_id]" class="form-control select2 choices" style="width: 100%">
            <option value="" disabled selected>Choose</option>
            @foreach ($archiveContainers as $app)
              <option value="{{ $app->id }}" data-value="{{ $app->regarding }}" data-value2="{{ $app->division->name }}" data-app="{{ $app->id }}">{{ $app->number_document }}</option>
            @endforeach
          </select>
            </td>
            <td><input type="text" class="form-control version" id="version_${a}" readonly></td>
            <td><input type="text" class="form-control product" id="product_${a}" readonly></td>
            <td><select type="text" class="form-control" name="inputs[${a}][type_document]" readonly>
              <option value="" selected disabled>Choose</option>
              <option value="FISIK">Fisik</option>
              <option value="DIGITAL">Digital</option>
              </select></td>
            <td>
              <button type="button" class="btn btn-danger remove-row">Remove</button></td>
          </tr>
        `);

      // Initialize Select2 for the newly added select element
      $('.select2').select2({
        dropdownParent: $("#mymodal"),
        theme: 'classic', // Apply the 'classic-dark' theme
      });

      // Disable options that have been selected in other rows
      $('select[name^="inputs["]:not([name$="[type_document]"]').each(function() {
        let selectedId = $(this).val();
        $(this).find('option').prop('disabled', function() {
          return selectedIds.includes($(this).val()) && $(this).val() !== selectedId;
        });
      });
    });

    $(document).on('change', 'select[name^="inputs["]:not([name$="[type_document]"])', function() {
      var selectedOption = $(this).find(':selected');
      var versionValue = selectedOption.data('value') || '';
      var productValue = selectedOption.data('value2') || '';

      $(this).closest('tr').find('.version').val(versionValue);
      $(this).closest('tr').find('.product').val(productValue);
    });

    $(document).on('click', '.remove-row', function() {
      // Get the removed ID
      let removedId = $(this).closest('tr').find('select').val();

      // Remove the ID from the array
      selectedIds = selectedIds.filter(id => id !== removedId);

      // Remove the entire row when the "Remove" button is clicked
      $(this).closest('tr').remove();

      // Enable the option with the removed ID in all other select elements
      $('select[name^="inputs["]:not([name$="[type_document]"])').find('option').prop('disabled', false);
      $('select[name^="inputs["]:not([name$="[type_document]"])').each(function() {
        let selectedId = $(this).val();
        $(this).find('option').prop('disabled', function() {
          return selectedIds.includes($(this).val()) && $(this).val() !== selectedId;
        });
      });
    });
  });
</script>

{{-- modal --}}
<script>
  jQuery(document).ready(function($) {
    $('#detailLending').on('show.bs.modal', function(e) {
      var button = $(e.relatedTarget);
      var modal = $(this);

      modal.find('.modal-body').load(button.data("remote"));
      modal.find('.modal-title').html(button.data("title"));
    });
  });
</script>

{{-- Fancybox --}}
<script>
  Fancybox.bind('[data-fancy]', {
    infinite: false,
    zIndex: 2100
  });
</script>

<div class="modal fade " data-backdrop="false" id="detailLending" role="dialog">
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
@push('after-style')
<style>
  #detailLending {
    z-index: 1001;
    background-color: rgba(0, 0, 0, 0.5);
  }

  /* .modal-backdrop {
                                                                                                                          z-index: 991;
                                                                                                                          display: none;
                                                                                                                        } */

  /* Dark theme for Select2 with hover effect */
  html[data-bs-theme="dark"] .select2-container--classic .select2-selection--single,
  html[data-bs-theme="dark"] .select2-container--classic .select2-selection--multiple {
    background-color: #1b1b29 !important;
    border-color: #1b1b29 !important;
    color: #fff !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-selection__arrow b {
    border-color: #1b1b29 transparent transparent transparent !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-selection__placeholder {
    color: #aaa !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-selection__rendered {
    color: #fff !important;
    background-color: #1b1b29 !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-dropdown {
    background-color: #1b1b29 !important;
    border-color: #1b1b29 !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-results__option {
    background-color: #1b1b29 !important;
    color: #fff !important;
    transition: background-color 0.1s;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-results__option:hover {
    background-color: #28283c !important;
    color: #fff !important;
  }

  html[data-bs-theme="dark"] .select2-container--classic .select2-results__option[aria-selected="true"] {
    background-color: #28283c !important;
    color: #fff !important;
  }
</style>
@endpush
