@extends('layouts.app')

@section('title', 'Detail Location')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Detail Location</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item" aria-current="page">Detail Location</li>
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
              <form id="myForm" class="form" method="POST"
                action="{{ route('backsite.detail-location.update', $detailLocations->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row ">
                  <div class="col-md-8 col-12 mx-auto">
                    <div class="form-group">
                      <label for="main_location_id">Nama Lokasi Utama <code>*</code></label>
                      <select name="main_location_id" id="main_location_id" class="form-control choices" required>
                        <option value="" selected disabled>Pilih Lokasi Utama</option>
                        @foreach ($mainLocations as $location)
                          <option value="{{ $location->id }}"
                            {{ $location->id == $detailLocations->main_location_id ? 'selected' : '' }}>
                            {{ $location->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('main_location_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('main_location_id') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-8 col-12 mx-auto">
                    <div class="form-group">
                      <label for="sub_location_id">Nama Sub Lokasi <code>*</code></label>
                      <select name="sub_location_id" id="sub_location_id" class="form-control" required>
                        @foreach ($subLocations as $subLocation)
                          <option
                            value="{{ $subLocation->id }}"{{ $subLocation->id == $detailLocations->sub_location_id ? 'selected' : '' }}
                            selected>{{ $subLocation->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('sub_location_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_location_id') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-8 col-12 mx-auto">
                    <div class="form-group">
                      <label for="name">Nama Detail Lokasi <code>*</code></label>
                      <input type="text" id="name" class="form-control" placeholder="Nama Detail Lokasi"
                        name="name" value="{{ old('name', $detailLocations->name) }}" required>
                      @if ($errors->has('name'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('name') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-8 col-12 mx-auto">
                    <div class="form-group">
                      <label for="description">Keterangan</label>
                      <textarea id="description" class="form-control" name="description" rows="3">{{ $detailLocations->description }} </textarea>
                      @if ($errors->has('description'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
                    <a href="{{ route('backsite.detail-location.index') }}"
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
      $('#main_location_id').change(function() {
        var mainLocationId = $(this).val();
        if (mainLocationId) {
          $.ajax({
            url: "{{ route('backsite.getSubLocations') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              main_location_id: mainLocationId
            },
            success: function(data) {
              $('#sub_location_id').empty();
              $('#sub_location_id').append('<option value="" selected disabled>Choose</option>');
              $.each(data, function(key, value) {
                $('#sub_location_id').append('<option value="' + value.id + '">' + value.name +
                  '</option>');
              });

              // Initialize Choices for the sub_location_id dropdown
              var subLocationSelect = new Choices('#sub_location_id', {
                searchEnabled: true, // Customize as needed
                // Add more configuration options based on Choices documentation
              });
            }
          });
        } else {
          $('#sub_location_id').empty();
          $('#sub_location_id').append('<option value="" selected disabled>Choose</option>');
        }
      });
    });
  </script>

@endsection
