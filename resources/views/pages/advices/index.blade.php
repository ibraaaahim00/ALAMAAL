@extends('layouts.app')

@section('title', 'جسر الأمل | النصائح')

@section('content')
    <!-- ============================================
         BREADCRUMB SECTION
    ============================================= -->
    <section class="page-header" id="page-header">
        <div class="container">
            <div class="breadcrumb breadcrumb--details">
                <a href="{{ route('home') }}">الرئيسية</a>
                <i class="fas fa-chevron-left"></i>
                <span class="active">النصائح</span>
            </div>
        </div>
    </section>

    <!-- ============================================
         ADVICES PAGE CONTENT
    ============================================= -->
    <section class="advices-section">
        <div class="container">
            <div class="advices-layout">
                <!-- Sidebar Filters -->
                <aside class="advices-sidebar">
                    <div class="filter-header">
                        <h2 class="filter-header__title">تصفية الفيديوهات</h2>
                        <a href="{{ route('advices.index') }}" class="filter-header__reset">إعادة تعيين</a>
                    </div>

                    <form id="adviceFilterForm" action="{{ route('advices.index') }}" method="GET">
                        @if (request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif
                        @if (request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <!-- Year Filter -->
                        <div class="filter-group">
                            <button type="button" class="filter-group__trigger active">
                                <span>السنة</span>
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <div class="filter-group__content">
                                @foreach ([2026, 2025, 2024, 2023, 2022] as $yr)
                                    <label class="custom-radio">
                                        <input type="radio" name="year" value="{{ $yr }}"
                                            {{ (request('year') == $yr || (!request('year') && $yr == 2026)) ? 'checked' : '' }}
                                            onchange="document.getElementById('adviceFilterForm').submit();">
                                        <span class="radio-mark"></span>
                                        <span class="radio-label">{{ $yr }} <span class="count">({{ $yearCounts[$yr] ?? 0 }})</span></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Month Filter -->
                        <div class="filter-group">
                            <button type="button" class="filter-group__trigger active">
                                <span>الشهر</span>
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <div class="filter-group__content">
                                @php
                                    $months = [
                                        'january' => 'يناير',
                                        'february' => 'فبراير',
                                        'march' => 'مارس',
                                        'april' => 'أبريل',
                                        'may' => 'مايو',
                                        'june' => 'يونيه',
                                        'july' => 'يوليو',
                                        'august' => 'أغسطس',
                                        'september' => 'سبتمبر',
                                        'october' => 'أكتوبر',
                                        'november' => 'نوفمبر',
                                        'december' => 'ديسمبر',
                                    ];
                                @endphp
                                @foreach ($months as $mKey => $mName)
                                    <label class="custom-radio">
                                        <input type="radio" name="month" value="{{ $mKey }}"
                                            {{ request('month') === $mKey ? 'checked' : '' }}
                                            onchange="document.getElementById('adviceFilterForm').submit();">
                                        <span class="radio-mark"></span>
                                        <span class="radio-label">{{ $mName }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </aside>

                <!-- Main Content Grid -->
                <div class="advices-content">
                    <div class="advices-header">
                        <form action="{{ route('advices.index') }}" method="GET" class="content-search" style="flex: 1; max-width: 400px;">
                            @if (request('year')) <input type="hidden" name="year" value="{{ request('year') }}"> @endif
                            @if (request('month')) <input type="hidden" name="month" value="{{ request('month') }}"> @endif
                            @if (request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث هنا ..." id="advicesSearchInput">
                            <i class="fas fa-search" onclick="this.closest('form').submit();" style="cursor: pointer;"></i>
                        </form>

                        <div class="content-sort">
                            <button class="sort-dropdown-btn" id="sortDropdownBtn" type="button">
                                @php
                                    $sortLabel = match(request('sort')) {
                                        'latest' => 'الأحدث',
                                        'oldest' => 'الأقدم',
                                        default => 'الكل'
                                    };
                                @endphp
                                <span>ترتيب حسب : {{ $sortLabel }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="sort-dropdown-menu" id="sortDropdownMenu">
                                <a href="{{ route('advices.index', array_merge(request()->except('sort'), ['sort' => 'all'])) }}" class="sort-option {{ !request('sort') || request('sort') === 'all' ? 'active' : '' }}" data-filter="all">الكل</a>
                                <a href="{{ route('advices.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}" class="sort-option {{ request('sort') === 'latest' ? 'active' : '' }}" data-filter="latest">الأحدث</a>
                                <a href="{{ route('advices.index', array_merge(request()->except('sort'), ['sort' => 'oldest'])) }}" class="sort-option {{ request('sort') === 'oldest' ? 'active' : '' }}" data-filter="oldest">الأقدم</a>
                            </div>
                        </div>
                    </div>

                    <div class="advices-grid">
                        @forelse ($advices as $advice)
                            <div class="content-card">
                                <div class="content-card__image">
                                    <img src="{{ $advice->thumbnail_url }}" alt="{{ $advice->title }}">
                                    <div class="content-card__play-icon">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                <div class="content-card__body">
                                    <h3 class="content-card__title">{{ $advice->title }}</h3>
                                    <p class="content-card__date">
                                        {{ $advice->published_at ? $advice->published_at->translatedFormat('d F, Y') : date('d F, Y') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #718096;">
                                <i class="fas fa-video-slash" style="font-size: 3rem; margin-bottom: 16px; color: #CBD5E1;"></i>
                                <p style="font-size: 1.25rem;">لا توجد نصائح وفيديوهات مطابقة للبحث أو الفلتر المختار.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($advices->hasPages())
                        <div class="pagination">
                            @if ($advices->onFirstPage())
                                <button class="pagination__btn pagination__btn--prev" disabled aria-label="السابق">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            @else
                                <a href="{{ $advices->previousPageUrl() }}" class="pagination__btn pagination__btn--prev" aria-label="السابق">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @endif

                            <div class="pagination__numbers">
                                @foreach ($advices->getUrlRange(1, $advices->lastPage()) as $page => $url)
                                    @if ($page == $advices->currentPage())
                                        <button class="pagination__number active">{{ $page }}</button>
                                    @else
                                        <a href="{{ $url }}" class="pagination__number">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </div>

                            @if ($advices->hasMorePages())
                                <a href="{{ $advices->nextPageUrl() }}" class="pagination__btn pagination__btn--next" aria-label="التالي">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @else
                                <button class="pagination__btn pagination__btn--next" disabled aria-label="التالي">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Cards Section -->
    @include('partials.trust-cards', ['bgClass' => 'bg-light'])

    <!-- Newsletter Section -->
    @include('partials.newsletter')
@endsection
