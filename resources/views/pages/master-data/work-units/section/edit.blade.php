@extends('layouts.app')

@section('title', 'Section')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Section</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item" aria-current="page">Section</li>
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
                action="{{ route('backsite.section.update', $sections->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row ">
                  <div class="col-md-8 col-12 mx-auto">
                    <div class="form-group">
                      <label for="division_id">Nama Divisi <code>*</code></label>
                      <select type="text" id="division_id" class="form-control choices" name="division_id" required>
                        <option value="" disabled selected>Pilih Divisi</option>
                        @foreach ($divisions as $division)
                          <option
                            value="{{ $division->id }}"{{ $division->id == $sections->division_id ? 'selected' : '' }}>
                            {{ $division->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('division_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('division_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="department_id">Nama Departemen <code>*</code></label>
                      <select type="text" id="department_id" class="form-control" name="department_id" required>
                        <option value="" disabled selected>Pilih Departemen</option>
                        @foreach ($departments as $department)
                          <option
                            value="{{ $department->id }}"{{ $department->id == $sections->department_id ? 'selected' : '' }}>
                            {{ $department->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('department_id'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('department_id') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="name">Nama Departemen <code>*</code></label>
                      <input type="text" id="name" class="form-control" placeholder="Nama Departemen"
                        name="name" value="{{ old('name', $sections->name) }}" required>
                      @if ($errors->has('name'))
                        <p style="font-style: bold; color: red;">
                          {{ $errors->first('name') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
                    <a href="{{ route('backsite.division.index') }}" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
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
      $('#division_id').change(function() {
        var divisionId = $(this).val();
        if (divisionId) {
          $.ajax({
            url: "{{ route('backsite.getDepartments') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              division_id: divisionId
            },
            success: function(data) {
              $('#department_id').empty();
              $('#department_id').append('<option value="" selected disabled>Choose</option>');
              $.each(data, function(key, value) {
                $('#department_id').append('<option value="' + value.id + '">' + value.name +
                  '</option>');
              });


              // Manually reset the selected option in the department_id dropdown
              $('#department_id').val('').trigger('change');
            }
          });
        } else {
          $('#department_id').empty();
          $('#department_id').append('<option value="" selected disabled>Choose</option>');
        }
      });
    });
  </script>
@endsection
