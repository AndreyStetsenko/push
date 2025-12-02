<?php
/**
 * Главный шаблон темы
 *
 * @package Push
 */

get_header(); ?>

<div class="hero" id="hero">
    <div class="container" style="z-index: 2">
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <div class="hero__content">
                    <div class="hero__title">
                        <div class="span">Стильний</div>
                        <div class="span">SMM для тебе</div>
                    </div>

                    <div class="hero__wrapp">
                        <span class="hero__description">
                            Ми – Push Agency, креативне агентство для соцмереж, яке поєднує системний підхід і нестандартні ідеї. Тут ти знайдеш сучасний дизайн, зрозумілу навігацію і рішення, які реально працюють. 
                        </span>

                        <div class="hero__button">
                            <a href="#" class="hero__button-link">
                                <span>Зв’язатись з нами</span>
                                <div class="hero__button-icon-wrapp">
                                    <svg class="hero__button-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="hero__wrapp-push">
                            <img src="<?= img_url('hero/push.png'); ?>" alt="push">

                            <div class="hero__wrapp-push-shadow">
                                <div class="hero__wrapp-push-shadow-circle"></div>
                                <div class="hero__wrapp-push-shadow-circle"></div>
                                <div class="hero__wrapp-push-shadow-circle"></div>
                                <div class="hero__wrapp-push-shadow-circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hero__bg">
        <div class="item item-inst">
            <img src="<?= img_url('hero/btn-inst.png'); ?>" alt="inst">
        </div>
        <div class="item item-fb">
            <img src="<?= img_url('hero/btn-fb.png'); ?>" alt="fb">
        </div>
        <div class="item item-tiktok">
            <img src="<?= img_url('hero/btn-tiktok.png'); ?>" alt="tiktok">

            <div class="item-shadow">
                <div class="item-shadow__item"></div>
            </div>
        </div>
        <div class="item item-reddit">
            <img src="<?= img_url('hero/btn-reddit.png'); ?>" alt="reddit">

            <div class="item-shadow">
                <div class="item-shadow__item"></div>
                <div class="item-shadow__item"></div>
            </div>
        </div>

        <div class="item item-twitter">
            <img src="<?= img_url('hero/btn-twitter.png'); ?>" alt="twitter">
        </div>
        <div class="item item-link">
            <img src="<?= img_url('hero/btn-link.png'); ?>" alt="link">
        </div>
        <div class="item item-youtube">
            <img src="<?= img_url('hero/btn-youtube.png'); ?>" alt="youtube">

            <div class="item-shadow">
                <div class="item-shadow__item"></div>
                <div class="item-shadow__item"></div>
                <div class="item-shadow__item"></div>
            </div>
        </div>
    </div>
</div>

