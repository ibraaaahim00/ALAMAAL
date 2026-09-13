@extends('layouts.app')

@section('title', 'جسر الأمل | ' . $content->title)

@section('content')
    <!-- ============================================
         BREADCRUMB SECTION
    ============================================= -->
    <section class="page-header" id="page-header">
        <div class="container">
            <div class="breadcrumb breadcrumb--details">
                <a href="{{ route('home') }}">الرئيسية</a>
                <i class="fas fa-chevron-left"></i>
                <a href="{{ route('educational.index') }}">المحتوى التوعوي</a>
                <i class="fas fa-chevron-left"></i>
                <span class="active">{{ $content->title }}</span>
            </div>
        </div>
    </section>

    <!-- ============================================
         VIDEO HERO SECTION
    ============================================= -->
    <section class="video-hero">
        <div class="container">
            <div class="video-hero__wrapper">
                <iframe width="100%" height="421" src="{{ $content->youtube_embed_url }}"
                    title="{{ $content->title }}" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <!-- ============================================
         ARTICLE DETAILS SECTION
    ============================================= -->
    <section class="content-article">
        <div class="container">
            <div class="content-article__header">
                <span class="content-article__date" id="publishDate">
                    {{ $content->published_at ? $content->published_at->translatedFormat('d F , Y') : date('d M , Y') }}
                </span>
            </div>

            <div class="content-article__body">
                @if ($content->instructions)
                    <h2 class="content-article__heading">التعليمات</h2>
                    <p class="content-article__paragraph">
                        {!! nl2br(e($content->instructions)) !!}
                    </p>
                @endif

                @if ($content->guidance_steps)
                    <h2 class="content-article__heading mt-4">خطوات إرشادية</h2>
                    <p class="content-article__paragraph">
                        {!! nl2br(e($content->guidance_steps)) !!}
                    </p>
                @endif

                @if (!$content->instructions && !$content->guidance_steps)
                    <h2 class="content-article__heading">الوصف والتفاصيل</h2>
                    <p class="content-article__paragraph">
                        {!! nl2br(e($content->description)) !!}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Trust Cards Section -->
    @include('partials.trust-cards')

    <!-- Newsletter Section -->
    @include('partials.newsletter')
@endsection
