<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Lara-Poll') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @inertiaHead
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900 text-black dark:text-white">
    @inertia
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/@chenfengyuan/vue-countdown@2"></script>
</body>

</html>
