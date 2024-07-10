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
                  <div class="col-md-6 col-12 mx-auto">
                    <div class="form-group">
                      <label for="main_classification_id">Nama Klasifikasi <code>*</code></label>
                      <select type="text" id="main_classification_id" class="form-control choices"
                        name="main_classification_id" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($mainClassifications as $mainClassification)
                          <option value="{{ $mainClassification->id }}">
                            ({{ $mainClassification->division->code }})
                            -{{ $mainClassification->name }}
                          </option>
                        @endforeach
                      </select>
                      @if ($errors->has('main_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('main_classification_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="code">Kode Sub Klasifikasi</label>
                      <input type="text" id="code" class="form-control" placeholder="Kode Sub Klasifikasi"
                        name="code" value="{{ old('code') }}">
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
                  <div class="col-md-6 col-12 mx-auto">
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
                        <option value="8">8 Tahun</option>
                        <option value="10">10 Tahun</option>
                        <option value="PERMANEN">Permanen</option>
                      </select>
                      @if ($errors->has('period_active'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_active') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_active">Keterangan Aktif</label>
                      <textarea type="text" id="description_active" class="form-control" name="description_active" rows="1"> </textarea>
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
                        <option value="8">8 Tahun</option>
                        <option value="10">10 Tahun</option>
                        <option value="PERMANEN">Permanen</option>
                      </select>
                      @if ($errors->has('period_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_inactive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_inactive">Keterangan Inaktif</label>
                      <textarea type="text" id="description_inactive" class="form-control" name="description_inactive" rows="1"> </textarea>
                      @if ($errors->has('description_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_inactive') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-12 col-12 mx-auto">
                    <div class="form-group">
                      <label for="description">Keterangan Tambahan</label>
                      <textarea type="text" id="description" class="form-control" name="description" rows="4"></textarea>
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
