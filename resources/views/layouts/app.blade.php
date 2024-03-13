<!DOCTYPE html>
<html lang="en">

<head>
  {{-- meta --}}
  @include('includes.meta')
  <title>@yield('title') | DITA</title>
  {{-- style --}}
  @stack('before-style')
  @include('includes.style')
  @stack('after-style')
</head>

<body>
  @routes()
  <script src="{{ asset('') }}/assets/static/js/initTheme.js"></script>
  <div id="app">
    {{-- sidebar --}}
    {{-- @include('components.menu') --}}
    <x-menu />

    <div id="main" class='layout-navbar'>
      {{-- header --}}
      @include('components.header')



      <div id="main-content">
        <div class="page-heading">
          <div class="page-title">
            <div class="row">
              @yield('breadcrumb')
            </div>
          </div>
        </div>
        <x-form.notivication.alert />
        <x-form.validation.error />
        {{-- content --}}
        @yield('content')
        @include('sweetalert::alert')
      </div>
      {{-- footer --}}
      @include('components.footer')
      {{-- script --}}
      @stack('before-script')
      @include('includes.script')
      @stack('after-script')
    </div>
  </div>

</body>

</html>
