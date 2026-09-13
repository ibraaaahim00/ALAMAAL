<footer class="footer" id="contact">
    <div class="container">
        <div class="footer__grid">
            <!-- Footer Logo & Description -->
            <div class="footer__brand">
                <img src="{{ asset('images/footer-logo.png') }}" alt="جسر الأمل" class="footer__logo">
                <p class="footer__description">
                    نهتم بتوفير الدعم اللازم لذوي الاحتياجات الخاصة في مجال اضطراب طيف التوحد و متلازمة داون ، فهو
                    بمثابة شريان حياة للآباء .
                </p>
                <div class="footer__social">
                    <a href="#" class="footer__social-link" aria-label="فيسبوك"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="footer__social-link" aria-label="انستقرام"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="footer__social-link" aria-label="واتساب"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer__links">
                <h3 class="footer__heading">روابط أخرى</h3>
                <ul class="footer__link-list">
                    <li><a href="{{ route('privacy') }}">سياسة الخصوصية</a></li>
                    <li><a href="{{ route('contact') }}">مركز المساعدة</a></li>
                    <li><a href="{{ route('privacy') }}">الشروط والأحكام</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer__contact">
                <h3 class="footer__heading">معلومات التواصل</h3>
                <ul class="footer__contact-list">
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:bridge-of-hope@gmail.com">bridge-of-hope@gmail.com</a>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:+966123456789">+966 123 456 7890</a>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:+201234567890">+20 123 4567 890</a>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>الرياض، المملكة العربية السعودية</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer__bottom">
            <p>جميع الحقوق محفوظة لشركة تسوق © {{ date('Y') }} – جسر الأمل</p>
        </div>
    </div>

    <!-- Decorative Stars -->
    <div class="footer__decor-star footer__decor-star--1">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M12 2L14 10H22L16 14L18 22L12 18L6 22L8 14L2 10H10L12 2Z" fill="none"
                stroke="rgba(255,255,255,0.3)" stroke-width="1.5" />
        </svg>
    </div>
    <div class="footer__decor-star footer__decor-star--2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M12 2L14 10H22L16 14L18 22L12 18L6 22L8 14L2 10H10L12 2Z" fill="none"
                stroke="rgba(255,255,255,0.3)" stroke-width="1.5" />
        </svg>
    </div>
</footer>
