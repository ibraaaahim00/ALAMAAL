/* ============================================
   جسر الأمل - Main JavaScript
============================================= */

document.addEventListener('DOMContentLoaded', () => {
    // Mobile Navigation Toggle
    initMobileNav();

    // Testimonials Slider
    initTestimonialsSlider();

    // Smooth Scroll
    initSmoothScroll();

    // Header Scroll Effect
    initHeaderScroll();

    // Newsletter Form
    initNewsletter();

    // Language Toggle
    initLanguageToggle();

    // Profile Dropdown
    initProfileDropdown();

    // Contact Form
    initContactForm();

    // Checkout
    initCheckout();

    // Educational Content
    initEducationalContent();

    // Advices Page
    initAdvices();

    // Authentication (Register/Login)
    initAuth();
});

/* ============================================
   MOBILE NAVIGATION
============================================= */
function initMobileNav() {
    const toggle = document.getElementById('navToggle');
    const menu = document.getElementById('navMenu');

    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        toggle.classList.toggle('active');
        menu.classList.toggle('active');
        document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
    });

    // Close menu when clicking a link
    menu.querySelectorAll('.navbar__link').forEach(link => {
        link.addEventListener('click', () => {
            toggle.classList.remove('active');
            menu.classList.remove('active');
            document.body.style.overflow = '';
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            toggle.classList.remove('active');
            menu.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
}

/* ============================================
   PROFILE DROPDOWN
============================================= */
function initProfileDropdown() {
    const trigger = document.getElementById('profileTrigger');
    const dropdown = document.getElementById('profileDropdown');

    if (!trigger || !dropdown) return;

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('navbar__dropdown--active');
    });

    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target) && e.target !== trigger) {
            dropdown.classList.remove('navbar__dropdown--active');
        }
    });
}

/* ============================================
   CONTACT FORM
============================================= */
function initContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const btn = form.querySelector('.contact-form__btn');
        const originalText = btn.textContent;
        btn.textContent = 'تم الإرسال بنجاح ✓';
        btn.style.background = '#27AE60';

        setTimeout(() => {
            btn.textContent = originalText;
            btn.style.background = '';
            form.reset();
        }, 2500);
    });
}

/* ============================================
   CHECKOUT
============================================= */
function initCheckout() {
    const steps = document.querySelectorAll('.checkout-step');
    if (!steps.length) return;

    // Helper to activate a step and scroll to it
    const activateStep = (stepNum) => {
        const targetStep = document.getElementById('step' + stepNum);
        if (!targetStep) return;

        // Mark previous steps as completed
        for (let i = 1; i < stepNum; i++) {
            const prev = document.getElementById('step' + i);
            if (prev) {
                prev.classList.remove('checkout-step--active', 'checkout-step--inactive');
                prev.classList.add('checkout-step--completed');
            }
        }

        // Activate target step
        targetStep.classList.remove('checkout-step--inactive', 'checkout-step--completed');
        targetStep.classList.add('checkout-step--active');

        targetStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    // Step 1 -> Step 2
    const next1 = document.querySelector('#step1 .checkout-step__next');
    if (next1) {
        next1.addEventListener('click', () => {
            activateStep(2);
        });
    }

    // Step 2 -> Step 3 (Validation Required)
    const next2 = document.querySelector('#step2 .checkout-step__next');
    const checkoutForm = document.getElementById('checkoutForm');
    if (next2 && checkoutForm) {
        next2.addEventListener('click', () => {
            if (checkoutForm.checkValidity()) {
                activateStep(3);
            } else {
                checkoutForm.reportValidity();
            }
        });
    }

    // Step 3 -> Step 4
    const next3 = document.querySelector('#step3 .checkout-step__next');
    if (next3) {
        next3.addEventListener('click', () => {
            activateStep(4);
        });
    }

    // Promo code apply logic (Feedback only, navigation is on "Next")
    const applyBtn = document.getElementById('applyPromo');
    if (applyBtn) {
        applyBtn.addEventListener('click', () => {
            const code = document.getElementById('promoCode').value.trim();
            if (code) {
                applyBtn.textContent = 'تم التطبيق ✓';
                applyBtn.style.background = '#27AE60';
                setTimeout(() => {
                    applyBtn.textContent = 'تطبيق الرمز';
                    applyBtn.style.background = '';
                }, 2000);
            }
        });
    }

    // Step 4: Confirm payment
    const confirmBtn = document.getElementById('confirmPayment');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', () => {
            const selected = document.querySelector('input[name="payment"]:checked');
            if (selected) {
                confirmBtn.textContent = 'تم تأكيد الدفع بنجاح ✓';
                confirmBtn.style.background = '#27AE60';
                setTimeout(() => {
                    alert('تم استلام طلبك بنجاح! شكرًا لك.');
                    window.location.href = 'index.html';
                }, 2000);
            } else {
                alert('الرجاء اختيار طريقة الدفع');
            }
        });
    }
}

