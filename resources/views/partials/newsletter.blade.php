<section class="newsletter {{ $class ?? '' }}">
    <div class="container">
        <h2 class="newsletter__title">احصل على جميع أخبارنا وعروضنا في مكان واحد</h2>
        <form class="newsletter__form" id="newsletterForm" action="{{ route('newsletter.subscribe') }}" method="POST">
            @csrf
            <input type="email" name="email" class="newsletter__input" placeholder="أدخل البريد الإلكتروني" required
                aria-label="البريد الإلكتروني">
            <button type="submit" class="btn btn--primary newsletter__btn">اشترك الآن</button>
        </form>
    </div>
</section>
