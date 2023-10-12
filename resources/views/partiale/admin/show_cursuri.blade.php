@extends('partiale.master')
@section('content')
<h1 class="d-block text-center mt-5">Cursurile</h1>

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
  <a class="btn btn-success mybtn-left" href="/creeaza_curs">Creeaza curs nou</a>
</div>
<div class="d-block">
<div class="table-responsive">
<table class="table table-hover mytable">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Curs</th>
      <th scope="col">Autor</th>
      <th scope="col">Limbaj</th>
      <th scope="col">Capitole</th>
      <th scope="col">Editeaza</th>
      <th scope="col">Sterge</th>
    </tr>
  </thead>
  <tbody>
    @foreach($cursuri as $curs)
    <tr>
      <th scope="row">{{$curs->id}}</th>
      <td>{{$curs->curs}}</td>
      <td>{{$curs->autor}}</td>
      <td>{{$curs->language}}</td>
      <td><a class="btn btn-success" href="/show_capitole/{{$curs->id}}">Capitolele</a></td>
      <td><a class="btn btn-warning" href="{{route('edit_curs',$curs->id)}}">Editeaza</a></td>
      <td>
      <form action="/delete_curs/{{$curs->id}}" method="post" id="form_delete_curs_{{$curs->id}}">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="button" onclick="sterge_curs('form_delete_curs_{{$curs->id}}','{{$curs->curs}}', '{{$curs->id}}');">Sterge</button>
                </form>
     </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>
@endsection