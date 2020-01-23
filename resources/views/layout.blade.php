<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Helmes')</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('app.scss') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="{{ asset('site.js') }}"></script>
</head>
<body>

<div class="container">
    @yield('content')
</div>

</body>
</html>
