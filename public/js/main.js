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

    // If form has action attribute pointing to backend, we allow normal submit or ajax
    form.addEventListener('submit', (e) => {
        const btn = form.querySelector('.contact-form__btn');
        if (btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
        }
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
        next2.addEventListener('click', (e) => {
            e.preventDefault();
            // Validate step 2 fields
            const orderTitle = document.getElementById('orderTitle');
            const orderName = document.getElementById('orderName');
            const orderPhone = document.getElementById('orderPhone');

            if (orderTitle && !orderTitle.value.trim()) {
                orderTitle.reportValidity();
                return;
            }
            if (orderName && !orderName.value.trim()) {
                orderName.reportValidity();
                return;
            }
            if (orderPhone && !orderPhone.value.trim()) {
                orderPhone.reportValidity();
                return;
            }

            activateStep(3);
        });
    }

    // Step 3 -> Step 4
    const next3 = document.querySelector('#step3 .checkout-step__next');
    if (next3) {
        next3.addEventListener('click', (e) => {
            e.preventDefault();
            activateStep(4);
        });
    }

    // Promo code apply logic with backend AJAX check
    const applyBtn = document.getElementById('applyPromo');
    if (applyBtn) {
        applyBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const promoInput = document.getElementById('promoCode');
            const code = promoInput ? promoInput.value.trim() : '';
            const priceEl = document.querySelector('.order-summary-card__price');
            const rawPrice = priceEl ? parseFloat(priceEl.getAttribute('data-price') || '250') : 250;

            if (!code) {
                alert('الرجاء إدخال كود الخصم');
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('/checkout/apply-coupon', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ code: code, amount: rawPrice })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    applyBtn.textContent = 'تم التطبيق ✓';
                    applyBtn.style.background = '#27AE60';
                    if (priceEl && data.new_total !== undefined) {
                        priceEl.textContent = data.new_total + ' ريال (خصم: ' + data.discount + ' ريال)';
                    }
                    setTimeout(() => {
                        applyBtn.textContent = 'تطبيق الرمز';
                        applyBtn.style.background = '';
                    }, 2000);
                } else {
                    alert(data.message || 'كود الخصم غير صالح');
                }
            })
            .catch(() => {
                // Fallback simulation
                applyBtn.textContent = 'تم التطبيق ✓';
                applyBtn.style.background = '#27AE60';
                setTimeout(() => {
                    applyBtn.textContent = 'تطبيق الرمز';
                    applyBtn.style.background = '';
                }, 2000);
            });
        });
    }

    // Step 4: Confirm payment
    const confirmBtn = document.getElementById('confirmPayment');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', (e) => {
            const selected = document.querySelector('input[name="payment"]:checked');
            if (!selected) {
                alert('الرجاء اختيار طريقة الدفع');
                return;
            }

            // Submit main checkout form
            if (checkoutForm) {
                // Ensure payment method and promo code are attached to form
                let paymentInput = checkoutForm.querySelector('input[name="payment"]');
                if (!paymentInput) {
                    paymentInput = document.createElement('input');
                    paymentInput.type = 'hidden';
                    paymentInput.name = 'payment';
                    checkoutForm.appendChild(paymentInput);
                }
                paymentInput.value = selected.value;

                const promoVal = document.getElementById('promoCode')?.value;
                if (promoVal) {
                    let promoHidden = checkoutForm.querySelector('input[name="promo_code"]');
                    if (!promoHidden) {
                        promoHidden = document.createElement('input');
                        promoHidden.type = 'hidden';
                        promoHidden.name = 'promo_code';
                        checkoutForm.appendChild(promoHidden);
                    }
                    promoHidden.value = promoVal;
                }

                confirmBtn.textContent = 'جاري تأكيد الطلب...';
                confirmBtn.style.background = '#27AE60';
                checkoutForm.submit();
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

    if (!sortBtn || !sortMenu) return;

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
        const activeFilterEl = sortMenu.querySelector('.sort-option.active');
        const activeFilter = activeFilterEl ? activeFilterEl.getAttribute('data-filter') : 'all';
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

        cards.forEach(card => {
            const category = card.getAttribute('data-category');
            const titleEl = card.querySelector('.content-card__title');
            const textEl = card.querySelector('.content-card__text');
            const title = titleEl ? titleEl.textContent.toLowerCase() : '';
            const text = textEl ? textEl.textContent.toLowerCase() : '';

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
            if (href === '#' || href === '') return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const header = document.querySelector('.header');
                const headerHeight = header ? header.offsetHeight : 0;
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
        const emailInput = form.querySelector('.newsletter__input');
        const email = emailInput ? emailInput.value : '';

        if (email) {
            const btn = form.querySelector('.newsletter__btn');
            const originalText = btn.textContent;
            btn.textContent = 'تم التسجيل بنجاح ✓';
            btn.style.background = '#27AE60';

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email: email })
            }).finally(() => {
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.background = '';
                    form.reset();
                }, 2000);
            });
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
    '.value-card--purple .value-card__title': 'Our Mission',
    '.value-card--yellow .value-card__title': 'Our Goals',
    '.about__content .section-label': 'Who are we?',
    '.about__content .section-title': 'A brief overview of the organization',
    '.services__header-text .section-label': 'What we offer',
    '.services__header-text .section-title': 'Our three core services',
    '.navbar__actions .btn': 'Login',
    '.navbar__dropdown-list li:nth-child(1) span': 'Profile',
    '.navbar__dropdown-list li:nth-child(2) span': 'Orders',
    '.navbar__dropdown-list li:nth-child(3) span': 'Tips',
    '.navbar__dropdown-list li:nth-child(5) span': 'Logout',
    '.testimonials__header-text .section-label': 'What do they say?',
    '.testimonials__header-text .section-title': 'Client Opinions',
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
    '#contentSearchInput': { attr: 'placeholder', val: 'Search here ...' },
    '#sortDropdownBtn span': 'Sort by : All',
    '.sort-option[data-filter="all"]': 'All',
    '.sort-option[data-filter="autism"]': 'Autism',
    '.sort-option[data-filter="down"]': 'Down Syndrome',
    '.btn--save': 'Save',
    '.status-badge--pending': 'Pending',
    '.status-badge--progress': 'In Progress',
    '.status-badge--completed': 'Completed',
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
            window.location.href = '/advices';
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
    const toggleBtns = authPage.querySelectorAll('.password-toggle, .form-input-toggle');
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const wrapper = btn.closest('.input-wrapper') || btn.closest('.form-input-wrapper');
            const input = wrapper ? wrapper.querySelector('input') : null;
            const icon = btn.querySelector('i');

            if (input && icon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
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

                if (value && !/^\d$/.test(value)) {
                    e.target.value = '';
                    return;
                }

                if (value) {
                    input.classList.add('filled');
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

        // Initialize Countdown Timer
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
