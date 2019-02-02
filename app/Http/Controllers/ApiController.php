<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{

     public function makeResponse($data, $isError = false, $redirectToIfNotAjax = '/') {
        if (Request::ajax()) {
            if ($isError) {
                return $this->jsonFailure(array(
                    'errors' => $data
                ));
            } else {
                return $this->jsonSuccess($data);
            }
        } else {
            if ($isError) {
                return Redirect::route($redirectToIfNotAjax)
                    ->withInput()
                    ->withErrors($data);
            } else {
                Redirect::route($redirectToIfNotAjax);
            }
        }
    }
}
