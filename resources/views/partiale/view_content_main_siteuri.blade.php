@if((!empty($nota_selectata))&&(!empty($site_selectat))&&($has_note==true)&&($has_site==true))
<br>
<div class="mysite">
<p>Site-ul:</p>
<div class="mywebsite"><!--textarea class="form-control" id="note_site" readonly rows="3"-->
<pre><code  class="language-url">
{{$site_selectat->site}}
</code></pre>
<!--/textarea-->
</div>
@if($site_selectat->note!='')
<p>Nota:</p>
<div class="mynote"><!--textarea class="form-control" id="note_site" readonly rows="10"-->
<pre><code class="language-none"> <!--plain text-->
{{$site_selectat->note}}
</code></pre>
<!--/textarea-->     
</div>
@endif
<br>
<a class="btn" href="{{$site_selectat->site}}">Viziteaza site-ul</a>
<br><br>
<div class="mybuttons">
@if(!empty($site_anterior))
<a class="btn" 
href="/visitor_home/capitol/{{$capitol_selectat->id}}/nota/{{$nota_selectata->id}}/site/{{$site_anterior->id}}/siteuri">
    <- Site anterior</a>
@else
<a class="btn" href="#" disabled><- Site anterior</a>
@endif

@if(!empty($site_urmator))
<a class="btn" 
href="/visitor_home/capitol/{{$capitol_selectat->id}}/nota/{{$nota_selectata->id}}/site/{{$site_urmator->id}}/siteuri">
    Site urmator -></a>
@else
<a class="btn" href="#" disabled>Site urmator -></a>
@endif
</div>
</div>
@endif

<!--doar cu siteuri-->
@if((!empty($site_selectat))&&($has_note==false)&&($has_site==true))
<br>
<div class="mysite">
<p>Site-ul:</p>
<div class="mywebsite">
<!--textarea class="form-control" id="note_site" readonly rows="3"-->
<pre><code  class="language-url">
{{$site_selectat->site}}
</code></pre>
<!--/textarea-->
</div>

@if($site_selectat->note!='')
<p>Nota:</p>
<div class="mynote"><!--textarea class="form-control" id="note_site" readonly rows="10"-->
<pre><code class="language-none">  <!--plain text -->
{{$site_selectat->note}}
</code></pre>
<!--/textarea-->   
          </div>
@endif
<br>
<a class="btn" href="{{$site_selectat->site}}">Viziteaza site-ul</a>
<br><br>
<div class="mybuttons">
@if(!empty($site_anterior))
<a class="btn" 
href="/visitor_home/capitol/{{$capitol_selectat->id}}/site/{{$site_anterior->id}}">
    <- Site anterior</a>
@else
<a class="btn" href="#" disabled><- Site anterior</a>
@endif

@if(!empty($site_urmator))
<a class="btn" 
href="/visitor_home/capitol/{{$capitol_selectat->id}}/site/{{$site_urmator->id}}">
    Site urmator -></a>
@else
<a class="btn" href="#" disabled>Site urmator -></a>
@endif
</div>
</div>
@endif
