<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="shortcut icon" href="{{ asset('/dist/assets/img/logo.png') }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset('/dist/assets/img/logo.png') }}" type="image/png">

  <link rel="stylesheet" crossorigin href="./assets/compiled/css/app.css">
  <link rel="stylesheet" crossorigin href="./assets/compiled/css/app-dark.css">
  <link rel="stylesheet" crossorigin href="./assets/compiled/css/auth.css">
</head>

<body>
  <script src="assets/static/js/initTheme.js"></script>
  <div id="auth">

    @yield('content')


  </div>
</body>

</html>
