@extends('partiale.master')
@section('content')
<p class="d-flex m-5" style="flex-wrap:wrap;"><!--a href="/show_cursuri" class="nav-link nav-link-underlined" style="margin-right:20px;">
  Inapoi la cursuri</a-->
  <a href="/show_capitole/{{$capitol->curs_id}}" class="nav-link nav-link-underlined">
  Inapoi la capitole</a></p>

<h1 class="d-block text-center mt-5">Cursul {{$capitol->curs->curs}}</h1>
<h2 class="d-block text-center mt-5">
  Capitolul {{$capitol->capitol}} - Note </h2>

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
  <a class="btn btn-success mybtn-left" href="/creeaza_nota/{{$capitol->id}}">Creeaza nota noua</a>
</div>

<div class="table-responsive">
<table class="table table-hover mytable">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Cod</th>
      <th scope="col">Nota</th>
      <th scope="col">Nr ordine</th>
      <th scope="col">Editeaza</th>
      <th scope="col">Sterge</th>
    </tr>
  </thead>
  <tbody>
    @foreach($note as $nota)
    <tr>
      <th scope="row">{{$nota->id}}</th>
      <td>{{$nota->cod}}</td>
      <td>{{$nota->note}} </td>
      <td>{{$nota->nrord}}</td>
      <td><a class="btn btn-warning" href="{{route('edit_nota',$nota->id)}}">Editeaza</a></td>
      <td>
      <form action="/delete_nota/{{$nota->id}}" method="post" id="form_delete_nota_{{$nota->id}}">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" 
                  type="button" onclick="sterge_nota('form_delete_nota_{{$nota->id}}','{{$nota->id}}');">Sterge</button>
                </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection