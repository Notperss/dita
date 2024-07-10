@extends('layouts.app')

@section('title', 'Company')
@section('content')
  <div class="page-heading">

    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Company</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Company</li>
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
              <form class="form" method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data"
                id=myForm>
                @csrf
                <div class="row ">
                  <div class="col-md-8 col-12 mx-auto">
                    <div class="form-group">
                      <label for="name">Nama Perusahaan <code>*</code></label>
                      <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}"
                        required>
                      @if ($errors->has('name'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('name') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="address">Alamat Perusahaan <code>*</code></label>
                      <input type="text" id="address" class="form-control" name="address"
                        value="{{ old('address') }}" required>
                      @if ($errors->has('address'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('address') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description">Nomor Telp / Email <code>*</code></label>
                      <input type="text" id="description" class="form-control" name="description"
                        value="{{ old('description') }}" required>
                      @if ($errors->has('description'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="logo">Logo<code>*</code></label>
                      <input type="file" id="logo" class="form-control" name="logo" required>
                      @if ($errors->has('logo'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('logo') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
                    <a href="{{ route('company.index') }}" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
{{-- @push('after-script')
  <script src="assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
@endpush --}}
