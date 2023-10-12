@extends('partiale.master')
@section('content')
<p class="d-block m-5">
  <a href="/show_note/{{$nota->capitol->id}}" class="nav-link nav-link-underlined">Inapoi la note</a>
</p>
<br><br>
<div class="mymessages">
@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
</div>
<form class="myform" action="{{route('update_nota', $nota->id)}}" method="post">
    @csrf
    @method('PUT')

<div class="row  mb-3">
      <label for="capitol" class="col-sm-2 col-form-label">Capitol</label>
      <div class="col-sm-10">
        <input type="hidden" name="capitol_id" id="capitol_id" value="{{$nota->capitol->id}}">
        <input type="text" readonly=true class="form-control" id="capitol" name="capitol" 
        value="{{$nota->capitol->capitol}}">
       </div>
</div>
<div class="row  mb-3">
      <label for="cod" class="col-sm-2 col-form-label">Cod</label>
      <div class="col-sm-10">
      <textarea class="form-control" id="cod" name="cod" rows="5">{{old('cod')??$nota->cod}}</textarea>
      </div>
</div>

<div class="row  mb-3">
      <label for="note" class="col-sm-2 col-form-label">Note</label>
      <div class="col-sm-10">
      <textarea class="form-control" id="note" name="note" rows="5">{{old('note')??$nota->note}}</textarea>
      </div>
</div>

<div class="row  mb-3">
      <label for="nrord" class="col-sm-2 col-form-label">Nr. ordine</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="nrord" placeholder="Numar de ordine" name="nrord" 
        value="{{old('nrord')??$nota->nrord}}">
      </div>
</div>


<button type="submit" class="btn btn-primary"><span>Modifica</span></button>


</form>

@endsection