<div class="services" id="services">
    <div class="container">
        <h2 class="services__title">Наші <span>послуги</span></h2>

        <div class="services__slider">
            <div class="light">
                <div class="l1"></div>
                <div class="l2"></div>
                <div class="l3"></div>
                <div class="l4"></div>
            </div>
            <div class="slide">
                <div class="item">
                    <div class="item-head">
                        <img src="<?= img_url('services/s1.png'); ?>" alt="icon">
                    </div>
                    <div class="item-body">
                        <span class="title">01/SMM-консалтинг</span>
                        <span class="description">Повний аудит профілю з обговоренням і наданням SMM стратегії</span>
                    </div>
                </div>
            </div>

            <div class="slide">
                <div class="item">
                    <div class="item-head">
                        <img src="<?= img_url('services/s1.png'); ?>" alt="icon">
                    </div>
                    <div class="item-body">
                        <span class="title">02/SMM-консалтинг</span>
                        <span class="description">Повний аудит профілю з обговоренням і наданням SMM стратегії</span>
                    </div>
                </div>
            </div>

            <div class="slide">
                <div class="item">
                    <div class="item-head">
                        <img src="<?= img_url('services/s1.png'); ?>" alt="icon">
                    </div>
                    <div class="item-body">
                        <span class="title">03/SMM-консалтинг</span>
                        <span class="description">Повний аудит профілю з обговоренням і наданням SMM стратегії</span>
                    </div>
                </div>
            </div>

            <div class="slide">
                <div class="item">
                    <div class="item-head">
                        <img src="<?= img_url('services/s1.png'); ?>" alt="icon">
                    </div>
                    <div class="item-body">
                        <span class="title">01/SMM-консалтинг</span>
                        <span class="description">Повний аудит профілю з обговоренням і наданням SMM стратегії</span>
                    </div>
                </div>
            </div>

            <div class="slide">
                <div class="item">
                    <div class="item-head">
                        <img src="<?= img_url('services/s1.png'); ?>" alt="icon">
                    </div>
                    <div class="item-body">
                        <span class="title">01/SMM-консалтинг</span>
                        <span class="description">Повний аудит профілю з обговоренням і наданням SMM стратегії</span>
                    </div>
                </div>
            </div>

            <div class="slide">
                <div class="item">
                    <div class="item-head">
                        <img src="<?= img_url('services/s1.png'); ?>" alt="icon">
                    </div>
                    <div class="item-body">
                        <span class="title">01/SMM-консалтинг</span>
                        <span class="description">Повний аудит профілю з обговоренням і наданням SMM стратегії</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="whyus" id="whyus">
    <div class="container">
        <div class="row">
            <div class="col-1">
                <div class="whyus__emoji-wrapp">
                    <img src="<?= img_url('whyus/blckbtn.png'); ?>" alt="emoji" class="whyus__emoji">
                </div>
            </div>
            <div class="col">
                <div class="whyus__head">
                    <div class="whyus__emoji-wrapp">
                        <img src="<?= img_url('whyus/blckbtn.png'); ?>" alt="emoji" class="whyus__emoji mob">
                    </div>
                    <h2 class="whyus__title">
                        <span class="whyus__title-first">чому</span>
                        <span>саме ми?</span>
                    </h2>
                </div>
            </div>
        </div>

        <div class="whyus__wrapp">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-2">
                    <div class="whyus__item">
                        <div class="content">
                            <span class="num">01</span>
                            <span class="title">Кожен крок має сенс</span>
                            <span class="description">Ми робимо тільки те, що реально працює, і завжди відповідаємо на питання: “Навіщо це потрібно твоєму бізнесу?”</span>
                        </div>
                    </div>
                </div>
                <div class="col-3-4">
                    <div class="whyus__item colorist item-3">
                        <div class="content" style="background-image: url('<?= img_url('bg/bg-whyus-item.png'); ?>');">
                            <span class="num">02</span>
                            <span class="title">Сучасний дизайн, який виділяє</span>
                            <span class="description">Жодних чорно-білих розкладок, "шахматок" чи бежевих профілів. Твій бренд завжди виглядатиме стильно, сучасно і впізнавано.</span>
                        </div>
                        <div class="light">
                            <div class="light-1">
                                <div class="l1"></div>
                                <div class="l2"></div>
                                <div class="l3"></div>
                            </div>
                            <div class="light-2">
                                <div class="l1"></div>
                                <div class="l2"></div>
                                <div class="l3"></div>
                                <div class="l4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-2">
                <div class="col-1">
                    <div class="whyus__item colorist item-3">
                        <div class="content" style="background-image: url('<?= img_url('bg/bg-whyus-item2.png'); ?>');">
                            <span class="num">03</span>
                            <span class="title">Технології, які працюють на тебе</span>
                            <span class="description">Для нас VEO3 - не абревіатура, а звичний інструмент для креативу, аналітики та результату.</span>
                        </div>
                        <div class="light">
                            <div class="light-1">
                                <div class="l1"></div>
                                <div class="l2"></div>
                                <div class="l3"></div>
                            </div>
                            <div class="light-2">
                                <div class="l1"></div>
                                <div class="l2"></div>
                                <div class="l3"></div>
                                <div class="l4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
                <div class="col-3">
                    <div class="whyus__item">
                        <div class="content">
                            <span class="num">04</span>
                            <span class="title">Креатив + системність = результат</span>
                            <span class="description">Ми поєднуємо нестандартні ідеї з дисципліною та чіткими дедлайнами. Твої пости завжди будуть там, де потрібно, у потрібний час.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="pushstart" class="pushstart">
    <div class="container">
        <div class="pushstart__wrapp">
            <div class="pushstart__cursors">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-1">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-2">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-3">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-4">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-5">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-6">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-7">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-8">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-9">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-10">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-11">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-12">
                <img src="<?= img_url('icons/cursor.png'); ?>" alt="cursor" class="cursor cursor-13">
            </div>
            <div class="content">
                <div class="title">
                    <span>PUSH-СТАРТ</span>
                    <span>ДЛЯ ТВОГО БРЕНДУ</span>
                </div>

                <p class="description">Залиш свій телефон і ім’я, і ми швидко зв’яжемося з тобою, щоб зрозуміти твої цілі, підібрати найефективнішу стратегію, показати, як твої соцмережі можуть реально продавати.</p>

                <form action="">
                    <div class="form">
                        <input type="text" placeholder="Ваше Ім’я">
                        <input type="text" placeholder="Номер телефону">
                        <div class="buttons">
                            <button class="send">
                                Зв’язатись з нами

                                <div class="icon-wrap">
                                    <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"></path>
                                    </svg>
                                </div>
                            </button>
                            <a href="#" class="social">
                                <svg class="icon" viewBox="0 0 37 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M33.8208 8.18363L29.1496 30.6432C28.8012 32.225 27.907 32.5812 26.6151 31.8671L19.6082 26.5598L16.178 29.9275C15.8311 30.2854 15.4827 30.6432 14.6872 30.6432L15.2345 23.2411L28.3048 11.0431C28.8505 10.481 28.1552 10.2768 27.4599 10.7375L11.2092 21.2509L4.2008 19.0564C2.66068 18.5465 2.66068 17.473 4.54922 16.7605L31.7828 5.8878C33.124 5.4793 34.2679 6.19496 33.8208 8.18363Z" fill="white"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="cases" class="cases">
    <div class="container">
        <div class="row cases__row">
            <div class="col-1-2">
                <div class="cases__wrap">
                    <h2 class="cases__title">
                        <span>Наші</span>
                        <span>Кейси</span>
                    </h2>

                    <p class="cases__description">
                        Ми створюємо стратегії, які приносять реальні результати. Подивись, як ми допомагаємо брендам розвиватися в соціальних мережах, формувати впізнаваність і збільшувати продажі.
                    </p>

                    <div class="cases__buttons">
                        <button class="cases__filter-btn" data-slide-index="0">SMM-консалтинг</button>
                        <button class="cases__filter-btn" data-slide-index="1">Введення сторінок</button>
                        <button class="cases__filter-btn" data-slide-index="2">Брендинг</button>
                        <button class="cases__filter-btn" data-slide-index="3">Таргет</button>
                        <button class="cases__filter-btn" data-slide-index="4">Створення креативів</button>
                        <button class="cases__filter-btn" data-slide-index="5">АІ-контент</button>
                        <button class="cases__filter-btn" data-slide-index="6">Зйомка відео</button>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="cases__slider">
                    <div class="cases__slider-container">
                        <div class="cases__card cases__card--white">
                            <h3 class="cases__card-title">СТРАТЕГІЯ РОСТУ ДЛЯ GLOWUP STUDIO</h3>
                            <p class="cases__card-description">
                                Ми допомогли сформувати сильний бренд спортивного харчування, що викликає довіру та виділяється серед конкурентів. Стратегія включала унікальний візуальний стиль, послідовну комунікацію та контент-план для побудови активної спільноти.
                            </p>
                            <div>
                                <button class="cases__card-button">
                                    <span>Детальніше</span>
                                    <div class="cases__card-button-icon">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"/>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="cases__card-kpi">
                                <div class="cases__card-kpi-item">
                                    <span class="cases__card-kpi-value">+450</span>
                                    <span class="cases__card-kpi-label">продажів за місяць</span>
                                </div>
                                <div class="cases__card-kpi-item">
                                    <span class="cases__card-kpi-value">320%</span>
                                    <span class="cases__card-kpi-label">збільшення охоплення</span>
                                </div>
                            </div>
                        </div>

                        <div class="cases__card cases__card--white">
                            <h3 class="cases__card-title">SKINLAB - КОМПЛЕКС ЩО ФОРМУЄ ДОВІРУ</h3>
                            <p class="cases__card-description">
                                Ми розробили SMM-стратегію для клініки, щоб підвищити впізнаваність, довіру та залучити нових клієнтів. Створили візуальний стиль у clean, експертний контент і комунікацію, що відображає турботу та професійність.
                            </p>
                            <div>
                                <button class="cases__card-button">
                                    <span>Детальніше</span>
                                    <div class="cases__card-button-icon">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"/>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="cases__card-kpi">
                                <div class="cases__card-kpi-item">
                                    <span class="cases__card-kpi-value">+60%</span>
                                    <span class="cases__card-kpi-label">заявок із Instagram</span>
                                </div>
                                <div class="cases__card-kpi-item">
                                    <span class="cases__card-kpi-value">+8</span>
                                    <span class="cases__card-kpi-label">залучених клієнтів</span>
                                </div>
                            </div>
                        </div>

                        <div class="cases__card cases__card--white">
                            <h3 class="cases__card-title">СТРАТЕГІЯ РОСТУ ДЛЯ GLOWUP STUDIO</h3>
                            <p class="cases__card-description">
                                Ми допомогли сформувати сильний бренд спортивного харчування, що викликає довіру та виділяється серед конкурентів. Стратегія включала унікальний візуальний стиль, послідовну комунікацію та контент-план для побудови активної спільноти.
                            </p>
                            <div>
                                <button class="cases__card-button">
                                    <span>Детальніше</span>
                                    <div class="cases__card-button-icon">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"/>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="cases__card-kpi">
                                <div class="cases__card-kpi-item">
                                    <span class="cases__card-kpi-value">+450</span>
                                    <span class="cases__card-kpi-label">продажів за місяць</span>
                                </div>
                                <div class="cases__card-kpi-item">
                                    <span class="cases__card-kpi-value">320%</span>
                                    <span class="cases__card-kpi-label">збільшення охоплення</span>
                                </div>
                            </div>
                        </div>

                        <div class="cases__card cases__card--white">
                            <h3 class="cases__card-title">SKINLAB - КОМПЛЕКС ЩО ФОРМУЄ ДОВІРУ</h3>
                            <p class="cases__card-description">
                                Ми розробили SMM-стратегію для клініки, щоб підвищити впізнаваність, довіру та залучити нових клієнтів. Створили візуальний стиль у clean, експертний контент і комунікацію, що відображає турботу та професійність.
                            </p>
                            <div>
                                <button class="cases__card-button">
                                    <span>Детальніше</span>
                                    <div class="cases__card-button-icon">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"/>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="cases__card-kpi">
                                <div class="cases__card-kpi-item">
                                    <span class="cases__card-kpi-value">+60%</span>
                                    <span class="cases__card-kpi-label">заявок із Instagram</span>
                                </div>
                                <div class="cases__card-kpi-item">
                                    <span class="cases__card-kpi-value">+8</span>
                                    <span class="cases__card-kpi-label">залучених клієнтів</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cases__slider-indicator">
                        <div class="cases__slider-indicator-progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="actors" class="actors">
    <div class="container">
        <div class="actors__head">
            <div class="actors__title">
                <div class="title">наші <span>актори</span></div>
                <div class="sub">Команда, яка вміє працювати на камеру.</div>
            </div>
            <div class="actors__emoji">
                <img src="<?= img_url('actors/emoji.png'); ?>" alt="emoji">
            </div>
        </div>

        <div class="actors__slider">
            <div class="swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="item">
                            <div class="image">
                                <img src="<?= img_url('actors/1.png'); ?>" alt="#Актор 1">
                            </div>
                            <div class="body">
                                <h3 class="title">#Актор 1</h3>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="item">
                            <div class="image">
                                <img src="<?= img_url('actors/2.png'); ?>" alt="#Актор 2">
                            </div>
                            <div class="body">
                                <h3 class="title">#Актор 2</h3>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="item">
                            <div class="image">
                                <img src="<?= img_url('actors/3.png'); ?>" alt="#Актор 3">
                            </div>
                            <div class="body">
                                <h3 class="title">#Актор 3</h3>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="item">
                            <div class="image">
                                <img src="<?= img_url('actors/4.png'); ?>" alt="#Актор 4">
                            </div>
                            <div class="body">
                                <h3 class="title">#Актор 4</h3>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="item">
                            <div class="image">
                                <img src="<?= img_url('actors/5.png'); ?>" alt="#Актор 5">
                            </div>
                            <div class="body">
                                <h3 class="title">#Актор 5</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="collab" class="collab">
    <div class="container">
        <div class="collab__title">
            <div class="title">етапи <span>співпраці</span></div>
            <div class="sub">Ми розробляємо кожен крок співпраці з тобою, щоб створити найкращий результат.</div>

            <div class="buttons">
                <div class="buttons__item button-1">
                    <span>Push</span>
                </div>
                <div class="buttons__item button-2">
                    <span>your</span>
                </div>
                <div class="buttons__item button-3">
                    <span>business</span>
                </div>
            </div>
        </div>

        <div class="collab__steps">
            <div class="item">
                <div class="num">01</div>
                <div class="content">
                    <span class="title">Бриф</span>
                    <p class="description">Заповнюєш форму, де розповідаєш про бізнес, цілі та очікування - щоб ми зразу розуміли контекст і завдання.</p>
                </div>
            </div>

            <div class="item">
                <div class="num">02</div>
                <div class="content">
                    <span class="title">старт проєкту</span>
                    <p class="description">Додаємо тебе у спільний чат із командою, щоб ти міг(ла) бачити всі оновлення, ставити запитання та бути в курсі процесу.</p>
                </div>
            </div>

            <div class="item">
                <div class="num">03</div>
                <div class="content">
                    <span class="title">комунікація</span>
                    <p class="description">Менеджер зв’язується з тобою, щоб уточнити деталі, відповісти на запитання й переконатися, що ми однаково бачимо цілі проєкту.</p>
                </div>
            </div>

            <div class="item">
                <div class="num">04</div>
                <div class="content">
                    <span class="title">план дій</span>
                    <p class="description">Презентуємо покрокову стратегію або таймлайн проєкту, обговорюємо та затверджуємо її перед запуском основних етапів.</p>
                </div>
            </div>

            <div class="item">
                <div class="num">05</div>
                <div class="content">
                    <span class="title">пропозиція</span>
                    <p class="description">Готуємо для тебе комерційну пропозицію з чітким планом дій, строками, етапами роботи та вартістю кожного з них.</p>
                </div>
            </div>

            <div class="item">
                <div class="num">06</div>
                <div class="content">
                    <span class="title">реалізація</span>
                    <p class="description">Переходимо до роботи: запускаємо всі процеси, узгоджуємо проміжні результати й тримаємо тебе в курсі кожного кроку.</p>
                </div>
            </div>

            <div class="item">
                <div class="num">07</div>
                <div class="content">
                    <span class="title">узгодження</span>
                    <p class="description">Погоджуємо всі умови, терміни та формат співпраці. Після цього закріплюємо домовленості оплатою - і офіційно стартуємо.</p>
                </div>
            </div>

            <div class="item">
                <div class="num">08</div>
                <div class="content">
                    <span class="title">звітність</span>
                    <p class="description">Наприкінці місяця надсилаємо звіт про виконану роботу, результати та обговорюємо плани на наступний етап під час дзвінка.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="faq" class="faq">
    <div class="container">
        <span class="faq__title">FAQ</span>
    </div>

    <div class="faq__folders">
        <!-- Folder 1 -->
        <div class="folder folder--black folder--1">
            <div class="folder__tab">
                <span class="title">SMM-консалтинг</span>
            </div>
            <div class="folder__content">
                <div class="folder__content--image">
                    <img src="<?= img_url('faq/folder-1.png'); ?>" alt="">
                </div>
                <div class="container">
                    <div class="folder__content--wrapp">

                        <a href="#" class="item">
                            <span>01/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>02/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>03/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>04/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- Folder 2 -->
        <div class="folder folder--orange folder--2">
            <div class="folder__tab">
                <span class="title">Введення сторінок</span>
            </div>
            <div class="folder__content">
                <div class="folder__content--image">
                    <div class="socials">
                        <img src="<?= img_url('faq/folder-2-fb.png'); ?>" alt="">
                        <img src="<?= img_url('faq/folder-2-tt.png'); ?>" alt="">
                        <img src="<?= img_url('faq/folder-2-inst.png'); ?>" alt="">
                    </div>
                </div>
                <div class="container">
                    <div class="folder__content--wrapp">

                        <a href="#" class="item">
                            <span>01/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>02/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>03/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>04/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- Folder 3 -->
        <div class="folder folder--black folder--3">
            <div class="folder__tab">
                <span class="title">Таргет</span>
            </div>
            <div class="folder__content">
                <div class="folder__content--image">
                    <img src="<?= img_url('faq/folder-3.png'); ?>" alt="">
                </div>
                <div class="container">
                    <div class="folder__content--wrapp">

                        <a href="#" class="item">
                            <span>01/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>02/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>03/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>04/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- Folder 4 -->
        <div class="folder folder--orange folder--4">
            <div class="folder__tab">
                <span class="title">Брендинг</span>
            </div>
            <div class="folder__content">
                <div class="folder__content--image">
                    <img src="<?= img_url('faq/folder-4.png'); ?>" alt="">
                </div>
                <div class="container">
                    <div class="folder__content--wrapp">

                        <a href="#" class="item">
                            <span>01/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>02/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>03/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>04/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- Folder 5 -->
        <div class="folder folder--black folder--5">
            <div class="folder__tab">
                <span class="title">Створення креативів</span>
            </div>
            <div class="folder__content">
                <div class="folder__content--image">
                    <img src="<?= img_url('faq/folder-5.png'); ?>" alt="">
                </div>
                <div class="container">
                    <div class="folder__content--wrapp">

                        <a href="#" class="item">
                            <span>01/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>02/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>03/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>04/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- Folder 6 -->
        <div class="folder folder--orange folder--6">
            <div class="folder__tab">
                <span class="title">Зйомка відео</span>
            </div>
            <div class="folder__content">
                <div class="folder__content--image">
                    <img src="<?= img_url('faq/folder-6.png'); ?>" alt="">
                </div>
                <div class="container">
                    <div class="folder__content--wrapp">

                        <a href="#" class="item">
                            <span>01/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>02/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>03/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>04/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- Folder 7 -->
        <div class="folder folder--black folder--7">
            <div class="folder__tab">
                <span class="title">Аі-контент</span>
            </div>
            <div class="folder__content">
                <div class="folder__content--image">
                    <img src="<?= img_url('faq/folder-7.png'); ?>" alt="">
                </div>
                <div class="container">
                    <div class="folder__content--wrapp">

                        <a href="#" class="item">
                            <span>01/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>02/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>03/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="#" class="item">
                            <span>04/Що входить у послугу SMM-консалтингу?</span>
                            <div class="item__icon">
                                <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                </svg>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- Folder 8 -->
        <div class="folder folder--orange folder--8">
            <div class="folder__tab">
                <span class="title"></span>
            </div>
            <div class="folder__content">
                <div class="container">
                    <div class="folder__content--wrapp">

                        <div class="contacts">
                            <div class="container">
                                <div class="row">
                                    <div class="col-1-2">
                                        <div class="contacts__info">
                                            <h3 class="contacts__title">контакти</h3>
                                            <p class="contacts__description">Хочеш обговорити проект або просто дізнатися, як ми можемо допомогти твоєму бізнесу рости? Зв’яжись з нами будь-яким зручним способом — ми швидко відповімо!</p>

                                            <div class="contacts__actions">
                                                <button class="contacts__button">
                                                    <span>Заповнити бриф</span>
                                                    <div class="contacts__button-icon-wrapp">
                                                        <svg class="contacts__button-icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"></path>
                                                        </svg>
                                                    </div>
                                                </button>

                                                <button class="contacts__button">
                                                    <span>Зв’язатись з нами</span>
                                                    <div class="contacts__button-icon-wrapp">
                                                        <svg class="contacts__button-icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"></path>
                                                        </svg>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3"></div>
                                    <div class="col-4-5">
                                        <div class="contacts__contacts">
                                            <button class="contacts__button">
                                                <div class="info">
                                                    <span class="name">telegram</span>
                                                    <span class="sub">@pushsmmagency</span>
                                                </div>
                                                <div class="contacts__button-icon-wrapp">
                                                    <svg class="contacts__button-icon" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_16_1286)">
                                                        <path d="M33.8292 3.26628L1.21006 15.91C-0.102596 16.4988 -0.546572 17.6779 0.892789 18.3179L9.26101 20.991L29.4943 8.42176C30.5991 7.63269 31.7301 7.8431 30.7569 8.71113L13.3792 24.5268L12.8333 31.2199C13.3389 32.2533 14.2647 32.2582 14.8552 31.7445L19.663 27.1718L27.8971 33.3695C29.8096 34.5076 30.8502 33.7732 31.2617 31.6873L36.6625 5.98141C37.2233 3.41384 36.267 2.28254 33.8292 3.26628Z" fill="white"/>
                                                        </g>
                                                        <defs>
                                                        <clipPath id="clip0_16_1286">
                                                        <rect width="36.8182" height="36.8182" fill="white"/>
                                                        </clipPath>
                                                        </defs>
                                                    </svg>
                                                </div>
                                            </button>

                                            <button class="contacts__button">
                                                <div class="info">
                                                    <span class="name">email</span>
                                                    <span class="sub">pushsmmagency@gmail.com</span>
                                                </div>
                                                <div class="contacts__button-icon-wrapp">
                                                    <svg class="contacts__button-icon" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M32.5 4H4.5C2.575 4 1.0175 5.575 1.0175 7.5L1 28.5C1 30.425 2.575 32 4.5 32H32.5C34.425 32 36 30.425 36 28.5V7.5C36 5.575 34.425 4 32.5 4ZM31.8 11.4375L19.4275 19.1725C18.8675 19.5225 18.1325 19.5225 17.5725 19.1725L5.2 11.4375C5.02452 11.339 4.87086 11.2059 4.74831 11.0463C4.62575 10.8867 4.53686 10.7039 4.48701 10.5089C4.43716 10.3139 4.42738 10.1109 4.45827 9.91204C4.48917 9.71319 4.56009 9.52267 4.66674 9.35203C4.7734 9.18138 4.91357 9.03415 5.07877 8.91924C5.24397 8.80434 5.43077 8.72414 5.62787 8.68352C5.82496 8.6429 6.02825 8.64269 6.22542 8.68291C6.4226 8.72313 6.60956 8.80293 6.775 8.9175L18.5 16.25L30.225 8.9175C30.3904 8.80293 30.5774 8.72313 30.7746 8.68291C30.9718 8.64269 31.175 8.6429 31.3721 8.68352C31.5692 8.72414 31.756 8.80434 31.9212 8.91924C32.0864 9.03415 32.2266 9.18138 32.3333 9.35203C32.4399 9.52267 32.5108 9.71319 32.5417 9.91204C32.5726 10.1109 32.5628 10.3139 32.513 10.5089C32.4631 10.7039 32.3743 10.8867 32.2517 11.0463C32.1291 11.2059 31.9755 11.339 31.8 11.4375Z" fill="white"/>
                                                    </svg>
                                                </div>
                                            </button>

                                            <button class="contacts__button">
                                                <div class="info">
                                                    <span class="name">телефон</span>
                                                    <span class="sub">+38 (067) 555-23-41</span>
                                                </div>
                                                <div class="contacts__button-icon-wrapp">
                                                    <svg class="contacts__button-icon" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M28.1518 34.558C26.7465 34.558 24.7724 34.0497 21.8162 32.3981C18.2215 30.3823 15.441 28.5212 11.8657 24.9552C8.41857 21.5103 6.74107 19.2798 4.3933 15.0076C1.74099 10.1839 2.19312 7.65545 2.69853 6.57479C3.30041 5.28319 4.18883 4.51068 5.33716 3.74393C5.9894 3.31659 6.67964 2.95026 7.39911 2.6496C7.47111 2.61864 7.53806 2.58912 7.59782 2.56248C7.9542 2.40193 8.49416 2.15931 9.17812 2.41849C9.63457 2.58984 10.0421 2.94046 10.6799 3.57042C11.9881 4.86058 13.7758 7.73392 14.4352 9.14503C14.878 10.0961 15.171 10.7239 15.1717 11.428C15.1717 12.2524 14.7571 12.8881 14.2538 13.5742C14.1595 13.7031 14.0659 13.8262 13.9752 13.9457C13.4273 14.6656 13.3071 14.8737 13.3863 15.2452C13.5468 15.9918 14.7441 18.2143 16.7117 20.1776C18.6794 22.1409 20.8378 23.2626 21.5873 23.4225C21.9746 23.5053 22.187 23.38 22.93 22.8127C23.0365 22.7313 23.146 22.6471 23.2604 22.5628C24.0279 21.9919 24.6341 21.588 25.439 21.588H25.4433C26.1439 21.588 26.7436 21.8918 27.7371 22.3929C29.033 23.0466 31.9928 24.8113 33.2909 26.1209C33.9223 26.7573 34.2743 27.1633 34.4464 27.6191C34.7056 28.3052 34.4615 28.843 34.3024 29.203C34.2758 29.2627 34.2462 29.3283 34.2153 29.401C33.9122 30.1192 33.5437 30.8079 33.1145 31.4586C32.3492 32.6033 31.5738 33.4896 30.2793 34.0922C29.6146 34.4067 28.8871 34.5659 28.1518 34.558Z" fill="white"/>
                                                    </svg>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="bonus" class="bonus">
    <div class="container">
        <div class="bonus__title">
            <span class="bonus__title-first">Натисни на подарунок, щоб</span>
            <span class="bonus__title-second">отримати бонус</span>
        </div>

        <div class="bonus__wrapp">
            <div class="bonus__item">
                <div class="bonus__item-close">
                    <img src="<?= img_url('bonus/bonus-close.png'); ?>" alt="">
                </div>

                <div class="bonus__item-open">
                    <img src="<?= img_url('bonus/bonus-open.png'); ?>" alt="">

                    <div class="bonus__item-content">
                        <span class="bonus__item-content-title">Бонус</span>
                    </div>
                </div>

                <div class="bonus__item-shadow"></div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для кейсов -->
