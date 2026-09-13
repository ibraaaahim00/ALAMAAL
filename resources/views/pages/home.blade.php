@extends('layouts.app')

@section('title', 'جسر الأمل | لذوي الاحتياجات الخاصة')

@section('content')
    <!-- ============================================
         HERO SECTION
    ============================================= -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero__grid">
                <!-- Hero Content -->
                <div class="hero__content">
                    <h1 class="hero__title">
                        جسر الأمل
                        <span class="hero__title-sub"> لذوي الاحتياجات الخاصة وخدماتهم</span>
                    </h1>
                    <p class="hero__description">
                        سواء كنت ولي أمر تبحث عن مساعدة لطفلك، أو أخصائي نفسي و تربوي تسعى إلى تعزيز خبرتك، فإن هذه
                        المنظمة تجمع كل شيء في مكان واحد يسهل الوصول إليه.
                    </p>
                    <a href="#services" class="btn btn--white">ابدأ الآن</a>
                </div>

                <!-- Hero Image -->
                <div class="hero__image-wrapper">
                    <div class="hero__image-circle">
                        <img src="{{ asset('images/hero-child.png') }}" alt="أخصائية تعمل مع طفل في جلسة علاجية"
                            class="hero__image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         ABOUT US SECTION
    ============================================= -->
    <section class="about" id="about">
        <div class="container">
            <div class="about__grid">
                <!-- About Image -->
                <div class="about__image-wrapper">
                    <img src="{{ asset('images/about-child.png') }}" alt="طفل من ذوي الاحتياجات الخاصة" class="about__image">
                </div>
                <!-- About Content -->
                <div class="about__content">
                    <span class="section-label">من نحن ؟</span>
                    <h2 class="section-title section-title--red">نبذة مختصرة عن المنظمة و ما تستهدفه</h2>
                    <ul class="about__list">
                        <li>توفير بيئة تعليمية وتأهيلية شاملة وآمنة لجميع الأطفال.</li>
                        <li>برامج تأهيلية وعلاجية وسلوكية متخصصة تلبي الاحتياجات الفردية.</li>
                        <li>دعم وإرشاد الأسر عبر نخبة من الخبراء والاستشاريين المعتمدين.</li>
                    </ul>
                    <a href="{{ route('about') }}" class="btn btn--primary">أقرأ المزيد</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         SERVICES SECTION
    ============================================= -->
    <section class="services" id="services">
        <div class="container">
            <!-- Section Header -->
            <div class="services__header">
                <a href="{{ route('services.index') }}" class="btn btn--primary">أقرأ المزيد</a>
                <div class="services__header-text">
                    <span class="section-label">ماذا نقدم</span>
                    <h2 class="section-title section-title--red">خدماتنا الثلاث الأساسية التي نوفرها</h2>
                </div>
            </div>

            <!-- Service Cards -->
            <div class="services__grid">
                @foreach ($services as $service)
                    <div class="service-card">
                        <div class="service-card__image">
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}">
                        </div>
                        <h3 class="service-card__title">{{ $service->title }}</h3>
                        <p class="service-card__description">{{ $service->description }}</p>
                        <div class="service-card__footer">
                            <a href="{{ route('checkout', ['service' => $service->slug]) }}" class="btn btn--outline">
                                {{ $service->type->value === 'consultation' ? 'حجز استشارة' : 'طلب الخدمة' }}
                            </a>
                            <span class="service-card__price">{{ number_format($service->price, 0) }} ريال</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================================
         WHY CHOOSE US SECTION
    ============================================= -->
    <section class="why-us" id="why-us">
        <div class="container">
            <div class="why-us__grid">
                <!-- Features Side -->
                <div class="why-us__content">
                    <span class="section-label">لماذا تختارنا ؟</span>
                    <h2 class="section-title section-title--red">بعض المميزات التي نقدمها لأطفالنا</h2>

                    <div class="why-us__features">
                        <!-- Feature 1 -->
                        <div class="feature-block">
                            <div class="feature-block__icon feature-block__icon--yellow">
                                <i class="fas fa-hands-holding-child"></i>
                            </div>
                            <h4 class="feature-block__title">الدعم العائلي</h4>
                            <p class="feature-block__text">تدريب الأهالي على طرق التعامل مع السلوكيات الخاصة بالتوحد</p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="feature-block">
                            <div class="feature-block__icon feature-block__icon--green">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h4 class="feature-block__title">سهولة التواصل</h4>
                            <p class="feature-block__text">توفر المنصة الأساليب المتاحة للتواصل بين الآباء والأخصائيين</p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="feature-block">
                            <div class="feature-block__icon feature-block__icon--pink">
                                <i class="fas fa-file-medical"></i>
                            </div>
                            <h4 class="feature-block__title">التدخل المبكر</h4>
                            <p class="feature-block__text">توفير بيئة تعليمية منظمة وعلاج سلوكي لتحسين المهارات التواصلية</p>
                        </div>

                        <!-- Feature 4 -->
                        <div class="feature-block">
                            <div class="feature-block__icon feature-block__icon--blue">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h4 class="feature-block__title">تأهيل تعليمي</h4>
                            <p class="feature-block__text">برامج فردية تلبي احتياجات الطفل التعليمية وتراعي قدراته</p>
                        </div>
                    </div>
                </div>

                <!-- Image Side -->
                <div class="why-us__image-wrapper">
                    <img src="{{ asset('images/why-choose-us.png') }}" alt="طفلة ترسم في الفصل" class="why-us__image">
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         TESTIMONIALS SECTION
    ============================================= -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <!-- Section Header -->
            <div class="testimonials__header">
                <div class="testimonials__header-text">
                    <span class="section-label">ماذا يقولون عنا ؟</span>
                    <h2 class="section-title section-title--red">آراء عملائنا</h2>
                </div>
                <!-- Slider Controls -->
                <div class="testimonials__controls">
                    <button class="testimonials__btn testimonials__btn--next" id="nextTestimonial" aria-label="السابق">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button class="testimonials__btn testimonials__btn--prev" id="prevTestimonial" aria-label="التالي">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Testimonial Slider Container -->
        <div class="testimonials__slider-container">
            <div class="testimonials__slider" id="testimonialSlider">
                @foreach ($testimonials as $testimonial)
                    <div class="testimonial-card">
                        <div class="testimonial-card__header">
                            <div class="testimonial-card__rating">
                                <span class="testimonial-card__score">({{ $testimonial->rating }}/5)</span>
                                <div class="testimonial-card__stars">
                                    @for ($i = 0; $i < floor($testimonial->rating); $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="testimonial-card__text">{{ $testimonial->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trust Cards Section -->
    @include('partials.trust-cards')

    <!-- Newsletter Section -->
    @include('partials.newsletter')
@endsection
