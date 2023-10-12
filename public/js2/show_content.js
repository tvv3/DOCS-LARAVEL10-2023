function myfunction_close_cursuri(myid) {
    //alert(myid);
    let must_open=false;

    if (document.getElementById(myid).getAttribute("area-expanded")== "false")
    { must_open=true;}

    var elements2 = document.getElementsByClassName("mySidebarCollapse");//content-ul 
    for (var i = 0; i < elements2.length; i++) {
      //if (elements[i].parrent.id!=myid)
    {elements2[i].classList.remove("show");}

    }
    var elements = document.getElementsByClassName("mySidebarBtn-toggle");
    
    for (var i = 0; i < elements.length; i++) {
    elements[i].setAttribute("area-expanded", "false");
    //elements[i].addEventListener('click', myFunction2(elements[i].id));
};

    if (must_open==true)
    {
    document.getElementById(myid).setAttribute("area-expanded", "true");
    document.getElementById(myid+"-collapse").classList.add("show");
    }
}//if


function toggle_cursuri()
{
   let lista=document.getElementById("lista_cursuri");
   if (lista.style.display=="block") {lista.style.display="none";}
   else {lista.style.display="block"; }

}

function sterge_curs(form_id, curs_curs, curs_id)
{
  //"form_delete_curs_{{$curs->id}}"=>$form_id

  //alert(form_id);
  //alert(curs_curs);

  $ok=confirm("Sunteti sigur ca doriti sa stergeti cursul: "+curs_curs+" cu id-ul "+curs_id+" ?");
  if ($ok==true) 
  {
    document.getElementById(form_id).submit();
  }

}


function sterge_capitol(form_id, capitol_capitol, capitol_id)
{
  //"form_delete_capitol_{{$capitol->id}}"=>$form_id

  //alert(form_id);
  //alert(capitol_capitol);

  $ok=confirm("Sunteti sigur ca doriti sa stergeti capitolul: "+capitol_capitol+" cu id-ul "+capitol_id+" ?");
  if ($ok==true) 
  {
    document.getElementById(form_id).submit();
  }

}

function sterge_nota(form_id, nota_id)
{
  //"form_delete_nota_{{$nota->id}}"=>form_id

  $ok=confirm("Sunteti sigur ca doriti sa stergeti nota cu id-ul "+nota_id+" ?");
  if ($ok==true) 
  {
    document.getElementById(form_id).submit();
  }

}

function sterge_site(form_id, site_id)
{
  //"form_delete_site_{{$site->id}}"=>form_id

  $ok=confirm("Sunteti sigur ca doriti sa stergeti site-ul cu id-ul "+site_id+" ?");
  if ($ok==true) 
  {
    document.getElementById(form_id).submit();
  }

}