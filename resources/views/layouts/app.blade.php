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
    <script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}" defer></script>

    <script src="{{ asset('js/crud.js') }}" ></script>
   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.datetimepicker.min.css') }}" rel="stylesheet">
  </head>
<body>
    
    <div id="app">

        <!-- Update Modal -->
        <div class="modal insert-modal-lg fade" id="noUpdateModal" tabindex="-1" role="dialog" style=>
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class=" bg-white">
                <h5 class="modal-title" id="messageShow"></h5>
              </div>
              <div class="modal-body text-center" style="font-size: 18px;color: gray" id='messageContent'>
                
              </div>
              <div class="modal-footer" style="padding: 5px">
                <button type="button" class="btn btn-primary form-control" data-dismiss="modal" id='sameUpdateModal'>{{__('Close')}}</button>
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
                           
                              <a class="nav-link" href="/home">{{ __('home') }}</a>
                        </li>
                        <li>   
                            <a class="nav-link" href="/cars">{{ __('Cars') }}</a>
                      </li>
                      <li>   
                            <a class="nav-link" href="/drivers">{{ __('Drivers') }}</a>
                      </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{ __('Bookings') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="/bookings">{{ __('Bookings') }}</a>
                              <a class="dropdown-item" href="/pending_bookings">{{ __('Pendings') }}</a>
                            </div>
                          </li>
                       
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{ __('Users') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="/users">{{ __('Users') }}</a>
                              <a class="dropdown-item" href="/pendings_users">{{ __('Pendings') }}</a>
                            </div>
                          </li>
                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('Access controller') }}
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                
                                  <a class="dropdown-item" href="/user_roles">{{ __('Users Role') }}</a>
                                  <a class="dropdown-item" href="/user_permissions">{{ __('Users permission') }}</a>
                                <a class="dropdown-item" href="/roles">{{ __('Roles') }}</a>
                                <a class="dropdown-item" href="/permissions">{{ __('Permissions') }}</a>
                              </div>
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
                               @if(Auth::check())
                                <li>
                                    <button type="button" class="btn btn-primary bookingBtn " data-toggle="modal" data-target="#carBooking">booking</button>
                                </li>
                                @endif
                                
                            @endif

                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name  }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <li>
                          
                                      <button type="button" class="btn btn-primary bookingBtn" data-toggle="modal" data-target="#carBooking">booking</button>
                                    </li>
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
          <style>
            .alertStyle{
              position:fixed;z-index:30000;width:50%;left:25%;right:25%;bottom:4%;display: none;
              padding: 10px; border-radius: 5px;
            }
          </style>
                <div id='sucDiv' class="alertStyle" style="background-color:seagreen;color:white">
                  <span></span>
                  <span class="text-light btn btn-sm float-right close-alert">x</span>
                </div>
                <div id='errDiv' class=" alert-danger alertStyle" style="background-color:firebrick;color:wheat">
                  <span></span>
                    <span class="btn btn-sm text-white close-alert float-right">x</span>
                </div>

                @if(Auth::check())
                <div id='carBooking' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered " style="min-width: 50%">
                    <div class="modal-content bg-primary">
                                                            <!--content-->
                      <div class="row">
                        <div class="col-md-12">
                          <div class=" text-white bg-secondary card">
                            <div class="card-header">Car booking</div>
                              <div class="card-body">
                                <form action='' id='bookACar'>
                                @csrf
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        
                                        <input type="hidden" value={{ Auth::user()->id }} name='user_id'>
                                    
                                        <label for="destination">{{ __('Destination') }} </label>
                                        <input type="text" class="form-control" name='destination' id="destination" placeholder="insert your destination">
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="pickup_time">{{ __('pickup time') }}</label>
                                        <input type="text" class="form-control" name="pickup_time" id="pickup_time" placeholder="yyyy/mm/dd hh:mm">
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="return_time">{{ __('return time') }}</label>
                                        <input type="text" class="form-control" id="return_time" name="return_time" placeholder="yyyy/mm/dd hh:mm">
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="count">{{ __('count of persons') }}</label>
                                        <input type="text" class="form-control" id="count" name="count" placeholder=" please type name of persons ">
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="description">{{ __('Descripion') }}</label>
                                        <textarea type="text" class="form-control" id="description" name="description" placeholder=" more description "></textarea>
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                        </div>
                                    
                                      <div class="form-group clear-fix">
                                        <button type='submit' class='btn float-right btn-primary' name="reserve" id='reserve'>{{('Reserve')}}</button>
                                        <span class="float-right">&nbsp</span>
                                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">{{('Cancel')}}</button>
                                      </div>
                                    </div>
                                  </div>
                                </form>        
                              </div>
                            </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                  </div>
                  @endif

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

