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
                <h6 class="text-muted font-semibold">Riwayat Semua Arsip</h6>
                <h6 class="font-extrabold mb-0">112.000</h6>
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
                <h6 class="text-muted font-semibold">Riwayat Hard Copy</h6>
                <h6 class="font-extrabold mb-0">183.000</h6>
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
                <h6 class="text-muted font-semibold">Riwayat Soft Copy</h6>
                <h6 class="font-extrabold mb-0">80.000</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon red mb-2">
                  <i class="iconly-boldBookmark"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Saved Post</h6>
                <h6 class="font-extrabold mb-0">112</h6>
              </div>
            </div>
          </div>
        </div>
      </div> --}}
    </div>

    <div class="row match-height">
      <div class="col-12">
        <a href="#mymodal" data-toggle="modal" data-target="#mymodal" class="btn btn-primary my-2"> <i
            class="bi bi-plus-lg"></i>
          Pinjam Arsip</a>
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">List Data Arsip Dalam Proses Persetujuan</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped mb-0">
                  <thead>
                    <tr>
                      <th>Nomor Arsip</th>
                      <th>Tahun</th>
                      <th>Bentuk Dokumen</th>
                      <th>Tgl Pinjam</th>
                      <th>Tgl Dikembalikan</th>
                      <th>Status</th>
                      {{-- <th>Action</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-bold-500">Michael Right</td>
                      <td>$15/hr</td>
                      <td class="text-bold-500">UI/UX</td>
                      <td>Remote</td>
                      <td>Austin,Taxes</td>
                      <td><a href="#"><i class="badge-circle badge-circle-light-secondary font-medium-1"
                            data-feather="mail"></i></a></td>
                    </tr>
                    <tr>
                      <td class="text-bold-500">Morgan Vanblum</td>
                      <td>$13/hr</td>
                      <td class="text-bold-500">Graphic concepts</td>
                      <td>Remote</td>
                      <td>Shangai,China</td>
                      <td><a href="#"><i class="badge-circle badge-circle-light-secondary font-medium-1"
                            data-feather="mail"></i></a></td>
                    </tr>
                    <tr>
                      <td class="text-bold-500">Tiffani Blogz</td>
                      <td>$15/hr</td>
                      <td class="text-bold-500">Animation</td>
                      <td>Remote</td>
                      <td>Austin,Texas</td>
                      <td><a href="#"><i class="badge-circle badge-circle-light-secondary font-medium-1"
                            data-feather="mail"></i></a></td>
                    </tr>
                    <tr>
                      <td class="text-bold-500">Ashley Boul</td>
                      <td>$15/hr</td>
                      <td class="text-bold-500">Animation</td>
                      <td>Remote</td>
                      <td>Austin,Texas</td>
                      <td><a href="#"><i class="badge-circle badge-circle-light-secondary font-medium-1"
                            data-feather="mail"></i></a></td>
                    </tr>
                    <tr>
                      <td class="text-bold-500">Mikkey Mice</td>
                      <td>$15/hr</td>
                      <td class="text-bold-500">Animation</td>
                      <td>Remote</td>
                      <td>Austin,Texas</td>
                      <td><a href="#"><i class="badge-circle badge-circle-light-secondary font-medium-1"
                            data-feather="mail"></i></a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- // Basic multiple Column Form section end -->

  {{-- Modal --}}
  <div class="modal fade" id="mymodal" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Data</h5>
          <button class="btn close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <i class="fa fa-spinner fa spin"></i>
          <form class="form" method="POST" action="{{ route('backsite.lending-archive.store') }}"
            enctype="multipart/form-data" id=myForm>
            @csrf
            <div class="row">
              <div class="col-md-6 col-12 mx-auto">
                <div class="form-group">
                  <label for="lending_number">Nomor Peminjaman</label>
                  <input type="text" id="lending_number" class="form-control" name="lending_number">
                </div>
                <div class="form-group">
                  <label for="division">Divisi</label>
                  <input type="text" id="division" class="form-control" name="division">
                </div>
                <div class="form-group">
                  <label for="description">keterangan</label>
                  <textarea type="text" id="description" class="form-control" name="description"></textarea>
                </div>
              </div>
              <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
              </div>
            </div>
            {{-- APlikasi --}}
            <div class="form-group row">
              <div class="col-md-4">
                <button type="button" id="add-archive" class="btn btn-success addRow mb-1">Tambah Arsip</button>
              </div>
              <table id="table-archive" class=" table col-md-12">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Aplikasi</th>
                    <th class="text-center">Versi</th>
                    <th class="text-center">Product</th>
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
@endsection
@push('after-script')
  <script>
    $(document).ready(function() {
      // Set to store selected names
      var selectApp = new Set();
      let a = 0;

      $('#add-archive').click(function() {
        // Increment index for unique IDs
        a++;

        // Append a new row
        $('#table-archive').append(`
        <tr>
          <td class="text-center text-primary">${a}</td>
          <td>
            <select name="inputs[${a}][archive_container_id]" class="form-control select2" style="width: 100%">
              <option value="" disabled selected>Choose</option>
              @foreach ($archiveContainers as $app)
                <option value="{{ $app->id }}" data-value="{{ $app->version }}" data-value2="{{ $app->product }}" data-app="{{ $app->id }}" >{{ $app->number_archive }}</option>
              @endforeach
            </select>
          </td>
          <td><input type="text" class="form-control version" id="version_${a}" readonly></td>
          <td><input type="text" class="form-control product" id="product_${a}" readonly></td>
          <td><button type="button" class="btn btn-danger remove-table-row">Remove</button></td>
        </tr>
      `);

        // Initialize Select2 for the newly added select element
        $('.select2').select2({
          dropdownParent: $("#mymodal"),
          theme: 'classic', // Apply the 'classic-dark' theme
        });
      });

      $(document).on('change', 'select[name^="inputs["]', function() {
        // Get the values from the selected option
        var selectedOption = $(this).find(':selected');
        var versionValue = selectedOption.data('value') || '';
        var productValue = selectedOption.data('value2') || '';
        var appValue = selectedOption.data('app') || '';

        // Check if the name value is unique among selected names
        if (!selectApp.has(appValue)) {
          // Update corresponding input fields based on the selected option
          var $row = $(this).closest('tr');
          $row.find('.version').val(versionValue);
          $row.find('.product').val(productValue);

          // Disable the selected option for both parent and child
          disableOptionWithName(appValue, this);

          // Add the name to the set of selected names
          selectApp.add(appValue);
        } else {
          // Reset the select or take other actions for validation error
          $(this).val('').trigger('change');
          alert('Name value must be unique. Please choose a valid option.');
        }
      });

      $(document).on('click', '.remove-table-row', function() {
        // Enable the disabled options before removing the row
        var removedName = $(this).closest('tr').find('select').data('app') || '';
        enableOptionWithName(removedName);

        // Remove the name from the set of selected names
        selectApp.delete(removedName);

        // Remove the entire row when the "Remove" button is clicked
        $(this).closest('tr').remove();
      });

      // Function to disable options with a specific name value
      function disableOptionWithName(appValue, currentSelect) {
        $('select[name^="inputs["]').not(currentSelect).each(function() {
          $(this).find(`option[data-app="${appValue}"]`).prop('disabled', true);
        });
      }

      // Function to enable options with a specific name value
      function enableOptionWithName(appValue) {
        $('select[name^="inputs["]').each(function() {
          $(this).find(`option[data-app="${appValue}"]`).prop('disabled', false);
        });
      }
    });
  </script>
@endpush
@push('after-style')
  <style>
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
