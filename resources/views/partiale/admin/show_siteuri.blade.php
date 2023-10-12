@extends('partiale.master')
@section('content')
<p class="d-flex m-5" style="flex-wrap:wrap;"><!--a href="/show_cursuri" class="nav-link nav-link-underlined" style="margin-right:20px;">
  Inapoi la cursuri</a-->
  <a href="/show_capitole/{{$capitol->curs_id}}" class="nav-link nav-link-underlined">
  Inapoi la capitole</a></p>

<h1 class="d-block text-center mt-5">Cursul {{$capitol->curs->curs}}</h1>
<h2 class="d-block text-center mt-5">
  Capitolul {{$capitol->capitol}} - Site-uri</h2>

<br><br>
<div class="mymessages">
@if(session()->has("success"))
    <div class="alert alert-success">{{session("success")}}</div>
@endif

@if(session()->has("error"))
    <div class="alert alert-danger">{{session("error")}}</div>
@endif
</div>

@include("partiale.timer")

<div>
  <a class="btn btn-success mybtn-left" href="/creeaza_site/{{$capitol->id}}">Creeaza site nou</a>
</div>
<div class="table-responsive">
<table class="table table-hover mytable">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Site</th>
      <th scope="col">Note</th>
      <th scope="col">Viziteaza</th>
      <th scope="col">Editeaza</th>
      <th scope="col">Sterge</th>
    </tr>
  </thead>
  <tbody>
    @foreach($siteuri as $site)
    <tr>
      <th scope="row">{{$site->id}}</th>
      <td>{{$site->site}}</td>
      <td>{{$site->note}}</td>
      <td><a class="btn btn-success" href="{{$site->site}}">Viziteaza</a></td>
      <td><a class="btn btn-warning" href="{{route('edit_site',$site->id)}}">Editeaza</a></td>
      <td>
      <form action="/delete_site/{{$site->id}}" method="post" id="form_delete_site_{{$site->id}}">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" 
                  type="button" onclick="sterge_site('form_delete_site_{{$site->id}}', '{{$site->id}}');">Sterge</button>
                </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection