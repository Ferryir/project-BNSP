<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Program Beasiswa BNSP 2026 - Daftar dan pantau status beasiswa Anda">
    <title>ProjectBNSP - Program Beasiswa</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex flex-col bg-[#f8f9fb]" style="font-family: 'Inter', sans-serif;">

    @include('components.navbar')
    <main class="flex-1">
        @yield('content')
    </main>
    @include('components.footer')

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>