/* ============================================
   EDUCATIONAL CONTENT
============================================= */
function initEducationalContent() {
    const section = document.getElementById('educational-content');
    if (!section) return;

    const sortBtn = section.querySelector('#sortDropdownBtn');
    const sortMenu = section.querySelector('#sortDropdownMenu');
    const searchInput = section.querySelector('#contentSearchInput');
    const cards = section.querySelectorAll('.content-card');
    const paginationNumbers = section.querySelectorAll('.pagination__number');

    if (!sortBtn || !sortMenu || !cards.length) return;

    // Toggle Sort Dropdown
    sortBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        sortMenu.classList.toggle('active');
    });

    document.addEventListener('click', () => {
        sortMenu.classList.remove('active');
    });

    // Handle Filtering (Sort/Category)
    const filterCards = () => {
        const activeFilter = sortMenu.querySelector('.sort-option.active').getAttribute('data-filter');
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

        cards.forEach(card => {
            const category = card.getAttribute('data-category');
            const title = card.querySelector('.content-card__title').textContent.toLowerCase();
            const text = card.querySelector('.content-card__text').textContent.toLowerCase();

            const matchesFilter = activeFilter === 'all' || category === activeFilter;
            const matchesSearch = !searchTerm || title.includes(searchTerm) || text.includes(searchTerm);

            if (matchesFilter && matchesSearch) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    };

    sortMenu.querySelectorAll('.sort-option').forEach(option => {
        option.addEventListener('click', () => {
            sortMenu.querySelectorAll('.sort-option').forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');

            const filterText = option.textContent;
            sortBtn.querySelector('span').innerHTML =
                document.documentElement.lang === 'en' ? `Sort by : ${filterText}` : `ترتيب حسب : ${filterText}`;

            filterCards();
            sortMenu.classList.remove('active');
        });
    });

    // Search Input Logic
    if (searchInput) {
        searchInput.addEventListener('input', filterCards);
    }

    // Pagination Logic (Simple Visual Toggling)
    paginationNumbers.forEach(num => {
        num.addEventListener('click', () => {
            paginationNumbers.forEach(n => n.classList.remove('active'));
            num.classList.add('active');
            window.scrollTo({ top: document.getElementById('educational-content').offsetTop - 100, behavior: 'smooth' });
        });
    });
}

/* ============================================
   TESTIMONIALS SLIDER
============================================= */
function initTestimonialsSlider() {
    const sliderContainer = document.querySelector('.testimonials__slider-container');
    const slider = document.getElementById('testimonialSlider');
    const prevBtn = document.getElementById('prevTestimonial');
    const nextBtn = document.getElementById('nextTestimonial');
    const cards = slider ? Array.from(slider.querySelectorAll('.testimonial-card')) : [];

    if (!sliderContainer || !slider || !prevBtn || !nextBtn || cards.length === 0) return;

    const getScrollAmount = () => {
        const style = window.getComputedStyle(slider);
        const gap = parseInt(style.gap) || 0;
        return cards[0].offsetWidth + gap;
    };

    const getActiveCardIndex = () => {
        const rect = sliderContainer.getBoundingClientRect();
        const containerCenter = rect.left + rect.width / 2;
        let minDiff = Infinity;
        let activeIndex = 0;
        cards.forEach((card, index) => {
            const cardRect = card.getBoundingClientRect();
            const cardCenter = cardRect.left + cardRect.width / 2;
            const diff = Math.abs(cardCenter - containerCenter);
            if (diff < minDiff) {
                minDiff = diff;
                activeIndex = index;
            }
        });
        return activeIndex;
    };

    const scrollToCard = (index) => {
        const currentIndex = getActiveCardIndex();
        const diff = index - currentIndex;
        if (diff === 0) return;

        const amount = getScrollAmount();
        const dir = document.documentElement.dir === 'ltr' ? 1 : -1;
        sliderContainer.scrollBy({ left: diff * amount * dir, behavior: 'smooth' });
    };

    const scrollNext = () => {
        const currentIndex = getActiveCardIndex();
        if (currentIndex === cards.length - 1) {
            scrollToCard(0); // loop back to first
        } else {
            scrollToCard(currentIndex + 1);
        }
    };

    const scrollPrev = () => {
        const currentIndex = getActiveCardIndex();
        if (currentIndex === 0) {
            scrollToCard(cards.length - 1); // loop back to last
        } else {
            scrollToCard(currentIndex - 1);
        }
    };

    nextBtn.addEventListener('click', scrollNext);
    prevBtn.addEventListener('click', scrollPrev);

    // Auto-slide looping feature
    let autoSlide = setInterval(scrollNext, 5000);

    // Pause on hover
    sliderContainer.addEventListener('mouseenter', () => clearInterval(autoSlide));
    sliderContainer.addEventListener('mouseleave', () => {
        autoSlide = setInterval(scrollNext, 5000);
    });
}

/* ============================================
   SMOOTH SCROLL
============================================= */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = target.offsetTop - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/* ============================================
   HEADER SCROLL EFFECT
============================================= */
function initHeaderScroll() {
    const header = document.getElementById('header');
    if (!header) return;

    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 100) {
            header.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
        } else {
            header.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.08)';
        }

        lastScroll = currentScroll;
    });
}

