<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Nota;
use App\Models\Capitol;
use App\Models\Curs;
use Illuminate\Database\QueryException;
class NotaController extends Controller
{
    //
    public function creeaza_nota(Capitol $capitol)
    {
        if (!$this->is_admin()) return redirect("/");

        return view('partiale.admin.creare_nota',['capitol'=>$capitol]);
    }

    public function show_note(Capitol $capitol)
    {
        if (!$this->is_admin()) return redirect("/");

        $note=$capitol->note;

        return view('partiale.admin.show_note',['capitol'=>$capitol,'note'=>$note]);
    }

    public function store_nota(Request $request)
    {
        if (!$this->is_admin()) return redirect("/");
        $request->validate([
            'note' => 'required|max:2000',
            'cod' => 'nullable|max:2000',
            'nrord' => 'required|numeric|integer',
        ]);
        $nota = new Nota();
 
        $nota->capitol_id = $request->capitol_id;

        $nota->cod=$request->cod;

        $nota->note=$request->note;

        $nota->nrord=$request->nrord;
 
         //de adaugat validate $curs

        $nota->save();

        return redirect('show_note/'.$request->capitol_id);
    }
    

    //update

    public function edit_nota(Nota $nota)
    {
        if (!$this->is_admin()) return redirect("/");

        return view('partiale.admin.edit_nota',['nota'=>$nota]);
    }

    public function update_nota(Request $request, Nota $nota)
    {
        if (!$this->is_admin()) return redirect("/");

        //$capitol = Capitol::find($capitol->id); //cred ca nu trebuie se face cautarea automat 
        $request->validate([
            'note' => 'required|max:2000',
            'cod' => 'nullable|max:2000',
            'nrord' => 'required|numeric|integer',
        ]);

        $nota->capitol_id = $request->capitol_id;

        $nota->cod=$request->cod;

        $nota->note=$request->note;

        $nota->nrord=$request->nrord;
 
         //de adaugat validate $nota

        $salvat=true;
        try{
        $nota->save();
        }
        catch (QueryException $e)
        {
          $salvat=false;
        };
        if ($salvat) return redirect('show_note/'.$nota->capitol_id)->with('success', 'Nota a fost modificata.');
        //else
        return redirect('show_note/'.$nota->capitol_id)->with('error', 'Nota NU a fost modificata.');
    }


    //delete
    public function delete_nota(Nota $nota)
    {
        if (!$this->is_admin()) { return redirect("/");}

        $nr=$nota->id;
        $capitol_id=$nota->capitol_id;
        $deleted=true;
        try {
        $nota->delete();
        
        }
        catch(QueryException $e)
        {
          $deleted=false;
        };

        if ($deleted) {session()->flash("success","Nota cu id-ul ".$nr." a fost stearsa cu succes!");}
        else {
            session()->flash("error","Eroare! Nota cu id-ul ".$nr." NU a fost stearsa!");
        }

        return redirect("show_note/".$capitol_id);
    }
}
