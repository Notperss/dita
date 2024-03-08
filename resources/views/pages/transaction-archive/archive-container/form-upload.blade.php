<div class="modal fade" id="modalupload" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Container</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
      <form class="form" method="POST" action="{{ route('backsite.archive-container.store') }}"
        enctype="multipart/form-data" id=myForm>
        @csrf
        <div class="modal-body">
          <div class="row ">
            <div class="col-md-4 col-4">
              <div class="form-group">
                <label for="division_id">Nama Divisi <code>*</code></label>
                <select type="text" id="division_id" class="form-control select2" style="width: 100%"
                  name="division_id" required>
                  <option value="" disabled selected>Choose</option>
                  @foreach ($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('division_id'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('division_id') }}</p>
                @endif
              </div>
              <div class="form-group">
                <label for="number_container">Nomor Kontainer <code>*</code></label>
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
                <label for="main-location">Lokasi Utama<code>*</code></label>
                <input type="text" id="main_location" name="main_location" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="sub-location">Sub Lokasi<code>*</code></label>
                <input type="text" id="sub_location" name="sub_location" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="detail-location">Detail Lokasi<code>*</code></label>
                <input type="text" id="detail_location" name="detail_location" class="form-control" readonly>
              </div>

              <div class="form-group">
                <label for="description">Keterangan</label>
                <textarea type="text" id="description_location" name="description_location" class="form-control" readonly> </textarea>
                @if ($errors->has('description'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('description') }}</p>
                @endif
              </div>
            </div>
            <div class="col-md-4 col-4">
              <div class="form-group">
                <label for="number_archive">Nomor Arsip<code>*</code></label>
                <input type="text" id="number_archive" name="number_archive" value="{{ old('number_archive') }}"
                  class="form-control">
                @if ($errors->has('number_archive'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('number_archive') }}</p>
                @endif
              </div>
              <div class="form-group">
                <label for="main_classification_id">Klasifikasi Arsip <code>*</code></label>
                <select type="text" id="main_classification_id" class="form-control select2" style="width: 100%"
                  name="main_classification_id" required>
                  <option value="" disabled selected>Choose</option>
                  @foreach ($mainClassifications as $classification)
                    <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('main_classification_id'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('main_classification_id') }}</p>
                @endif
              </div>
              <div class="form-group">
                <label for="sub_classificatio_id">Sub Klasifikasi Arsip <code>*</code></label>
                <select type="text" id="sub_classification_id" class="form-control select2" style="width: 100%"
                  name="sub_classification_id" required>
                  <option value="" disabled selected>Choose</option>

                </select>
                @if ($errors->has('sub_classification_id'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('sub_classification_id') }}</p>
                @endif
              </div>
              <div class="form-group">
                <label for="subseries">Sub Series Arsip <code>*</code></label>
                <select type="text" id="subseries" class="form-control select2" style="width: 100%" name="subseries"
                  required>
                  <option value="" disabled selected>Choose</option>
                </select>
                @if ($errors->has('subseries'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('subseries') }}</p>
                @endif
              </div>
              <div class="form-group">
                <label for="retention">Masa Retensi<code>*</code></label>
                <input type="text" id="retention" class="form-control" name="retention" required>
                @if ($errors->has('retention'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('retention') }}</p>
                @endif
              </div>
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
                  <option value="PERUSAHAAN">PERUSAHAAN</option>
                  <option value="PROYEK">PROYEK</option>
                </select>
                @if ($errors->has('archive_type'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('archive_type') }}</p>
                @endif
              </div>
            </div>
            <div class="col-md-4 col-4">
              <div class="form-group">
                <label for="amount">Jumlah & Satuan<code>*</code></label>
                <input type="text" id="amount" name="amount" value="{{ old('amount') }}"
                  class="form-control">
                @if ($errors->has('amount'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('amount') }}</p>
                @endif
              </div>
              <div class="form-group">
                <label for="division_confirmation">Confirm Unit Kerja<code>*</code></label>
                <select type="text" id="division_confirmation" name="division_confirmation" style="width: 100%"
                  class="form-control select2">
                  <option value="" selected disabled>Choose</option>
                  @foreach ($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('division_confirmation'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('division_confirmation') }}
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="archive_in">Tanggal Masuk Arsip<code>*</code></label>
                <input type="date" id="archive_in" name="archive_in" class="form-control mb-3"
                  placeholder="Select date..">
                @if ($errors->has('archive_in'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('archive_in') }}</p>
                @endif
              </div>
              <div class="form-group">
                <label for="year">Tahun Arsip<code>*</code></label>
                <input type="text" class="form-control" name="year" id="year" data-provide="datepicker"
                  data-date-format="yyyy" data-date-min-view-mode="2" autocomplete="off" readonly required>
                @if ($errors->has('year'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('year') }}</p>
                @endif
              </div>
              <div class="form-group">
                <label for="file">File<code>*</code></label>
                <input type="file" id="name" name="file" class="basic-filepond">
                @if ($errors->has('file'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('file') }}</p>
                @endif
              </div>
            </div>

            <div class="col-12 d-flex justify-content-end">
              <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
              <a href="{{ route('backsite.archive-container.index') }}"
                class="btn btn-light-secondary me-1 mb-1">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/date-picker.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}">
<script src="{{ asset('assets/extensions/filepond/filepond.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/filepond.js') }}"></script>

<link rel="stylesheet" type="text/css"
  href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>



{{-- location --}}
<script>
  $(document).ready(function() {
    $('.select2').select2({
      dropdownParent: $('#modalupload'),
      theme: 'classic', // Apply the 'classic-dark' theme
    });

    $('#division_id').change(function() {
      var divisionId = $(this).val();
      if (divisionId) {
        $.ajax({
          url: "{{ route('backsite.getNumberContainer') }}",
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
</script>
{{-- clasifitcation --}}
<script>
  $(document).ready(function() {
    $('#main_classification_id').change(function() {
      var mainclassificationId = $(this).val();
      if (mainclassificationId) {
        $.ajax({
          url: "{{ route('backsite.getSubClassifications') }}",
          type: 'GET',
          dataType: 'json',
          data: {
            main_classification_id: mainclassificationId
          },
          success: function(data) {
            $('#sub_classification_id').empty();
            $('#sub_classification_id').append('<option value="" selected disabled>Choose</option>');
            $.each(data, function(key, value) {
              $('#sub_classification_id').append('<option value="' + value.id + '">' + value.name +
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
  });

  $(document).ready(function() {
    $('#sub_classification_id').change(function() {
      var subclassificationId = $(this).val();
      if (subclassificationId) {
        $.ajax({
          url: "{{ route('backsite.getSeriesClassifications') }}",
          type: 'GET',
          dataType: 'json',
          data: {
            sub_classification_id: subclassificationId
          },
          success: function(data) {
            $('#subseries').empty();
            $('#subseries').append('<option value="" selected disabled>Choose</option>');
            $.each(data, function(key, value) {
              $('#subseries').append('<option value="' + value.sub_series + '" data-value="' + value
                .retention_period + '">' + value
                .sub_series +
                '</option>');
            });


            // Manually reset the selected option in the department dropdown
            $('#subseries').val('').trigger('change');
          }
        });
      } else {
        $('#subseries').empty();
        $('#subseries').append('<option value="" selected disabled>Choose</option>');
      }
    });
    // Handle change event of number_container
    $('#subseries').on('change', function() {
      var selectedOption = $(this).find(':selected');

      console.log(selectedOption);

      var mainLocationValue = selectedOption.data('value');
      $('#retention').val(mainLocationValue);
    });
  });
</script>

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
