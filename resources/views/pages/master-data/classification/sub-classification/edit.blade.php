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
                action="{{ route('sub-classification.update', $subClassifications->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row ">
                  <div class="col-md-6 col-12 mx-auto">
                    <div class="form-group">
                      <label for="main_classification_id">Nama Klasifikasi <code>*</code></label>
                      <select type="text" id="main_classification_id" class="form-control choices"
                        name="main_classification_id" required>
                        <option value="" disabled selected>Choose</option>
                        @foreach ($mainClassifications as $mainClassification)
                          <option value="{{ $mainClassification->id }}"
                            {{ $subClassifications->main_classification_id == $mainClassification->id ? 'selected' : '' }}>
                            ({{ $mainClassification->division->code }})
                            - {{ $mainClassification->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('sub_classification_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('sub_classification_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="code">Kode Sub Klasifikasi</label>
                      <input type="text" id="code" class="form-control" placeholder="Kode Sub Klasifikasi"
                        name="code" value="{{ old('code', $subClassifications->code) }}">
                      @if ($errors->has('code'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('code') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="name">Nama Sub Klasifikasi <code>*</code></label>
                      <input type="text" id="name" class="form-control" placeholder="Nama Sub Klasifikasi"
                        name="name" value="{{ old('name', $subClassifications->name) }}" required>
                      @if ($errors->has('name'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('name') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="document_type">Tipe Dokumen<code>*</code></label>
                      <select id="document_type" class="form-control choices" name="document_type" required>
                        <option value="" disabled selected>Choose</option>
                        <option value="MUSNAH" {{ $subClassifications->document_type == 'MUSNAH' ? 'selected' : '' }}>
                          Musnah
                        </option>
                        <option value="PERMANEN"{{ $subClassifications->document_type == 'PERMANEN' ? 'selected' : '' }}>
                          Permanen
                        </option>
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
                        <option value="1" {{ $subClassifications->period_active == 1 ? 'selected' : '' }}>1 Tahun
                        </option>
                        <option value="2" {{ $subClassifications->period_active == 2 ? 'selected' : '' }}>2 Tahun
                        </option>
                        <option value="3" {{ $subClassifications->period_active == 3 ? 'selected' : '' }}>3 Tahun
                        </option>
                        <option value="4" {{ $subClassifications->period_active == 4 ? 'selected' : '' }}>4 Tahun
                        </option>
                        <option value="5" {{ $subClassifications->period_active == 5 ? 'selected' : '' }}>5 Tahun
                        </option>
                        <option value="8" {{ $subClassifications->period_active == 8 ? 'selected' : '' }}>8 Tahun
                        </option>
                        <option value="10" {{ $subClassifications->period_active == 10 ? 'selected' : '' }}>10 Tahun
                        </option>
                        <option value="PERMANEN"
                          {{ $subClassifications->period_active == 'PERMANEN' ? 'selected' : '' }}>Permanen</option>
                      </select>
                      @if ($errors->has('period_active'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_active') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_active">Keterangan Aktif</label>
                      <textarea type="text" id="description_active" class="form-control" rows="1" name="description_active"> {{ $subClassifications->description_active }} </textarea>
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
                        <option value="1" {{ $subClassifications->period_inactive == 1 ? 'selected' : '' }}>1 Tahun
                        </option>
                        <option value="2" {{ $subClassifications->period_inactive == 2 ? 'selected' : '' }}>2 Tahun
                        </option>
                        <option value="3" {{ $subClassifications->period_inactive == 3 ? 'selected' : '' }}>3 Tahun
                        </option>
                        <option value="4" {{ $subClassifications->period_inactive == 4 ? 'selected' : '' }}>4 Tahun
                        </option>
                        <option value="5" {{ $subClassifications->period_inactive == 5 ? 'selected' : '' }}>5 Tahun
                        </option>
                        <option value="8" {{ $subClassifications->period_inactive == 8 ? 'selected' : '' }}>8 Tahun
                        </option>
                        <option value="10" {{ $subClassifications->period_inactive == 10 ? 'selected' : '' }}>10
                          Tahun
                        </option>
                        <option value="PERMANEN"
                          {{ $subClassifications->period_inactive == 'PERMANEN' ? 'selected' : '' }}>Permanen</option>
                      </select>
                      @if ($errors->has('period_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('period_inactive') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="description_inactive">Keterangan Inaktif</label>
                      <textarea type="text" id="description_inactive" class="form-control" rows="1" name="description_inactive">{{ $subClassifications->description_inactive }} </textarea>
                      @if ($errors->has('description_inactive'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('description_inactive') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-12 col-12 mx-auto">
                    <div class="form-group">
                      <label for="description">Keterangan</label>
                      <textarea type="text" id="description" class="form-control" name="description"> {{ $subClassifications->description }} </textarea>
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
