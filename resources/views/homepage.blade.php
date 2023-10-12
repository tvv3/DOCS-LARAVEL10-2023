<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel 10 Cursuri</title>
        <link rel="stylesheet" href="{{asset('css2/bootstrap.css')}}">
       <link rel="stylesheet" href="{{asset('css2/main.css')}}">
    </head>
    <style>
      body{background-image:url( 
        "/imagini/andrew-neel-cckf4TsHAuw-unsplash2cut.jpg"); /*https://unsplash.com/photos/cckf4TsHAuw*/
  background-repeat:no-repeat;
  background-size:cover;
  background-attachment:fixed;/*obligatoriu fixed si fara position specificat*/
  background-color: #22333b;color:black;}
      </style>
    <body>
    <form action="/home" method="post" class="myform">
        @csrf
    <fieldset>
     <h1 class="pt-3 pb-3 titluHomePage">Platforma de cursuri</h1>
    <div class="form-group">
      <!--label for="pass1" class="form-label mt-4">Parola</label-->
      <input type="password" class="form-control text-center" id="pass1" placeholder="Parola" name="pass1">
      @if(!empty(session('errorMessage'))) <div class="invalid-feedback d-block text-center">{{session('errorMessage')}}</div> @endif
    </div>
    
    <button type="submit" class="btn btn-primary"><span>Conecteaza-te</span></button>
    </fieldset>
   </form>
   <script src="/js2/bootstrap.min.js"></script>
    </body>
    <html>