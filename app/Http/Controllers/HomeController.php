<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Curs;
use App\Models\Capitol;
use App\Models\Nota;
use App\Models\Site;

class HomeController extends Controller
{
    //
    public function verifica_parola(Request $request)
    {  
        // echo $request->pass1;
        //$request->session()->put('last_active',time());
        if ($request->pass1=='a')
        {
            $request->session()->put('user','admin');

        return redirect(route('show_cursuri'));// with aici transmite o variabila de sesiune
        }
        if ($request->pass1=='t')
        {
            $request->session()->put('user','test');
            return redirect(route('visitor_home'));
        }
        
        return redirect('/')->with(['errorMessage'=>'Parola nu este corecta!']);// with aici transmite o var de sesiune
        
    }

    public function myhome()
    {
       if (!empty(Session::get('user')))
         {
            if (Session::get('user')=='admin')
              return redirect('show_cursuri');//view('admin_home');
              //else
              if (Session::get('user')=='test')
              return redirect('visitor_home');
              //else
              return redirect('/');
            
         }
       else return redirect('/');
    }

    public function logout()
    {
        Session::forget('user');
        Session::flush();
        return redirect('/');
    }

    public function show_test_home()
    {
        if (!$this->is_logged()) { return redirect("/");}
        $cursuri=Curs::with('capitole')->get();
        return view('test_home',['cursuri'=>$cursuri, 'curs_id_selectat'=>-1]);
    }
}
