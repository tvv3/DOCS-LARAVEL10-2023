@extends('partiale.master')
@section('content')
<p class="d-block m-5">
  <a href="/show_siteuri/{{$capitol->id}}" class="nav-link nav-link-underlined">Inapoi la site-uri</a>
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
<form class="myform" action="{{route('store_site')}}" method="post">
    @csrf
    

<div class="row  mb-3">
      <label for="capitol" class="col-sm-2 col-form-label">Capitol</label>
      <div class="col-sm-10">
        <input type="hidden" name="capitol_id" id="capitol_id" value="{{$capitol->id}}">
        <input type="text" readonly=true class="form-control" id="capitol" name="capitol" 
        value="{{$capitol->capitol}}">
       </div>
</div>
<div class="row  mb-3">
      <label for="site" class="col-sm-2 col-form-label">Site</label>
      <div class="col-sm-10">
      <input type="text" class="form-control" id="site" placeholder="Site" name="site" value="{{old('site')}}">
      </div>
</div>

<div class="row  mb-3">
      <label for="note" class="col-sm-2 col-form-label">Note</label>
      <div class="col-sm-10">
      <textarea class="form-control" id="note" name="note" rows="5">{{old('note')}}</textarea>
      </div>
</div>

<button type="submit" class="btn btn-primary"><span>Salveaza</span></button>


</form>

@endsection