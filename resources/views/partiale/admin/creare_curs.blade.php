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
<form class="myform" action="{{route('store_curs')}}" method="post">
    @csrf
    
<div class="row  mb-3">
      <label for="curs" class="col-sm-2 col-form-label">Curs</label>
      <div class="col-sm-10">
        <input type="text"  class="form-control" id="curs" placeholder="Curs" name="curs" value="{{old('curs')}}">
       </div>
</div>

<div class="row  mb-3">
      <label for="autor" class="col-sm-2 col-form-label">Autor</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="autor" placeholder="Autor" name="autor" value="{{old('autor')}}">
      </div>
</div>

<div class="row  mb-3">
      <label for="language" class="col-sm-2 col-form-label">Limbaj</label>
      <div class="col-sm-10">
      <select class="form-select" id="language" size=1 name="language">
           <option selected>Alegeti limbajul</option>
           <option value="none" {{ ((old('language'))=='none') ? 'selected': '' }}>none</option>
           <option value="plsql" {{ ((old('language'))=='plsql') ? 'selected': '' }}>plsql</option>
           <option value="sql" {{ ((old('language')) =='sql') ? 'selected': '' }}>sql</option>
           <option value="php" {{ ((old('language')) =='php') ? 'selected': '' }}>php</option>
           <option value="html" {{ ((old('language')) =='html') ? 'selected': '' }}>html</option>
           <option value="css" {{ ((old('language'))=='css') ? 'selected': '' }}>css</option>
           <option value="js" {{ ((old('language'))=='js') ? 'selected': '' }}>js</option>
           <option value="csharp" {{ ((old('language'))=='csharp') ? 'selected': '' }}>csharp</option>
     
       </select>

    </div>
</div>


<button type="submit" class="btn btn-primary"><span>Salveaza</span></button>


</form>
@endsection