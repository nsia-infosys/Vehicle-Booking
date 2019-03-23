@extends('layouts.app')

@section('content')



@php
use DB;
use Auth;

return Auth::user()->name;
@endphp
<h1></h1>
@endsection