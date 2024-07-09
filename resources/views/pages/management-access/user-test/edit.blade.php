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
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">User</li>
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
              <form id="myForm" class="form" method="POST" action="{{ route('backsite.user.update', $user->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row ">
                  <div class="col-md-8 col-12 mx-auto">

                    <div class="form-group row">
                      <label class="col-md-4 label-control" for="name">NIK <code style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <input type="text" id="nik" name="nik" class="form-control" placeholder="Nik"
                          value="{{ old('nik', isset($user->detail_user->nik) ? $user->detail_user->nik : '') }}"
                          autocomplete="off" required>

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
                          value="{{ old('name', isset($user->name) ? $user->name : '') }}" autocomplete="off" required>

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
                          placeholder="example@mail.com"
                          value="{{ old('email', isset($user->email) ? $user->email : '') }}" autocomplete="off" required>

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
                          placeholder="Kosongkan jika password tidak diganti" value="">
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
                          @foreach ($type_user as $key => $type_user_item)
                            <option value="{{ $type_user_item->id }}"
                              {{ $type_user_item->id == $user->detail_user->type_user_id ? 'selected' : '' }}>
                              {{ $type_user_item->name }}</option>
                          @endforeach
                        </select>

                        @if ($errors->has('user_id'))
                          <p style="font-style: bold; color: red;">
                            {{ $errors->first('user_id') }}</p>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-4 label-control" for="company_id">Perusahaan
                        <code style="color:red;">*</code></label>
                      <div class="col-md-8 mx-auto">
                        <select name="company_id" id="company_id" class="form-control choices" required>
                          <option value="{{ '' }}" disabled selected>
                            Choose
                          </option>
                          @foreach ($companies as $company)
                            <option
                              value="{{ $company->id }}"{{ $company->id == $user->detail_user->company_id ? 'selected' : '' }}>
                              {{ $company->name }}</option>
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
                          <option value="1" {{ $user->detail_user->status == 1 ? 'selected' : '' }}>
                            Aktif</option>
                          <option value="2" {{ $user->detail_user->status == 2 ? 'selected' : '' }}>
                            Tidak Aktif</option>
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
                      <div class="col-md-4 mx-left">
                        <div class="user-img d-flex align-items-center">
                          <div class="">
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="icon"
                              width="70%" height="auto" style="border-radius: 50%">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 mx-left">
                        <input type="file" class="image-preview-filepond" id="profile_photo_path"
                          name="profile_photo_path">
                        <p class="text-muted"><small class="text-danger">Hanya dapat
                            mengunggah 1 Icon</small></p>
                      </div>

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
  <!-- // Basic multiple Column Form section end -->


@endsection
