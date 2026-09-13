@extends('layouts.app')

@section('title', 'جسر الأمل | المحتوى التوعوي')

@section('content')
    <!-- ============================================
         PAGE HEADER SECTION
    ============================================= -->
    <section class="page-header" id="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">الرئيسية</a>
                <i class="fas fa-chevron-left"></i>
                <span>المحتوى التوعوي</span>
            </div>
        </div>
    </section>

    <!-- ============================================
         EDUCATIONAL CONTENT GRID
    ============================================= -->
    <section class="educational-content" id="educational-content">
        <div class="container">
            <!-- Actions Bar: Search and Sort -->
            <div class="content-actions">
                <form action="{{ route('educational.index') }}" method="GET" class="content-search">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث هنا ..." id="contentSearchInput">
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                </form>

                <div class="content-sort">
                    <button class="sort-dropdown-btn" id="sortDropdownBtn" type="button">
                        @php
                            $catLabel = match(request('category')) {
                                'autism' => 'التوحد',
                                'down' => 'متلازمة داون',
                                default => 'الكل'
                            };
                        @endphp
                        <span>ترتيب حسب : {{ $catLabel }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="sort-dropdown-menu" id="sortDropdownMenu">
                        <a href="{{ route('educational.index', array_merge(request()->except('category'), ['category' => 'all'])) }}" class="sort-option {{ !request('category') || request('category') === 'all' ? 'active' : '' }}" data-filter="all">الكل</a>
                        <a href="{{ route('educational.index', array_merge(request()->except('category'), ['category' => 'autism'])) }}" class="sort-option {{ request('category') === 'autism' ? 'active' : '' }}" data-filter="autism">التوحد</a>
                        <a href="{{ route('educational.index', array_merge(request()->except('category'), ['category' => 'down'])) }}" class="sort-option {{ request('category') === 'down' ? 'active' : '' }}" data-filter="down">متلازمة داون</a>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                @forelse ($contents as $content)
                    <a href="{{ route('educational.show', $content->slug) }}" class="content-card" data-category="{{ $content->target_category }}">
                        <div class="content-card__image">
                            <img src="{{ $content->thumbnail_url }}" alt="{{ $content->title }}">
                            <div class="content-card__play-icon">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="content-card__body">
                            <h3 class="content-card__title">{{ $content->title }}</h3>
                            <p class="content-card__text">{{ $content->description }}</p>
                        </div>
                    </a>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #718096;">
                        <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 16px; color: #CBD5E1;"></i>
                        <p style="font-size: 1.25rem;">لا توجد نتائج مطابقة لبحثك في المحتوى التوعوي.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($contents->hasPages())
                <div class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($contents->onFirstPage())
                        <button class="pagination__btn pagination__btn--prev" disabled aria-label="السابق">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    @else
                        <a href="{{ $contents->previousPageUrl() }}" class="pagination__btn pagination__btn--prev" aria-label="السابق">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    <div class="pagination__numbers">
                        @foreach ($contents->getUrlRange(1, $contents->lastPage()) as $page => $url)
                            @if ($page == $contents->currentPage())
                                <button class="pagination__number active">{{ $page }}</button>
                            @else
                                <a href="{{ $url }}" class="pagination__number">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>

                    {{-- Next Page Link --}}
                    @if ($contents->hasMorePages())
                        <a href="{{ $contents->nextPageUrl() }}" class="pagination__btn pagination__btn--next" aria-label="التالي">
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
    </section>

    <!-- Trust Cards Section -->
    @include('partials.trust-cards')

    <!-- Newsletter Section -->
    @include('partials.newsletter')
@endsection
