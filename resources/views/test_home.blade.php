@if(!empty(session('user')))

 @if (session('user')=='test') 
 
 @include('partiale.view_content')
 
@else

<a href="/">Inapoi la pagina principala</a>

@endif

@else

<a href="/">Inapoi la pagina principala</a>

@endif