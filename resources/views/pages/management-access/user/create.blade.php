@extends('layouts.app')

@section('title', 'User')
@section('content')
  <div class="page-heading">

    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>User</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item" aria-current="page">User</li>
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
              <form class="form" method="POST" action="{{ route('backsite.user.store') }}"
                enctype="multipart/form-data" id=myForm>
                @csrf
                <div class="row ">
                  <div class="col-md-8 col-12 mx-auto">

                    <div class="form-group row">
                      <label class="col-md-4 label-control" for="name">NIK <code style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <input type="text" id="nik" name="nik" class="form-control" placeholder="Nik"
                          value="{{ old('nik') }}" autocomplete="off" required>

                        @if ($errors->has('nik'))
                          <p style="font-style: bold; color: red;">
                            {{ $errors->first('nik') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-4 label-control" for="name">Nama <code style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nama"
                          value="{{ old('name') }}" autocomplete="off" required>

                        @if ($errors->has('name'))
                          <p style="font-style: bold; color: red;">
                            {{ $errors->first('name') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-4 label-control" for="email">E-mail <code
                          style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <input type="email" id="email" name="email" class="form-control"
                          placeholder="example@mail.com" value="{{ old('email') }}" autocomplete="off" required>

                        @if ($errors->has('email'))
                          <p style="font-style: bold; color: red;">
                            {{ $errors->first('email') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="password" class="col-md-4 form-label">Password <code style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <input type="password" name="password" id="password" class="form-control"
                          placeholder="Enter password" value="">
                        @if ($errors->has('password'))
                          <p style="font-style: bold; color: red;">
                            {{ $errors->first('password') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="confirm_password" class="col-md-4 form-label">Confirm Password <code
                          style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <input type="password" name="password_confirmation" id="confirm_password" class="form-control"
                          placeholder="Enter confirm password" value="">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-4 label-control">Type User <code style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <select name="type_user_id" id="type_user_id" class="form-control choices" required>
                          <option value="{{ '' }}" disabled selected>Choose
                          </option>
                          @foreach ($type_users as $key => $type_user_item)
                            <option value="{{ $type_user_item->id }}"
                              {{ old('type_user_id') == $type_user_item->id ? 'selected' : '' }}>
                              {{ $type_user_item->name }}</option>
                          @endforeach
                        </select>

                        @if ($errors->has('type_user_id'))
                          <p style="font-style: bold; color: red;">
                            {{ $errors->first('type_user_id') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-4 label-control" for="company_id">Perushaaan
                        <code style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <select name="company_id" id="company_id" class="form-control choices" required>
                          <option value="{{ '' }}" disabled selected>
                            Choose
                          </option>
                          @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                          @endforeach
                        </select>

                        @if ($errors->has('company_id'))
                          <p style="font-style: bold; color: red;">
                            {{ $errors->first('company_id') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-4 label-control" for="status">Status
                        <code style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <select name="status" id="status" class="form-control choices" required>
                          <option value="{{ '' }}" disabled selected>
                            Choose
                          </option>
                          <option value="1"{{ old('status') == 1 ? 'selected' : '' }}>Aktif</option>
                          <option value="2"{{ old('status') == 2 ? 'selected' : '' }}>Tidak Aktif
                          </option>
                        </select>

                        @if ($errors->has('status'))
                          <p style="font-style: bold; color: red;">
                            {{ $errors->first('status') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-4 label-control" for="profile_photo_path">Upload Icon
                      </label>
                      <div class="col-md-7 mx-left">
                        <div class="custom-file">
                          <input type="file" class="image-preview-filepond" id="profile_photo_path"
                            name="profile_photo_path">
                          <label class="custom-file-label" for="file" aria-describedby="file">Pilih
                            Icon</label>
                        </div>
                        <p class="text-muted"><small class="text-danger">Hanya dapat
                            mengunggah 1 Icon</small></p>
                        @if ($errors->has('profile_photo_path'))
                          <p style="font-style: bold; color: red;">
                            {{ $errors->first('profile_photo_path') }}</p>
                        @endif
                      </div>
                    </div>

                  </div>
                  <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="submitForm()">Submit</button>
                    <a href="{{ route('backsite.user.index') }}" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
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