/* ============================================
   NEWSLETTER FORM
============================================= */
function initNewsletter() {
    const form = document.getElementById('newsletterForm');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = form.querySelector('.newsletter__input').value;

        if (email) {
            // Show success feedback
            const btn = form.querySelector('.newsletter__btn');
            const originalText = btn.textContent;
            btn.textContent = 'تم التسجيل بنجاح ✓';
            btn.style.background = '#27AE60';

            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.background = '';
                form.reset();
            }, 2000);
        }
    });
}

/* ============================================
   LANGUAGE TOGGLE
============================================= */
const enTranslations = {
    'title': 'Bridge of Hope | Special Needs',
    '#navMenu li:nth-child(1) a': 'Home',
    '#navMenu li:nth-child(2) a': 'About Us',
    '#navMenu li:nth-child(3) a': 'Services',
    '#navMenu li:nth-child(4) a': 'Awareness Content',
    '#navMenu li:nth-child(5) a': 'Contact Us',
    '.hero__title': 'Bridge of Hope <span class="hero__title-sub">For Special Needs</span>',
    '.hero__description': 'Whether you are a parent looking for help for your child, or a psychological and educational specialist seeking to enhance your expertise, this organization brings everything together in one easily accessible place.',
    '.hero__content .btn': 'Start Now',
    '.breadcrumb span': 'About Us',
    '.page-header__title': 'The platform\'s introductory story',
    '.page-header__title--dark': 'Contact Us',
    '.page-header__list li': 'The idea revolves around creating a simple and easy-to-use website as the first reference for parents. It allows viewing services, registration, and submitting initial consultation requests manually, then tracking the request and customized treatment plans for the child.',
    '.contact__info-title': 'Contact Us',
    '.contact__info-subtitle': 'Contact us through our form and we will reply to you soon',
    '.contact__details li:nth-child(3) span': 'Riyadh, Saudi Arabia',
    '#contactForm label[for="fullName"]': 'Full Name',
    '#contactForm label[for="phone"]': 'Mobile Number',
    '#contactForm label[for="email"]': 'Email',
    '#contactForm label[for="message"]': 'Message',
    '#fullName': { attr: 'placeholder', val: 'Mohamed Ahmed Mohamed' },
    '#phone': { attr: 'placeholder', val: 'Mobile Number' },
    '#email': { attr: 'placeholder', val: 'Email Address' },
    '#message': { attr: 'placeholder', val: 'Write your message here ...' },
    '.contact-form__btn': 'Send',
    '#step1 .checkout-step__title': 'Order Summary',
    '#step1 .checkout-step__subtitle': 'We display the type of service requested and the amount of fees due',
    '.order-summary-card__title': 'Autism Children',
    '.order-summary-card__description': 'Specialized rehabilitation programs to support children with autism and develop communication, behavior, and independence skills, with individual plans for each child.',
    '.order-summary-card__price': '250 SAR',
    '#step1 .checkout-step__next': 'Next',
    '#step2 .checkout-step__title': 'Request Form',
    '#step2 .checkout-step__subtitle': 'Fill out this form to complete your request and we will contact you soon',
    '#checkoutForm label[for="orderTitle"]': 'Request Title',
    '#checkoutForm label[for="orderName"]': 'Name',
    '#checkoutForm label[for="orderPhone"]': 'Mobile Number',
    '#checkoutForm label[for="orderTime"]': 'Preferred Contact Time',
    '#checkoutForm label[for="orderNotes"]': 'Notes',
    '#orderTitle': { attr: 'placeholder', val: 'Mohamed Ahmed Mohamed' },
    '#orderName': { attr: 'placeholder', val: 'Name' },
    '#orderPhone': { attr: 'placeholder', val: 'Mobile Number' },
    '#orderNotes': { attr: 'placeholder', val: 'Write your message here ...' },
    '#step2 .checkout-step__next': 'Next',
    '#step3 .checkout-step__next': 'Next',
    '#step3 .checkout-step__title': 'Promo Code',
    '#step3 .checkout-step__subtitle': 'Do you have a promo code?',
    '.promo-code label': 'Discount Code',
    '#promoCode': { attr: 'placeholder', val: 'Discount Code' },
    '#applyPromo': 'Apply Code',
    '#step4 .checkout-step__title': 'Available Payment Methods',
    '#step4 .checkout-step__subtitle': 'Choose the payment method that suits you',
    '#confirmPayment': 'Confirm Payment',
    '.value-card--green .value-card__title': 'Our Vision',
    '.value-card--green .value-card__list li': 'To be the first reference for parents who have children suffering from challenges in special education, autism spectrum disorder, and Down syndrome.',
    '.value-card--purple .value-card__title': 'Our Mission',
    '.value-card--purple .value-card__list li': 'Providing safe professional services that help families develop their children\'s abilities and improve their lives.',
    '.value-card--yellow .value-card__title': 'Our Goals',
    '.value-card--yellow .value-card__list li:nth-child(1)': 'Providing customized consultations and plans.',
    '.value-card--yellow .value-card__list li:nth-child(2)': 'Tracking progress.',
    '.value-card--yellow .value-card__list li:nth-child(3)': 'Publishing awareness content.',
    '.about__content .section-label': 'Who are we?',
    '.about__content .section-title': 'A brief overview of the organization',
    '.about__list li:nth-child(1)': 'Providing an inclusive environment for all children.',
    '.about__list li:nth-child(2)': 'Specialized rehabilitation and therapeutic programs.',
    '.about__list li:nth-child(3)': 'Supporting families with expert guidance and therapy.',
    '.about__content .btn': 'Read More',
    '.services__header-text .section-label': 'What we offer',
    '.services__header-text .section-title': 'Our three core services',
    '.services__header .btn': 'Read More',
    '.service-card:nth-child(1) .service-card__title': 'Autism Children',
    '.service-card:nth-child(1) .service-card__description': 'Specialized rehabilitation programs to support children with autism and develop communication, behavior, and independence skills.',
    '.service-card:nth-child(1) .btn': 'Request Service',
    '.service-card:nth-child(1) .service-card__price': '250 SAR',
    '.service-card:nth-child(2) .service-card__title': 'Down Syndrome',
    '.service-card:nth-child(2) .service-card__description': 'Training and rehabilitation programs that help children with Down syndrome confidently develop their mental, motor, and social skills.',
    '.service-card:nth-child(2) .btn': 'Request Service',
    '.service-card:nth-child(2) .service-card__price': '350 SAR',
    '.service-card:nth-child(3) .service-card__title': 'Consultations',
    '.service-card:nth-child(3) .service-card__description': 'Book a consultation with a specialist to help you understand your child\'s condition and get practical guidance.',
    '.service-card:nth-child(3) .btn': 'Book Consultation',
    '.service-card:nth-child(3) .service-card__price': '450 SAR',
    '.trust-card--yellow .trust-card__title': 'Experience',
    '.trust-card--yellow .trust-card__text': 'Professional speech and educational specialists',
    '.trust-card--purple .trust-card__title': 'Specialization',
    '.trust-card--purple .trust-card__text': 'Specialized therapeutic and rehabilitation plans',
    '.trust-card--green .trust-card__title': 'Trust',
    '.trust-card--green .trust-card__text': 'Credibility and integrity in dealing',
    '.why-us__content .section-label': 'Why choose us?',
    '.why-us__content .section-title': 'Our Features',
    '.feature-block:nth-child(1) .feature-block__title': 'Family Support',
    '.feature-block:nth-child(1) .feature-block__text': 'Training parents on how to deal with specific behaviors',
    '.feature-block:nth-child(2) .feature-block__title': 'Easy Communication',
    '.feature-block:nth-child(2) .feature-block__text': 'Direct communication channels between parents and specialists',
    '.feature-block:nth-child(3) .feature-block__title': 'Early Intervention',
    '.feature-block:nth-child(3) .feature-block__text': 'Providing an organized educational environment',
    '.feature-block:nth-child(4) .feature-block__title': 'Educational Rehab',
    '.feature-block:nth-child(4) .feature-block__text': 'Individual programs that meet the child\'s needs',
    '.navbar__actions .btn': 'Login',
    '.navbar__dropdown-list li:nth-child(1) span': 'Profile',
    '.navbar__dropdown-list li:nth-child(2) span': 'Orders',
    '.navbar__dropdown-list li:nth-child(3) span': 'Tips',
    '.navbar__dropdown-list li:nth-child(5) span': 'Logout',
    '.testimonials__header-text .section-label': 'What do they say?',
    '.testimonials__header-text .section-title': 'Client Opinions',
    '.testimonial-card:nth-child(1) .testimonial-card__text': 'A wonderful experience with Bridge of Hope. A specialized team that cares about developing children\'s abilities.',
    '.testimonial-slide:nth-child(1) .testimonial-slide__author strong': 'Ahmed Mohamed',
    '.testimonial-slide:nth-child(1) .testimonial-slide__author span': 'Parent',
    '.testimonial-slide:nth-child(2) .testimonial-slide__text': 'Excellent platform and great communication with the specialists. Highly recommended.',
    '.testimonial-slide:nth-child(2) .testimonial-slide__author strong': 'Sara Ali',
    '.testimonial-slide:nth-child(2) .testimonial-slide__author span': 'Parent',
    '.newsletter__title': 'Get all our news and offers in one place',
    '#newsletterForm input': { attr: 'placeholder', val: 'Enter Email Address' },
    '.newsletter__btn': 'Subscribe',
    '.footer__description': 'We care about providing necessary support for special needs in the field of Autism spectrum and Down syndrome.',
    '.footer__links .footer__heading': 'Other Links',
    '.footer__link-list li:nth-child(1) a': 'Privacy Policy',
    '.footer__link-list li:nth-child(2) a': 'Help Center',
    '.footer__link-list li:nth-child(3) a': 'Terms & Conditions',
    '.footer__contact .footer__heading': 'Contact Info',
    '.footer__contact-list li:nth-child(4) span': 'Riyadh, Saudi Arabia',
    '.footer__bottom p': 'All rights reserved &copy; 2026 Bridge of Hope',
    '.page-header__content .page-header__title:not(.page-header__title--dark)': 'Educational Content',
    '.page-header__content .page-header__list li': 'We offer a collection of articles and educational tips to help you in your journey with your children with special needs.',
    '#contentSearchInput': { attr: 'placeholder', val: 'Search here ...' },
    '#sortDropdownBtn span': 'Sort by : All',
    '.sort-option[data-filter="all"]': 'All',
    '.sort-option[data-filter="autism"]': 'Autism',
    '.sort-option[data-filter="down"]': 'Down Syndrome',
    '.content-card[data-category="down"] .content-card__title': 'Animations about Down Syndrome',
    '.content-card[data-category="general"] .content-card__title': 'Take My Hand',
    '.content-card[data-category="autism"] .content-card__title': 'Touches of creativity seeking those who develop them',
    '.breadcrumb--details span.active': 'Video Details',
    '.content-article__date': 'March 12, 2025',
    '.content-article__heading': 'Instructions',
    '.content-article__heading.mt-4': 'Guidance Steps',
    '.breadcrumb span.active': 'Personal Page',
    '.profile-header__edit-btn': { attr: 'aria-label', val: 'Edit Image' },
    '.personal-form .form-group:nth-child(1) .form-label': 'Name',
    '.personal-form .form-group:nth-child(2) .form-label': 'Mobile Number',
    '.personal-form .form-group:nth-child(3) .form-label': 'Email',
    '.personal-form .form-group:nth-child(4) .form-label': 'Password',
    '.personal-form .form-group:nth-child(1) .form-input': { attr: 'placeholder', val: 'Name' },
    '.personal-form .form-group:nth-child(2) .form-input': { attr: 'placeholder', val: 'Mobile Number' },
    '.personal-form .form-group:nth-child(3) .form-input': { attr: 'placeholder', val: 'Email' },
    '.personal-form .form-group:nth-child(4) .form-input': { attr: 'placeholder', val: 'Password' },
    '.child-info__title': 'My Child\'s Information',
    '.child-info .form-group:nth-child(1) .form-label': 'Child\'s Name',
    '.child-info .form-group:nth-child(2) .form-label': 'Date of Birth',
    '.child-info .form-group:nth-child(3) .form-label': 'Gender',
    '.child-info .form-group:nth-child(4) .form-label': 'Condition',
    '.child-info .form-group:nth-child(5) .form-label': 'Speech Level',
    '.child-info .form-group:nth-child(6) .form-label': 'Behavioral Challenge',
    '.child-info .form-group:nth-child(7) .form-label': 'Independence',
    '.child-info .form-group:nth-child(8) .form-label': 'Desired Goal',
    '.child-info .form-group:nth-child(1) .form-input': { attr: 'placeholder', val: 'Child\'s Name' },
    '.child-info .form-group:nth-child(2) .form-input': { attr: 'placeholder', val: 'Day / Month / Year' },
    '.child-info .form-group:nth-child(3) .form-select option[value=""]': 'Select Gender',
    '.child-info .form-group:nth-child(3) .form-select option[value="male"]': 'Male',
    '.child-info .form-group:nth-child(3) .form-select option[value="female"]': 'Female',
    '.child-info .form-group:nth-child(4) .form-select option[value=""]': 'Select Condition',
    '.child-info .form-group:nth-child(4) .form-select option[value="autism"]': 'Autism Spectrum',
    '.child-info .form-group:nth-child(4) .form-select option[value="down"]': 'Down Syndrome',
    '.child-info .form-group:nth-child(5) .form-select option[value=""]': 'Select Speech Level',
    '.child-info .form-group:nth-child(5) .form-select option[value="none"]': 'None',
    '.child-info .form-group:nth-child(5) .form-select option[value="low"]': 'Simple words',
    '.child-info .form-group:nth-child(5) .form-select option[value="medium"]': 'Short sentences',
    '.child-info .form-group:nth-child(5) .form-select option[value="high"]': 'Fluent',
    '.child-info .form-group:nth-child(6) .form-select option[value=""]': 'Select Behavioral Challenge',
    '.child-info .form-group:nth-child(6) .form-select option[value="hyperactivity"]': 'Hyperactivity',
    '.child-info .form-group:nth-child(6) .form-select option[value="aggression"]': 'Aggression',
    '.child-info .form-group:nth-child(6) .form-select option[value="shyness"]': 'Social shyness',
    '.child-info .form-group:nth-child(7) .form-select option[value=""]': 'Select Independence',
    '.child-info .form-group:nth-child(7) .form-select option[value="dependent"]': 'Not independent',
    '.child-info .form-group:nth-child(7) .form-select option[value="partially"]': 'Partially independent',
    '.child-info .form-group:nth-child(7) .form-select option[value="independent"]': 'Fully independent',
    '.child-info .form-group:nth-child(8) .form-select option[value=""]': 'Select Desired Goal',
    '.child-info .form-group:nth-child(8) .form-select option[value="communication"]': 'Improve communication',
    '.child-info .form-group:nth-child(8) .form-select option[value="behavior"]': 'Modify behavior',
    '.child-info .form-group:nth-child(8) .form-select option[value="skills"]': 'Develop skills',
    '.btn--save': 'Save',
    /* Orders Page Translations */
    '.breadcrumb span.active': 'Orders',
    '.order-card:nth-child(1) .order-card__title': 'Autism Spectrum',
    '.order-card:nth-child(2) .order-card__title': 'Down Syndrome',
    '.order-card:nth-child(3) .order-card__title': 'Autism Spectrum',
    '.order-card:nth-child(4) .order-card__title': 'Consultations',
    '.status-badge--pending': 'Pending',
    '.status-badge--progress': 'In Progress',
    '.status-badge--completed': 'Completed',
    '.order-card__row:nth-child(1) .order-card__label': 'Order Number :',
    '.order-card__row:nth-child(2) .order-card__label': 'Assigned Specialist :',
    '.order-card:nth-child(1) .order-card__row:nth-child(2) .order-card__value': 'Mohamed Abdallah',
    '.order-card:nth-child(2) .order-card__row:nth-child(2) .order-card__value': 'Ahmed Mohamed',
    '.order-card:nth-child(3) .order-card__row:nth-child(2) .order-card__value': 'Mahmoud Mohamed Ahmed',
    '.order-card:nth-child(4) .order-card__row:nth-child(2) .order-card__value': 'Ahmed Mohamed',
    '.btn--gray': 'Show Plan Details',
    '.btn--active-plan': 'Show Plan Details',

    /* Order Details Page Translations */
    '.breadcrumb a:nth-child(3)': 'Orders',
    '.breadcrumb span.active': 'Show Plan Details',
    '.order-details__title': 'Autism Spectrum',
    '.order-details__row:nth-child(1) .order-details__label': 'Order Number :',
    '.order-details__row:nth-child(2) .order-details__label': 'Assigned Specialist :',
    '.order-details__row:nth-child(2) .order-details__value': 'Mohamed Abdallah',
    '.order-details__response-title': 'Management Response :',
    '.order-details__response-text': 'This is a virtual model placed in designs to show the client how text will look within the designs.. This is a virtual model placed in designs to show the client how text will look within the designs.. This is a virtual model placed in designs to show the client how text will look within the designs.. This is a virtual model placed in designs to show the client how text will look within the designs..',
    '.attached-file:nth-child(1) .attached-file__name': 'Final Image 005.png',
    '.attached-file:nth-child(2) .attached-file__name': 'Final File 005. Contract pdf',
    '.attached-file:nth-child(3) .attached-file__name': 'Final Video mp4',
    '.order-details__notes .order-details__label--big': 'Notes',
    '.form-textarea': 'Write message text here...',
    '.order-details__rating .order-details__label--big': 'Add your rating here',

    /* Advices Page Translations */
    '.breadcrumb-section .active': 'Advices',
    '.search-wrapper input': 'Search here ...',
    '.custom-dropdown__btn span': 'Sort by : All',
    '.custom-dropdown__list li:nth-child(1)': 'All',
    '.custom-dropdown__list li:nth-child(2)': 'Latest',
    '.custom-dropdown__list li:nth-child(3)': 'Oldest',
    '.filter-header__title': 'Filter Videos',
    '.filter-header__reset': 'Reset',
    '.filter-group:nth-child(2) .filter-group__trigger span': 'Year',
    '.filter-group:nth-child(3) .filter-group__trigger span': 'Month',
    '.custom-radio:nth-child(1) .radio-label': 'January',
    '.custom-radio:nth-child(2) .radio-label': 'February',
    '.custom-radio:nth-child(3) .radio-label': 'March',
    '.custom-radio:nth-child(4) .radio-label': 'April',
    '.custom-radio:nth-child(5) .radio-label': 'May',
    '.custom-radio:nth-child(6) .radio-label': 'June',
    '.custom-radio:nth-child(7) .radio-label': 'July',
    '.custom-radio:nth-child(8) .radio-label': 'August',
    '.custom-radio:nth-child(9) .radio-label': 'September',
    '.custom-radio:nth-child(10) .radio-label': 'October',
    '.custom-radio:nth-child(11) .radio-label': 'November',
    '.custom-radio:nth-child(12) .radio-label': 'December',

    /* Register Page Translations */
    '#registerPage .auth-card__title': 'Register Now for Free',
    '#registerPage .auth-card__subtitle': 'Enter to create a new account to continue',
    '#registerPage .auth-form label[for="regName"]': 'Full Name',
    '#registerPage .auth-form label[for="regMobile"]': 'Mobile Number',
    '#registerPage .auth-form label[for="regEmail"]': 'Email Address',
    '#registerPage .auth-form label[for="regPassword"]': 'Password',
    '#regName': { attr: 'placeholder', val: 'Full Name' },
    '#regMobile': { attr: 'placeholder', val: 'Mobile Number' },
    '#regEmail': { attr: 'placeholder', val: 'Email Address' },
    '#regPassword': { attr: 'placeholder', val: 'Password' },
    '.checkbox-label': 'Agree to Terms and Conditions',
    '#registerPage .auth-btn': 'Register Now',
    '#registerPage .auth-card__footer p': 'Already have an account? <a href="login.html">Login</a>',

    /* Login Page Translations */
    '#loginPage .auth-card__title': 'Log in to Your Account',
    '#loginPage .auth-card__subtitle': 'Welcome back, enter to continue and explore',
    '#loginPage .auth-form label[for="loginEmail"]': 'Email Address',
    '#loginPage .auth-form label[for="loginPassword"]': 'Password',
    '#loginEmail': { attr: 'placeholder', val: 'Email Address' },
    '#loginPassword': { attr: 'placeholder', val: 'Password' },
    '.forgot-password': 'Forgot Password?',
    '#loginPage .auth-btn': 'Log In',
    '#loginPage .auth-card__footer p': 'Don\'t have an account? <a href="register.html">Register Now</a>',

    /* Forget Password Page Translations */
    '#forgetPasswordPage .auth-card__title': 'Forgot Password?',
    '#forgetPasswordPage .auth-card__subtitle': 'Please enter the email address you use to reset your password',
    '#forgetPasswordPage .auth-form label[for="forgetEmail"]': 'Email Address',
    '#forgetEmail': { attr: 'placeholder', val: 'Email Address' },
    '#forgetPasswordPage .auth-btn': 'Send',
    '#forgetPasswordPage .auth-card__footer a': 'Back to Login',

    /* OTP Page Translations */
    '#otpPage .auth-card__title': 'Verification Code',
    '#otpPage .auth-card__subtitle': 'Please enter the code we sent to your email',
    '#otpPage .auth-form label': 'Verification Code',
    '#otpPage .auth-btn': 'Verify',
    '.resend-link': 'Resend the code',

    /* Reset Password Page Translations */
    '#resetPasswordPage .auth-card__title': 'Reset Password',
    '#resetPasswordPage .auth-card__subtitle': 'Please enter the new password',
    '#resetPasswordPage label[for="newPassword"]': 'New Password',
    '#newPassword': { attr: 'placeholder', val: 'Enter new password' },
    '#resetPasswordPage label[for="confirmPassword"]': 'Confirm New Password',
    '#confirmPassword': { attr: 'placeholder', val: 'Enter confirm new password' },
    '#resetPasswordPage .auth-btn': 'Save',

    /* Privacy Policy Page Translations */
    '.privacy-policy .section-label': 'Protecting Your Data',
    '.privacy-policy .section-title': 'Privacy Policy & Information Security',
    '.policy-text p:nth-of-type(1)': 'At "Bridge of Hope", we are committed to protecting your privacy and ensuring the security of your personal data. This policy explains how we collect, use, and protect the information you provide to us.',
    '.policy-subtitle:nth-of-type(1)': '1. Data Collection',
    '.policy-text p:nth-of-type(2)': 'We collect the information you provide to us directly when registering on the platform or requesting a consultation, including name, email, and details of your child\'s condition.',
    '.policy-subtitle:nth-of-type(2)': '2. Information Usage',
    '.policy-text p:nth-of-type(3)': 'The information is used to improve our services, customize individual treatment plans, and communicate with you regarding updates and new services.',
    '.policy-subtitle:nth-of-type(3)': '3. Data Protection',
    '.policy-text p:nth-of-type(4)': 'We apply advanced security measures to ensure that your data is not lost or accessed without authorization.'
};

