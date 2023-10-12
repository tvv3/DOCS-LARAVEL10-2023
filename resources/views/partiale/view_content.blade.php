

@extends('partiale.master')

@section('mypagecss')
    <link href="/css2/prism.css" rel="stylesheet" />
    <style>
        @media screen and (min-width:601px) {
         /* body{position:relative;height:100vh;}*/
        .mastermainpage{display:flex;flex-direction:column;height:100vh;position:relative;}
        header{display:block;}
        div.mypage{position:relative;flex-grow:1;}
        .aside1{width:280px;}
        .aside1, main{height:100%;}
        main{flex-grow:1;display:flex;flex-direction: column;}/*creste in width*/
        /*din main*/
        .mypage{display:flex;flex-wrap: nowrap;/*obligatoriu nowrap*/position:relative;
                  height:100%;
                flex-direction: row;}
        
        }
        main h1{text-align:center;}
       /* .mymainintro h1{padding:40px 20px 40px 20px};*//*corectie margine pt pagina initiala, cand nu este selectat nici un curs*/
        .aside1 li a.isactive{color:#8cc1a6 !important;} 
        @media screen and (max-width:600px) {
          .mastermainpage{display:flex;flex-direction:column;min-height:100vh;position:relative;}
        header{display:block;}
        div.mypage{display:flex;flex-direction:column;position:relative;flex-grow:1;}
        main{flex-grow:1;}       
        }
    </style>
    
@endsection
@section('content')

<!--script> alert('start page'); </script-->
<div class="mypage">

<div class="aside1 flex-shrink-0 p-3" >
    <span class="btn vezilistacursuribtn d-flex align-items-center justify-content-center 
    pb-3 mb-3 text-decoration-none border-bottom fs-5 fw-semibold" onclick=toggle_cursuri();>Vezi Cursurile</span>
    
    <ul class="list-unstyled ps-0" id="lista_cursuri">
        @foreach($cursuri as $curs)
      <li class="mb-1">
        @if($curs->id==$curs_id_selectat)
        <button class="btn btn-toggle active mySidebarBtn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
         data-bs-toggle="collapse" data-bs-target="#curs{{$curs->id}}-collapse"
         id="curs{{$curs->id}}"
         onclick="myfunction_close_cursuri(this.id);"
        area-expanded="false">
         @else
         <button class="btn btn-toggle mySidebarBtn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
         data-bs-toggle="collapse" data-bs-target="#curs{{$curs->id}}-collapse"
         id="curs{{$curs->id}}"
        area-expanded="false"
        onclick="myfunction_close_cursuri(this.id);"
        >
        @endif
         
          {{$curs->curs}}
        </button>
        @if($curs->id==$curs_id_selectat)
        <div class="collapse mySidebarCollapse" id="curs{{$curs->id}}-collapse"
        
        > <!--pt clasa afisata implicit se pune class="collapse show"-->
        @else
        <div class="collapse mySidebarCollapse" id="curs{{$curs->id}}-collapse"
        
        > <!--pt clasa afisata implicit se pune class="collapse show"-->
        @endif

        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            @foreach($curs->capitole as $key=>$capitol)
            @if($key==0)
            <li class="mb-1 mt-1"><a href="{{route('show_capitol_content', $capitol->id)}}" class="link-light d-inline-flex text-decoration-none rounded
              ">{{$capitol->capitol}}</a></li>
            @else
            <li class="mb-1"><a href="{{route('show_capitol_content', $capitol->id)}}" 
              class="link-light d-inline-flex text-decoration-none rounded
              ">{{$capitol->capitol}}</a></li>
            @endif  
            @endforeach
        </ul>
        </div>
      </li>
      <li class="border-top my-3"></li>
      @endforeach
    </ul>
  </div>

<!--end content offcanvas body-->  

<!--END MAIN DIV FROM ASIDE1-->


<main>
    
    @include("partiale.timer")

    @if(empty($capitol_selectat))
    <div class="mymainintro">
    <h1>Bine ai venit! <br><br> Alege un capitol din cadrul cursurilor din lista <br> pentru a vizualiza continutul acestuia!</h1> 
    </div>
    @else
      @include('partiale.view_content_main_info')

<!--end main info -->

       
    @endif
</main>
</div>
<!--?php
$t3=floor(microtime(true) * 1000);//miliseconds
echo '
<script> alert("end page'.($t3-$t2).'"); </script>';
?-->

@endsection

@section('mypagejs')

<script src="/js2/prism.js"></script>
@endsection