<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Site;
use App\Models\Capitol;
use App\Models\Curs;
use Illuminate\Database\QueryException;
class SiteController extends Controller
{
    //
    public function creeaza_site(Capitol $capitol)
    {
        if (!$this->is_admin()) return redirect("/");

        return view('partiale.admin.creare_site',['capitol'=>$capitol]);
    }

    public function show_siteuri(Capitol $capitol)
    {
        if (!$this->is_admin()) return redirect("/");

        $siteuri=$capitol->siteuri;

        return view('partiale.admin.show_siteuri',['capitol'=>$capitol,'siteuri'=>$siteuri]);
    }

    public function store_site(Request $request)
    {
        if (!$this->is_admin()) return redirect("/");

        $request->validate([
            'site' => 'required|max:2000|url',
            'note' => 'required|max:2000',
        ]);
        
        $site = new Site();
 
        $site->capitol_id = $request->capitol_id;

        $site->site=$request->site;

        $site->note=$request->note;
 
         //de adaugat validate $site

        $site->save();

        return redirect('show_siteuri/'.$request->capitol_id);
    }
        //update

        public function edit_site(Site $site)
        {
            if (!$this->is_admin()) return redirect("/");
    
            return view('partiale.admin.edit_site',['site'=>$site]);
        }
    
        public function update_site(Request $request, Site $site)
        {
            if (!$this->is_admin()) return redirect("/");
            $request->validate([
                'site' => 'required|max:2000|url',
                'note' => 'required|max:2000',
            ]);
            //$capitol = Capitol::find($capitol->id); //cred ca nu trebuie se face cautarea automat 
     
            $site->capitol_id = $request->capitol_id;
    
            $site->site=$request->site;
    
            $site->note=$request->note;
    
           // $site->nrord=$request->nrord;
     
             //de adaugat validate $nota
    
            $salvat=true;
            try{
            $site->save();
            }
            catch (QueryException $e)
            {
              $salvat=false;
            };
            if ($salvat) return redirect('show_siteuri/'.$site->capitol_id)->with('success', 'Site-ul a fost modificat.');
            //else
            return redirect('show_siteuri/'.$site->capitol_id)->with('error', 'Site-ul NU a fost modificat.');
        }

    //delete
    public function delete_site(Site $site)
    {
        if (!$this->is_admin()) { return redirect("/");}

        $nume=$site->site;
        $capitol_id=$site->capitol_id;
        $deleted=true;
        try {
        $site->delete();
        
        }
        catch(QueryException $e)
        {
          $deleted=false;
        };

        if ($deleted) {session()->flash("success","Site-ul ".$nume." a fost sters cu succes!");}
        else {
            session()->flash("error","Eroare! Site-ul ".$nume." NU a fost sters!");
        }

        return redirect("show_siteuri/".$capitol_id);
    }
}
