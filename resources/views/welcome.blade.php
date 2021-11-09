<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Home | habaybna</title>
   </head>
   <body>
   <div id="app">
      <the-header></the-header>
      <router-view></router-view>
    </div>
   </body>
   <script src="{{mix('/js/app.js')}}"></script>
</html>

