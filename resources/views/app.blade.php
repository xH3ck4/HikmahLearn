<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="API, HikmahLearn, FREEAPI, APIKEYS, APIDEV, APIINDONESIA, INDONESIA, APPLICATION PROGRAMMING INTERFACE, PREMIUM API, FREE API, API KEYS, API INDONESIA, API ID">
    <meta name="description" content="Hikmah-Learn | Platform API terlengkap untuk developer Indonesia. Dapatkan akses ke berbagai API premium dan gratis untuk kebutuhan pengembangan aplikasi Anda.">
    <meta property="og:title" content="Hikmah-Learn | API Untuk Developer Indonesia">
    <meta property="og:description" content="Platform API terlengkap untuk developer Indonesia. Dapatkan akses ke berbagai API premium dan gratis untuk kebutuhan pengembangan aplikasi Anda.">
    <meta property="og:image" content="{{asset('img/headerTitle.webp')}}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Hikmah-Learn | API Untuk Developer Indonesia">
    <meta name="twitter:description" content="Platform API terlengkap untuk developer Indonesia. Dapatkan akses ke berbagai API premium dan gratis untuk kebutuhan pengembangan aplikasi Anda.">
    <meta name="twitter:image" content="{{asset('img/headerTitle.webp')}}">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{asset('img/headerTitle.webp')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
      .rc-anchor-normal-footer {
          display: none !important;
      }
      .grecaptcha-badge { 
          visibility: hidden; 
      }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @inertiaHead
  </head>
  

  <body>
        @inertia
  </body>

  <script src="https://kit.fontawesome.com/a86445b340.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key={{env('VITE_MIDTRANS_CLIENT_KEY')}}></script>
  
  </html>