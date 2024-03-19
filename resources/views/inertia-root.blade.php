<!DOCTYPE html>
<html
    lang="en"
    dir="ltr"
    class="light-style"
    data-theme="theme-default"
    data-assets-path="/assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="{{asset('web/assets/img/favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body>
    @inertia
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
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
</body>
</html>
