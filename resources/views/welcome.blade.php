<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title>Home | habaybna</title>
    <meta property="og:image" content="/images/logo.png">
    <meta property="twitter:image:src" content="/images/logo.png">
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
    <!-- MailerLite Universal -->
    <script>
        (function(w, d, e, u, f, l, n) {
            w[f] = w[f] || function() {
                    (w[f].q = w[f].q || [])
                    .push(arguments);
                }, l = d.createElement(e), l.async = 1, l.src = u,
                n = d.getElementsByTagName(e)[0], n.parentNode.insertBefore(l, n);
        })
        (window, document, 'script', 'https://assets.mailerlite.com/js/universal.js', 'ml');
        ml('account', '255623');
    </script>
    <!-- End MailerLite Universal -->

</head>

<body>

    <div id="app">
        <main-app></main-app>
    </div>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>
<script src="{{ mix('/js/app.js') }}"></script>

</html>
