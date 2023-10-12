@extends('partiale.master')
@section('content')

<p class="d-block m-5">
  <a href="/show_cursuri" class="nav-link nav-link-underlined">Inapoi la cursuri</a>
</p>

<h1 class="d-block text-center mt-5">
  Capitolele cursului {{$curs->curs}}
</h1>

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
  <a class="btn btn-success mybtn-left" href="/creeaza_capitol/{{$curs->id}}">Creeaza capitol nou</a>
</div>
<div class="table-responsive">
<table class="table table-hover mytable">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Capitol</th>
      <th scope="col">Nr ordine</th>
      <th scope="col">Note</th>
      <th scope="col">Site-uri</th>
      <th scope="col">Editeaza</th>
      <th scope="col">Sterge</th>
    </tr>
  </thead>
  <tbody>
    @foreach($capitole as $capitol)
    <tr>
      <th scope="row">{{$capitol->id}}</th>
      <td>{{$capitol->capitol}}</td>
      <td>{{$capitol->nrord}}</td>
      <td><a class="btn btn-success" href="/show_note/{{$capitol->id}}">Notele</a></td>
      <td><a class="btn btn-success" href="/show_siteuri/{{$capitol->id}}">Site-urile</a></td>
      <td><a class="btn btn-warning" href="{{route('edit_capitol',$capitol->id)}}">Editeaza</a></td>
      <td><form action="/delete_capitol/{{$capitol->id}}" method="post" id="form_delete_capitol_{{$capitol->id}}">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger"
                  type="button" onclick="sterge_capitol('form_delete_capitol_{{$capitol->id}}','{{$capitol->capitol}}', '{{$capitol->id}}');">Sterge</button>
                </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection