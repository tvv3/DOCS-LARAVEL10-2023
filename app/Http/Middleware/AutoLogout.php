<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
//use Illuminate\Session\Store;
//use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
class AutoLogout //creat de mine si trebuie pus ca group middleware in kernel ca sa mearga sesiunile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    //protected $session;
    protected $timeout = 300;//600; //3600=1 ora 1=1secunda
  /*  
    public function __construct(Store $session)
    {
        $this->session = $session;
    }
    */
    public function handle(Request $request, Closure $next)
    {  
      
        $usr=$request->session()->get('user');
        if ((isset($usr))&&($request->path()!='logout'))
        {
    //   echo '<script>alert("aa'.session('last_active').session('user').'");</script>'; 
        
        //$resp=$next($request);//trebuie comentat aici pt ca altfel salveaza de 2 ori capitolul la insert !!!
        $t2=$request->session()->get('last_active');
      //  echo '<script>alert("yy'.$t2.session('user').'");</script>';
        $t3=time();
         //echo '<script>alert("time/user='.$t2.session('user').'");</script>';
        
        if (((isset($t2)) ? ($t3 - $t2) : 0) > $this->timeout)
        {  
        
        //$request->session()->save();
         //echo '<script>alert("time_expired'.session('last_active').session('user').'");</script>';
         //inainte de a sterge
          //$request->session()->forget('last_active');
        // $request->session()->flush();
        // $request->session()->save();   
        //session(['last_active'=> time()]);  
        $err=$t3-$t2;
        $err='Logged out automatically after '.$err.' sec';   
        //if (isset($usr))
          //  {  //echo '<script>alert("time_expired'.session('last_active').session('user').'");</script>';     
               $request->session()->forget('user');
               $request->session()->forget('last_active');
              // $request->session()->flush();
             //  $request->session()->save(); 
             //  $request->session()->put('last_active',time());//ca sa am timp pentru redirect
               return redirect('/')->with(['errorMessage' => $err]);
            //} 
        }
       
        //echo '<script>alert("cc3 user set'.session('last_active').session('user').'");</script>';
        $request->session()->put('last_active',time());
        //$request->session()->save();//NU merge fara save ???
        
    }
       
    return $next($request);
     

        
    }//function handle
}
