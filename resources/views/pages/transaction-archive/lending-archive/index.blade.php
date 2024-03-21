@extends('layouts.app')

@section('title', 'Lending Archive')
@section('content')
  <div class="page-heading">

    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Lending Archive</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item" aria-current="page">Lending Archive</li>
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

              asdasdasdasd
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

  <script>
    $(document).ready(function() {
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

@endsection
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
