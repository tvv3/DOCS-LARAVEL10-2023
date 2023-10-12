<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Curs;
use App\Models\Capitol;
use App\Models\Nota;
use App\Models\Site;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class CapitolController extends Controller
{
    private $nrc=0;  //the number of calls of the store method for one save capitol call
    public function creeaza_capitol(Curs $curs)
    {
        if (!$this->is_admin()) return redirect("/");

        return view('partiale.admin.creare_capitol',['curs'=>$curs]);
    }

    public function show_capitole(Curs $curs)
    {
        if (!$this->is_admin()) return redirect("/");
    
        $capitole=$curs->capitole;
        return view('partiale.admin.show_capitole',['curs'=>$curs,'capitole'=>$capitole]);
    }

    public function store_capitol_nou(Request $request, Curs $curs)
    {
      $capitol=Capitol::create($request->all());
      return redirect('show_capitole/'.$capitol->curs_id)->with('success','Capitolul a fost creat');
      // return $request; 
   
   }

   public function store_capitol(Request $request)
    {
        if (!$this->is_admin()) return redirect("/");
        /*$request->validate([
         'capitol' => 'required|max:100',
         'nrord' => 'required|numeric|integer',
     ]);*/

    $validator = Validator::make($request->all(), [
      'capitol' => 'required|max:100',
      'nrord' => 'required|numeric|integer',
  ]);
     
   
     $validator->after(function ($validator) use ($request) {
      if (is_valid_capitol($request->curs_id, $request->nrord, 'none')==false) {
          $validator->errors()->add('nrord', 'Eroare! Exista deja acest nr de ordine in curs!');
      }
  });
  // $validator->validate();
  if ($validator->fails()) {
   if ($this->nrc==0)
   {
     return redirect('/creeaza_capitol'.'/'.$request->curs_id)
             ->withErrors($validator)
             ->withInput();
   }
     //else s-a apelat din nou store din cauza model::create([...]); daca fac cu validate fara validator merge fara acest artificiu        
     return redirect('/show_capitole'.'/'.$request->curs_id);//este suficient va tine minte mesajul de succes geerat mai jos
     //       ->withErrors($validator);
            //->withInput();       
      
     }
      //continua insert-ul
        $capitol=new Capitol();

        $capitol->curs_id=$request->curs_id;
        $capitol->capitol=$request->capitol;
        $capitol->nrord=$request->nrord;
        
        //de adaugat validate $capitol
        $found=true;
        try{
            $curs=Curs::find($request->curs_id);
            }
            catch(QueryException $e)
            {
                $found=false;
            };

        if ($found)
        {
        $salvat=true;
         try{   
          $this->nrc++; //atat create cat si save apeleaza din nou functia store  si daca prima oara validatorul a fost ok , a doua oara gaseste vechiul row si nu il mai creeaza ci da eroare = fails!!!!
         // $capitol_nou=Capitol::create(["curs_id"=>$request->curs_id, "capitol"=>$request->capitol, "nrord"=>$request->nrord]);
         $capitol->save(); //
         //$saved=true;
         }
         catch (QueryException $e)
         {
           $salvat=false;
         };
        }//found


        //return redirect('show_capitole/'.$request->curs_id);
        if ($found)
        {
        if ($salvat) 
        {return redirect('show_capitole/'.$curs->id)->with('success', 'Capitolul a fost creat.');
      
        }
         //else
         return redirect('show_capitole/'.$curs->id)->with('error', 'Capitolul NU a fost creat.');
        }
        else return redirect('/');
    }

   
    
     //update

     public function edit_capitol(Capitol $capitol)
     {
         if (!$this->is_admin()) return redirect("/");
 
         return view('partiale.admin.edit_capitol',['capitol'=>$capitol]);
     }
 
     public function update_capitol(Request $request, Capitol $capitol)
     {
         if (!$this->is_admin()) return redirect("/");
 
         //$capitol = Capitol::find($capitol->id); //cred ca nu trebuie se face cautarea automat 
        /* $request->validate([
            'capitol' => 'required|max:100',
            'nrord' => 'required|numeric|integer',
        ]);*/

        $validator = Validator::make($request->all(), [
         'capitol' => 'required|max:100',
         'nrord' => 'required|numeric|integer',
     ]);
        
      
        $validator->after(function ($validator) use ($capitol, $request) {
         if (is_valid_capitol($request->curs_id, $request->nrord, $capitol->id)==false) {
             $validator->errors()->add('nrord', 'Eroare! Exista deja acest nr de ordine in curs!');
         }
     });

      if ($validator->fails()) {
      return redirect('/modifica_capitol'.'/'.$capitol->id)
                  ->withErrors($validator)
                  ->withInput();
        }
        
         $capitol->capitol = $request->capitol;
 
         $capitol->curs_id=$request->curs_id;

         $capitol->nrord=$request->nrord;
  
          //de adaugat validate $curs
         $salvat=true;
         try{
         $capitol->save();
         }
         catch (QueryException $e)
         {
           $salvat=false;
         };
         if ($salvat) return redirect('show_capitole/'.$capitol->curs_id)->with('success', 'Capitolul a fost modificat.');
         //else
         return redirect('show_capitole/'.$capitol->curs_id)->with('error', 'Capitolul NU a fost modificat.');
     }

     //delete

    public function delete_capitol(Capitol $capitol)
    {
        if (!$this->is_admin()) { return redirect("/");}

        $nume=$capitol->capitol;
        $curs_id=$capitol->curs_id;
        $deleted=true;
        try {
        $capitol->delete();
        
        }
        catch(QueryException $e)
        {
          $deleted=false;
        };

        if ($deleted) {session()->flash("success","Capitolul ".$nume." a fost sters cu succes!");}
        else {
            session()->flash("error","Eroare! Capitolul ".$nume." NU a fost sters!");
        }

        return redirect("show_capitole/".$curs_id);
    }

    //show capitol content with note si siteuri in cadrul view_content -- viewul de vizualizare cursuri

    public function show_capitol_content(Capitol $capitol)
    {
        //$t2=floor(microtime(true) * 1000);//milisecunde
        $curslanguage=$capitol->curs->language;
        if (!$this->is_logged()) { return redirect("/");}
        $cursuri=Curs::with('capitole')->get();

        $note=Nota::where('capitol_id', '=', $capitol->id)->whereRaw("
        nrord =
        ( select min(nrord) from note 
        where capitol_id = ".$capitol->id."                  
        )")->orderBy('id','asc')->get();


        if (count($note)==0) /*nu exista nota anterioara */
           {$nota_anterioara=null;
            $nota=null;
            $nota_urmatoare=null;
           }
        else 
        {  $nota_anterioara=null;
           $nota=$note[0];
           
        $note_urmatoare=Nota::where('capitol_id','=',$capitol->id)->whereRaw("
           nrord in 
           ( select min(nrord) from note
             where nrord > ".$nota->nrord." 
             and capitol_id = ".$capitol->id."                 
           )")->orderBy('id','asc')->get();
   
           if (count($note_urmatoare)==0) /*nu exista nota urmatoare */
              $nota_urmatoare=null;
           else 
              $nota_urmatoare=$note_urmatoare[0];
        }

        //get site

        $siteuri=Site::where('capitol_id', '=', $capitol->id)->whereRaw("
        id in 
        ( select min(id) from siteuri 
        where capitol_id = ".$capitol->id."                  
        )")->orderBy('id','asc')->get();


        if (count($siteuri)==0) /*nu exista nota anterioara */
           {$site_anterior=null;
            $site=null;
            $site_urmator=null;
            
           }
        else 
        {  
           $site_anterior=null;
           $site=$siteuri[0];
           
        $siteuri_urmatoare=Site::where('capitol_id','=',$capitol->id)->whereRaw("
           id in 
           ( select min(id) from siteuri
             where id > ".$site->id." 
             and capitol_id = ".$capitol->id."                 
           )")->orderBy('id','asc')->get();
   
           if (count($siteuri_urmatoare)==0) /*nu exista nota urmatoare */
              $site_urmator=null;
           else 
              $site_urmator=$siteuri_urmatoare[0];
        }

        $capitol_selectat=$capitol;
        $tab_active='note';

$curs_id_selectat= empty($capitol_selectat)? -1 :$capitol_selectat->curs->id;
$capitol_id_selectat= empty($capitol_selectat)? -1 :$capitol_selectat->id;
     //conditia optionala : @if(($curs->id=$curs_id_selectat)||(($curs_id_selectat==-1)&&($key1==0)))
 // echo empty($capitol_selectat);
 //echo $curs_id_selectat;
 //echo '<script>alert("php section ended");</script>';
 
         
         //$t2=floor(microtime(true) * 1000);//miliseconds
         //echo '<script>alert("controller:'.($t2-$t1).'");</script>';   
         $nrnote=$capitol->note->count();
         if ($nrnote==0) {$has_note=false;}
         else {$has_note=true;}       

         $nrsiteuri=$capitol->siteuri->count();
         if ($nrsiteuri==0) {$has_site=false;}
         else {$has_site=true;} 

         if (($has_note==false)&&($has_site==true)) {$tab_active='siteuri';}

$status_note1=($tab_active=='note')?' active ': '';
$status_note2=($tab_active=='note')?' show active ': '';
$status_note3=($tab_active=='note')? 'true': 'false';

$status_siteuri1=($tab_active=='siteuri')?' active ': '';
$status_siteuri2=($tab_active=='siteuri')?' show active ': '';
$status_siteuri3=($tab_active=='siteuri')? 'true': 'false';

        return view('partiale.view_content',['cursuri'=>$cursuri,
        'capitol_selectat'=>$capitol,
        'nota_selectata'=>$nota,
        'nota_urmatoare'=>$nota_urmatoare,
        'nota_anterioara'=>$nota_anterioara,
        'site_selectat'=>$site,
        'site_anterior'=>$site_anterior,
        'site_urmator'=>$site_urmator,
        'tab_active'=>$tab_active,
        'curs_id_selectat'=>$curs_id_selectat,
        'capitol_id_selectat'=>$capitol_id_selectat,
        'status_note1'=>$status_note1,
        'status_note2'=>$status_note2,
        'status_note3'=>$status_note3,
      
        'status_siteuri1'=>$status_siteuri1,
        'status_siteuri2'=>$status_siteuri2,
        'status_siteuri3'=>$status_siteuri3,
        'has_site'=>$has_site,
        'has_note'=>$has_note,
        'curslanguage'=>$curslanguage
        //'t2'=>$t2
      ]);
    }

    
    public function show_capitol_content_with_nota_and_site(Capitol $capitol, Nota $nota, Site $site, $tab)
    {
        $curslanguage=$capitol->curs->language;
      //$t2=floor(microtime(true) * 1000);//milisecunde
        if (!$this->is_logged()) { return redirect("/");}

        //tab active in view
        if (empty($tab)) $tab='note';
        if (($tab!='note')&&($tab!='siteuri')) $tab='note';

        $cursuri=Curs::with('capitole')->get();
        if ($nota->capitol->id!=$capitol->id)
            return redirect('/visitor_home/capitol/'.$capitol->id);
        
        if ($site->capitol->id!=$capitol->id)
            return redirect('/visitor_home/capitol/'.$capitol->id);

        $note_anterioare=Nota::where('capitol_id','=',$capitol->id)->whereRaw("
        nrord in 
        ( select max(nrord) from note
          where nrord < ".$nota->nrord." 
          and capitol_id = ".$capitol->id."                   
        )")->orderBy('id','desc')->get();

        if (count($note_anterioare)==0) /*nu exista nota anterioara */
           $nota_anterioara=null;
        else 
           $nota_anterioara=$note_anterioare[0];

        $note_urmatoare=Nota::where('capitol_id','=',$capitol->id)->whereRaw("
           nrord in 
           ( select min(nrord) from note
             where nrord > ".$nota->nrord."  
             and capitol_id = ".$capitol->id."                  
           )")->orderBy('id','asc')->get();
   
           if (count($note_urmatoare)==0) /*nu exista nota urmatoare */
              $nota_urmatoare=null;
           else 
              $nota_urmatoare=$note_urmatoare[0];

            // get site anterior si urmator

              $siteuri_anterioare=Site::where('capitol_id','=',$capitol->id)->whereRaw("
              id in 
              ( select max(id) from siteuri
                where id < ".$site->id."
                and capitol_id = ".$capitol->id."                    
              )")->orderBy('id','desc')->get();
      
              if (count($siteuri_anterioare)==0) /*nu exista site-ul anterior */
                 $site_anterior=null;
              else 
                 $site_anterior=$siteuri_anterioare[0];
      
              $siteuri_urmatoare=Site::where('capitol_id','=',$capitol->id)->whereRaw("
                 id in 
                 ( select min(id) from siteuri
                   where id > ".$site->id."  
                   and capitol_id = ".$capitol->id."                  
                 )")->orderBy('id','asc')->get();
         
                 if (count($siteuri_urmatoare)==0) /*nu exista nota urmatoare */
                    $site_urmator=null;
                 else 
                    $site_urmator=$siteuri_urmatoare[0];
      
                    $capitol_selectat=$capitol;
                    $tab_active=$tab;//atentie aici am tab-ul spre deosebire de functia de mai sus unde este null
            
            $curs_id_selectat= empty($capitol_selectat)? -1 :$capitol_selectat->curs->id;
            $capitol_id_selectat= empty($capitol_selectat)? -1 :$capitol_selectat->id;
                 //conditia optionala : @if(($curs->id=$curs_id_selectat)||(($curs_id_selectat==-1)&&($key1==0)))
             // echo empty($capitol_selectat);
             //echo $curs_id_selectat;
             //echo '<script>alert("php section ended");</script>';
             if (empty($tab_active)) {$tab_active='note';}
            
            $status_note1=($tab_active=='note')?' active ': '';
            $status_note2=($tab_active=='note')?' show active ': '';
            $status_note3=($tab_active=='note')? 'true': 'false';
            
            $status_siteuri1=($tab_active=='siteuri')?' active ': '';
            $status_siteuri2=($tab_active=='siteuri')?' show active ': '';
            $status_siteuri3=($tab_active=='siteuri')? 'true': 'false';
            
            $nrnote=$capitol->note->count();
            if ($nrnote==0) {$has_note=false;}
            else {$has_note=true;}       

            $nrsiteuri=$capitol->siteuri->count();
            if ($nrsiteuri==0) {$has_site=false;}
            else {$has_site=true;}            

        return view('partiale.view_content',['cursuri'=>$cursuri,
        'capitol_selectat'=>$capitol, 'nota_selectata'=>$nota,
        'nota_anterioara'=>$nota_anterioara,
        'nota_urmatoare'=>$nota_urmatoare,
        'site_selectat'=>$site,
        'site_anterior'=>$site_anterior,
        'site_urmator'=>$site_urmator,
        'tab_active'=>$tab_active,
        'curs_id_selectat'=>$curs_id_selectat,
        'capitol_id_selectat'=>$capitol_id_selectat,
        'status_note1'=>$status_note1,
        'status_note2'=>$status_note2,
        'status_note3'=>$status_note3,
      
        'status_siteuri1'=>$status_siteuri1,
        'status_siteuri2'=>$status_siteuri2,
        'status_siteuri3'=>$status_siteuri3,
        'has_site'=>$has_site,
        'has_note'=>$has_note,
        'curslanguage'=>$curslanguage
    /*'t2'=>$t2*/]);
    }

    public function show_capitol_content_with_nota_and_no_site(Capitol $capitol, Nota $nota)
    {
        $curslanguage=$capitol->curs->language;
      //$t2=floor(microtime(true) * 1000);//milisecunde
        if (!$this->is_logged()) { return redirect("/");}

        //tab active in view
        $tab='note';

        $cursuri=Curs::with('capitole')->get();
        if ($nota->capitol->id!=$capitol->id)
            return redirect('/visitor_home/capitol/'.$capitol->id);
        
        //if ($site->capitol->id!=$capitol->id)
          //  return redirect('/visitor_home/capitol/'.$capitol->id);

        $note_anterioare=Nota::where('capitol_id','=',$capitol->id)->whereRaw("
        nrord in 
        ( select max(nrord) from note
          where nrord < ".$nota->nrord." 
          and capitol_id = ".$capitol->id."                   
        )")->orderBy('id','desc')->get();

        if (count($note_anterioare)==0) /*nu exista nota anterioara */
           $nota_anterioara=null;
        else 
           $nota_anterioara=$note_anterioare[0];

        $note_urmatoare=Nota::where('capitol_id','=',$capitol->id)->whereRaw("
           nrord in 
           ( select min(nrord) from note
             where nrord > ".$nota->nrord."  
             and capitol_id = ".$capitol->id."                  
           )")->orderBy('id','asc')->get();
   
           if (count($note_urmatoare)==0) /*nu exista nota urmatoare */
              $nota_urmatoare=null;
           else 
              $nota_urmatoare=$note_urmatoare[0];

            // get site anterior si urmator

                    $capitol_selectat=$capitol;
                    $tab_active=$tab;//atentie aici am tab-ul spre deosebire de functia de mai sus unde este null
            
            $curs_id_selectat= empty($capitol_selectat)? -1 :$capitol_selectat->curs->id;
            $capitol_id_selectat= empty($capitol_selectat)? -1 :$capitol_selectat->id;
                 //conditia optionala : @if(($curs->id=$curs_id_selectat)||(($curs_id_selectat==-1)&&($key1==0)))
             // echo empty($capitol_selectat);
             //echo $curs_id_selectat;
             //echo '<script>alert("php section ended");</script>';
            
            
            $status_note1=($tab_active=='note')?' active ': '';
            $status_note2=($tab_active=='note')?' show active ': '';
            $status_note3=($tab_active=='note')? 'true': 'false';
            
            $status_siteuri1=($tab_active=='siteuri')?' active ': '';
            $status_siteuri2=($tab_active=='siteuri')?' show active ': '';
            $status_siteuri3=($tab_active=='siteuri')? 'true': 'false';
            
            $nrnote=$capitol->note->count();
            if ($nrnote==0) {$has_note=false;}
            else {$has_note=true;} 

            $nrsiteuri=$capitol->siteuri->count();
            if ($nrsiteuri==0) {$has_site=false;}
            else {$has_site=true;}            

        return view('partiale.view_content',['cursuri'=>$cursuri,
        'capitol_selectat'=>$capitol, 'nota_selectata'=>$nota,
        'nota_anterioara'=>$nota_anterioara,
        'nota_urmatoare'=>$nota_urmatoare,
        'site_selectat'=>null,
        'site_anterior'=>null,
        'site_urmator'=>null,
        'tab_active'=>$tab_active,
        'curs_id_selectat'=>$curs_id_selectat,
        'capitol_id_selectat'=>$capitol_id_selectat,
        'status_note1'=>$status_note1,
        'status_note2'=>$status_note2,
        'status_note3'=>$status_note3,
      
        'status_siteuri1'=>$status_siteuri1,
        'status_siteuri2'=>$status_siteuri2,
        'status_siteuri3'=>$status_siteuri3,
        'has_site'=>$has_site,
        'has_note'=>$has_note,
        'curslanguage'=>$curslanguage
    /*'t2'=>$t2*/]);
    }

    public function show_capitol_content_with_site(Capitol $capitol, Site $site)
    {
       $curslanguage=$capitol->curs->language;
      //$t2=floor(microtime(true) * 1000);//milisecunde
        if (!$this->is_logged()) { return redirect("/");}

        //tab active in view
        $tab='siteuri';
        

        $cursuri=Curs::with('capitole')->get();
        //if ($nota->capitol->id!=$capitol->id)
          //  return redirect('/visitor_home/capitol/'.$capitol->id);
        
        if ($site->capitol->id!=$capitol->id)
            return redirect('/visitor_home/capitol/'.$capitol->id);


            // get site anterior si urmator

              $siteuri_anterioare=Site::where('capitol_id','=',$capitol->id)->whereRaw("
              id in 
              ( select max(id) from siteuri
                where id < ".$site->id."
                and capitol_id = ".$capitol->id."                    
              )")->orderBy('id','desc')->get();
      
              if (count($siteuri_anterioare)==0) /*nu exista site-ul anterior */
                 $site_anterior=null;
              else 
                 $site_anterior=$siteuri_anterioare[0];
      
              $siteuri_urmatoare=Site::where('capitol_id','=',$capitol->id)->whereRaw("
                 id in 
                 ( select min(id) from siteuri
                   where id > ".$site->id."  
                   and capitol_id = ".$capitol->id."                  
                 )")->orderBy('id','asc')->get();
         
                 if (count($siteuri_urmatoare)==0) /*nu exista nota urmatoare */
                    $site_urmator=null;
                 else 
                    $site_urmator=$siteuri_urmatoare[0];
      
                    $capitol_selectat=$capitol;
                    $tab_active=$tab;//atentie aici am tab-ul spre deosebire de functia de mai sus unde este null
            
            $curs_id_selectat= empty($capitol_selectat)? -1 :$capitol_selectat->curs->id;
            $capitol_id_selectat= empty($capitol_selectat)? -1 :$capitol_selectat->id;
                 //conditia optionala : @if(($curs->id=$curs_id_selectat)||(($curs_id_selectat==-1)&&($key1==0)))
             // echo empty($capitol_selectat);
             //echo $curs_id_selectat;
             //echo '<script>alert("php section ended");</script>';
            // if (empty($tab_active)) {$tab_active='note';}
            
            $status_note1=($tab_active=='note')?' active ': '';
            $status_note2=($tab_active=='note')?' show active ': '';
            $status_note3=($tab_active=='note')? 'true': 'false';
            
            $status_siteuri1=($tab_active=='siteuri')?' active ': '';
            $status_siteuri2=($tab_active=='siteuri')?' show active ': '';
            $status_siteuri3=($tab_active=='siteuri')? 'true': 'false';
            
            $nrnote=$capitol->note->count();
            if ($nrnote==0) {$has_note=false;}
            else {$has_note=true;}            
             
            $nrsiteuri=$capitol->siteuri->count();
            if ($nrsiteuri==0) {$has_site=false;}
            else {$has_site=true;}  
        return view('partiale.view_content',['cursuri'=>$cursuri,
        'capitol_selectat'=>$capitol, 'nota_selectata'=>null,
        'nota_anterioara'=>null,
        'nota_urmatoare'=>null,
        'site_selectat'=>$site,
        'site_anterior'=>$site_anterior,
        'site_urmator'=>$site_urmator,
        'tab_active'=>$tab_active,
        'curs_id_selectat'=>$curs_id_selectat,
        'capitol_id_selectat'=>$capitol_id_selectat,
        'status_note1'=>$status_note1,
        'status_note2'=>$status_note2,
        'status_note3'=>$status_note3,
      
        'status_siteuri1'=>$status_siteuri1,
        'status_siteuri2'=>$status_siteuri2,
        'status_siteuri3'=>$status_siteuri3,
        'has_site'=>$has_site,
        'has_note'=>$has_note,
        'curslanguage'=>$curslanguage
    /*'t2'=>$t2*/]);
    }
    
    
}
