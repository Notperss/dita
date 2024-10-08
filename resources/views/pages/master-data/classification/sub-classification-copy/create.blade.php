@extends('layouts.app')

@section('title', 'Sub Classification')
@section('content')
  <div class="page-heading">

    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Sub Classification</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Sub Classification</li>
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
              <form class="form" method="POST" action="{{ route('sub-classification.store') }}"
                enctype="multipart/form-data" id=myForm>
                @csrf
                <div class="row ">
                  <div class="col-md-8 col-12 mx-auto">
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
                      <label for="code">Kode Sub Klasifikasi <code>*</code></label>
                      <input type="text" id="code" class="form-control" placeholder="Kode Sub Klasifikasi"
                        name="code" value="{{ old('code') }}" required>
                      @if ($errors->has('code'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('code') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="name">Nama Sub Klasifikasi <code>*</code></label>
                      <input type="text" id="name" class="form-control" placeholder="Nama Sub Klasifikasi"
                        name="name" value="{{ old('name') }}" required>
                      @if ($errors->has('name'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('name') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description">Keterangan</label>
                      <textarea type="text" id="description" class="form-control" name="description"> </textarea>
                      @if ($errors->has('description'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
                    <a href="{{ route('sub-classification.index') }}"
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

@endsection
