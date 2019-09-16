<html>
    <head>
        <title>@yield('title')</title>

      @include('inc.materialized')
      <link rel="stylesheet" href="/css/alert.css">
      <link rel="stylesheet" href="/css/main.css">

    </head>
    <body>
        @section('sidebar')
            This is the master sidebar.
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
