<?php
/*function excerpt3($sir, $key) ---- am pus-o in app/helpers.php https://www.tutsmake.com/laravel-9-create-custom-helper-functions-example/
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
}*/


?>


@extends('partiale.master')
@section('mypagecss')
<style>
    body{display:flex;flex-direction:column;min-height:100vh;}
    header{min-width:100vw;}
    
</style>
@endsection
@section('content')



<div class="mysearchresultspage">
@include("partiale.timer")
<h1>Rezultatele cautarii cuvantului <text class="search_result_keyword">{{$search_val}}</text></h1>
<br>
@if(!($cursuri->count()==0))
<h2>Cursuri:</h2>
    <div>
        <ul>
    @foreach($cursuri as $curs)
    <li><a href="{{route('visitor_home')}}">{{$curs->curs}}</a> <br>
    </li>
    @endforeach
        </ul>
    <br>
    </div>
@endif
@if(!($capitole->count()==0))
<h2>Capitole:</h2>
    <div>
    <ul>
    @foreach($capitole as $capitol)
    <li>
    <a href="{{route('show_capitol_content',$capitol->id)}}">{{$capitol->curs->curs}}/{{$capitol->capitol}}</a> <br>
    </li>
    @endforeach
</ul>
    <br>
    </div>
@endif
@if(!($note->count()==0))
<h2>Note:</h2>
    <div>
    <ul>
    @foreach($note as $nota)
    <li>
    @if($nota->capitol->siteuri->count()==0)
    <a href="{{route('show_capitol_content_with_nota_and_no_site',
        ['capitol'=>$nota->capitol->id,'nota'=>$nota->id])}}">
        {{$nota->capitol->curs->curs}}/{{$nota->capitol->capitol}}/Nota {{$nota->nrord}}</a> <br>
    
    @else
    <a href="{{route('show_capitol_content_with_nota_and_site',
        ['capitol'=>$nota->capitol->id,'nota'=>$nota->id,
         'site'=>$nota->capitol->siteuri->first()->id,
         'tab'=>'note'])}}">
        {{$nota->capitol->curs->curs}}/{{$nota->capitol->capitol}}/Nota {{$nota->nrord}}</a> <br>
    @endif
    </li>
    <div class="search_rezult_cod"><text>Cod:</text> {{excerpt3($nota->cod, $search_val)}}</div>
    <div class="search_rezult_nota"><text>Note:</text> {{excerpt3($nota->note, $search_val)}}</div>
  
    @endforeach
    </ul>
    <br>
    </div>
@endif
@if(!($siteuri->count()==0))
<h2>Siteuri:</h2>
    <div>
    <ul>
    @foreach($siteuri as $site)
    <li>
    @if($site->capitol->note->count()==0)
    <a href="{{route('show_capitol_content_with_site',
        ['capitol'=>$site->capitol->id, 'site'=> $site->id])}}">
        {{$site->capitol->curs->curs}}/{{$site->capitol->capitol}}/Site {{$site->id}}</a> <br>
    @else
    <a href="{{route('show_capitol_content_with_nota_and_site',
        ['capitol'=>$site->capitol->id, 'nota'=> $site->capitol->note->first()->id,
         'site'=> $site->id, 'tab'=>'siteuri'])}}">
        {{$site->capitol->curs->curs}}/{{$site->capitol->capitol}}/Site {{$site->id}}</a> <br>
    @endif
    </li>
    <div class="search_rezult_site"><text>Site:</text> {{excerpt3($site->site, $search_val)}}</div>
    <div class="search_rezult_nota"><text>Note:</text> {{excerpt3($site->note, $search_val)}}</div>
    @endforeach
    </ul>
    </div>
@endif
</div>

@endsection