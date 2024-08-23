@extends('layouts.auth')
@section('title', 'Login')
@section('content')
  <div class="row h-100">
    <div class="col-lg-5 col-12">
      <div id="auth-left">
        <div class="auth-logo">
          </a>
        </div>
        <div class="text-center">
          <a href="#">
            <img src="{{ asset('dist/assets/img/CMNPFIX.png') }}" class="mb-4" alt="Logo" width="20%">
          </a>
          <h1>Data Input Tapersip</h1>
          <p class="auth-subtitle  my-3">Harap Login terlebih dahulu.</p>
        </div>

        @if (session('status'))
          <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
          </div>
        @endif

        @if ($errors->has('email'))
          <p class="mb-2 text-sm text-danger">Email atau Password salah.</p>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="email" name="email" id="email" class="form-control form-control-xl" placeholder="Email"
              required autofocus>
            <div class="form-control-icon">
              <i class="bi bi-person"></i>
            </div>
          </div>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" name="password" id="password" class="form-control form-control-xl"
              placeholder="Password" required>
            <div class="form-control-icon">
              <i class="bi bi-shield-lock"></i>
            </div>
          </div>

          <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3">Log in</button>
        </form>

      </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
      <div id="auth-right">
        <img src="{{ asset('dist/assets/img/archive-1.jpg') }}" alt="">
      </div>
    </div>
  </div>
@endsection
