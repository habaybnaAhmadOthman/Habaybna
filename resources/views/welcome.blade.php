<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
      {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
      <title>Home | habaybna</title>
      <style>
         /* @font-face {
            font-family: "Almarai Bold";
            src: url("/../../../public/fonts/Almarai-Bold.woff2") format("woff2"),
               url("./../../public/fonts/Almarai-Bold.woff") format("woff");
            font-weight: bold;
            font-style: normal;
            font-display: swap;
         }

         @font-face {
            font-family: "Almarai Regular";
            src: url("/../../public/fonts/Almarai-Regular.woff2") format("woff2"),
            url("./../../public/fonts/Almarai-Regular.woff") format("woff");
            font-weight: normal;
            font-style: normal;
            font-display: swap;
         } */
      </style>

   </head>
   <body>

   <div id="app">
      <main-app></main-app>
    </div>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
   </body>
   <script src="{{mix('/js/app.js')}}"></script>
</html>
