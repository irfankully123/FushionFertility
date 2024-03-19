<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>@yield('title')</title>
    <link type="image/x-icon" href="{{ asset('web/assets/img/favicon.png') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('web/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/assets/css/style.css') }}">
<style>
.doctors-wrapper{height:100vh;margin-bottom:100px}.date{border-radius:30px;background-image:linear-gradient(to right,#3caf98,#3978b9);color:#fff;font-weight:600}@media screen and (max-width:768px){.date{border-radius:12%;font-size:16.5px!important}}@media screen and (max-width:480px){.date{border-radius:10%;font-size:12.5px!important}}.zoom-btn:disabled,.zoom-btn[disabled]{opacity:.4}
.table-main{height:100vh!important}@media only screen and (max-width:762px){.mobile-menu{display:block!important}.logo{width:50%!important;margin-left:auto!important;margin-right:auto!important}}@media only screen and (min-width:767px){.mobile-menu{display:none!important}}.mobile-logout{position:absolute;bottom:0;width:100%;margin-bottom:3%}@media screen and (max-width:992px){.table-main{height:auto!important}.table-wrapper table tbody tr{background:rgba(255,255,255,.2);box-shadow:0 8px 32px 0 rgba(31,38,135,.37);border-radius:10px;border:1px solid rgba(255,255,255,.18);margin:20px 10px}.table-wrapper table tbody,.table-wrapper table thead,.table-wrapper table tr{display:block}.table-wrapper table thead tr{position:absolute;top:-9999px;left:-9999px}.table-wrapper table tbody tr td{display:block;border:none;position:relative;padding-left:50%;text-align:left}.table-wrapper table tbody tr td:before{position:absolute;top:6px;left:6px;width:45%;padding-right:10px;white-space:nowrap;font-weight:700}.section-search{background-image:url('{{ asset('web/assets/img/mobile-banner.png') }}');background-size:100%;background-repeat:no-repeat;background-position:-3px 225px;height:600px}}@media screen and (max-width:525px){.section-search{background-size:85%!important;background-position:50% 225px}}@media screen and (max-width:992px){.section-search{background-size:55%;background-position:50% 225px}}@media screen and (max-width:750px){.section-search{background-size:70%;background-position:50% 225px}}.loader-mask{position:fixed;top:0;left:0;right:0;bottom:0;background-color:#fff;z-index:99999}.loader,.loader div{display:inline-block;position:absolute;width:100px;height:100px}.loader{left:50%;top:50%;font-size:0;color:#6edac3;margin:-45px 0 0 -45px;text-indent:-9999em;-webkit-transform:translateZ(0);-ms-transform:translateZ(0);transform:translateZ(0)}.lead{font-size:13px}.loader div{background-color:#6edac3;float:none;top:0;left:0;opacity:.5;border-radius:50%;-webkit-animation:2s ease-in-out infinite ballPulseDouble;animation:2s ease-in-out infinite ballPulseDouble}.loader div:last-child{-webkit-animation-delay:-1s;animation-delay:-1s}@-webkit-keyframes ballPulseDouble{0%,100%{-webkit-transform:scale(0);transform:scale(0)}50%{-webkit-transform:scale(1);transform:scale(1)}}@keyframes ballPulseDouble{0%,100%{-webkit-transform:scale(0);transform:scale(0)}50%{-webkit-transform:scale(1);transform:scale(1)}}@media screen and (max-width:950px){.footer-logo img{width:250px!important}}.doctor-heading{position:relative}.doctor-heading::after{position:absolute;content:'';width:65px;height:6px;background:#09dca4;bottom:-10px;left:40%}.vector{width:700px}@media screen and (min-width:1100px){#specialities-heading{position:relative;top:70px}#specialities-paragraph,.fa-quote-left{position:relative;top:80px}}
.bg-1,.page-title{position:relative}.page-title{padding:120px 0 70px}.overlay:before{content:"";position:absolute;left:0;top:0;bottom:0;right:0;width:100%;height:100%;opacity:.9;background:#223a66}.bg-1{background:url("{{ asset("web/assets/img/blog-banner.jpg") }}") 50% 50%/cover no-repeat}.page-title .block h1{color:#fff}
.line-div{position:relative;}.line-div::before{position:absolute;content:'';top:50px; left:-2px; width:6px; height: 2px; background: black;}
</style>

</head>

<body>
    @yield('condition')
    @if ($preloader === true)
        <div class="loader-mask">
            <div class="loader">
                <div></div>
                <div></div>
            </div>
        </div>
    @endif
    <div class="main-wrapper">
        @include('web.rating')
        @include('web.Layout.header')
        @yield('content')
        @include('web.Layout.footer')
    </div>
    <script src="{{ asset('web/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('web/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/assets/js/slick.js') }}"></script>
    <script src="{{ asset('web/assets/js/script.js') }}"></script>
    <script>
    fetch('{{  route('set.timezone')  }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token
        },
        body: JSON.stringify({
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone // Get the client's timezone using JavaScript
        })
    })
        .then(response => response.json())
        .then(data => {
            // Handle the AJAX response
            console.log(data);
        })
        .catch(error => {
            // Handle any errors
            console.log(error);
        });
   </script>
    @if ($preloader === true)
        <script>
            $(window).on("load", function() {
                $(".loader").fadeOut(700), $(".loader-mask").delay(500).fadeOut("slow")
            });
        </script>
    @endif
</body>

</html>