const arTranslations = {};
let currentDomainLang = 'ar';

function initLanguageToggle() {
    const langBtns = document.querySelectorAll('.navbar__lang-btn');
    if (!langBtns.length) return;

    langBtns.forEach(langBtn => {
        langBtn.addEventListener('click', () => {
            const isAr = currentDomainLang === 'ar';
            const newLang = isAr ? 'en' : 'ar';
            const dict = isAr ? enTranslations : arTranslations;

            document.documentElement.dir = isAr ? 'ltr' : 'rtl';
            document.documentElement.lang = newLang;

            for (const [selector, text] of Object.entries(dict)) {
                if (selector === 'title') {
                    if (isAr && !arTranslations['title']) arTranslations['title'] = document.title;
                    document.title = text;
                    continue;
                }

                const elements = document.querySelectorAll(selector);
                elements.forEach(el => {
                    if (typeof text === 'object' && text.attr) {
                        if (isAr && !arTranslations[selector]) arTranslations[selector] = { attr: text.attr, val: el.getAttribute(text.attr) };
                        el.setAttribute(text.attr, text.val);
                    } else {
                        if (isAr && !arTranslations[selector]) arTranslations[selector] = el.innerHTML;
                        el.innerHTML = text;
                    }
                });
            }

            // Update text for ALL language buttons
            document.querySelectorAll('.navbar__lang-btn span').forEach(span => {
                span.textContent = newLang === 'en' ? 'العربية' : 'English';
            });
            currentDomainLang = newLang;
        });
    });
}

