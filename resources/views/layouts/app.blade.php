<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Laravel Training - @yield('title')</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset_timed('css/cover.css') }}">

    @yield('css')
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                @if(Auth::guest())
                <a class="navbar-brand" href="{{ url('/') }}">Laravel Training</a>
                @else
                <a class="navbar-brand" href="{{ url('/dashboard') }}">Laravel Training</a>
                @endif


            </div>
            <!-- Right side of navbar -->
            <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if(Auth::guest())
                <li>@yield('page')</li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->first_name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                    @if(Auth::user()->id == 1)
                       <li><a href="{{ url('/list') }}"><i class="fa fa-btn fa-btn fa-smile-o "></i>Users</a></li>
                       <li><a href="{{ url('/datatables') }}"><i class="fa fa-btn fa-arrow-circle-up"></i>Users Status</a></li>
                       <li><a href="{{ url('/register') }}"><i class="fa fa-btn fa-plus-square"></i> Add New User</a></li>
                    @else
                       <li><a href="{{ url('/list') }}"><i class="fa fa-btn fa-btn fa-smile-o "></i>Users</a></li>
                       <li><a href="{{ url('/datatables') }}"><i class="fa fa-btn fa-arrow-circle-up"></i>Users Status</a></li>
                    @endif
                       <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                    </ul>
                </li>
            @endif
            </ul>
        </div>
    </nav>

    @yield('content')

    @yield('modal')
    @yield('github-modal')
    @yield('delete-modal')
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('js-css')
    @stack('scripts')
</body>
</html>
