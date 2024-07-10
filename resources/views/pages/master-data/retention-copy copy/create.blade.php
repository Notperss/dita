@extends('layouts.app')

@section('title', 'Retention Archives')
@section('content')
  <div class="page-heading">

    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Retention Archives</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Retention Archives</li>
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
              <form class="form" method="POST" action="{{ route('retention.store') }}" enctype="multipart/form-data"
                id=myForm>
                @csrf
                <div class="row ">
                  <div class="col-md-6 col-6 mx-auto">
                    <div class="form-group">
                      <label for="main_classification_id">Nama Klasifikasi <code>*</code></label>
                      <select type="text" id="main_classification_id" class="form-control choices"
                        name="main_classification_id" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($mainClassifications as $mainClassification)
                          <option value="{{ $mainClassification->id }}">{{ $mainClassification->name }}
                            ({{ $mainClassification->code }})
                          </option>
                        @endforeach
                      </select>
                      @if ($errors->has('main_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('main_classification_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="sub_classification_id">Nama Sub Klasifikasi <code>*</code></label>
                      <select type="text" id="sub_classification_id" class="form-control" name="sub_classification_id"
                        required>
                        <option value="" disabled selected>Choose</option>
                        {{-- @foreach ($subClassifications as $subClassification)
                          <option value="{{ $subClassification->id }}">{{ $subClassification->name }}</option>
                        @endforeach --}}
                      </select>
                      @if ($errors->has('sub_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_classification_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group" hidden>
                      <label for="code">Kode Sub Series <code>*</code></label>
                      <input type="text" id="code" class="form-control" placeholder="Kode" name="code"
                        value="{{ old('code') }}" required readonly>
                      @if ($errors->has('code'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('code') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="sub_series">Nama Sub Series <code>*</code></label>
                      <input type="text" id="sub_series" class="form-control" placeholder="Nama" name="sub_series"
                        value="{{ old('sub_series') }}" required>
                      @if ($errors->has('sub_series'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_series') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="document_type">Tipe Dokumen<code>*</code></label>
                      <select id="document_type" class="form-control choices" name="document_type" required>
                        <option value="" disabled selected>Choose</option>
                        <option value="MUSNAH">Musnah</option>
                        <option value="PERMANEN">Permanen</option>
                      </select>
                      @if ($errors->has('document_type'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('document_type') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-6 col-6 mx-auto">
                    <div class="form-group">
                      <label for="period_active">Masa aktif<code>*</code></label>
                      <select type="year" id="period_active" class="form-control choices" name="period_active"
                        required>
                        <option value="" disabled selected>Choose</option>
                        <option value="1">1 Tahun</option>
                        <option value="2">2 Tahun</option>
                        <option value="3">3 Tahun</option>
                        <option value="4">4 Tahun</option>
                        <option value="5">5 Tahun</option>
                        <option value="PERMANEN">Permanen</option>
                      </select>
                      @if ($errors->has('period_active'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_active') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_active">Keterangan Aktif</label>
                      <textarea type="text" id="description_active" class="form-control" name="description_active"> </textarea>
                      @if ($errors->has('description_active'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_active') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="period_inactive">Masa Inaktif <code>*</code></label>
                      <select type="year" id="period_inactive" class="form-control choices" name="period_inactive"
                        required>
                        <option value="" disabled selected>Choose</option>
                        <option value="1">1 Tahun</option>
                        <option value="2">2 Tahun</option>
                        <option value="3">3 Tahun</option>
                        <option value="4">4 Tahun</option>
                        <option value="5">5 Tahun</option>
                        <option value="PERMANEN">Permanen</option>
                      </select>
                      @if ($errors->has('period_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_inactive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_inactive">Keterangan Inaktif</label>
                      <textarea type="text" id="description_inactive" class="form-control" name="description_inactive"> </textarea>
                      @if ($errors->has('description_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_inactive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description">Keterangan Tambahan</label>
                      <textarea type="text" id="description" class="form-control" name="description"> </textarea>
                      @if ($errors->has('description'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
                    <a href="{{ route('retention.index') }}" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- // Basic multiple Column Form section end -->
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
              $.each(data, function(key, value) {
                $('#sub_classification_id').append('<option value="' + value.id + '" data-value="' +
                  value.code + '">' + value.name +
                  ' (' + value.code + ')' +
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

        // Handle change event of number_container
        $('#sub_classification_id').on('change', function() {
          var selectedOption = $(this).find(':selected');
          var mainLocationValue = selectedOption.data('value');
          $('#code').val(mainLocationValue);
        });
      });
    });
  </script>

@endsection
