<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="جسر الأمل لذوي الاحتياجات الخاصة - نهتم بتوفير الدعم اللازم لذوي الاحتياجات الخاصة في مجال اضطراب طيف التوحد ومتلازمة داون">
    <title>@yield('title', 'جسر الأمل | لذوي الاحتياجات الخاصة')</title>

    <!-- Google Fonts: Beiruti -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Beiruti:wght@200..900&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>

<body class="@yield('body_class')">

    @include('partials.header')

    <main>
        @if (!request()->routeIs('home'))
            <div class="container" style="margin-top: 15px;">
                @include('partials.alerts')
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Main JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
