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
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item" aria-current="page">Retention Archives</li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
            <h4 class="card-title">Edit Data</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>Isi input <code>Required (*)</code>, Sebelum menekan tombol submit. </p>
              <form class="form" method="POST"
                action="{{ route('backsite.archive-container.update', $archiveContainers->id) }}"
                enctype="multipart/form-data" id=myForm>
                @csrf
                @method('PUT')

                <div class="row ">

                  {{-- <div class="col-md-6 col-6">
                    <div class="form-group">
                      <label for="number_archive">Nomor Arsip<code>*</code></label>
                      <input type="text" id="number_archive" name="number_archive"
                        value="{{ old('number_archive', $archiveContainers->number_archive) }}" class="form-control">
                      @if ($errors->has('number_archive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_archive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="archive_in">Tanggal Masuk Arsip<code>*</code></label>
                      <input type="date" id="archive_in" name="archive_in" class="form-control mb-3 flatpickr-no-time"
                        placeholder="Select date.." value="{{ old('archive_in', $archiveContainers->archive_in) }}">
                      @if ($errors->has('archive_in'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('archive_in') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="year">Tahun Arsip<code>*</code></label>
                      <input type="text" class="form-control" name="year" id="year" data-provide="datepicker"
                        data-date-format="yyyy" data-date-min-view-mode="2" autocomplete="off"
                        value="{{ old('year', $archiveContainers->year) }}" readonly required>
                      @if ($errors->has('year'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('year') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="division_id">Nama Divisi <code>*</code></label>
                      <select type="text" id="division_id" class="form-control select2" style="width: 100%"
                        name="division_id" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($divisions as $division)
                          <option value="{{ $division->id }}"
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
                      <select type="text" id="number_container" class="form-control select2" style="width: 100%"
                        name="number_container" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($locationContainers as $locationContainer)
                          <option value="{{ $locationContainer->number_container }}"
                            {{ $locationContainer->number_container == $archiveContainers->number_container ? 'selected' : '' }}>
                            {{ $locationContainer->number_container }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('number_container'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_container') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="main-location">Lokasi Utama<code>*</code></label>
                      <input type="text" id="main_location" name="main_location" class="form-control"
                        value="{{ old('main_location', $archiveContainers->main_location) }}" readonly>
                      @if ($errors->has('main_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('main_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="sub-location">Sub Lokasi<code>*</code></label>
                      <input type="text" id="sub_location" name="sub_location" class="form-control"
                        value="{{ old('sub_location', $archiveContainers->sub_location) }}" readonly>
                      @if ($errors->has('sub_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="detail_location">Detail Lokasi<code>*</code></label>
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

                  <div class="col-md-6 col-6">
                    <div class="form-group">
                      <label for="main_classification_id">Klasifikasi Arsip <code>*</code></label>
                      <select type="text" id="main_classification_id" class="form-control select2"
                        style="width: 100%" name="main_classification_id" required>
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
                      <label for="sub_classificatio_id">Sub Klasifikasi Arsip <code>*</code></label>
                      <select type="text" id="sub_classification_id" class="form-control select2"
                        style="width: 100%" name="sub_classification_id" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($subClassifications as $classification)
                          <option value="{{ $classification->id }}"
                            {{ $classification->id == $archiveContainers->sub_classification_id ? 'selected' : '' }}>
                            {{ $classification->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('sub_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_classification_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="subseries">Sub Series Arsip <code>*</code></label>
                      <select type="text" id="subseries" class="form-control select2" style="width: 100%"
                        name="subseries" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($retentions as $retention)
                          <option value="{{ $retention->sub_series }}"
                            {{ $retention->sub_series == $archiveContainers->subseries ? 'selected' : '' }}>
                            {{ $retention->sub_series }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('subseries'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('subseries') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="retention">Masa Retensi<code>*</code></label>
                      <input type="text" id="retentions" class="form-control" name="retention"
                        value="{{ old('retention', $archiveContainers->retention) }}" required readonly>
                      <input type="text" id="retention" class="form-control" name="expiration_date"
                        value="{{ old('expiration_date', $archiveContainers->expiration_date) }}" hidden>
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
                      <label for="archive_type">Jenis Arsip<code>*</code></label>
                      <select type="text" id="archive_type" class="form-control" style="width: 100%"
                        name="archive_type" required>
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
                      <label for="amount">Jumlah & Satuan<code>*</code></label>
                      <input type="text" id="amount" name="amount"
                        value="{{ old('amount', $archiveContainers->amount) }}" class="form-control">
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
                      <label for="file">File<code>*</code></label>
                      <input type="file" id="name" name="file" class="basic-filepond">
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
                  </div> --}}

                  <div class="col-md-4 col-4">
                    <h4 class="card-title">Pilih Kontainer</h4>
                    <div class="form-group">
                      <label for="division_id">Nama Divisi <code>*</code></label>
                      <select type="text" id="division_id" class="form-control select2" style="width: 100%"
                        name="division_id" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($divisions as $division)
                          <option value="{{ $division->id }}"
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
                      <select type="text" id="number_container" class="form-control select2" style="width: 100%"
                        name="number_container" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($locationContainers as $locationContainer)
                          <option value="{{ $locationContainer->number_container }}"
                            {{ $locationContainer->number_container == $archiveContainers->number_container ? 'selected' : '' }}>
                            {{ $locationContainer->number_container }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('number_container'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_container') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="main-location">Lokasi Utama<code>*</code></label>
                      <input type="text" id="main_location" name="main_location" class="form-control"
                        value="{{ old('main_location', $archiveContainers->main_location) }}" readonly>
                      @if ($errors->has('main_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('main_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="sub-location">Sub Lokasi<code>*</code></label>
                      <input type="text" id="sub_location" name="sub_location" class="form-control"
                        value="{{ old('sub_location', $archiveContainers->sub_location) }}" readonly>
                      @if ($errors->has('sub_location'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_location') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="detail_location">Detail Lokasi<code>*</code></label>
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
                      <label for="main_classification_id">Klasifikasi Arsip <code>*</code></label>
                      <select type="text" id="main_classification_id" class="form-control select2" style="width: 100%"
                        name="main_classification_id" required>
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
                      <label for="sub_classificatio_id">Sub Klasifikasi Arsip <code>*</code></label>
                      <select type="text" id="sub_classification_id" class="form-control select2" style="width: 100%"
                        name="sub_classification_id" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($subClassifications as $classification)
                          <option value="{{ $classification->id }}"
                            {{ $classification->id == $archiveContainers->sub_classification_id ? 'selected' : '' }}>
                            {{ $classification->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('sub_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_classification_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="subseries">Sub Series Arsip <code>*</code></label>
                      <select type="text" id="subseries" class="form-control select2" style="width: 100%"
                        name="subseries" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($retentions as $retention)
                          <option value="{{ $retention->sub_series }}"
                            {{ $retention->sub_series == $archiveContainers->subseries ? 'selected' : '' }}>
                            {{ $retention->sub_series }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('subseries'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('subseries') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="retention">Masa Retensi<code>*</code></label>
                      <input type="text" id="retentions" class="form-control" name="retention"
                        value="{{ old('retention', $archiveContainers->retention) }}" required readonly>
                      <input type="text" id="retention" class="form-control" name="expiration_date"
                        value="{{ old('expiration_date', $archiveContainers->expiration_date) }}" hidden>
                      @if ($errors->has('retention'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('retention') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-4 col-4">
                    <h4 class="card-title">Input Data Arsip</h4>
                    <div class="form-group">
                      <label for="number_archive">Nomor Arsip<code>*</code></label>
                      <input type="text" id="number_archive" name="number_archive"
                        value="{{ old('number_archive', $archiveContainers->number_archive) }}" class="form-control">
                      @if ($errors->has('number_archive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('number_archive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="archive_in">Tanggal Masuk Arsip<code>*</code></label>
                      <input type="date" id="archive_in" name="archive_in"
                        class="form-control mb-3 flatpickr-no-time" placeholder="Select date.."
                        value="{{ old('archive_in', $archiveContainers->archive_in) }}">
                      @if ($errors->has('archive_in'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('archive_in') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="year">Tahun Arsip<code>*</code></label>
                      <input type="text" class="form-control" name="year" id="year"
                        data-provide="datepicker" data-date-format="yyyy" data-date-min-view-mode="2"
                        autocomplete="off" value="{{ old('year', $archiveContainers->year) }}" readonly required>
                      @if ($errors->has('year'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('year') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="document_type">Bentuk Dokumen<code>*</code></label>
                      <select type="text" id="document_type" class="form-control" style="width: 100%"
                        name="document_type" required>
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
                      <label for="archive_type">Jenis Arsip<code>*</code></label>
                      <select type="text" id="archive_type" class="form-control" style="width: 100%"
                        name="archive_type" required>
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
                      <label for="amount">Jumlah & Satuan<code>*</code></label>
                      <input type="text" id="amount" name="amount"
                        value="{{ old('amount', $archiveContainers->amount) }}" class="form-control">
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
                      <label for="file">File<code>*</code></label>
                      <input type="file" id="name" name="file" class="basic-filepond">
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

                  <div class="col-12 d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
                    <a href="{{ route('backsite.archive-container.index') }}"
                      class="btn btn-light-secondary me-1 mb-1">Cancel</a>
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
      // Assuming you have a table with the id 'table1'
      let table = $('#table11');
      // Add table headers
      table.append(
        '<thead><tr><th>Nomor Kontainer</th><th>Nomor Arsip</th><th>Masa Retensi</th><th>Jenis Arsip</th><th>Action</th></tr></thead>'
      );

      $('#number_container').change(function() {
        var numberId = $(this).val();
        if (numberId) {
          $.getJSON("{{ route('backsite.getDataContainer') }}", {
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
                row.append('<td>' + value.number_archive + '</td>');
                row.append('<td>' + (value.expiration_date ? value.expiration_date : 'Permanen') +
                  '</td>');
                row.append('<td>' + value.archive_type + '</td>');
                // Add action buttons
                let editButton = '<button class="btn btn-sm btn-primary" onclick="editRow(' + value.id +
                  ')">Edit</button>';
                let deleteButton = '<button class="btn btn-sm btn-danger" onclick="deleteRow(' + value.id +
                  ')">Delete</button>';
                let showButton = '<button class="btn btn-sm btn-success" onclick="showRow(' + value.id +
                  ')">Show</button>';

                row.append('<td>' + editButton + ' ' + deleteButton + ' ' + showButton + '</td>');

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
    // fancybox
    Fancybox.bind('[data-fancybox]', {
      infinite: false
    });

    flatpickr(".flatpickr-no-time", {
      enableTime: false,
      dateFormat: "Y-m-d",
    });
  </script>
  {{-- location --}}
  <script>
    $(document).ready(function() {
      $('.select2').select2({
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

        var retentionPeriod = selectedOption.data('value');
        var currentDate = new Date();
        var expirationDate;

        if (retentionPeriod !== "PERMANEN") {
          // Calculate the expiration date by adding the selected retention period to the current date
          expirationDate = new Date(currentDate.getFullYear() + retentionPeriod, currentDate.getMonth(),
            currentDate.getDate());
        } else {
          // If retention period is "PERMANEN", set the expiration date string
          expirationDate = 'PERMANEN';
        }

        // Set the formatted date or "PERMANEN" as the value of the "retention" input field
        var formattedDate = (retentionPeriod !== "PERMANEN") ? expirationDate.toISOString().split('T')[0] :
          "PERMANEN";
        $('#retention').val(formattedDate);


        var mainLocationValue = selectedOption.data('value');
        var retentionsValue;
        if (mainLocationValue !== "PERMANEN") {
          retentionsValue = mainLocationValue + ' tahun';
        } else {
          retentionsValue = mainLocationValue; // Do not add "tahun" for "PERMANENT"
        }
        $('#retentions').val(retentionsValue);
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
