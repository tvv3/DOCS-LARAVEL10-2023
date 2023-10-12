<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function is_admin() //creata de mine
    {
        if (Session::has('user'))
        {
        if (Session::get('user')=='admin')
              return true;
        }
        return false;

    }

    public function is_logged() //creata de mine
    {
        if (Session::has('user'))
        {
        if (Session::get('user')=='admin')
              return true;
        if (Session::get('user')=='test')
              return true;
        }
        return false;

    }


}
