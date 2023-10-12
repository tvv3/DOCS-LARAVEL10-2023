@extends('partiale.master')
@section('content')
<p class="d-block m-5">
  <a href="/show_cursuri" class="nav-link nav-link-underlined">Inapoi la cursuri</a>
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
<form class="myform" action="{{route('update_curs',$curs->id)}}" method="post">
    @csrf
    @method('PUT')
<div class="row  mb-3">
      <label for="curs" class="col-sm-2 col-form-label">Curs</label> 
      <div class="col-sm-10">
        <input type="text"  class="form-control" id="curs" placeholder="Curs" name="curs" value="{{ old('curs') ?? $curs->curs }}">
       </div>
</div>

<div class="row  mb-3">
      <label for="autor" class="col-sm-2 col-form-label">Autor</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="autor" placeholder="Autor" name="autor" value="{{ old('autor') ?? $curs->autor }}">
      </div>
</div>

<div class="row  mb-3">
      <label for="language" class="col-sm-2 col-form-label">Limbaj</label>
      <div class="col-sm-10">
      <select class="form-select" id="language" size=1 name="language">
           <option value="none" {{ ((old('language') ?? $curs->language ) =='none') ? 'selected': '' }}>none</option>
           <option value="plsql" {{ ((old('language') ?? $curs->language )=='plsql') ? 'selected': '' }}>plsql</option>
           <option value="sql" {{ ((old('language') ?? $curs->language ) =='sql') ? 'selected': '' }}>sql</option>
           <option value="php" {{ ((old('language') ?? $curs->language ) =='php') ? 'selected': '' }}>php</option>
           <option value="html" {{ ((old('language') ?? $curs->language ) =='html') ? 'selected': '' }}>html</option>
           <option value="css" {{ ((old('language') ?? $curs->language )=='css') ? 'selected': '' }}>css</option>
           <option value="js" {{ ((old('language') ?? $curs->language )=='js') ? 'selected': '' }}>js</option>
           <option value="csharp" {{ ((old('language') ?? $curs->language )=='csharp') ? 'selected': '' }}>csharp</option>
      </select>

    </div>
</div>

<button type="submit" class="btn btn-primary"><span>Modifica</span></button>

</form>
@endsection