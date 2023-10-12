
<div class="titluri">
<h1 class="d-block text-center"><!--a href="#" class="nav-link"--> {{$capitol_selectat->curs->curs}}<!--/a--></h1>
<h2 class="d-block text-center mt-3"><!--a href="#" class="nav-link"-->
   {{$capitol_selectat->capitol}} <!--/a--></h2>
<br>
</div>

<div class="mymainmenu">

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="justify-content:center">
  <li class="nav-item" role="presentation">
    <button class="btn {{$status_note1}} mypills" id="pills-note-tab" data-bs-toggle="pill" data-bs-target="#pills-note"
     type="button" role="tab" aria-controls="pills-note" aria-selected="{{$status_note3}}" >Notele</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="btn {{$status_siteuri1}} mypills" id="pills-siteuri-tab" data-bs-toggle="pill" data-bs-target="#pills-siteuri"
     type="button" role="tab" aria-controls="pills-siteuri" aria-selected="{{$status_siteuri3}}" >Site-urile</button>
  </li>
</ul>

<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade {{$status_note2}} text-center" id="pills-note" role="tabpanel" aria-labelledby="pills-note-tab"
   tabindex="0">
     
     @include('partiale.view_content_main_note')
  </div>
  <div class="tab-pane fade {{$status_siteuri2}} text-center" id="pills-siteuri" role="tabpanel" aria-labelledby="pills-siteuri-tab"
   tabindex="0">
     
     @include('partiale.view_content_main_siteuri')

  </div>
 </div>
</div>
