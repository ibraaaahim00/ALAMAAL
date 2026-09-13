@extends('layouts.app')

@section('title', 'جسر الأمل | من نحن')

@section('content')
    <!-- ============================================
         PAGE HEADER SECTION
    ============================================= -->
    <section class="page-header" id="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">الرئيسية</a>
                <i class="fas fa-chevron-left"></i>
                <span>من نحن</span>
            </div>
            <div class="page-header__content">
                <h1 class="page-header__title">القصة التعريفية للمنصة</h1>
                <ul class="page-header__list">
                    <li>تتمحور فكرة المشروع حول إنشاء موقع إلكتروني بسيط وسهل الاستخدام يمثل المرجع الأول للأهالي .
                        يتيح الموقع للعميل الاطلاع على الخدمات، والتسجيل، وتقديم طلب استشارة مبدئي حاليًا بشكل يدوي
                        ، ومن ثم متابعة حالة طلبه والخطط العلاجية المخصصة لحالة طفله .</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ============================================
         VALUES SECTION
    ============================================= -->
    <section class="values" id="values">
        <div class="container">
            <div class="values__list">
                <!-- Vision -->
                <div class="value-card value-card--green">
                    <div class="value-card__header">
                        <div class="value-card__icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="value-card__title">رؤيتنا</h3>
                    </div>
                    <ul class="value-card__list">
                        <li>أن تكون المنصة المرجع الأول للأهالي الذين لديهم أطفال يعانون من تحديات في التربية الخاصة
                            و اضطراب طيف التوحد و متلازمة داون .</li>
                    </ul>
                </div>

                <!-- Mission -->
                <div class="value-card value-card--purple">
                    <div class="value-card__header">
                        <div class="value-card__icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3 class="value-card__title">رسالتنا</h3>
                    </div>
                    <ul class="value-card__list">
                        <li>تقديم خدمات مهنية آمنة تساعد الأسر على تطوير قدرات أطفالهم وتحسين حياتهم .</li>
                    </ul>
                </div>

                <!-- Goals -->
                <div class="value-card value-card--yellow">
                    <div class="value-card__header">
                        <div class="value-card__icon">
                            <i class="fas fa-bullseye" style="transform: rotate(45deg);"></i>
                        </div>
                        <h3 class="value-card__title">أهدافنا</h3>
                    </div>
                    <ul class="value-card__list">
                        <li>تقديم استشارات وخطط مخصصة .</li>
                        <li>متابعة التقدم .</li>
                        <li>نشر محتوى توعوي .</li>
                    </ul>
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
                    <a href="{{ route('services.index') }}" class="btn btn--primary">استكشف الخدمات</a>
                </div>
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

    <!-- Trust Cards Section -->
    @include('partials.trust-cards')

    <!-- Newsletter Section -->
    @include('partials.newsletter')
@endsection
