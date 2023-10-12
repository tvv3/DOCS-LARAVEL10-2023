
@if((!empty($nota_selectata))&&(!empty($site_selectat))
&&($has_site==true)&&($has_note==true))
<br>

<div class="mynota">
    

@if($nota_selectata->cod!='')
<span>Nota {{$nota_selectata->nrord}} -</span> &nbsp; <p>Codul:</p>
<div class="mycode">
<!--textarea class="form-control" id="cod" readonly rows="10"--><pre>
    <code  class="{{'language-'.$curslanguage}}">
{{$nota_selectata->cod}}</code></pre><!--/textarea-->       
</div>
@endif

@if($nota_selectata->note!='')
<span>Nota {{$nota_selectata->nrord}} -</span> &nbsp; <p>Explicatii:</p>
<div class="mynote">
 <!--textarea class="form-control" id="note" readonly rows="10" data-break-lines="60"-->
 <pre><code class="language-none">Nota:
{{$nota_selectata->note}}</code></pre><!--/textarea-->   
</div>
@endif

<br><br>
<div class="mybuttons">
@if(!empty($nota_anterioara))
<a class="btn" href="/visitor_home/capitol/{{$capitol_selectat->id}}/nota/{{$nota_anterioara->id}}/site/{{$site_selectat->id}}/note">
    <- Nota anterioara</a>
@else
<a class="btn" href="#" disabled><- Nota anterioara</a>
@endif

@if(!empty($nota_urmatoare))
<a class="btn" href="/visitor_home/capitol/{{$capitol_selectat->id}}/nota/{{$nota_urmatoare->id}}/site/{{$site_selectat->id}}/note">
    Nota urmatoare -></a>
@else
<a class="btn" href="#" disabled>Nota urmatoare -></a>
@endif
</div>

</div>
@endif

<!--capitolul are doar note -->
@if((!empty($nota_selectata))&&($has_site==false)&&($has_note==true))
<br>
<div class="mynota">
    <!--span>Nota {{$nota_selectata->nrord}}</span-->
@if($nota_selectata->cod!='')
<span>Nota {{$nota_selectata->nrord}} -</span> <p>Codul:</p>
<div class="mycode">
<!--textarea class="form-control" id="cod" readonly rows="10"-->
<pre><code class="{{'language-'.$curslanguage}}">
{{$nota_selectata->cod}}</code></pre><!--/textarea-->           
</div>
@endif
@if($nota_selectata->note!='')
<span>Nota {{$nota_selectata->nrord}} -</span> <p>Explicatii:</p>
<div class="mynote"><?php 
              /*$v=$nota_selectata->note;
              $val=Str::replace('<br>','',$v);
              if  ($val==e($val))
                 echo $v;
               else echo e($v);*/
?>
  <!--textarea class="form-control" id="note" readonly rows="10"-->
  <pre>
  <code class="language-none">Nota:
{{$nota_selectata->note}}</code></pre><!--/textarea--> 
    
</div>
@endif
<br><br>
<div class="mybuttons">
@if(!empty($nota_anterioara))
<a class="btn" href="/visitor_home/capitol/{{$capitol_selectat->id}}/nota/{{$nota_anterioara->id}}">
    <- Nota anterioara</a>
@else
<a class="btn" href="#" disabled><- Nota anterioara</a>
@endif

@if(!empty($nota_urmatoare))
<a class="btn" href="/visitor_home/capitol/{{$capitol_selectat->id}}/nota/{{$nota_urmatoare->id}}">
    Nota urmatoare -></a>
@else
<a class="btn" href="#" disabled>Nota urmatoare -></a>
@endif
</div>

</div>
@endif