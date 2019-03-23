<!DOCTYPE html>
<html id='html' lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'tmsNsia') }}</title>
<script>
  var lang = document.getElementsByTagName('html')[0].getAttribute('lang');
</script>
    <!-- Scripts -->
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}" defer></script>
    
    @if(App::getLocale()=='fa')
    <script src="{{ asset('js/messages_fa.js') }}" defer></script>
    @endif
    <script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}" defer></script>

    <script src="{{ asset('js/crud.js') }}" ></script>
   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.datetimepicker.min.css') }}" rel="stylesheet">
    @if(App::getLocale()=='fa')
    <link href="{{ asset('css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <style>
      *{direction: rtl}
    </style>
    @endif
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
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel fixed-top" >
            <div class="container">
                <a href="{{ url('/home') }}" class="navbar-brand">
                    <img width='160' height='55' src="{{ asset('img/logo.png') }}"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    
                @if(Auth::check()&& Auth::user()->status==true)
                    <ul class="navbar-nav mr-auto">
                        <li>   
                          
                              <a class="nav-link" href="/home">{{ __('msg.Home') }}</a>
                              
                        </li>
                        
                         @if(Auth::check() && Auth::user()->status==true && 
                        Auth::user()->can('Create_driver_car')||
                        Auth::user()->can('Update_driver_car')||
                        Auth::user()->can('Update_status_of_driver_car')||
                        Auth::user()->can('Read_driver_car')
                        ) 
                      <li>   
                            <a class="nav-link" href="/cars">{{ __('msg.Cars') }}</a>
                      </li>
                      <li>   
                            <a class="nav-link" href="/drivers">{{ __('msg.Drivers') }}</a>
                      </li>
                      @endif

                          @if(
                          Auth::user()->can('Read_booking')||
                          Auth::user()->can('Approve_booking')
                          )  
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{ __('msg.Bookings') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                           @if(Auth::user()->can('Update_booking')||Auth::user()->can('Read_booking'))
                              <a class="dropdown-item" href="/bookings">{{ __('msg.Bookings') }}</a>
                          @endif  
                              <a class="dropdown-item" href="/pending_bookings">{{ __('msg.Pendings') }}</a>
                            </div>
                          </li>
                          @endif
                          @endif
                          @if(
                          auth()->user()->can('Create_user')||
                          auth()->user()->can('Read_user')||
                          auth()->user()->can('Approve_user'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{ __('msg.Users') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              @if(Auth::user()->can('Create_user')||Auth::user()->can('Read_user'))
                              <a class="dropdown-item" href="/users">{{ __('msg.Users') }}</a>
                              @endif
                              <a class="dropdown-item" href="/pendings_users">{{ __('msg.Pendings') }}</a>
                            </div>
                          </li>
                          @endif
                          @if(
                          auth()->user()->can('Create_role')&&
                          auth()->user()->can('Update_role')||
                          auth()->user()->can('Read_role'))
                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('msg.Access controller') }}
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                
                                  <a class="dropdown-item" href="/user_roles">{{ __('msg.Users role') }}</a>
                                  <a class="dropdown-item" href="/user_permissions">{{ __('msg.Users permission') }}</a>
                                <a class="dropdown-item" href="/roles">{{ __('msg.Roles') }}</a>
                                <a class="dropdown-item" href="/permissions">{{ __('msg.Permissions') }}</a>
                              </div>
                            </li>
                          @endif                       
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
                                    <button type="button" class="btn btn- bookingBtn " data-toggle="modal" data-target="#carBooking">{{ __('msg.Booking') }}</button>
                                </li>
                                @endif
                                
                            @endif

                        @else
                          @csrf
                          <li class="nav-item dropdown">
                              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                  {{ Config::get('languages')[App::getLocale()] }}
                              </a>
                              <ul class="dropdown-menu ">
                                  @foreach (Config::get('languages') as $lang => $language)
                                      @if ($lang != App::getLocale())
                                          <li class="nav-item dropdown">
                                             
                                              <a href="{{ route('lang.switch', $lang) }}" class="nav-link">{{$language}}</a>
                                          </li>
                                      @endif
                                  @endforeach
                              </ul>
                          </li>
                        
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
                                    
                                    
                                    @if(Auth::check() && Auth::user()->status==true && Auth::user()->can('Create_booking'))
                                    <li>
                          
                                      <button type="button" class="btn btn-secondary bookingBtn" data-toggle="modal" data-target="#carBooking">{{ __('msg.Booking') }}</button>
                                    </li>
                                    @endif
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
          

            @if(Auth::check() && Auth::user()->status == true)
          <style>
            .alertStyle{
              position:fixed;z-index:30000;width:50%;left:25%;top:4%;display: none;
              padding: 20px; border-radius: 5px;
            }
            
          </style>
          @if(App::getLocale()=='fa')
          <style>table{direction:rtl}</style>
          @endif
                <div id='sucDiv' class="alertStyle" style="background-color:seagreen;color:white">
                  <span></span>
                  <span class="text-light btn btn-sm float-right close-alert">x</span>
                </div>
                <div id='errDiv' class=" alert-danger alertStyle" style="background-color:firebrick;color:wheat">
                  <span></span>
                    <span class="btn btn-sm text-white close-alert float-right">x</span>
                </div>
                
                <div id='carBooking' class="modal fade insert-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered " style="min-width: 50%">
                    <div class="modal-content bg-primary">
                                                            <!--content-->
                      <div class="row">
                        <div class="col-md-12">
                          <div class=" text-white bg-secondary card">
                            <div class="card-header">{{ __('msg.Car booking') }}</div>
                              <div class="card-body">
                                <form action='' id='bookACar'>
                                @csrf
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        
                                        <input type="hidden" value={{ Auth::user()->id }} name='user_id'>
                                    
                                        <label for="destination">{{ __('msg.Destination') }} </label>
                                        <input type="text" class="form-control" name='destination' id="destination" placeholder="{{ __('msg.Insert your destination') }}">
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="pickup_time">{{ __('msg.Pickup_time') }}</label>
                                        <input type="text" class="form-control" name="pickup_time" id="pickup_time" placeholder="yyyy/mm/dd hh:mm">
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="return_time">{{ __('msg.Return_time') }}</label>
                                        <input type="text" class="form-control" id="return_time" name="return_time" placeholder="yyyy/mm/dd hh:mm">
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="count">{{ __('msg.Count') }}</label>
                                        <input type="text" class="form-control" id="count" name="count" placeholder="{{ __('msg.Count of persons') }}">
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="description">{{ __('msg.Description') }}</label>
                                        <textarea type="text" class="form-control" id="description" name="description" placeholder="{{ __('msg.More description') }} "></textarea>
                                        <div class='errorsOfDriver font-italic text-light' >
                                            <div class="help-block" id='UnameErr'></div>
                                          </div>
                                        </div>
                                    
                                      <div class="form-group clear-fix">
                                        <button type='submit' class='btn float-right btn-primary' name="reserve" id='reserve'>{{  __('msg.Reserve')}}</button>
                                        <span class="float-right">&nbsp</span>
                                        <button type='button' class='btn btn-dark float-right' name="cancel" id='cancel' data-dismiss="modal">{{ __('msg.Cancel')}}</button>
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

