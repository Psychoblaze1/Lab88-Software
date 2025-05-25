<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>@yield('title', str_replace('_',' ', config('app.name')))</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>

<body class="">
    <div id="app"></div>

    <noscript>
        <strong>
            We're sorry but this application doesn't work properly without JavaScript
            enabled. Please enable it to continue.
        </strong>
    </noscript>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>

</html>