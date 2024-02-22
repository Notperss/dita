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
    @include('components.menu')
    <div id="main" class='layout-navbar'>
      {{-- header --}}
      @include('components.header')
      <div id="main-content">
        {{-- content --}}
        @yield('content')
        @include('sweetalert::alert')
      </div>
      {{-- footer --}}
      @include('components.footer')
      {{-- script --}}
      @stack('before-style')
      @include('includes.script')
      @stack('after-style')
    </div>
  </div>

</body>

</html>
