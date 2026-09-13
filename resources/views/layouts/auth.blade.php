<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="جسر الأمل لذوي الاحتياجات الخاصة">
    <title>@yield('title', 'جسر الأمل')</title>

    <!-- Google Fonts: Beiruti -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Beiruti:wght@200..900&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="auth-page" id="@yield('page_id')">

    <div class="auth-overlay"></div>

    <!-- Language Toggle -->
    <div class="auth-lang">
        <button class="navbar__lang-btn" type="button">
            <i class="fas fa-globe"></i>
            <span>العربية</span>
        </button>
    </div>

    <main class="auth-container">
        @yield('content')
    </main>

    <!-- Main JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
