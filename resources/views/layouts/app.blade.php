<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'My App')</title>

    {{-- Global CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- PAGE CONTENT --}}
    <main class="flex-grow flex items-center justify-center p-4">
        @yield('content')
    </main>

    {{-- GLOBAL JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>
</html>