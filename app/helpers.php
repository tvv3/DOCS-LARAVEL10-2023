<?php
//use Illuminate\Support\Facades\DB;
function excerpt3_old($sir, $key) //bun
{
    $poz=stripos($sir, $key);
    $radius=40;
    //return $poz;
    if (!isset($poz)) return null;

    if ($poz-$radius>=0) $p1=$poz-$radius;
    else $p1=0;

    if ($poz+$radius+strlen($key)-1>=strlen($sir)-1) $p2=strlen($sir)-1;
    else $p2=$poz+$radius+strlen($key)-1;

   return substr($sir, $p1, $p2-$p1+1);
}

function excerpt3($sir, $key)
{
    $poz=stripos($sir, $key);
    $radius=40;
    //return $poz;
    if (!isset($poz)) return null;

    if ($poz-$radius>=0) 
    {
        $p1=$poz-$radius;
        if (($p1>0)&&($sir[$p1-1]!=' '))
        {
            $i=$p1-1;
            while(($i>0)&&($sir[$i-1]!=' '))
            {
                 $i--;
             
            }
            if (($i>0)&&($sir[$i-1]==' ')) $p1=$i;
            else $p1=0;
        }
    }
    else $p1=0;

    if ($poz+$radius+strlen($key)-1>=strlen($sir)-1) $p2=strlen($sir)-1;
    else {
        $p2=$poz+$radius+strlen($key)-1;
        if (($p2<strlen($sir)-1)&&($sir[$p2+1]!=' '))
        {
            $i=$p2+1;
            while(($i<strlen($sir)-1)&&($sir[$i+1]!=' '))
            {
                 $i++;
             
            }
            if (($i<strlen($sir)-1)&&($sir[$i+1]==' ')) $p2=$i;
            else $p2=strlen($sir)-1;
        }
    }
   $sir_rezultat= substr($sir, $p1, $p2-$p1+1);
   if ($p1>0) $sir_rezultat='...'.$sir_rezultat;
   if ($p2<strlen($sir)-1) $sir_rezultat=$sir_rezultat.'...';

   return $sir_rezultat;
}

function is_valid_capitol($curs_id, $nrord, $capitol_id)
{
    
   $records=-1;
   if ($capitol_id!='none')
   {
   $records=Illuminate\Support\Facades\DB::table('capitole')->where('curs_id','=',$curs_id)->where('nrord','=',$nrord)
           ->where('id','<>',$capitol_id)
           ->count();
   }  
   else{
    $records=Illuminate\Support\Facades\DB::table('capitole')->where('curs_id','=',$curs_id)->where('nrord','=',$nrord)
           ->count();
   }     
   if ($records==0)
   {
    //validation ok
    return true;
   }
   
    return false;
   
}

  function  return_to_homepage($message){
    return redirect()->route('loginhomepage')->with(["errorMessage"=>$message]);
  }
  function username_for_master_view($user)
  {
    if ($user=='admin') {return "administrator";}
    if ($user=='test') {return "vizitator"; }
    return "neautorizat";
  }
?>