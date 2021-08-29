<!DOCTYPE html>
<html lang="{{App::currentLocale()}}">
<head>
    <meta charset="UTF-8">
    <title>Twitch RPG</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    @stack('page_header')
</head>
<body>
@yield('body')
@stack('scripts')
</body>
</html>
