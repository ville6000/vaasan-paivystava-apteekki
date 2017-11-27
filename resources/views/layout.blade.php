<!doctype html>
<html lang="fi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Vaasan päivystävä apteekki</title>
    <meta name="description" content="Vaasan päivystävä apteekki">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lora:400,700|Ubuntu:700" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/normalize.css') }}" />
    <link rel="stylesheet" href="{{ url('css/main.css') }}" />
</head>
<body>

<main class="main-content">
    @yield('content')
</main>

<script>
    window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
    ga('create', '<?php echo env('ANALYTICS'); ?>','auto');ga('send','pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>
</html>