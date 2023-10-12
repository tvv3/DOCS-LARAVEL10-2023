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
use Illuminate\Validation\Rule;

class CursController extends Controller
{
    //
   
    public function creeaza_curs()
    {
        if (!$this->is_admin()) return redirect("/");

        return view('partiale.admin.creare_curs');
    }

    public function show_cursuri()
    {
        if (!$this->is_admin()) return redirect("/");
        $cursuri=Curs::all();
        return view('partiale.admin.show_cursuri',['cursuri'=>$cursuri]);
    }

    public function store_curs(Request $request)
    {
        if (!$this->is_admin()) return redirect("/");

        /*$request->validate([
            'curs' => 'required|unique:cursuri|max:100',
            'autor' => 'required|max:100',
            'language'=> 'required|in(["plsql","sql","php","js","html","css","csharp"])'
        ]);*/

       $validator= Validator::make($request->all(), [
            'curs' => ['required','max:100',Rule::unique('cursuri')],
            'autor' => 'required|max:100',
            'language'=> ['required', Rule::in(["none","plsql","sql","php","js","html","css","csharp"])],
        ]);

        if ($validator->fails()) {
            return redirect('creeaza_curs')
                        ->withErrors($validator)
                        ->withInput();
        }

        $curs = new Curs();
 
        $curs->curs = $request->curs;

        $curs->autor=$request->autor;
 
        $curs->language=$request->language;

         //de adaugat validate $curs

         $salvat=true;
         try{
         $curs->save();
         }
         catch (QueryException $e)
         {
           $salvat=false;
         };
         if ($salvat) return redirect('show_cursuri')->with('success','Cursul a fost creat cu succes.');

        return redirect('show_cursuri')->with('error','Eroare! Cursul nu a fost creat.');
    }

    //update

    public function edit_curs(Curs $curs)
    {
        if (!$this->is_admin()) return redirect("/");

        return view('partiale.admin.edit_curs',['curs'=>$curs]);
    }

    public function update_curs(Request $request, Curs $curs)
    {
        if (!$this->is_admin()) return redirect("/");

        //$curs = Curs::find($curs->id); //cred ca nu trebuie se face cautarea automat 
        /*$request->validate([
            'curs' => 'required|unique:cursuri|max:100',
            'autor' => 'required|max:100',
        ]);*/

        $validator= Validator::make($request->all(), [
            'curs' => ['required','max:100',Rule::unique('cursuri')->ignore($curs->id)],
            'autor' => 'required|max:100',
            'language'=> ['required', Rule::in(["none","plsql","sql","php","js","html","css","csharp"])],
        ]);

        if ($validator->fails()) {
            return redirect('/modifica_curs'.'/'.$curs->id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $curs->curs = $request->curs;

        $curs->autor=$request->autor;
 
        $curs->language=$request->language;
         //de adaugat validate $curs
        $salvat=true;
        try{
        $curs->save();
        }
        catch (QueryException $e)
        {
          $salvat=false;
        };
        if ($salvat) return redirect('show_cursuri')->with('success', 'Cursul a fost modificat.');
        //else
        return redirect('show_cursuri')->with('error', 'Cursul NU a fost modificat.');
    }

    //delete

    public function delete_curs(Curs $curs)
    {
        if (!$this->is_admin()) { return redirect("/");}

        $nume=$curs->curs;
        $deleted=true;
        try {
        $curs->delete();
        
        }
        catch(QueryException $e)
        {
          $deleted=false;
        };

        if ($deleted) {session()->flash("success","Cursul ".$nume." a fost sters cu succes!");}
        else {
            session()->flash("error","Eroare! Cursul ".$nume." NU a fost sters!");
        }

        return redirect("show_cursuri");
    }

    //search all courses

    public function search(Request $request)
    {
        if (!$this->is_logged()) return redirect("/");
        $this->validate($request, [
            'search_value' => 'required|min:3|max:255',
        ]);
        $request_search_value=strtolower($request->search_value);
        $cursuri=Curs::whereRaw('lower(curs) like "%'.$request_search_value.'%"')->get();
        $capitole=Capitol::whereRaw('lower(capitol) like "%'.$request_search_value.'%"')->get();
        $note=Nota::whereRaw('lower(note) like "%'.$request_search_value.'%"')
        ->orWhereRaw('lower(cod) like "%'.$request_search_value.'%"')
        ->with('capitol')->get();
        $siteuri=Site::whereRaw('lower(note) like "%'.$request_search_value.'%"')
        ->orWhereRaw('lower(site) like "%'.$request_search_value.'%"')->with('capitol')->get();
        return view('partiale.admin.show_search_results',['cursuri'=>$cursuri,'capitole'=>$capitole,
        'note'=>$note,'siteuri'=>$siteuri, 'search_val'=>$request->search_value]);        
    }
}
