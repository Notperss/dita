@extends('layouts.app')

@section('title', 'Sub Location')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Sub Location</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Sub Location</li>
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
                action="{{ route('sub-location.update', $subLocations->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row ">
                  <div class="col-md-8 col-12 mx-auto">
                    <div class="form-group">
                      <label for="name">Nama Lokasi Utama <code>*</code></label>
                      <select name="main_location_id" id="main_location_id" class="form-control choices" required>
                        <option value="" selected disabled>Pilih Lokasi Utama</option>
                        @foreach ($mainLocations as $location)
                          <option value="{{ $location->id }}"
                            {{ $location->id == $subLocations->main_location_id ? 'selected' : '' }}>{{ $location->name }}
                          </option>
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
                      <label for="name">Nama Sub Lokasi <code>*</code></label>
                      <input type="text" id="name" class="form-control" placeholder="Nama Sub Lokasi"
                        name="name" value="{{ old('name', $subLocations->name) }}" required>
                      @if ($errors->has('name'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('name') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
                    <a href="{{ route('sub-location.index') }}" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
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

@endsection
