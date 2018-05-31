<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link  href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/css/main.css?v={{ date('dmhms')}}">
    
    
</head>
<body class="bgback">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('admin.custom.login') }}">Ingresar</a></li>
                            <li><a href="{{ route('admin.custom.register') }}">Registrar</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('admin.custom.logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('admin.custom.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://apis.google.com/js/api.js"></script>
    <script>
            function start() {
              // 2. Initialize the JavaScript client library.
              gapi.client.init({
                'apiKey': 'AIzaSyBP9w7Hua1r2mBCKK3rjtiobTKrJYf0DP8',
                // Your API key will be automatically added to the Discovery Document URLs.
                //'discoveryDocs': ['https://people.googleapis.com/$discovery/rest'],
                // clientId and scope are optional if auth is not required.
                'clientId': '74938428927-c1rb6qt4b82hv343d26hra1bhb830525.apps.googleusercontent.com',
                'scope': 'profile',
              }).then(function() {
                // 3. Initialize and make the API request.
                return gapi.client.people.people.get({
                  'resourceName': 'people/me',
                  'requestMask.includeField': 'person.names'
                });
              }).then(function(response) {
                console.log(response.result);
              }, function(reason) {
               // console.log('Error: ' + reason.result.error.message);
              });
            };
            // 1. Load the JavaScript client library.
            gapi.load('client', start);
            </script>

            
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
    
    <script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript" src="/js/main.js?v=10"></script>
</body>
</html>
