<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'tmsNsia') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
     <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}" defer></script>

    <script src="{{ asset('js/crud.js') }}" ></script>
   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    
    <div id="app">
        <!-- Update Modal -->
        <div class="modal insert-modal-lg fade" id="noUpdateModal" tabindex="-1" role="dialog" style=>
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-info">
                <h5 class="modal-title" id="messageShow">{{__('Update')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id='messageContent'>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id='sameUpdateModal'>{{__('OK')}}</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Delete Approval div -->
        
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalCenterTitle">{{__('Delete')}}</h5>
                <button type="button" class="close bg-danger" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class='text-white'>&times;</span>
                </button>
              </div>
              <div class="modal-body">
                {{__('Are you sure you want to delete this item?')}}
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('NO')}}</button>
                <button type="button" class="btn btn-primary" id='yesBtn'>{{__('YES')}}</button>
              </div>
            </div>
          </div>
        </div>

        <nav class="navbar navbar-expand-md navbar-light navbar-laravel fixed-top">
            <div class="container">
                
                <a href="{{ url('/') }}" class="navbar-brand">
                    <img width='140' height='50' src="{{ asset('img/logo.png') }}"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    
                    <ul class="navbar-nav mr-auto">
                        <li>   
                              <a class="nav-link" href="/">{{ __('home') }}</a>
                        </li>
                        <li>   
                              <a class="nav-link" href="/cars">{{ __('cars') }}</a>
                        </li>
                        <li>   
                              <a class="nav-link" href="/drivers">{{ __('drivers') }}</a>
                        </li>
                        <li>   
                              <a class="nav-link" href="/bookings">{{ __('bookings') }}</a>
                        </li>  
                              <a class="nav-link" href="/users">{{ __('users') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4" style="margin-top: 5% !important">
                    
        </main>
        <div class="container">
                <div id='sucDiv' class="alert alert-success" style="display: none"></div>
                <div id='errDiv' class="alert alert-danger" style="display: none"></div>

            @yield('content')

            </div> 
    </div>
</body>
<script type="text/javascript">
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
</html>

