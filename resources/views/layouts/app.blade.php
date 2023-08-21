<?php
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

// if $url contains 'rvm' then set $lang to 'rvm'
if (strpos(strtolower($url), 'rvm') !== false) {
    $img = 'signInLogoCallzy.jpg';
    $favicon = 'favicon.ico';
    $name = 'CALLZY';
} else if (strpos(strtolower($url), 'callzy') !== false) {
    $img = 'signInLogoCallzy.jpg';
    $favicon = 'favicon.ico';
    $name = 'CALLZY';
} else if (strpos(strtolower($url), 'voslogic') !== false) {
    $img = 'signInLogoVosLogic.jpg';
    $favicon = 'faviconVosLogic.ico';
    $name = 'Vos Logic';
}else{
    $img = 'signInLogoCallzy.jpg';
    $favicon = 'favicon.ico';
    $name = 'CALLZY';
}
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
   dir="{{ (Session::get('layout')=='rtl' ? 'rtl' : 'ltr') }}">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      {{-- Title Section --}}
      <title>{{$name}}  @yield('title', $pageTitle ?? '')
      </title>
      {{-- Meta Data --}}
      <meta name="description"
         content="@yield('page_description', $pageDescription ?? 'Bootstrap 4 Laravel Web Application')" />
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

      {{-- Fonts --}}
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
      {{-- Inject:css, Global Theme Styles (used by all pages) --}}
      @include('layouts.partials._styles')
      {{-- Includable CSS --}}
      @yield('styles')
      {{-- Endinject --}}
      <link rel="icon" href="{{ asset('img/'.$favicon) }}">
   </head>
   <style>
.rotate{
    -moz-transition: all 1s linear;
    -webkit-transition: all 1s linear;
    transition: all 1s linear;

}

.rotate.down{
    -moz-transform:rotate(360deg);
    -webkit-transform:rotate(360deg);
    transform:rotate(360deg);
    background-color:goldenrod;

}
.orderDatatable_actions{
    white-space: nowrap;
}
.orderDatatable_actions li {
    display:inline;
}
.orderDatatable_actions li a {
    display: inline-flex;
}
</style>
   <body class="layout-light side-menu @auth() overlayScroll @endauth">
      @auth()
      <div class="mobile-search"></div>
      <div class="mobile-author-actions"></div>
      @include('layouts.partials._header')
      @endauth
      <main class="main-content">
         @auth()
            @include('layouts.partials._aside')
         @endauth
         @section('content')
         @show
         @auth()
            @include('layouts.partials._footer')
         @endauth
      </main>
      @auth()
      <div id="overlayer">
         <span class="loader-overlay">
            <div class="atbd-spin-dots spin-lg">
               <span class="spin-dot badge-dot dot-primary"></span>
               <span class="spin-dot badge-dot dot-primary"></span>
               <span class="spin-dot badge-dot dot-primary"></span>
               <span class="spin-dot badge-dot dot-primary"></span>
            </div>
         </span>
      </div>
      @endauth
      <div class="overlay-dark-sidebar"></div>
      <div class="customizer-overlay"></div>
      {{-- Inject:js, Global Theme JS Bundle (used by all pages) --}}
      @yield('mapScript')
      @include('layouts.partials._scripts')
      {{-- Includable JS --}}
      @yield('scripts')
      {{-- Endinject --}}
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/json-editor/2.5.3/jsoneditor.js" integrity="sha512-hODhrh3TxcDblde1Z9bVWLZ3u+/DeQpAeS7idaKjpCms8iyzagGHFGewnpk1VKuyvp5gwCv0xf+wr8E3C7l44Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script type="text/javascript" src="{{ asset('js/flash.js') }}"></script>
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-WCTRNV8');</script>
      <!-- End Google Tag Manager -->


      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCTRNV8"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
   </body>
</html>
