@extends('layouts.app')

@section('title', 'Penyimpanan Arsip')
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
              <li class="breadcrumb-item" aria-current="page">Penyimpanan Arsip</li>
              <li class="breadcrumb-item active" aria-current="page">Pindah Containter</li>
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
            <h4 class="card-title">Pindah Container</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>Isi input <code>Required (*)</code>, Sebelum menekan tombol submit. </p>
              <form class="form" method="POST" action="{{ route('movingArchive', $archiveContainers->id) }}"
                enctype="multipart/form-data" id=myForm>
                @csrf
                @method('PUT')

                <div class="row ">
                  <div class="col-md-4 col-4">
                    <h4 class="card-title">Pilih Kontainer</h4>
                    <div class="form-group">
                      <label for="division_id">Nama Divisi</label>
                      <select type="text" id="division_id" class="form-control " style="width: 100%" disabled required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($divisions as $division)
                          <option value="{{ $division->id }}" data-code={{ $division->code }}
                            data-id-container="{{ $archiveContainers->id }}"
                            {{ $division->id == $archiveContainers->division_id ? 'selected' : '' }}>
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
                      </select>
                      @if ($errors->has('number_container'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_container') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="main-location">Lokasi Utama</label>
                      <input type="text" id="main_location" name="main_location" class="form-control"
                        value="{{ old('main_location', $archiveContainers->main_location) }}" readonly>
                      @if ($errors->has('main_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('main_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="sub-location">Sub Lokasi</label>
                      <input type="text" id="sub_location" name="sub_location" class="form-control"
                        value="{{ old('sub_location', $archiveContainers->sub_location) }}" readonly>
                      @if ($errors->has('sub_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="detail_location">Detail Lokasi</label>
                      <input type="text" id="detail_location" name="detail_location" class="form-control"
                        value="{{ old('detail_location', $archiveContainers->detail_location) }}" readonly>
                      @if ($errors->has('detail_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('detail_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description">Keterangan</label>
                      <textarea type="text" id="description_location" name="description_location" class="form-control" readonly>  {{ old('description_location', $archiveContainers->description_location) }} </textarea>
                      @if ($errors->has('description_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_location') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-4 col-4">
                    <h4 class="card-title">Pilih Klasifikasi</h4>
                    <div class="form-group">
                      <label for="main_classification_id">Klasifikasi Arsip </label>
                      <select type="text" id="main_classification_id" class="form-control" style="width: 100%" disabled
                        required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($mainClassifications as $classification)
                          <option value="{{ $classification->id }}"
                            {{ $classification->id == $archiveContainers->main_classification_id ? 'selected' : '' }}>
                            {{ $classification->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('main_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('main_classification_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="sub_classificatio_id">Sub Klasifikasi Arsip</label>
                      <select type="text" id="sub_classification_id" class="form-control" style="width: 100%" disabled
                        required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($subClassifications as $subClassification)
                          <option value="{{ $subClassification->id }}"
                            {{ $subClassification->id == $archiveContainers->sub_classification_id ? 'selected' : '' }}>
                            {{ $subClassification->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('sub_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_classification_id') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-4 col-4">
                    <h4 class="card-title">Masa Aktif</h4>
                    <div class="form-group">
                      <label for="period_active">Masa Aktif</label>
                      <input type="text" id="period_actives" class="form-control"
                        value="{{ old('period_active', $archiveContainers->subClassification->period_active) }} {{ $archiveContainers->subClassification->period_active == 'PERMANEN' ? '' : 'Tahun' }}"
                        readonly>
                      <input type="text" id="period_active" class="form-control"
                        value="{{ $archiveContainers->subClassification->period_active }}" hidden>
                      @if ($errors->has('period_active'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_active') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_active">keterangan Masa Aktif</label>
                      <textarea type="text" id="description_active" class="form-control"readonly>{{ $archiveContainers->subClassification->description_active }}</textarea>
                      @if ($errors->has('description_active'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_active') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="period_inactive">Masa Inaktif</label>
                      <input type="text" id="period_inactives" class="form-control"
                        value="{{ old('period_inactive', $archiveContainers->subClassification->period_inactive) }} {{ $archiveContainers->subClassification->period_inactive == 'PERMANEN' ? '' : 'Tahun' }}"
                        readonly>
                      <input type="text" id="period_inactive" class="form-control"
                        value="{{ $archiveContainers->subClassification->period_inactive }}" hidden>
                      @if ($errors->has('period_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_inactive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_inactive">keterangan Masa Inaktif</label>
                      <textarea type="text" id="description_inactive" class="form-control" readonly>{{ $archiveContainers->subClassification->description_inactive }}</textarea>
                      @if ($errors->has('description_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_inactive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_retention">keterangan Tambahan</label>
                      <textarea type="text" id="description_retention" class="form-control" readonly>{{ $archiveContainers->subClassification->description }}</textarea>
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
                      <label for="number_catalog">Nomor Katalog</label>
                      <input type="text" id="number_catalog"
                        value="{{ old('number_catalog', $archiveContainers->number_catalog) }}" class="form-control"
                        readonly>
                      @if ($errors->has('number_catalog'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_catalog') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="number_document">Nomor Document</label>
                      <input type="text" id="number_document"
                        value="{{ old('number_document', $archiveContainers->number_document) }}" class="form-control"
                        readonly>
                      @if ($errors->has('number_document'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_document') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="number_archive">Nomor Arsip</label>
                      <input type="text" id="number_archive"
                        value="{{ old('number_archive', $archiveContainers->number_archive) }}" class="form-control"
                        readonly>
                      @if ($errors->has('number_archive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_archive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="regarding">Perihal</label>
                      <textarea type="text" id="regarding" class="form-control" rows="5" readonly>{{ $archiveContainers->regarding }}</textarea>
                      @if ($errors->has('regarding'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('regarding') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-4 col-4">
                    <div class="form-group">
                      <label for="number_app">Nomor Aplikasi<small>Otomatis</small></label>
                      <input type="text" id="number_app" name="number_app"
                        value="{{ old('number_app', $archiveContainers->number_app) }}" class="form-control" readonly>
                      @if ($errors->has('number_app'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_app') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="archive_in">Tanggal Masuk Arsip</label>
                      <input type="date" id="archive_in" class="form-control mb-3 " placeholder="Select date.."
                        value="{{ old('archive_in', $archiveContainers->archive_in) }}" readonly>
                      @if ($errors->has('archive_in'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('archive_in') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="year">Tahun Arsip</label>
                      <input type="text" class="form-control" id="year" autocomplete="off"
                        value="{{ old('year', $archiveContainers->year) }}" readonly required>
                      @if ($errors->has('year'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('year') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label for="tag">Tag</label>
                      <textarea maxlength="200" type="text" id="tag" class="form-control" rows="5" readonly>{{ $archiveContainers->tag }}</textarea>
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
                      <label for="document_type">Bentuk Dokumen</label>
                      <select type="text" id="document_type" class="form-control" style="width: 100%" disabled
                        required>
                        <option value="" disabled selected>Choose</option>
                        <option value="ASLI" {{ $archiveContainers->document_type = 'ASLI' ? 'selected' : '' }}>Asli
                        </option>
                        <option value="COPY"{{ $archiveContainers->document_type = 'COPY' ? 'selected' : '' }}>Copy
                        </option>
                      </select>
                      @if ($errors->has('document_type'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('document_type') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="archive_type">Jenis Arsip</label>
                      <select type="text" id="archive_type" class="form-control" style="width: 100%" disabled
                        required>
                        <option value="" disabled selected>Choose</option>
                        <option value="PERUSAHAAN"
                          {{ $archiveContainers->archive_type = 'PERUSAHAAN' ? 'selected' : '' }}>PERUSAHAAN</option>
                        <option value="PROYEK" {{ $archiveContainers->archive_type = 'PROYEK' ? 'selected' : '' }}>
                          PROYEK</option>
                      </select>
                      @if ($errors->has('archive_type'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('archive_type') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="amount">Jumlah & Satuan</label>
                      <input type="text" id="amount" value="{{ old('amount', $archiveContainers->amount) }}"
                        class="form-control" readonly>
                      @if ($errors->has('amount'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('amount') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="division_confirmation">Confirm Divisi</label>
                      <select type="text" id="division_id_confirmation" style="width: 100%" class="form-control"
                        disabled>
                        <option value="" selected disabled>Choose</option>
                        @foreach ($divisions as $division)
                          <option value="{{ $division->id }}"
                            {{ $division->id == $archiveContainers->division_id ? 'selected' : '' }}>
                            {{ $division->name }}</option>
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
                      {{-- <input type="file" id="name" class="basic-filepond" readonly> --}}
                      @if ($archiveContainers->file)
                        <p>Latest File
                          : {{ $fileName }}
                        </p>
                        <a type="button" data-fancybox data-src="{{ asset('storage/' . $archiveContainers->file) }}"
                          class="btn btn-info btn-sm text-white mt-0">
                          Lihat File
                        </a>
                      @else
                        <p>Latest File
                          : N/A
                        </p>
                      @endif
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
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- // Basic multiple Column Form section end -->
@endsection
@push('after-script')
  <script>
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
  </script>

  <script>
    // fancybox
    Fancybox.bind('[data-fancybox]', {
      infinite: false
    });

    flatpickr(".flatpickr-no-time", {
      enableTime: false,
      dateFormat: "Y-m-d",
    });
  </script>

  <script>
    $(document).ready(function() {
      // Store the selected number_container ID in a JavaScript variable
      var selectedNumberContainerId = "{{ $archiveContainers->number_container }}";

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

                // Check if the option should be selected
                var selected = (paddedNumber == selectedNumberContainerId) ? ' selected' : '';

                // Append the option to the dropdown
                $('#number_container').append('<option value="' + paddedNumber + '"' + selected +
                  ' data-value="' + value.nameMainLocation +
                  '" data-id="' + value.id +
                  '" data-value2="' + value.nameSubLocation +
                  '" data-value3="' + value.nameDetailLocation +
                  '" data-value4="' + value.descriptionLocation + '">' +
                  paddedNumber + '</option>');
              });

              // Trigger change event to update other fields based on the selected number_container
              $('#number_container').trigger('change');
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

      // Trigger the change event on page load to populate number_container if division is already selected
      $('#division_id').trigger('change');
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
