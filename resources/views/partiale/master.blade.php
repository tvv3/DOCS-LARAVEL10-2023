
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!--script type="text/javascript">
            let timerStart = Date.now();
        </script-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel 10 Cursuri</title>
       <link rel="stylesheet" href="{{asset('css2/bootstrap.css')}}">
       <link rel="stylesheet" href="{{asset('css2/main.css')}}">
        @yield('mypagecss')
    </head>
    <body onload="startCountdown()">
    <div class="mastermainpage">
    <header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light">
  <div class="container-fluid">
    <!--a class="navbar-brand" href="/">Logare</a-->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">Meniu</span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02" style="flex-direction:column!important;">
      
      <ul class="navbar-nav" style="width:100%">
         
        <li class="nav-item">
          <a class="nav-link" href="/myhome">Acasa
          </a>
        </li>
        <li class="nav-item">
          <!--myNavSpan-->
        <span class="nav-link text-success" style="display:inline-block">Sunteti logat ca<?php 
          $usr123=username_for_master_view(session('user')); 
          echo " ".$usr123;
          if ($usr123=="neautorizat") 
          {
            //return_to_homepage("User neautorizat");
            ?>
            <script>window.location = "{{ route('/') }}";</script>
            <?php
            exit();
          }
          ?>
         </span>
        </li>
         
         <div class="endingnav">
      <li class="nav-item">
      <form class="d-flex"
       action="{{route('search')}}" method="get">
        <!--@csrf-->
         <!--div class="d-flex" style="flex-direction:column;"-->  
        <input class="form-control me-sm-2 @error('search_value') is-invalid @enderror"
         type="text" placeholder="Cauta" name="search_value"
         id="search_value">
          <!--/div-->
        <!--button class="btn btn-light my-2 my-sm-0" type="submit" id="search-btn-nav">Cauta</button-->
      </form>
        </li>
        <li class="nav-item">
      <form  action="{{route('logout')}}" method="get">
        <button class="btn btn-light my-2 my-sm-0" type="submit">Logout</button>
      </form>
        </li>
        </div>
        
      </ul>
      <!--/div> dblock 1-->
      
        @error('search_value')
        <div class="invalid-feedback d-block">{{$message}}</div>
        @enderror 
        
  </div>
</div>
</nav>
</header>
    
     @yield('content')
     </div>
     <!--div onload="myalert();">Hello Div</div-->

     <script src="{{asset('js2/bootstrap.min.js')}}"></script>
     <script src="{{asset('js2/show_content.js')}}"></script>
     @yield('mypagejs')
     <!--script>

function myfunction_close_cursuri(myid) {
    //alert(myid);
    let must_open=false;

    if (document.getElementById(myid).getAttribute("area-expanded")== "false")
    { must_open=true;}

    var elements2 = document.getElementsByClassName("mySidebarCollapse");//content-ul 
    for (var i = 0; i < elements2.length; i++) {
      //if (elements[i].parrent.id!=myid)
    {elements2[i].classList.remove("show");}

    }
    var elements = document.getElementsByClassName("mySidebarBtn-toggle");
    
    for (var i = 0; i < elements.length; i++) {
    elements[i].setAttribute("area-expanded", "false");
    //elements[i].addEventListener('click', myFunction2(elements[i].id));
};

    if (must_open==true)
    {
    document.getElementById(myid).setAttribute("area-expanded", "true");
    document.getElementById(myid+"-collapse").classList.add("show");
    }
}//if


</script-->

   
    
    <script>
   
  // addEventListener('DOMContentLoaded', (event) => { alert('hello');});

   function myalert(){alert("mypage message");}

    /*  alert('unu');
      function myfunction_load()
{
let loadTime = window.performance.timing.domContentLoadedEventEnd- window.performance.timing.navigationStart;
alert("timp"+loadTime+"timp2 "+  (Date.now()-timerStart));
console.log(window.performance.timing);
}

if (document.getElementById('pills-note-tab').readyState == 'complete') {
    alert('complete1');
   // myfunction_load();
} else {
  document.getElementById('pills-note-tab').onreadystatechange = function () {
        if (document.readyState === "complete") {
           //alert(document.readyState);
           //alert(document.getElementById('pills-note-tab').innerHTML);
           myfunction_load();
        }
    };
  }
  */
</script>

<script>
let warningTimeout = 5*60*1000; //5 minute; 1sec=1000milisecunde
  let warningTimerID;
  let counterDisplay = document.getElementById('numCount');
  logoutUrl = "/logout";

  function startTimer() {
    // window.setTimeout returns an ID that can be used to start and stop the timer
    warningTimerID = window.setTimeout(idleLogout, warningTimeout);
    animate(counterDisplay, 5, 0, warningTimeout);
  }
    //function for resetting the timer
  function resetTimer() {
    window.clearTimeout(warningTimerID);
    startTimer();
  }

  // Logout the user.
  function idleLogout() {
    window.location = logoutUrl;
  }

  function startCountdown() {
    //document.addEventListener("mousemove", resetTimer);
    document.addEventListener("mousedown", resetTimer);
    document.addEventListener("keypress", resetTimer);
   // document.addEventListener("touchmove", resetTimer);
   // document.addEventListener("onscroll", resetTimer);
   // document.addEventListener("wheel", resetTimer);
    startTimer();
  }
   //the animating function
      function animate(obj, initVal, lastVal, duration) {

        let startTime = null;

        //get the current timestamp and assign it to the currentTime variable

        let currentTime = Date.now();

        //pass the current timestamp to the step function

        const step = (currentTime ) => {

        //if the start time is null, assign the current time to startTime

            if (!startTime) {
            startTime = currentTime ;
            }

        //calculate the value to be used in calculating the number to be displayed

            const progress = Math.min((currentTime  - startTime) / duration, 1);

        //calculate what is to be displayed using the value gotten above

            displayValue = Math.floor(progress * (lastVal - initVal) + initVal);
            obj.innerText = displayValue;

        //checking to make sure the counter does not exceed the last value(lastVal)

            if (progress < 1) {
                window.requestAnimationFrame(step);
            }else{
                window.cancelAnimationFrame(window.requestAnimationFrame(step));
            }
        };

        //start animating
        window.requestAnimationFrame(step);
    }
</script>
</body>
</html>