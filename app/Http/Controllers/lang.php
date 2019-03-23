<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;


class lang extends Controller
{
    //
    public function lang(Request $req){
        return $req->all();
     $lang = App::getLocale();
     if($lang == 'en'){
         App::setLocale('en');
         return "english";
     }else{
          App::setLocale('pr');
          return App::getLocale();
         
     }
    }
}
