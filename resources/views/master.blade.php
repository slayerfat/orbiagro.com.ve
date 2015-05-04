<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    orbiagro.com.ve
    @yield('title')
  </title>

  <link href="{!! asset('css/vendor/font-awesome.min.css') !!}" rel="stylesheet">
  <link href="/css/app.css" rel="stylesheet">
  {{-- css de una libreria en alguna vista --}}
  @yield('css')

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  @include('partials.navbar')

  <div class="container">
    @include('flash::message')
  </div>

  @yield('content')

  <!-- javascript -->
  <script src="{!! asset('js/vendor/jquery.min.js') !!}"></script>
  <script src="{!! asset('js/vendor/bootstrap.min.js') !!}"></script>
  {{-- js de una libreria en alguna vista --}}
  @yield('js')
</body>
</html>