/* ============================================
   ADVICES PAGE FUNCTIONALITY
============================================= */
function initAdvices() {
    const section = document.querySelector('.advices-section');
    if (!section) return;

    // 1. Sidebar Collapsible Groups
    const triggers = section.querySelectorAll('.filter-group__trigger');
    triggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            trigger.classList.toggle('active');
            const content = trigger.nextElementSibling;
            if (content) {
                content.style.display = trigger.classList.contains('active') ? 'flex' : 'none';
            }
        });
    });

    // 2. Sort Dropdown
    const sortBtn = section.querySelector('#sortDropdownBtn');
    const sortMenu = section.querySelector('#sortDropdownMenu');

    if (sortBtn && sortMenu) {
        sortBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sortMenu.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!sortMenu.contains(e.target) && e.target !== sortBtn) {
                sortMenu.classList.remove('active');
            }
        });

        const options = sortMenu.querySelectorAll('.sort-option');
        options.forEach(opt => {
            opt.addEventListener('click', () => {
                options.forEach(el => el.classList.remove('active'));
                opt.classList.add('active');
                sortBtn.querySelector('span').textContent = `ترتيب حسب : ${opt.textContent}`;
                sortMenu.classList.remove('active');
            });
        });
    }

    // 3. Reset Filters
    const resetBtn = document.querySelector('.filter-header__reset');
    if (resetBtn) {
        resetBtn.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.filter-group input[type="radio"]').forEach(radio => {
                if (radio.value === '2026' || radio.value === 'january') {
                    radio.checked = true;
                } else {
                    radio.checked = false;
                }
            });
        });
    }
}

/* ============================================
   AUTHENTICATION (Register/Login)
============================================= */
function initAuth() {
    const authPage = document.querySelector('.auth-page');
    if (!authPage) return;

    // Password Visibility Toggle
    const toggleBtns = authPage.querySelectorAll('.password-toggle');
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('input');
            const icon = btn.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // OTP Functionality
    const otpInputs = authPage.querySelectorAll('.otp-input');
    if (otpInputs.length) {
        otpInputs.forEach((input, index) => {
            // Handle typing (number only and auto-focus)
            input.addEventListener('input', (e) => {
                const value = e.target.value;

                // Allow only numbers
                if (value && !/^\d$/.test(value)) {
                    e.target.value = '';
                    return;
                }

                // Add "filled" class for design feedback
                if (value) {
                    input.classList.add('filled');
                    // Focus next input
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                } else {
                    input.classList.remove('filled');
                }
            });

            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        // Initialize Countdown Timer (Simple 59:00 simulation for now)
        const timerEl = authPage.querySelector('.otp-timer');
        if (timerEl) {
            let totalSeconds = 59 * 60;
            const timerInterval = setInterval(() => {
                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    return;
                }
                totalSeconds--;
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;
                timerEl.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }, 1000);
        }
    }
}

