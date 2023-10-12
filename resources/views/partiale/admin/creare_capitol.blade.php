@extends('partiale.master')
@section('content')
<p class="d-block m-5">
  <a href="/show_capitole/{{$curs->id}}" class="nav-link nav-link-underlined">Inapoi la capitole</a>
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
<form class="myform" action="{{route('store_capitol')}}" method="post">
    @csrf
    

<div class="row  mb-3">
      <label for="curs" class="col-sm-2 col-form-label">Curs</label>
      <div class="col-sm-10">
      <input type="hidden" name="curs_id" id="curs_id" value="{{$curs->id}}">
      <input type="text" class="form-control" readonly="true"  name="curs" id="curs" value="{{$curs->curs}}">
      </div>
</div>

<div class="row  mb-3">
      <label for="capitol" class="col-sm-2 col-form-label">Capitol</label>
      <div class="col-sm-10">
        <input type="text"  class="form-control" id="capitol" placeholder="Capitol" name="capitol"
        value="{{old('capitol')}}"
        >
       </div>
</div>

<div class="row  mb-3">
      <label for="nrord" class="col-sm-2 col-form-label">Nr. ordine</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="nrord" placeholder="Numar de ordine" name="nrord"
        value="{{old('nrord')}}">
      </div>
</div>


<button type="submit" class="btn btn-primary"><span>Salveaza</span></button>


</form>

@endsection

