@extends('layouts.app')
@section('title', '404 Not Found')
@section('content')
  <div id="error">


    <div class="error-page container">
      <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
          <img class="img-error" src="{{ asset('/assets/compiled/svg/error-500.svg') }}" alt="Not Found" width="50%"
            height="auto">
          <h1 class="error-title">System Error</h1>
          <p class="fs-5 text-gray-600">The website is currently unaivailable. Try again later or contact the
            developer.</p>
          <a href="{{ route('dashboard.index') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
      </div>
    </div>


  </div>
@endsection
