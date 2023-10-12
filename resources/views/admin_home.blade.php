

@if(!empty(session('user')))

 @if (session('user')=='admin') 
 
 @include('partiale.admin_home1')
 @else

   <a href="/">Inapoi la pagina principala</a>

  @endif

@else

<a href="/">Inapoi la pagina principala</a>

@endif