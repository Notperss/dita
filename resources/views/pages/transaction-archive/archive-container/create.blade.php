@extends('layouts.app')

@section('title', 'Archive Container')
@section('content')
  <div class="page-heading">

    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Penyimpanan Arsip</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Archive Container</li>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- // Basic multiple Column Form section start -->
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Create Data</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>Isi input <code>Required (*)</code>, Sebelum menekan tombol submit. </p>
              <form class="form" method="POST" action="{{ route('archive-container.store') }}"
                enctype="multipart/form-data" id=myForm>
                @csrf
                {{-- <input type="text" id="container-id" value="{{  }}"> --}}
                <div class="row ">
                  <div class="col-md-4 col-4">
                    <h4 class="card-title">Pilih Kontainer</h4>
                    <div class="form-group">
                      <label for="division_id">Nama Divisi <code>*</code></label>
                      <select type="text" id="division_id" class="form-control select2" style="width: 100%"
                        name="division_id" required>
                        <option value="" disabled selected>Choose</option>
                        @php
                          $latestRecord = DB::table('archive_containers')->latest()->first();
                          $dataIdContainer = $latestRecord ? $latestRecord->id + 1 : '1';
                        @endphp
                        @foreach ($divisions as $division)
                          <option value="{{ $division->id }}" data-code={{ $division->code }}
                            data-id-container="{{ $dataIdContainer }}" {{-- {{ $division->id ==optional(DB::table('archive_containers')->where('company_id', auth()->user()->company_id)->latest()->first())->division_id ??null? 'selected': '' }} --}}>
                            {{ $division->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('division_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('division_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="number_container">Nomor Kontainer <code>*</code></label>
                      <input type="hidden" name="location_container_id" id="location_container_id">
                      <select type="text" id="number_container" class="form-control select2" style="width: 100%"
                        name="number_container" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($numberContainers as $numberContainer)
                          <option value="{{ str_pad($numberContainer->number_container, 3, '0', STR_PAD_LEFT) }}"
                            data-id="{{ $numberContainer->id }}" data-value="{{ $numberContainer->mainLocation->name }}"
                            data-value2="{{ $numberContainer->subLocation->name }}"
                            data-value3="{{ $numberContainer->detailLocation->name }}"
                            data-value4="{{ $numberContainer->description }}" {{-- {{ $numberContainer->number_container == DB::table('archive_containers')->latest()->first()->number_container ? 'selected' : '' }} --}}>
                            {{-- {{ str_pad($numberContainer->number_container, 3, '0', STR_PAD_LEFT) }} --}}
                          </option>
                        @endforeach

                      </select>
                      @if ($errors->has('number_container'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_container') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="main_location">Lokasi Utama</label>
                      <input type="text" id="main_location" name="main_location" {{-- value="{{ DB::table('archive_containers')->latest()->first()->main_location ?? '' }}" --}}
                        class="form-control" readonly>
                      @if ($errors->has('main_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('main_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="sub_location">Sub Lokasi</label>
                      <input type="text" id="sub_location" name="sub_location" {{-- value="{{ DB::table('archive_containers')->latest()->first()->sub_location ?? '' }}" --}}
                        class="form-control" readonly>
                      @if ($errors->has('sub_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="detail_location">Detail Lokasi</label>
                      <input type="text" id="detail_location" name="detail_location" {{-- value="{{ DB::table('archive_containers')->latest()->first()->detail_location ?? '' }}" --}}
                        class="form-control" readonly>
                      @if ($errors->has('detail_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('detail_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description">Keterangan</label>
                      <textarea type="text" id="description_location" name="description_location" class="form-control" readonly>
                        {{-- {{ DB::table('archive_containers')->latest()->first()->description_location ?? '' }}  --}}
                      </textarea>
                      @if ($errors->has('description_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_location') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-4 col-4">
                    <h4 class="card-title">Pilih Klasifikasi</h4>
                    <div class="form-group">
                      <label for="main_classification_id">Klasifikasi Arsip <code>*</code></label>
                      <select type="text" id="main_classification_id" class="form-control select2" style="width: 100%"
                        name="main_classification_id" required>
                        <option value="" disabled selected>Choose</option>
                        {{-- @foreach ($mainClassifications as $classification)
                          <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                        @endforeach --}}
                      </select>
                      @if ($errors->has('main_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('main_classification_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="sub_classificatio_id">Sub Klasifikasi Arsip <code>*</code></label>
                      <select type="text" id="sub_classification_id" class="form-control select2"
                        style="width: 100%" name="sub_classification_id" required>
                        <option value="" disabled selected>Choose</option>

                      </select>
                      @if ($errors->has('sub_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_classification_id') }}</p>
                      @endif
                    </div>
                    {{-- <div class="form-group">
                      <label for="subseries">Sub Series Arsip <code>*</code></label>
                      <select type="text" id="subseries" class="form-control select2" style="width: 100%"
                        name="subseries" required>
                        <option value="" disabled selected>Choose</option>
                      </select>
                      @if ($errors->has('subseries'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('subseries') }}</p>
                      @endif
                    </div> --}}
                  </div>

                  <div class="col-md-4 col-4">
                    <h4 class="card-title">Masa Retensi</h4>
                    <div class="form-group">
                      <label for="period_active">Masa Aktif</label>
                      <input type="text" id="period_actives" class="form-control"readonly>
                      <input type="text" id="period_active" class="form-control" name="masa_aktif" hidden>
                      @if ($errors->has('period_active'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_active') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_active">keterangan Masa Aktif</label>
                      <textarea type="text" id="description_active" class="form-control"readonly></textarea>
                      @if ($errors->has('description_active'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_active') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="period_inactive">Masa Inaktif</label>
                      <input type="text" id="period_inactives" class="form-control"readonly>
                      <input type="text" id="period_inactive" class="form-control" name="masa_inaktif" hidden>
                      @if ($errors->has('period_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_inactive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_inactive">Keterangan Masa Inaktif</label>
                      <textarea type="text" id="description_inactive" class="form-control"readonly></textarea>
                      @if ($errors->has('description_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_inactive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_retention">Keterangan Tambahan</label>
                      <textarea type="text" id="description_retention" class="form-control"readonly></textarea>
                      @if ($errors->has('description_retention'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_retention') }}</p>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="row my-3">
                  <h4 class="card-title text-center">Input Data Arsip</h4>
                  <div class="col-md-4 col-4">
                    <div class="form-group">
                      <label for="number_catalog">Nomor Katalog/PP/DLL</label>
                      <input type="text" id="number_catalog" name="number_catalog"
                        value="{{ old('number_catalog') }}" class="form-control">
                      @if ($errors->has('number_catalog'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_catalog') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="number_document">Nomor Dokumen</label>
                      <input type="text" id="number_document" name="number_document"
                        value="{{ old('number_document') }}" class="form-control">
                      @if ($errors->has('number_document'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_document') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="number_archive">Nomor Arsip</label>
                      <input type="text" id="number_archive" name="number_archive"
                        value="{{ old('number_archive') }}" class="form-control">
                      @if ($errors->has('number_archive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_archive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="regarding">Perihal</label>
                      <textarea type="text" id="regarding" class="form-control" name="regarding" rows="7"></textarea>
                      @if ($errors->has('regarding'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('regarding') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-4 col-4">
                    <div class="form-group">
                      <label for="number_app">Nomor Aplikasi <small>(Otomatis)</small></label>
                      <input type="text" id="number_app" class="form-control" readonly>
                      @if ($errors->has('number_app'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_app') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="archive_in">Tanggal Masuk Arsip<code>*</code></label>
                      <input type="date" id="archive_in" name="archive_in"
                        class="form-control mb-3 flatpickr-no-time" placeholder="Select date..">
                      @if ($errors->has('archive_in'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('archive_in') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="year">Tahun Arsip<code>*</code></label>
                      <input type="text" class="form-control" name="year" id="year"
                        data-provide="datepicker" data-date-format="yyyy" data-date-min-view-mode="2"
                        autocomplete="off" readonly required>
                      @if ($errors->has('year'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('year') }}</p>
                      @endif
                    </div>



                    <div class="form-group">
                      <label for="tag">Tag</label>
                      <textarea maxlength="200" type="text" id="tag" class="form-control" name="tag" rows="7"></textarea>
                      @if ($errors->has('tag'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('tag') }}</p>
                      @endif
                      <p id="the-count">
                        <small style="color: red">*Maksimal 200 Character</small>
                        <small id="current">0</small>
                        <small id="maximum">/ 200</small>
                      </p>
                    </div>
                  </div>

                  <div class="col-md-4 col-4">
                    <div class="form-group">
                      <label for="document_type">Bentuk Dokumen<code>*</code></label>
                      <select type="text" id="document_type" class="form-control" style="width: 100%"
                        name="document_type" required>
                        <option value="" disabled selected>Choose</option>
                        <option value="ASLI">Asli</option>
                        <option value="COPY">Copy</option>
                      </select>
                      @if ($errors->has('document_type'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('document_type') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="archive_type">Jenis Arsip<code>*</code></label>
                      <select type="text" id="archive_type" class="form-control" style="width: 100%"
                        name="archive_type" required>
                        <option value="" disabled selected>Choose</option>
                        <option value="PROYEK">PROYEK</option>
                        <option value="NON-PROYEK">NON-PROYEK</option>
                      </select>
                      @if ($errors->has('archive_type'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('archive_type') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="amount">Jumlah & Satuan</label>
                      <input type="text" id="amount" name="amount" value="{{ old('amount') }}"
                        class="form-control">
                      @if ($errors->has('amount'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('amount') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="division_confirmation">Confirm Divisi<code>*</code></label>
                      <select type="text" id="division_id_confirmation" name="division_id_confirmation"
                        style="width: 100%" class="form-control select2">
                        <option value="" selected disabled>Choose</option>
                        @foreach ($divisions as $division)
                          <option value="{{ $division->id }}">{{ $division->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('division_id_confirmation'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('division_id_confirmation') }}
                        </p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="file">File</label>
                      <input type="file" id="name" name="file" class="basic-filepond">
                      @if ($errors->has('file'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('file') }}</p>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="col-12 d-flex justify-content-end my-3">
                  <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
                  <a href="{{ route('archive-container.index') }}" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                </div>

              </form>
            </div>
            <table class="table table-striped" id="table11">
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- // Basic multiple Column Form section end -->

  {{-- <script>
    $(document).ready(function() {
      var subLocationSelect;

      $('#division_id').change(function() {
        var divisionId = $(this).val();

        // Reset subLocationSelect dropdown
        if (subLocationSelect) {
          subLocationSelect.destroy();
        }

        if (divisionId) {
          $.ajax({
            url: "{{ route('getNumberContainer') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              division_id: divisionId
            },
            success: function(data) {
              $('#number_container').empty();
              $('#number_container').append('<option value="" selected disabled>Choose</option>');

              $.each(data, function(key, value) {
                // Using padStart to achieve similar functionality as str_pad
                let paddedNumber = value.number_container ? value.number_container.toString().padStart(
                  3, '0') : 'N/A';

                // Append the option to the dropdown
                $('#number_container').append('<option value="' + paddedNumber + '" data-value="' +
                  value.nameMainLocation + '" data-value2="' + value.nameSubLocation +
                  '" data-value3="' + value.nameDetailLocation + '" data-value4="' + value
                  .descriptionLocation + '">' +
                  paddedNumber + '</option>');
              });

              // Initialize subLocationSelect with new data
              // subLocationSelect = new Choices('#number_container', {
              //   searchEnabled: true,
              //   allowHTML: true,
              // });
            }
          });
        } else {
          // Reset and show default option
          $('#number_container').empty();
          $('#number_container').append('<option value="" selected disabled>Choose</option>');
        }
      });

      // Handle change event of number_container
      $('#number_container').on('change', function() {
        var selectedOption = $(this).find(':selected');

        console.log(selectedOption);

        var mainLocationValue = selectedOption.data('value');
        $('#main_location').val(mainLocationValue);
        var subLocationValue = selectedOption.data('value2');
        $('#sub_location').val(subLocationValue);
        var detailLocationValue = selectedOption.data('value3');
        $('#detail_location').val(detailLocationValue);
        var descriptionLocationValue = selectedOption.data('value4');
        $('#description_location').val(descriptionLocationValue);
      });
    });
  </script> --}}
  {{-- <script>
    $('#number_container').change(function() {
      var numberId = $(this).val();
      if (numberId) {
        $.ajax({
          url: "{{ route('getDataContainer') }}",
          type: 'GET',
          dataType: 'json',
          data: {
            number_container: numberId
          },
          success: function(data) {
            // Assuming you have a table with the id 'table1'
            let table = $('#table1');

            // Clear existing rows in the table
            table.empty();

            // Add table headers
            table.append(
              '<thead><tr><th>Nomor Kontainer</th><th>Nomor Arsip</th><th>Masa Retensi</th><th>Jenis Arsip</th><th>Action</th></tr></thead>'
            );

            // Create table body
            let tbody = $('<tbody></tbody>');

            $.each(data, function(key, value) {
              let paddedNumber = value.number_container ? value.number_container.toString().padStart(3,
                '0') : 'N/A';

              // Create a new row for each item in the data
              let row = $('<tr></tr>');
              row.append('<td>' + paddedNumber + '</td>');
              row.append('<td>' + value.number_archive + '</td>');
              row.append('<td>' + value.expiration_date + '</td>');
              row.append('<td>' + value.archive_type + '</td>');
              row.append('<td>' + value.archive_type + '</td>');

              // Append the row to the table body
              tbody.append(row);
            });

            // Append the table body to the table
            table.append(tbody);
          }

        });
      } else {
        // Reset and show default option
        $('#number_container').empty();
        $('#number_container').append('<option value="" selected disabled>Choose</option>');
      }
    });
  </script> --}}
  <script>
    $(document).ready(function() {
      // Assuming you have a table with the id 'table1'
      let table = $('#table11');
      // Add table headers
      table.append(
        '<thead><tr><th>Nomor Kontainer</th><th>Nomor Dokumen</th><th>Perihal</th><th>Jenis Arsip</th><th>Action</th></tr></thead>'
      );

      $('#number_container').change(function() {
        var numberId = $(this).val();
        if (numberId) {
          $.getJSON("{{ route('getDataContainer') }}", {
              number_container: numberId
            })
            .done(function(data) {
              // Create table body
              let tbody = $('<tbody></tbody>');

              $.each(data, function(key, value) {

                let paddedNumber = value.number_container ? value.number_container.toString().padStart(3,
                  '0') : 'N/A';

                // Create a new row for each item in the data
                let row = $('<tr></tr>');
                row.append('<td>' + paddedNumber + '</td>');
                row.append('<td>' + (value.number_document ? value.number_document : 'N/A') + '</td>');
                row.append('<td>' + (value.regarding ? value.regarding : 'N/A') +
                  '</td>');
                row.append('<td>' + value.archive_type + '</td>');
                // Add action buttons
                let editButton = '<a class="btn btn-sm btn-primary" href="' +
                  '{{ route('archive-container.edit', ['archive_container' => ':id']) }}'.replace(
                    ':id', value.id) + '">Edit</a>';

                let deleteButton = '<form id="deleteForm_' + value.id +
                  '" action="{{ route('archive-container.destroy', ['archive_container' => ':id']) }}'
                  .replace(
                    ':id', value.id) + '" method="POST" style="display: inline;">' +
                  '@csrf' +
                  '@method('DELETE')' +
                  '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(' + value.id +
                  ')">Delete</button>' +
                  '</form>';

                // let showButton = '<button class="btn btn-sm btn-success" onclick="showRow(' + value.id +
                //   ')">Show</button>';

                // row.append('<td>' + editButton + ' ' + deleteButton + ' ' + showButton + '</td>');
                row.append('<td>' + editButton + ' ' + deleteButton + '</td>');

                // Append the row to the table body
                tbody.append(row);
              });

              // Empty and append the new table body to the table
              table.find('tbody').remove();
              table.append(tbody);
            })
            .fail(function() {
              // Handle errors, e.g., show an alert
              alert('Failed to fetch data');
            });
        } else {
          // Reset and show default option
          table.find('tbody').remove();
          table.append('<tbody><tr><td colspan="5">No data available</td></tr></tbody>');
        }
      });
    });
  </script>

@endsection
@push('after-script')
  <script>
    $(document).ready(function() {
      // Function to update the number_app field
      function updateNumberApp() {
        // Retrieve selected values
        var codeDivision = $('#division_id option:selected').data('code') || '';
        var id = $('#division_id option:selected').data('id-container') || '';
        var numberContainer = $('#number_container').val() || '';
        var documentTypeValue = $('#document_type').val() || '';
        var documentType = (documentTypeValue === 'COPY') ? 'C' : ((documentTypeValue === 'ASLI') ? 'A' :
          documentTypeValue);
        var year = $('#year').val();

        // Concatenate the values to form the number_app
        var numberApp = codeDivision + '/' + numberContainer + '/' + documentType + '/' + year + '/' + id;

        // Set the value of the number_app field
        $('#number_app').val(numberApp);
      }

      // Call the function when any related field changes
      $('#division_id, #number_container, #document_type, #year').change(function() {
        updateNumberApp();
      });

      // Call the function initially to set the initial value
      updateNumberApp();
    });

    $(document).ready(function() {
      var tagInput = $('#tag');
      var current = $('#current');
      var maximum = $('#maximum');
      var theCount = $('#the-count');

      // Function to update character count and styling
      function updateCharacterCount() {
        var characterCount = tagInput.val().length;
        current.text(characterCount);

        if (characterCount < 150) {
          current.css('color', '#666');
        } else if (characterCount >= 150 && characterCount < 180) {
          current.css('color', '#ffA500');
        } else if (characterCount >= 180 && characterCount < 200) {
          current.css('color', '#FF0000');
        }

        if (characterCount >= 200) {
          maximum.css('color', '#8f0001');
          current.css('color', '#8f0001');
          theCount.css('font-weight', 'bold');
        } else {
          maximum.css('color', '#666');
          theCount.css('font-weight', 'normal');
        }
      }
      // Initialize the character count on page load
      updateCharacterCount();
      // Update the character count on keyup event
      tagInput.on('keyup', updateCharacterCount);
    });
  </script>

  {{-- lain-lain --}}
  <script>
    function confirmDelete(archiveContainerId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          document.getElementById('deleteForm_' + archiveContainerId).submit();
        }
      });
    }
    // fancybox
    Fancybox.bind('[data-fancybox]', {
      infinite: false
    });

    flatpickr(".flatpickr-no-time", {
      enableTime: false,
      dateFormat: "Y-m-d",
    });
  </script>

  {{-- get location --}}
  <script>
    $(document).ready(function() {
      $('.select2').select2({
        theme: 'classic', // Apply the 'classic-dark' theme
      });

      $('#division_id').change(function() {
        var divisionId = $(this).val();
        if (divisionId) {
          $.ajax({
            url: "{{ route('getNumberContainer') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              division_id: divisionId
            },
            success: function(data) {
              $('#number_container').empty();
              $('#number_container').append('<option value="" selected disabled>Choose</option>');

              $.each(data, function(key, value) {
                // Using padStart to achieve similar functionality as str_pad
                let paddedNumber = value.number_container ? value.number_container.toString().padStart(
                  3, '0') : 'N/A';

                $('#number_container').append('<option value="' + paddedNumber + '" data-value="' +
                  value.nameMainLocation + '" data-value2="' + value.nameSubLocation +
                  '" data-id="' +
                  value.id + '" data-value2="' + value.nameSubLocation +
                  '" data-value3="' + value.nameDetailLocation + '" data-value4="' + value
                  .descriptionLocation + '" ' +
                  ($('#number_container').val() == paddedNumber ? 'selected' : '') +
                  '>' +
                  paddedNumber + '</option>');
              });
            }
          });
        } else {
          // Reset and show default option
          $('#number_container').empty();
          $('#number_container').append('<option value="" selected disabled>Choose</option>');
        }
      });


      // Handle change event of number_container
      $('#number_container').on('change', function() {
        var selectedOption = $(this).find(':selected');

        console.log(selectedOption);

        var idContainerValue = selectedOption.data('id');
        $('#location_container_id').val(idContainerValue);
        var mainLocationValue = selectedOption.data('value');
        $('#main_location').val(mainLocationValue);
        var subLocationValue = selectedOption.data('value2');
        $('#sub_location').val(subLocationValue);
        var detailLocationValue = selectedOption.data('value3');
        $('#detail_location').val(detailLocationValue);
        var descriptionLocationValue = selectedOption.data('value4');
        $('#description_location').val(descriptionLocationValue);
      });
    });
  </script>

  {{-- get mainSublocation --}}
  <script>
    $(document).ready(function() {
      $('#division_id').change(function() {
        var divisionId = $(this).val();
        if (divisionId) {
          $.ajax({
            url: "{{ route('getMainClassifications') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              division_id: divisionId
            },
            success: function(data) {
              $('#main_classification_id').empty();
              $('#main_classification_id').append('<option value="" selected disabled>Choose</option>');
              $.each(data, function(key, value) {
                $('#main_classification_id').append('<option value="' + value.id + '">' + value.name +
                  '</option>');
              });
              // Manually reset the selected option in the department_id dropdown
              $('#main_classification_id').val('').trigger('change');
            }
          });
        } else {
          $('#main_classification_id').empty();
          $('#main_classification_id').append('<option value="" selected disabled>Choose</option>');
        }
      });
    });
  </script>

  {{-- get subclasifitcation --}}
  <script>
    $(document).ready(function() {
      $('#main_classification_id').change(function() {
        var mainclassificationId = $(this).val();
        if (mainclassificationId) {
          $.ajax({
            url: "{{ route('getSubClassifications') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              main_classification_id: mainclassificationId
            },
            success: function(data) {
              $('#sub_classification_id').empty();
              $('#sub_classification_id').append('<option value="" selected disabled>Choose</option>');
              // $.each(data, function(key, value) {
              //   $('#sub_classification_id').append('<option value="' + value.id + '">' + value.name +
              //     '</option>');
              // });

              $.each(data, function(key, value) {
                $('#sub_classification_id').append('<option value="' + value.id +
                  '" data-value-active="' +
                  value
                  .period_active + '" data-value-inactive="' + value.period_inactive +
                  '" data-description-active="' + value.description_active +
                  '" data-description-inactive="' + value.description_inactive +
                  '" data-description="' + value.description + '">' + value
                  .name +
                  '</option>');
              });


              // Manually reset the selected option in the department_id dropdown
              $('#sub_classification_id').val('').trigger('change');
            }
          });
        } else {
          $('#sub_classification_id').empty();
          $('#sub_classification_id').append('<option value="" selected disabled>Choose</option>');
        }
      });
      // Handle change event of number_container
      $('#sub_classification_id').on('change', function() {
        var selectedOption = $(this).find(':selected');

        var retentionActive = selectedOption.data('value-active');
        $('#period_active').val(retentionActive);

        var retentionInactive = selectedOption.data('value-inactive');
        $('#period_inactive').val(retentionInactive);

        var descriptionActive = selectedOption.data('description-active');
        $('#description_active').val(descriptionActive);

        var descriptionInactive = selectedOption.data('description-inactive');
        $('#description_inactive').val(descriptionInactive);

        var description = selectedOption.data('description');
        $('#description_retention').val(description);

        var expiredActive = selectedOption.data('value-active');
        $('#period_actives').val((expiredActive !==
          "PERMANEN") ? expiredActive + ' tahun' : "PERMANEN");

        var expiredInactive = selectedOption.data('value-inactive');
        $('#period_inactives').val((expiredInactive !==
          "PERMANEN") ? expiredInactive + ' tahun' : "PERMANEN");
      });
    });

    // $(document).ready(function() {
    //   $('#sub_classification_id').change(function() {
    //     var subclassificationId = $(this).val();
    //     if (subclassificationId) {
    //       $.ajax({
    //         url: "{{ route('getSeriesClassifications') }}",
    //         type: 'GET',
    //         dataType: 'json',
    //         data: {
    //           sub_classification_id: subclassificationId
    //         },
    //         success: function(data) {
    //           $('#subseries').empty();
    //           $('#subseries').append('<option value="" selected disabled>Choose</option>');
    //           $.each(data, function(key, value) {
    //             $('#subseries').append('<option value="' + value.sub_series + '" data-value-active="' +
    //               value
    //               .period_active + '" data-value-inactive="' + value.period_inactive +
    //               '" data-description-active="' + value.description_active +
    //               '" data-description-inactive="' + value.description_inactive +
    //               '" data-description="' + value.description + '">' + value
    //               .sub_series +
    //               '</option>');
    //           });


    //           // Manually reset the selected option in the department dropdown
    //           $('#subseries').val('').trigger('change');
    //         }
    //       });
    //     } else {
    //       $('#subseries').empty();
    //       $('#subseries').append('<option value="" selected disabled>Choose</option>');
    //     }
    //   });
    // });
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