<div class="cases-modal" id="casesModal">
    <div class="cases-modal__overlay"></div>
    <div class="cases-modal__content">
        <button class="cases-modal__close" aria-label="Закрыть">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
        
        <div class="cases-modal__header">
            <h2 class="cases-modal__title">
                <span class="cases-modal__title-orange">СТРАТЕГІЯ РОСТУ</span>
                <span class="cases-modal__title-black">ДЛЯ GLOWUP STUDIO</span>
            </h2>
            <p class="cases-modal__subtitle">SMM / Контент-стратегія / Візуальна айдентика</p>
            <p class="cases-modal__sub">ЛОГО КОМПАНІЇ</p>
        </div>

        <div class="cases-modal__body">
            <div class="cases-modal__content-left">
                <div class="cases-modal__section">
                    <h3 class="cases-modal__section-title">ЗАВДАННЯ</h3>
                    <p class="cases-modal__section-text">
                        GlowUp Studio — новий бренд спортивного харчування, який прагнув увійти на ринок з професійним іміджем та чіткою позицією. Основна мета — створити стратегію росту, що поєднує контент, дизайн та комунікацію з аудиторією.
                    </p>
                </div>

                <div class="cases-modal__section">
                    <h3 class="cases-modal__section-title">РІШЕННЯ</h3>
                    <p class="cases-modal__section-text">
                        Було створено комплексну стратегію розвитку бренду, що включала:
                    </p>
                    <ul class="cases-modal__section-list">
                        <li>Унікальний візуальний стиль для соціальних мереж (кольори, шрифти, tone of voice)</li>
                        <li>Контент-план, що балансує експертний, мотиваційний та промо-контент</li>
                        <li>Запуск рубрикатора stories для системної комунікації з аудиторією</li>
                        <li>Створення гайду для постів та stories для автономності команди клієнта</li>
                        <li>Розробка місячного SMM-плану з чіткими KPI та форматами контенту</li>
                    </ul>
                </div>

                <div class="cases-modal__section">
                    <h3 class="cases-modal__section-title">РЕЗУЛЬТАТИ</h3>
                    <p class="cases-modal__section-text">
                        За перший місяць після запуску:
                    </p>
                    <ul class="cases-modal__section-list">
                        <li>+450 продажів з органічного контенту</li>
                        <li>+320% охоплення сторінки Instagram</li>
                        <li>Підвищення впізнаваності бренду серед аудиторії спортивного харчування</li>
                        <li>Формування стабільної спільноти навколо бренду</li>
                    </ul>
                </div>

                <div class="cases-modal__section">
                    <h3 class="cases-modal__section-title">ВИСНОВКИ</h3>
                    <p class="cases-modal__section-text">
                        Успішна стратегія росту базується на послідовності, єдиній візуальній системі, якісному контенті та активній взаємодії з аудиторією, що дозволило GlowUp Studio побудувати повноцінну спільноту, яка передає енергію та довіру до бренду.
                    </p>
                </div>
            </div>

            <div class="cases-modal__content-right">
                <div class="cases-modal__logo">
                    <div class="cases-modal__image-placeholder">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16L8 12L12 16L20 8" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 8H16V12" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="cases-modal__images">
                    <div class="cases-modal__image-placeholder cases-modal__image-placeholder--small">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16L8 12L12 16L20 8" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 8H16V12" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="cases-modal__image-placeholder cases-modal__image-placeholder--small">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16L8 12L12 16L20 8" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 8H16V12" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="cases-modal__video">
                    <div class="cases-modal__image-placeholder cases-modal__image-placeholder--video">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#9CA3AF" stroke-width="2"/>
                            <path d="M10 8L16 12L10 16V8Z" fill="#9CA3AF"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();

