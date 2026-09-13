<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم | جسر الأمل')</title>

    <!-- Google Fonts: Beiruti -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Beiruti:wght@200..900&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__logo">
                <img src="{{ asset('images/logo.svg') }}" alt="جسر الأمل">
                <span>جسر الأمل</span>
            </a>

            <ul class="admin-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>الرئيسية والإحصائيات</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="admin-nav__link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>إدارة الطلبات</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.services.index') }}" class="admin-nav__link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span>إدارة الخدمات</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.educational.index') }}" class="admin-nav__link {{ request()->routeIs('admin.educational.*') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>المحتوى التوعوي</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.advices.index') }}" class="admin-nav__link {{ request()->routeIs('admin.advices.*') ? 'active' : '' }}">
                        <i class="fas fa-lightbulb"></i>
                        <span>إدارة النصائح</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.contact.index') }}" class="admin-nav__link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>رسائل التواصل</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.coupons.index') }}" class="admin-nav__link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>أكواد الخصم</span>
                    </a>
                </li>
                <li style="margin-top: auto; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <a href="{{ route('home') }}" class="admin-nav__link" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        <span>عرض الموقع</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Area -->
        <div class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <h1 style="font-size: 1.3rem; font-weight: 700; color: #1B4677;">@yield('header_title', 'لوحة التحكم')</h1>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <span style="color: #64748B; font-weight: 500;">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn--outline" style="padding: 6px 18px; font-size: 0.9rem;">
                            <i class="fas fa-sign-out-alt"></i> خروج
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                @include('partials.alerts')
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
