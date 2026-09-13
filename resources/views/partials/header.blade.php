<header class="header" id="header">
    <div class="container">
        <nav class="navbar">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="navbar__logo">
                <img src="{{ asset('images/logo.svg') }}" alt="جسر الأمل" class="navbar__logo-img">
            </a>

            <!-- Navigation Links -->
            <ul class="navbar__menu" id="navMenu">
                <li><a href="{{ route('home') }}" class="navbar__link {{ request()->routeIs('home') ? 'navbar__link--active' : '' }}">الرئيسية</a></li>
                <li><a href="{{ route('about') }}" class="navbar__link {{ request()->routeIs('about') ? 'navbar__link--active' : '' }}">من نحن</a></li>
                <li><a href="{{ route('services.index') }}" class="navbar__link {{ request()->routeIs('services.*') ? 'navbar__link--active' : '' }}">الخدمات</a></li>
                <li><a href="{{ route('educational.index') }}" class="navbar__link {{ request()->routeIs('educational.*') ? 'navbar__link--active' : '' }}">المحتوى التوعوي</a></li>
                <li><a href="{{ route('contact') }}" class="navbar__link {{ request()->routeIs('contact') ? 'navbar__link--active' : '' }}">تواصل معنا</a></li>
            </ul>

            <!-- Header Actions -->
            <div class="navbar__actions">
                @auth
                    <div class="navbar__profile">
                        <button class="navbar__profile-trigger" id="profileTrigger" aria-label="الملف الشخصي">
                            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="navbar__profile-img">
                        </button>
                        <div class="navbar__dropdown" id="profileDropdown">
                            <ul class="navbar__dropdown-list">
                                @if (Auth::user()->isAdmin())
                                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>لوحة التحكم</span></a></li>
                                @endif
                                <li><a href="{{ route('profile') }}"><i class="fas fa-user"></i> <span>الصفحة الشخصية</span></a></li>
                                <li><a href="{{ route('orders.index') }}"><i class="fas fa-clipboard-list"></i> <span>الطلبات</span></a></li>
                                <li><a href="{{ route('advices.index') }}"><i class="fas fa-lightbulb"></i> <span>النصائح</span></a></li>
                                <li class="divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="display: none;">
                                        @csrf
                                    </form>
                                    <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                        <i class="fas fa-sign-out-alt"></i> <span>تسجيل الخروج</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn--primary">تسجيل الدخول</a>
                @endauth

                <button class="navbar__lang-btn" type="button">
                    <i class="fas fa-globe"></i>
                    <span>العربية</span>
                </button>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="navbar__toggle" id="navToggle" aria-label="القائمة">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    </div>
</header>
