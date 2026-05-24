@extends('layouts.app')

@push('styles')
<style>
:root {
    --green: #17382b;
    --green-light: #2d6a4f;
    --green-soft: #e9f2ed;
    --gold: #c8a165;
    --gold-light: #e2c08d;
    --ink: #1e2c25;
    --muted: #6f7d73;
    --line: rgba(26, 60, 46, 0.12);
    --white: #ffffff;
    --bg-light: #f8f5f0;
    --shadow-sm: 0 10px 28px rgba(26, 60, 46, 0.08);
    --shadow-md: 0 22px 52px rgba(26, 60, 46, 0.14);
}

.home-page {
    overflow: hidden;
    background: #fff;
}

.home-scroll-progress {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1080;
    width: 100%;
    height: 3px;
    pointer-events: none;
}

.home-scroll-progress span {
    display: block;
    width: 0%;
    height: 100%;
    background: linear-gradient(90deg, var(--gold), var(--green-light));
    box-shadow: 0 0 18px rgba(200, 161, 101, 0.5);
}

.floating-wellness-cta {
    position: fixed;
    right: 22px;
    bottom: 22px;
    z-index: 1040;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    min-height: 56px;
    padding: 10px 18px 10px 10px;
    border-radius: 50px;
    color: var(--green) !important;
    background: rgba(255,255,255,0.92);
    border: 1px solid rgba(200, 161, 101, 0.42);
    box-shadow: 0 18px 44px rgba(26, 60, 46, 0.2);
    text-decoration: none;
    opacity: 0;
    transform: translateY(18px);
    pointer-events: none;
    backdrop-filter: blur(16px);
    transition: opacity 0.28s ease, transform 0.28s ease, box-shadow 0.28s ease;
}

.floating-wellness-cta.is-visible {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
}

.floating-wellness-cta:hover {
    color: var(--green) !important;
    transform: translateY(-4px);
    box-shadow: 0 24px 58px rgba(26, 60, 46, 0.28);
}

.floating-wellness-cta .floating-icon {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--green), var(--green-light));
    box-shadow: 0 8px 18px rgba(26, 60, 46, 0.24);
}

.floating-wellness-cta strong {
    display: block;
    font-size: 0.86rem;
    line-height: 1;
}

.floating-wellness-cta small {
    display: block;
    color: var(--muted);
    font-size: 0.68rem;
    line-height: 1.2;
    margin-top: 3px;
}

.section-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--green);
    font-weight: 800;
    font-size: 0.72rem;
    letter-spacing: 2.4px;
    text-transform: uppercase;
    padding: 7px 16px;
    background: rgba(200, 161, 101, 0.13);
    border-radius: 50px;
    border: 1px solid rgba(200, 161, 101, 0.26);
    margin-bottom: 12px;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    color: var(--green);
    line-height: 1.12;
    letter-spacing: 0;
}

.section-copy {
    max-width: 620px;
    color: var(--muted);
    line-height: 1.8;
}

.section-divider {
    width: 64px;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), transparent);
    border-radius: 10px;
    margin-top: 15px;
}

.section-divider.center {
    margin-left: auto;
    margin-right: auto;
}

.soft-band {
    background:
        linear-gradient(180deg, rgba(255,255,255,0.72), rgba(248,245,240,0.94)),
        radial-gradient(circle at 8% 10%, rgba(45,106,79,0.08), transparent 30%);
}

/* Hero */
.hero-slider {
    height: 92vh;
    min-height: 680px;
}

.hero-slide-link {
    z-index: 1;
}

.hero-overlay {
    background:
        linear-gradient(105deg, rgba(10,18,14,0.94) 0%, rgba(10,18,14,0.68) 50%, rgba(10,18,14,0.14) 100%),
        linear-gradient(0deg, rgba(10,18,14,0.22), rgba(10,18,14,0));
    z-index: 1;
    pointer-events: none;
}

.hero-content {
    opacity: 0;
    transform: translateY(36px);
    transition: all 1s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.2s;
}

.swiper-slide-active .hero-content {
    opacity: 1;
    transform: translateY(0);
}

.hero-slider:not(.swiper-initialized) .hero-content {
    opacity: 1;
    transform: none;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(200, 161, 101, 0.15);
    border: 1px solid rgba(200, 161, 101, 0.4);
    color: var(--gold-light);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.76rem;
    font-weight: 800;
    letter-spacing: 2.6px;
    text-transform: uppercase;
    backdrop-filter: blur(10px);
    margin-bottom: 24px;
    animation: badgePulse 3s ease-in-out infinite;
}

@keyframes badgePulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(200, 161, 101, 0.28); }
    50% { box-shadow: 0 0 0 8px rgba(200, 161, 101, 0); }
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.75rem, 5.8vw, 5.2rem);
    font-weight: 800;
    line-height: 1.05;
    letter-spacing: 0;
    color: #fff;
    text-shadow: 0 4px 30px rgba(0,0,0,0.3);
    margin-bottom: 24px;
}

.hero-subtitle {
    font-size: clamp(1rem, 2vw, 1.18rem);
    color: rgba(255,255,255,0.86);
    font-weight: 300;
    line-height: 1.85;
    max-width: 580px;
    margin-bottom: 36px;
}

.hero-btn-primary,
.home-outline-btn {
    min-height: 52px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 0.95rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: transform 0.28s ease, box-shadow 0.28s ease, background 0.28s ease, color 0.28s ease;
}

.hero-btn-primary {
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--green) !important;
    border: none;
    padding: 15px 34px;
    box-shadow: 0 12px 28px rgba(200, 161, 101, 0.34);
    position: relative;
    overflow: hidden;
}

.hero-btn-primary::before {
    content: '';
    position: absolute;
    top: -60%;
    left: -65%;
    width: 40%;
    height: 220%;
    background: rgba(255,255,255,0.36);
    transform: skewX(-20deg);
    transition: left 0.62s ease;
}

.hero-btn-primary:hover::before {
    left: 130%;
}

.hero-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 42px rgba(200, 161, 101, 0.44);
}

.hero-btn-primary i,
.home-outline-btn i,
.newsletter-btn,
.slider-btn i {
    transition: transform 0.25s ease;
}

.hero-btn-primary:hover i,
.home-outline-btn:hover i {
    transform: translateX(4px);
}

.home-outline-btn {
    border: 2px solid var(--green);
    color: var(--green) !important;
    background: transparent;
    padding: 13px 28px;
}

.home-outline-btn:hover {
    background: var(--green);
    color: #fff !important;
    transform: translateY(-3px);
    box-shadow: 0 14px 28px rgba(26, 60, 46, 0.18);
}

.hero-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    margin-top: 46px;
    padding-top: 34px;
    border-top: 1px solid rgba(255,255,255,0.15);
}

.hero-stat {
    min-width: 118px;
    padding: 14px 16px;
    border: 1px solid rgba(255,255,255,0.14);
    background: rgba(255,255,255,0.07);
    backdrop-filter: blur(10px);
    border-radius: 8px;
}

.hero-stat h3 {
    font-size: 1.85rem;
    font-weight: 800;
    color: var(--gold);
    margin: 0;
    font-family: 'Playfair Display', serif;
}

.hero-stat p {
    font-size: 0.72rem;
    color: rgba(255,255,255,0.7);
    margin: 2px 0 0;
    text-transform: uppercase;
    letter-spacing: 1.1px;
}

.hero-herbal-gallery {
    position: absolute;
    right: clamp(36px, 6vw, 92px);
    top: 50%;
    z-index: 2;
    width: min(34vw, 430px);
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    transform: translateY(-50%);
    pointer-events: none;
}

.hero-herbal-photo {
    position: relative;
    min-height: 128px;
    border: 1px solid rgba(226, 192, 141, 0.32);
    border-radius: 8px;
    overflow: hidden;
    background-size: cover;
    background-position: center;
    box-shadow: 0 18px 38px rgba(0, 0, 0, 0.22);
    opacity: 0;
    transform: translateY(22px) scale(0.96);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.hero-herbal-photo::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 34%, rgba(12, 24, 18, 0.38) 100%);
}

.hero-herbal-photo:nth-child(1) {
    grid-row: span 2;
    min-height: 270px;
}

.hero-herbal-photo:nth-child(5) {
    grid-column: span 2;
}

.swiper-slide-active .hero-herbal-photo {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.swiper-slide-active .hero-herbal-photo:nth-child(2) { transition-delay: 0.08s; }
.swiper-slide-active .hero-herbal-photo:nth-child(3) { transition-delay: 0.16s; }
.swiper-slide-active .hero-herbal-photo:nth-child(4) { transition-delay: 0.24s; }
.swiper-slide-active .hero-herbal-photo:nth-child(5) { transition-delay: 0.32s; }

.hero-herbal-caption {
    position: absolute;
    right: clamp(36px, 6vw, 92px);
    bottom: 92px;
    z-index: 3;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1px solid rgba(226, 192, 141, 0.36);
    border-radius: 50px;
    color: var(--gold-light);
    background: rgba(12, 24, 18, 0.46);
    backdrop-filter: blur(14px);
    padding: 9px 15px;
    font-size: 0.76rem;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    opacity: 0;
    transform: translateY(12px);
    transition: opacity 0.8s ease 0.38s, transform 0.8s ease 0.38s;
}

.swiper-slide-active .hero-herbal-caption {
    opacity: 1;
    transform: translateY(0);
}

.swiper-button-next,
.swiper-button-prev {
    width: 52px !important;
    height: 52px !important;
    background: rgba(255,255,255,0.1) !important;
    backdrop-filter: blur(10px);
    border-radius: 50% !important;
    border: 1px solid rgba(200,161,101,0.46) !important;
    transition: all 0.3s ease !important;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: var(--gold) !important;
    border-color: var(--gold) !important;
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 0.95rem !important;
    color: #fff !important;
    font-weight: 900 !important;
}

.swiper-pagination-bullet {
    background: rgba(255,255,255,0.55) !important;
    width: 8px !important;
    height: 8px !important;
    transition: all 0.3s ease !important;
}

.swiper-pagination-bullet-active {
    background: var(--gold) !important;
    width: 30px !important;
    border-radius: 4px !important;
}

/* Compact trust strip */
.trust-strip {
    margin-top: -34px;
    position: relative;
    z-index: 5;
}

.trust-panel {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1px;
    overflow: hidden;
    border-radius: 8px;
    border: 1px solid var(--line);
    background: var(--line);
    box-shadow: var(--shadow-sm);
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 14px;
    min-height: 92px;
    padding: 20px 24px;
    background: #fff;
}

.trust-item i {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: var(--green);
    background: rgba(200, 161, 101, 0.18);
    flex: 0 0 auto;
}

.trust-item strong {
    display: block;
    color: var(--ink);
    font-size: 0.98rem;
}

.trust-item span {
    display: block;
    color: var(--muted);
    font-size: 0.84rem;
    margin-top: 2px;
}

/* Category cards */
.category-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
    align-items: stretch;
}

.category-item {
    min-width: 0;
}

.category-card {
    height: 100%;
    min-height: 0;
    border-radius: 8px !important;
    overflow: hidden;
    transition: transform 0.32s ease, box-shadow 0.32s ease, border-color 0.32s ease !important;
    border: 1px solid rgba(26, 60, 46, 0.1) !important;
    box-shadow: var(--shadow-sm) !important;
    position: relative;
    background: #fff !important;
    isolation: isolate;
}

.category-card::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 8px;
    border: 1px solid transparent;
    transition: border-color 0.28s ease;
    z-index: 5;
    pointer-events: none;
}

.category-card:hover {
    transform: translateY(-8px) !important;
    border-color: rgba(200, 161, 101, 0.42) !important;
    box-shadow: var(--shadow-md) !important;
}

.category-card:hover::before {
    border-color: rgba(200, 161, 101, 0.62);
}

.category-card .img-wrap {
    height: 210px;
    overflow: hidden;
    position: relative;
    background: var(--green-soft);
}

.category-card .img-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    z-index: 2;
    background: linear-gradient(180deg, rgba(26,60,46,0.02) 22%, rgba(26,60,46,0.68) 100%);
    opacity: 0.9;
    transition: opacity 0.32s ease;
}

.category-card .img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.55s ease !important;
}

.category-card:hover .img-wrap img {
    transform: scale(1.07) !important;
}

.category-card-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    z-index: 4;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50px;
    padding: 7px 12px;
    color: #fff;
    background: rgba(26, 60, 46, 0.55);
    backdrop-filter: blur(12px);
    font-size: 0.66rem;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;
}

.category-card .card-body {
    display: flex;
    flex-direction: column;
    min-height: 0;
    padding: 18px !important;
    text-align: left !important;
    background: linear-gradient(180deg, #fff 0%, #fbf8f1 100%);
    position: relative;
}

.category-card-title {
    color: var(--green);
    font-size: 1.05rem;
    line-height: 1.28;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.category-card-copy {
    color: var(--muted);
    font-size: 0.84rem;
    line-height: 1.55;
    margin: 8px 0 14px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.category-card-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    border-top: 1px solid rgba(26, 60, 46, 0.08);
    padding-top: 13px;
    margin-top: auto;
}

.shop-now-link {
    color: var(--green);
    font-weight: 800;
    font-size: 0.76rem;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: color 0.25s ease;
}

.category-card-arrow {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    border-radius: 50%;
    color: var(--green);
    background: rgba(200, 161, 101, 0.18);
    transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease;
}

.category-card:hover .shop-now-link {
    color: var(--gold);
}

.category-card:hover .category-card-arrow {
    transform: translateX(4px);
    color: #fff;
    background: var(--green);
}

.category-item:nth-child(1) .category-card {
    background: linear-gradient(180deg, #ffffff 0%, #f4efe4 100%) !important;
}

.category-item:nth-child(2) .category-card .card-body {
    background: linear-gradient(180deg, #fff 0%, #eef6f1 100%);
}

/* Product and blog cards */
.slider-btn {
    width: 46px !important;
    height: 46px !important;
    border-radius: 50% !important;
    border: 2px solid var(--green) !important;
    color: var(--green) !important;
    background: transparent !important;
    transition: all 0.28s ease !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 0.86rem;
}

.slider-btn:hover {
    background: var(--green) !important;
    color: #fff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 10px 22px rgba(26,60,46,0.22) !important;
}

.best-sellers-slider .swiper-slide,
.new-arrivals-slider .swiper-slide {
    height: auto;
    display: flex;
}

.best-sellers-slider .swiper-slide > *,
.new-arrivals-slider .swiper-slide > * {
    width: 100%;
}

.best-sellers-slider .card,
.new-arrivals-slider .card,
.home-blog-section .card {
    width: 100%;
    height: 100%;
    min-height: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    border-radius: 8px !important;
    border: 1px solid rgba(26, 60, 46, 0.1) !important;
    box-shadow: var(--shadow-sm) !important;
    overflow: hidden;
    position: relative;
    background: #fff !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease !important;
}

.best-sellers-slider .card:hover,
.new-arrivals-slider .card:hover,
.home-blog-section .card:hover {
    transform: translateY(-8px) !important;
    border-color: rgba(200, 161, 101, 0.45) !important;
    box-shadow: var(--shadow-md) !important;
}

.best-sellers-slider .card-img-top,
.new-arrivals-slider .card-img-top,
.home-blog-section .card-img-top {
    width: 100% !important;
    height: 220px !important;
    object-fit: cover !important;
    background: var(--green-soft);
    transition: transform 0.42s ease !important;
}

.best-sellers-slider .card:hover .card-img-top,
.new-arrivals-slider .card:hover .card-img-top,
.home-blog-section .card:hover .card-img-top {
    transform: scale(1.045);
}

.best-sellers-slider .card-body,
.new-arrivals-slider .card-body,
.home-blog-section .card-body {
    flex: 1 1 auto;
    display: flex;
    flex-direction: column;
    min-height: 0 !important;
    padding: 18px !important;
    background: linear-gradient(180deg, #fff 0%, #fbf8f1 100%);
}

.best-sellers-slider .card-title,
.new-arrivals-slider .card-title,
.home-blog-section .card-title,
.best-sellers-slider h5,
.new-arrivals-slider h5,
.home-blog-section h5 {
    color: var(--ink);
    line-height: 1.32;
    margin-bottom: 8px !important;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.best-sellers-slider .card-text,
.new-arrivals-slider .card-text,
.home-blog-section .card-text {
    color: var(--muted);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.best-sellers-slider .card .btn,
.new-arrivals-slider .card .btn,
.home-blog-section .card .btn,
.p-card-btn {
    margin-top: auto;
    border-radius: 8px !important;
    padding: 11px 14px !important;
    font-weight: 800 !important;
    box-shadow: 0 10px 22px rgba(26, 60, 46, 0.12) !important;
}

.empty-card {
    min-height: 180px;
    border: 1px dashed rgba(26, 60, 46, 0.22);
    border-radius: 8px;
    background: rgba(255,255,255,0.78);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: var(--muted);
    padding: 24px;
}

.category-grid .empty-card {
    grid-column: 1 / -1;
}

.category-card,
.concern-card,
.routine-card,
.icon-box,
.testimonial-card,
.best-sellers-slider .card,
.new-arrivals-slider .card,
.home-blog-section .card,
.newsletter-form-card,
.expert-help-panel,
.buy-guide-panel,
.buy-guide-item {
    --mouse-x: 50%;
    --mouse-y: 50%;
    position: relative;
    overflow: hidden;
    will-change: transform;
}

.category-card,
.expert-help-panel {
    transform-style: preserve-3d;
}

.category-card::after {
    content: '';
    position: absolute;
    inset: 0;
    z-index: 8;
    pointer-events: none;
    opacity: 0;
    background: radial-gradient(circle at var(--mouse-x) var(--mouse-y), rgba(226, 192, 141, 0.36), transparent 36%);
    transition: opacity 0.28s ease;
}

.category-card:hover::after {
    opacity: 1;
}

.category-card .card-body,
.best-sellers-slider .card-body,
.new-arrivals-slider .card-body,
.home-blog-section .card-body,
.concern-card > span:last-child,
.concern-icon,
.routine-card > *,
.icon-box > *,
.testimonial-card > *,
.newsletter-form-card > *,
.expert-help-panel > *,
.buy-guide-panel > *,
.buy-guide-item > * {
    position: relative;
    z-index: 9;
}

.hover-tilt-card.is-tilting {
    transition: box-shadow 0.2s ease, border-color 0.2s ease !important;
}

.category-card:hover .card-body {
    transform: translateY(-2px);
}

.category-card .card-body,
.best-sellers-slider .card-body,
.new-arrivals-slider .card-body,
.home-blog-section .card-body,
.concern-card > span:last-child,
.routine-card > *,
.icon-box > *,
.newsletter-form-card > *,
.buy-guide-item > * {
    transition: transform 0.28s ease;
}

.category-card::before {
    box-shadow: inset 0 0 0 0 rgba(200, 161, 101, 0);
}

.category-card:hover::before {
    box-shadow: inset 0 0 0 1px rgba(200, 161, 101, 0.62);
}

.category-card:hover .category-card-badge {
    transform: translateY(-3px);
    background: rgba(200, 161, 101, 0.78);
    color: var(--green);
}

.category-card-badge {
    transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease;
}

.best-sellers-slider .card::after,
.new-arrivals-slider .card::after {
    content: '';
    position: absolute;
    left: 18px;
    right: 18px;
    bottom: 0;
    height: 4px;
    z-index: 8;
    background: linear-gradient(90deg, var(--gold), var(--green-light));
    border-radius: 8px 8px 0 0;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.32s ease;
}

.best-sellers-slider .card:hover::after,
.new-arrivals-slider .card:hover::after {
    transform: scaleX(1);
}

.best-sellers-slider .card:hover,
.new-arrivals-slider .card:hover {
    transform: translateY(-10px) scale(1.012) !important;
}

.best-sellers-slider .card:hover .card-img-top,
.new-arrivals-slider .card:hover .card-img-top {
    transform: scale(1.075) rotate(0.6deg);
    filter: saturate(1.08) contrast(1.04);
}

.home-blog-section .card::after {
    content: '';
    position: absolute;
    left: 18px;
    right: auto;
    bottom: 18px;
    width: 52px;
    height: 2px;
    z-index: 8;
    background: var(--gold);
    transform: scaleX(0.45);
    transform-origin: left;
    transition: transform 0.3s ease, width 0.3s ease;
}

.home-blog-section .card:hover::after {
    width: calc(100% - 36px);
    transform: scaleX(1);
}

.home-blog-section .card:hover {
    transform: translateY(-8px) !important;
}

.home-blog-section .card:hover .card-img-top {
    transform: scale(1.045);
    filter: saturate(1.08);
}

.routine-card::after {
    content: '';
    position: absolute;
    right: -26px;
    bottom: -26px;
    width: 92px;
    height: 92px;
    border-radius: 50%;
    border: 1px solid rgba(200, 161, 101, 0.35);
    background: rgba(200, 161, 101, 0.08);
    transition: transform 0.42s ease, opacity 0.42s ease;
}

.routine-card:hover::after {
    transform: scale(1.45);
    opacity: 0.72;
}

.routine-card:hover .routine-step {
    transform: rotate(-8deg) scale(1.08);
    background: var(--gold);
    color: var(--green);
}

.icon-box::after {
    content: '';
    position: absolute;
    inset: auto 22px 22px 22px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(200, 161, 101, 0.95), transparent);
    opacity: 0;
    transform: scaleX(0.25);
    transition: transform 0.32s ease, opacity 0.32s ease;
}

.icon-box:hover::after {
    opacity: 1;
    transform: scaleX(1);
}

.testimonial-card::after {
    content: '';
    position: absolute;
    inset: 16px;
    border: 1px solid rgba(200, 161, 101, 0.28);
    border-radius: 8px;
    opacity: 0;
    transform: scale(0.96);
    pointer-events: none;
    transition: opacity 0.32s ease, transform 0.32s ease;
}

.testimonial-card:hover::after {
    opacity: 1;
    transform: scale(1);
}

.testimonial-card:hover .testimonial-avatar {
    transform: translateY(-4px) scale(1.04);
}

.testimonial-avatar {
    transition: transform 0.28s ease;
}

.newsletter-form-card::after,
.expert-help-panel::after,
.buy-guide-panel::after {
    content: '';
    position: absolute;
    top: -55%;
    left: -65%;
    width: 38%;
    height: 220%;
    z-index: 8;
    pointer-events: none;
    opacity: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.42), transparent);
    transform: rotate(18deg);
    transition: left 0.7s ease, opacity 0.35s ease;
}

.newsletter-form-card:hover::after,
.expert-help-panel:hover::after,
.buy-guide-panel:hover::after {
    left: 125%;
    opacity: 1;
}

/* Concern cards */
.concern-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
}

.concern-card {
    height: 100%;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    border: 1px solid rgba(26, 60, 46, 0.1);
    border-radius: 8px;
    padding: 20px;
    background: #fff;
    color: var(--ink);
    text-decoration: none;
    box-shadow: var(--shadow-sm);
    transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease, background 0.28s ease;
}

.concern-card::before {
    content: '';
    position: absolute;
    top: 16px;
    bottom: 16px;
    left: 0;
    width: 4px;
    border-radius: 0 8px 8px 0;
    background: linear-gradient(180deg, var(--gold), var(--green-light));
    transform: scaleY(0.28);
    transform-origin: center;
    transition: transform 0.3s ease;
}

.concern-card::after {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0;
    background: linear-gradient(100deg, rgba(200,161,101,0.16), transparent 58%);
    transform: translateX(-28%);
    transition: transform 0.34s ease, opacity 0.34s ease;
}

.concern-card:hover {
    transform: translateY(-6px) translateX(3px);
    border-color: rgba(200, 161, 101, 0.46);
    background: linear-gradient(180deg, #fff 0%, #fbf8f1 100%);
    box-shadow: var(--shadow-md);
    color: var(--ink);
}

.concern-card:hover::before {
    transform: scaleY(1);
}

.concern-card:hover::after {
    opacity: 1;
    transform: translateX(0);
}

.concern-icon {
    width: 48px;
    height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    border-radius: 50%;
    color: var(--green);
    background: rgba(200, 161, 101, 0.18);
    transition: transform 0.28s ease, background 0.25s ease, color 0.25s ease, box-shadow 0.25s ease;
}

.concern-card:hover .concern-icon {
    color: #fff;
    background: var(--green);
    transform: rotate(-8deg) scale(1.08);
    box-shadow: 0 12px 24px rgba(26, 60, 46, 0.2);
}

.concern-card h4 {
    font-size: 1rem;
    color: var(--green);
    margin-bottom: 6px;
}

.concern-card p {
    color: var(--muted);
    font-size: 0.84rem;
    line-height: 1.62;
    margin-bottom: 12px;
}

.concern-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--green);
    font-size: 0.76rem;
    font-weight: 900;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.concern-link i {
    font-size: 0.72rem;
    transition: transform 0.25s ease;
}

.concern-card:hover .concern-link i {
    transform: translateX(5px);
}

/* Before-buy guide */
.buy-guide-panel {
    display: grid;
    grid-template-columns: 0.9fr 1.4fr;
    gap: 24px;
    align-items: center;
    border: 1px solid rgba(26, 60, 46, 0.1);
    border-radius: 8px;
    padding: clamp(22px, 3vw, 34px);
    background: linear-gradient(180deg, #fff 0%, #fbf8f1 100%);
    box-shadow: var(--shadow-sm);
}

.buy-guide-list {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
}

.buy-guide-item {
    display: flex;
    align-items: center;
    gap: 12px;
    min-height: 82px;
    border-radius: 8px;
    border: 1px solid rgba(26, 60, 46, 0.1);
    background: #fff;
    padding: 16px;
    transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
}

.buy-guide-item::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0;
    background: radial-gradient(circle at top right, rgba(200,161,101,0.18), transparent 46%);
    transition: opacity 0.28s ease;
}

.buy-guide-item:hover {
    transform: translateY(-6px);
    border-color: rgba(200, 161, 101, 0.42);
    box-shadow: var(--shadow-sm);
}

.buy-guide-item:hover::before {
    opacity: 1;
}

.buy-guide-item i {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    border-radius: 50%;
    color: var(--green);
    background: rgba(200, 161, 101, 0.16);
    transition: transform 0.28s ease, background 0.28s ease, color 0.28s ease;
}

.buy-guide-item:hover i {
    transform: scale(1.08);
    color: #fff;
    background: var(--green);
}

.buy-guide-item strong {
    display: block;
    color: var(--ink);
    font-size: 0.94rem;
    line-height: 1.25;
}

.buy-guide-item span {
    display: block;
    color: var(--muted);
    font-size: 0.78rem;
    line-height: 1.45;
    margin-top: 2px;
}

/* Closing CTA */
.expert-help-panel {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 28px;
    align-items: center;
    border-radius: 8px;
    border: 1px solid rgba(26, 60, 46, 0.1);
    padding: clamp(26px, 4vw, 42px);
    background:
        linear-gradient(135deg, rgba(23,56,43,0.96), rgba(45,106,79,0.92)),
        linear-gradient(90deg, rgba(200,161,101,0.2), transparent);
    box-shadow: var(--shadow-md);
}

.expert-help-panel h2,
.expert-help-panel p {
    color: #fff;
}

.expert-help-panel p {
    max-width: 620px;
    opacity: 0.82;
    line-height: 1.75;
}

.expert-help-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.expert-help-actions .home-outline-btn {
    border-color: rgba(255,255,255,0.58);
    color: #fff !important;
}

.expert-help-actions .home-outline-btn:hover {
    border-color: #fff;
    background: #fff;
    color: var(--green) !important;
}

/* Promo */
.parallax-banner {
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 118px 0;
    position: relative;
}

.parallax-banner::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(135deg, rgba(23,56,43,0.95) 0%, rgba(45,106,79,0.88) 54%, rgba(23,56,43,0.93) 100%),
        linear-gradient(90deg, rgba(200,161,101,0.18), transparent);
}

.countdown-box {
    background: rgba(255,255,255,0.09) !important;
    backdrop-filter: blur(15px);
    border: 1px solid rgba(200,161,101,0.32) !important;
    border-radius: 8px !important;
    padding: 20px 24px !important;
    min-width: 96px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.countdown-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--gold), transparent);
}

.countdown-box:hover {
    background: rgba(200,161,101,0.15) !important;
    transform: translateY(-4px);
    border-color: var(--gold) !important;
}

.countdown-box h3 {
    font-size: 2.45rem !important;
    font-weight: 800 !important;
    color: var(--gold) !important;
    font-family: 'Playfair Display', serif;
    margin: 0 !important;
    line-height: 1 !important;
}

.countdown-box small {
    color: rgba(255,255,255,0.72) !important;
    font-size: 0.68rem !important;
    letter-spacing: 2px;
    text-transform: uppercase;
    display: block;
    margin-top: 8px;
}

/* Feature and testimonial cards */
.icon-box,
.testimonial-card,
.routine-card {
    height: 100%;
    border-radius: 8px;
    border: 1px solid rgba(26,60,46,0.1);
    background: linear-gradient(180deg, #fff 0%, rgba(248,245,240,0.86) 100%);
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    position: relative;
    overflow: hidden;
}

.icon-box {
    padding: 32px 24px;
    text-align: center;
}

.icon-box::before,
.routine-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), transparent);
}

.icon-box:hover,
.testimonial-card:hover,
.routine-card:hover {
    transform: translateY(-8px);
    border-color: rgba(200, 161, 101, 0.42);
    box-shadow: var(--shadow-md);
}

.icon-box .icon-wrap {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: rgba(200, 161, 101, 0.16);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 22px;
    transition: all 0.3s ease;
}

.icon-box:hover .icon-wrap {
    background: var(--green);
    color: #fff;
    transform: translateY(-3px);
}

.icon-box:hover .icon-wrap i {
    color: #fff !important;
}

.routine-card {
    padding: 28px;
}

.routine-step {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--green);
    color: var(--gold-light);
    font-weight: 900;
    margin-bottom: 18px;
}

.testimonial-card {
    padding: 40px;
}

.testimonial-card::before {
    content: '"';
    position: absolute;
    top: -28px;
    right: 26px;
    font-size: 10rem;
    font-family: 'Playfair Display', serif;
    color: rgba(200,161,101,0.09);
    line-height: 1;
}

.testimonial-avatar {
    width: 62px;
    height: 62px;
    border-radius: 50%;
    border: 3px solid var(--gold);
    object-fit: cover;
    box-shadow: 0 5px 15px rgba(200,161,101,0.3);
}

/* Newsletter */
.newsletter-section {
    background:
        linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%),
        linear-gradient(90deg, rgba(200,161,101,0.18), transparent);
    position: relative;
    overflow: hidden;
}

.newsletter-panel {
    display: grid;
    grid-template-columns: 1.05fr 0.95fr;
    gap: 28px;
    align-items: center;
    border: 1px solid rgba(255,255,255,0.16);
    border-radius: 8px;
    padding: clamp(26px, 4vw, 46px);
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(18px);
    box-shadow: 0 28px 80px rgba(0,0,0,0.18);
}

.newsletter-kicker {
    color: var(--gold-light);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.6px;
    text-transform: uppercase;
}

.newsletter-perks {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    margin-top: 26px;
}

.newsletter-perk {
    border: 1px solid rgba(255,255,255,0.14);
    border-radius: 8px;
    padding: 14px;
    background: rgba(255,255,255,0.07);
    color: rgba(255,255,255,0.78);
    font-size: 0.82rem;
}

.newsletter-perk i {
    color: var(--gold-light);
    display: block;
    margin-bottom: 8px;
}

.newsletter-form-card {
    border-radius: 8px;
    background: #fff;
    padding: 22px;
    box-shadow: 0 18px 44px rgba(0,0,0,0.14);
}

.newsletter-form-wrap {
    border: 1px solid rgba(26,60,46,0.12);
    border-radius: 8px;
    padding: 7px;
    background: #f7f4ee;
}

.newsletter-input {
    min-height: 50px;
    border: none !important;
    background: transparent !important;
    color: var(--ink) !important;
    padding: 10px 14px !important;
    font-size: 0.94rem !important;
    box-shadow: none !important;
    outline: none !important;
}

.newsletter-input::placeholder {
    color: #8b968f !important;
}

.newsletter-btn {
    min-height: 50px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light)) !important;
    color: var(--green) !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 12px 22px !important;
    font-weight: 900 !important;
    transition: all 0.25s ease !important;
    white-space: nowrap;
}

.newsletter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(200,161,101,0.34) !important;
}

.newsletter-note {
    color: var(--muted);
    font-size: 0.82rem;
    line-height: 1.6;
    margin-top: 14px;
}

.count-up {
    display: inline-block;
    transition: transform 0.25s ease, text-shadow 0.25s ease;
}

.count-up.is-counting {
    transform: scale(1.06);
    text-shadow: 0 0 18px rgba(200, 161, 101, 0.45);
}

@media (max-width: 1199.98px) {
    .category-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 991.98px) {
    .trust-panel,
    .newsletter-panel {
        grid-template-columns: 1fr;
    }

    .hero-herbal-gallery,
    .hero-herbal-caption {
        display: none;
    }

    .concern-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .expert-help-panel {
        grid-template-columns: 1fr;
    }

    .buy-guide-panel,
    .buy-guide-list {
        grid-template-columns: 1fr;
    }

    .expert-help-actions {
        justify-content: flex-start;
    }

    .category-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .newsletter-perks {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767.98px) {
    .hero-slider {
        height: auto !important;
        min-height: 560px !important;
    }

    .hero-slider .swiper-slide {
        min-height: 560px;
        padding: 92px 0 70px;
    }

    .floating-wellness-cta {
        right: 14px;
        bottom: 14px;
        min-height: 50px;
        padding: 8px 13px 8px 8px;
    }

    .floating-wellness-cta .floating-icon {
        width: 34px;
        height: 34px;
    }

    .floating-wellness-cta strong {
        font-size: 0.78rem;
    }

    .floating-wellness-cta small {
        display: none;
    }

    .hero-title {
        font-size: clamp(2.28rem, 12vw, 3.2rem);
    }

    .hero-badge {
        letter-spacing: 1.5px;
        font-size: 0.68rem;
        padding: 8px 14px;
    }

    .hero-stats {
        gap: 10px;
        margin-top: 34px;
        padding-top: 24px;
    }

    .hero-stat {
        min-width: calc(50% - 5px);
        padding: 12px;
    }

    .hero-stat h3 {
        font-size: 1.45rem;
    }

    .trust-strip {
        margin-top: 0;
    }

    .trust-item {
        padding: 18px;
    }

    .category-grid {
        grid-template-columns: 1fr;
    }

    .concern-grid {
        grid-template-columns: 1fr;
    }

    .concern-card {
        padding: 18px;
    }

    .buy-guide-panel {
        padding: 20px;
    }

    .category-card .img-wrap {
        height: 205px;
    }

    .category-card .card-body {
        min-height: 0;
    }

    .category-card-title {
        min-height: 0;
    }

    .best-sellers-slider .card-img-top,
    .new-arrivals-slider .card-img-top,
    .home-blog-section .card-img-top {
        height: 205px !important;
    }

    .parallax-banner {
        background-attachment: scroll;
        padding: 80px 0;
    }

    .countdown-box {
        min-width: 78px;
        padding: 16px !important;
    }

    .countdown-box h3 {
        font-size: 1.85rem !important;
    }

    .testimonial-card {
        padding: 30px 22px;
    }

    .newsletter-panel,
    .newsletter-form-card {
        padding: 22px;
    }

    .newsletter-form-wrap form {
        flex-direction: column;
    }

    .newsletter-btn {
        width: 100%;
    }

    .swiper-button-next,
    .swiper-button-prev {
        display: none !important;
    }
}

[dir="rtl"] .swiper-button-next {
    right: auto !important;
    left: 20px !important;
}

[dir="rtl"] .swiper-button-prev {
    left: auto !important;
    right: 20px !important;
}

[dir="rtl"] .section-divider {
    background: linear-gradient(270deg, var(--gold), transparent);
}

[dir="rtl"] .category-card-arrow i,
[dir="rtl"] .hero-btn-primary i,
[dir="rtl"] .home-outline-btn i {
    transform: rotate(180deg);
}
</style>
@endpush

@section('content')
<main class="home-page">
<div class="home-scroll-progress" aria-hidden="true"><span></span></div>
<a href="{{ route('shop.index') }}" class="floating-wellness-cta" aria-label="{{ __('Open wellness finder') }}">
    <span class="floating-icon"><i class="fas fa-search"></i></span>
    <span>
        <strong>{{ __('Wellness Finder') }}</strong>
        <small>{{ __('Find your care') }}</small>
    </span>
</a>

{{-- Hero Slider --}}
@php
    $naturalHeroImages = [
        'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1497250681960-ef046c08a56e?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1520302630591-fd1c66edc19d?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1459156212016-c812468e2115?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?q=80&w=1920&auto=format&fit=crop',
    ];

    $curatedHeroSlides = [
        [
            'title' => __('Pure Herbal Wellness'),
            'subtitle' => __('Explore natural herbs, wellness essentials, and trusted care selected for daily balance.'),
            'button_text' => __('Shop Herbal Care'),
            'button_link' => route('shop.index'),
        ],
        [
            'title' => __('Nature Inspired Care'),
            'subtitle' => __('Bring home gentle herbal products inspired by plants, roots, leaves, and traditional wisdom.'),
            'button_text' => __('Explore Remedies'),
            'button_link' => route('shop.index'),
        ],
        [
            'title' => __('Daily Natural Support'),
            'subtitle' => __('Find herbal essentials for immunity, digestion, freshness, comfort, and everyday wellness.'),
            'button_text' => __('Start Shopping'),
            'button_link' => route('shop.index'),
        ],
        [
            'title' => __('Trusted Dawakhana Quality'),
            'subtitle' => __('Carefully selected natural products with a clean shopping experience and helpful support.'),
            'button_text' => __('View Products'),
            'button_link' => route('shop.index'),
        ],
        [
            'title' => __('From Nature to Daily Care'),
            'subtitle' => __('Discover herbal essentials inspired by gardens, leaves, roots, seeds, and traditional wellness.'),
            'button_text' => __('Browse Natural Care'),
            'button_link' => route('shop.index'),
        ],
        [
            'title' => __('Gentle Care for Every Home'),
            'subtitle' => __('Choose natural wellness products for daily routines, family care, and seasonal support.'),
            'button_text' => __('Shop Wellness'),
            'button_link' => route('shop.index'),
        ],
        [
            'title' => __('Herbal Wisdom, Modern Shopping'),
            'subtitle' => __('A calm and trusted Dawakhana experience for finding the right natural care product.'),
            'button_text' => __('Explore Store'),
            'button_link' => route('shop.index'),
        ],
        [
            'title' => __('Fresh Natural Wellness Picks'),
            'subtitle' => __('Upgrade your care routine with herbal products selected for quality, comfort, and confidence.'),
            'button_text' => __('See Products'),
            'button_link' => route('shop.index'),
        ],
        [
            'title' => __('Botanical Care for Better Days'),
            'subtitle' => __('Shop natural herbal products shaped around comfort, balance, and everyday family wellness.'),
            'button_text' => __('Discover Care'),
            'button_link' => route('shop.index'),
        ],
        [
            'title' => __('A More Natural Dawakhana'),
            'subtitle' => __('Beautiful plant-based care, selected with trust, tradition, and modern convenience in mind.'),
            'button_text' => __('Visit Shop'),
            'button_link' => route('shop.index'),
        ],
    ];

    $heroSlides = collect();

    foreach ($banners as $index => $banner) {
        $bannerImage = $banner->image ?: null;
        $isGenericImage = $bannerImage && str_contains($bannerImage, 'picsum.photos');
        $bannerButtonLink = $banner->button_link ?: route('shop.index');

        if ($bannerButtonLink === '/shop') {
            $bannerButtonLink = route('shop.index');
        } elseif (str_starts_with($bannerButtonLink, '/shop?')) {
            $bannerButtonLink = route('shop.index') . '?' . parse_url($bannerButtonLink, PHP_URL_QUERY);
        }

        $heroSlides->push([
            'title' => $banner->title ?: __('Authentic Herbal Wellness'),
            'subtitle' => $banner->subtitle ?: __('Explore trusted natural remedies, daily care essentials, and herbal products selected for healthier living.'),
            'button_text' => $banner->button_text === 'Shop Medicines' ? __('Shop Herbal Care') : ($banner->button_text ?: __('Explore Collection')),
            'button_link' => $bannerButtonLink,
            'image' => $isGenericImage || !$bannerImage
                ? $naturalHeroImages[$index % count($naturalHeroImages)]
                : (\Illuminate\Support\Str::startsWith($bannerImage, ['http://', 'https://']) ? $bannerImage : asset($bannerImage)),
        ]);
    }

    foreach ($curatedHeroSlides as $index => $slide) {
        $heroSlides->push(array_merge($slide, [
            'image' => $naturalHeroImages[($heroSlides->count() + $index) % count($naturalHeroImages)],
        ]));
    }
@endphp

<section class="hero-slider swiper w-100" style="margin-top: -1px;">
    <div class="swiper-wrapper w-100 h-100">
        @foreach($heroSlides->take(10) as $slide)
            <div class="swiper-slide position-relative w-100 h-100 d-flex align-items-center"
                style="background-image: url('{{ $slide['image'] }}'); background-size: cover; background-position: center;">

                @if(!empty($slide['button_link']))
                    <a href="{{ $slide['button_link'] }}"
                        class="hero-slide-link position-absolute top-0 start-0 w-100 h-100"
                        aria-label="{{ $slide['title'] }}"></a>
                @endif

                <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

                <div class="hero-herbal-gallery" aria-hidden="true">
                    @for($galleryIndex = 0; $galleryIndex < 5; $galleryIndex++)
                        <span class="hero-herbal-photo"
                            style="background-image: url('{{ $naturalHeroImages[($loop->index + $galleryIndex + 1) % count($naturalHeroImages)] }}');"></span>
                    @endfor
                </div>
                <div class="hero-herbal-caption">
                    <i class="fas fa-seedling"></i>{{ __('Natural Herbal Collection') }}
                </div>

                <div class="container position-relative" style="z-index: 2;">
                    <div class="row">
                        <div class="col-lg-7 col-md-10 hero-content ps-md-4">
                            <div class="hero-badge">
                                <i class="fas fa-leaf"></i>
                                {{ __('NEW ARRIVAL') }} &middot; {{ __('EXCLUSIVE COLLECTION') }}
                            </div>

                            <h1 class="hero-title">
                                {{ $slide['title'] }}
                            </h1>

                            <p class="hero-subtitle">
                                {{ $slide['subtitle'] }}
                            </p>

                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <a href="{{ $slide['button_link'] }}" class="hero-btn-primary">
                                    {{ $slide['button_text'] }}
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>

                            <div class="hero-stats">
                                <div class="hero-stat">
                                    <h3 class="count-up" data-target="500" data-suffix="+">1</h3>
                                    <p>{{ __('Products') }}</p>
                                </div>
                                <div class="hero-stat">
                                    <h3 class="count-up" data-target="5000" data-format="short" data-suffix="+">1</h3>
                                    <p>{{ __('Customers') }}</p>
                                </div>
                                <div class="hero-stat">
                                    <h3 class="count-up" data-target="100" data-suffix="%">1</h3>
                                    <p>{{ __('Natural') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="swiper-button-next d-none d-md-flex"></div>
    <div class="swiper-button-prev d-none d-md-flex"></div>
    <div class="swiper-pagination mb-3 custom-swiper-pagination"></div>
</section>

{{-- Trust Strip --}}
<section class="trust-strip">
    <div class="container">
        <div class="trust-panel" data-aos="fade-up">
            <div class="trust-item">
                <i class="fas fa-certificate"></i>
                <div>
                    <strong>{{ __('Quality Checked') }}</strong>
                    <span>{{ __('Carefully selected herbal products') }}</span>
                </div>
            </div>
            <div class="trust-item">
                <i class="fas fa-truck-fast"></i>
                <div>
                    <strong>{{ __('Fast Delivery') }}</strong>
                    <span>{{ __('Reliable shipping for every order') }}</span>
                </div>
            </div>
            <div class="trust-item">
                <i class="fas fa-headset"></i>
                <div>
                    <strong>{{ __('Support Ready') }}</strong>
                    <span>{{ __('Guidance before and after purchase') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Shop by Concern --}}
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="section-badge"><i class="fas fa-heartbeat"></i>{{ __('Shop by Concern') }}</span>
                <h2 class="section-title display-5 mb-0 mt-1">{{ __('Find Care for Your Daily Need') }}</h2>
                <p class="section-copy mt-3 mb-0">
                    {{ __('Make the first choice easier with quick paths for the wellness goals customers search for most.') }}
                </p>
                <div class="section-divider"></div>
            </div>
        </div>

        <div class="concern-grid">
            @foreach([
                ['fas fa-shield-alt', __('Immunity Support'), __('Daily herbal support for seasonal changes and body strength.'), 'immunity'],
                ['fas fa-leaf', __('Digestive Care'), __('Gentle natural options for comfort, balance, and daily routine.'), 'digestion'],
                ['fas fa-fire-alt', __('Pain Relief'), __('Explore trusted care for joints, muscles, and everyday discomfort.'), 'pain relief'],
                ['fas fa-spa', __('Skin & Beauty'), __('Natural care for glow, freshness, and confident self-care.'), 'skin care'],
            ] as $i => $concern)
                <a href="{{ route('shop.index', ['search' => $concern[3]]) }}"
                    class="concern-card"
                    data-aos="fade-up"
                    data-aos-delay="{{ $i * 80 }}">
                    <span class="concern-icon">
                        <i class="{{ $concern[0] }}"></i>
                    </span>
                    <span>
                        <h4 class="playfair fw-bold">{{ $concern[1] }}</h4>
                        <p>{{ $concern[2] }}</p>
                        <span class="concern-link">
                            {{ __('Explore') }} <i class="fas fa-arrow-right"></i>
                        </span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="py-5 soft-band">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end gap-3 flex-wrap mb-5">
            <div data-aos="fade-right">
                <span class="section-badge"><i class="fas fa-seedling"></i>{{ __('Health Solutions') }}</span>
                <h2 class="section-title display-5 mb-0 mt-1">{{ __('Shop by Category') }}</h2>
                <div class="section-divider"></div>
            </div>
            <a href="{{ route('shop.index') }}" class="home-outline-btn" data-aos="fade-left">
                {{ __('View All Categories') }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="category-grid">
            @forelse($categories as $category)
                @php
                    $catImg = $category->image
                        ? asset($category->image)
                        : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800&auto=format&fit=crop';
                @endphp
                <div class="category-item" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 70, 280) }}">
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                        class="text-decoration-none text-dark d-block h-100">
                        <div class="card category-card h-100">
                            <div class="img-wrap">
                                <span class="category-card-badge">
                                    <i class="fas fa-leaf"></i>
                                    {{ $loop->first ? __('Featured Care') : __('Natural Care') }}
                                </span>
                                <img src="{{ $catImg }}" loading="lazy" alt="{{ $category->name }}">
                            </div>
                            <div class="card-body">
                                <h5 class="playfair fw-bold mb-0 category-card-title">
                                    {{ $category->name }}
                                </h5>
                                <p class="category-card-copy">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($category->description ?? __('Explore trusted herbal wellness products for daily natural care.')), 86) }}
                                </p>
                                <div class="category-card-bottom">
                                    <span class="shop-now-link">{{ __('Explore Category') }}</span>
                                    <span class="category-card-arrow"><i class="fas fa-arrow-right"></i></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="empty-card">{{ __('Categories will appear here soon.') }}</div>
            @endforelse
        </div>
    </div>
</section>

{{-- Before You Buy --}}
<section class="py-4 bg-white">
    <div class="container">
        <div class="buy-guide-panel" data-aos="fade-up">
            <div>
                <span class="section-badge"><i class="fas fa-check-circle"></i>{{ __('Before You Buy') }}</span>
                <h2 class="section-title h1 mb-0">{{ __('Choose With Confidence') }}</h2>
                <p class="section-copy mt-3 mb-0">
                    {{ __('A compact guide helps customers feel certain before they move from browsing to checkout.') }}
                </p>
            </div>
            <div class="buy-guide-list">
                <div class="buy-guide-item">
                    <i class="fas fa-flask"></i>
                    <div>
                        <strong>{{ __('Check Ingredients') }}</strong>
                        <span>{{ __('Know what you are taking.') }}</span>
                    </div>
                </div>
                <div class="buy-guide-item">
                    <i class="fas fa-calendar-check"></i>
                    <div>
                        <strong>{{ __('Match Routine') }}</strong>
                        <span>{{ __('Pick care you can use daily.') }}</span>
                    </div>
                </div>
                <div class="buy-guide-item">
                    <i class="fas fa-headset"></i>
                    <div>
                        <strong>{{ __('Ask First') }}</strong>
                        <span>{{ __('Get support before buying.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Best Sellers --}}
<section class="py-5 bg-white">
    <div class="container py-4 py-md-5">
        <div class="d-flex justify-content-between align-items-end gap-3 flex-wrap mb-4 mb-md-5">
            <div data-aos="fade-right">
                <span class="section-badge"><i class="fas fa-star"></i>{{ __('Popular Choice') }}</span>
                <h2 class="section-title display-5 mb-0 mt-1">{{ __('Our Best Sellers') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="d-flex gap-2" data-aos="fade-left">
                @if(app()->getLocale() == 'ur')
                    <button class="slider-btn best-sellers-next" type="button" aria-label="{{ __('Next') }}"><i class="fas fa-chevron-left"></i></button>
                    <button class="slider-btn best-sellers-prev" type="button" aria-label="{{ __('Previous') }}"><i class="fas fa-chevron-right"></i></button>
                @else
                    <button class="slider-btn best-sellers-prev" type="button" aria-label="{{ __('Previous') }}"><i class="fas fa-chevron-left"></i></button>
                    <button class="slider-btn best-sellers-next" type="button" aria-label="{{ __('Next') }}"><i class="fas fa-chevron-right"></i></button>
                @endif
            </div>
        </div>

        <div class="swiper best-sellers-slider pb-4">
            <div class="swiper-wrapper">
                @forelse($featuredProducts as $product)
                    <div class="swiper-slide h-auto">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="swiper-slide h-auto">
                        <div class="empty-card w-100">{{ __('Best-selling products will appear here soon.') }}</div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="text-center mt-4 mt-md-5" data-aos="fade-up">
            <a href="{{ route('shop.index') }}" class="home-outline-btn">
                {{ __('View All Products') }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- Routine Builder --}}
<section class="py-5 soft-band">
    <div class="container py-5">
        <div class="row align-items-end mb-5">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="section-badge"><i class="fas fa-map-signs"></i>{{ __('Simple Routine') }}</span>
                <h2 class="section-title display-5 mb-0 mt-1">{{ __('Build a Better Daily Wellness Habit') }}</h2>
                <p class="section-copy mt-3 mb-0">
                    {{ __('From daily immunity to relaxation and body care, guide shoppers toward products that match their routine.') }}
                </p>
                <div class="section-divider"></div>
            </div>
        </div>

        <div class="row g-4">
            @foreach([
                ['01', 'fas fa-search', __('Choose Your Need'), __('Browse by concern, category, or daily wellness goal.')],
                ['02', 'fas fa-leaf', __('Pick Natural Care'), __('Compare trusted herbal products by benefit, ingredients, and daily use.')],
                ['03', 'fas fa-shopping-bag', __('Order With Confidence'), __('Checkout quickly and keep your wellness essentials ready.')],
            ] as $i => $step)
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="routine-card">
                        <span class="routine-step">{{ $step[0] }}</span>
                        <h4 class="playfair fw-bold text-dark mb-3">
                            <i class="{{ $step[1] }} me-2" style="color: var(--gold);"></i>{{ $step[2] }}
                        </h4>
                        <p class="text-muted mb-0" style="line-height: 1.8;">{{ $step[3] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Promo Banner --}}
@php
    $promoImage = $globalSettings['promo_banner_image'] ?? 'https://picsum.photos/seed/promo/1920/600';
    $promoBg = \Illuminate\Support\Str::startsWith($promoImage, ['http://', 'https://']) ? $promoImage : asset($promoImage);
    $promoLink = $globalSettings['promo_banner_btn_link'] ?? route('shop.index', ['sale' => 'true']);
@endphp
<section class="parallax-banner text-center position-relative" style="background-image: url('{{ $promoBg }}');">
    <a href="{{ $promoLink }}" class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0;" aria-label="{{ __('View Sale') }}"></a>

    <div class="container position-relative text-white py-5" style="z-index: 1;">
        <span class="section-badge d-inline-flex mb-4"
            style="background: rgba(200,161,101,0.15); color: var(--gold-light); border-color: rgba(200,161,101,0.3);"
            data-aos="fade-down">
            <i class="fas fa-clock"></i>{{ __('Limited Time Offer') }}
        </span>

        <h2 class="playfair display-3 mb-3 fw-bold text-white" data-aos="fade-up">
            {{ $globalSettings['promo_banner_title'] ?? __('Authentic Herbal Medicines') }}
        </h2>
        <p class="lead mb-5" style="opacity: 0.86; max-width: 620px; margin: 0 auto 40px;"
            data-aos="fade-up" data-aos-delay="100">
            {{ $globalSettings['promo_banner_subtitle'] ?? __('Natural healing for a healthier life.') }}
        </p>

        <div class="d-flex justify-content-center gap-3 gap-md-4 mb-5 flex-wrap"
            data-aos="fade-up" data-aos-delay="200"
            id="promo-countdown"
            data-deadline="{{ $globalSettings['promo_banner_ends_at'] ?? '' }}">
            <div class="countdown-box">
                <h3 id="days">00</h3>
                <small>{{ __('Days') }}</small>
            </div>
            <div class="countdown-box">
                <h3 id="hours">00</h3>
                <small>{{ __('Hours') }}</small>
            </div>
            <div class="countdown-box">
                <h3 id="minutes">00</h3>
                <small>{{ __('Mins') }}</small>
            </div>
            <div class="countdown-box d-none d-sm-block">
                <h3 id="seconds">00</h3>
                <small>{{ __('Secs') }}</small>
            </div>
        </div>

        <a href="{{ $promoLink }}" class="hero-btn-primary text-decoration-none" data-aos="fade-up" data-aos-delay="300">
            {{ $globalSettings['promo_banner_btn_text'] ?? __('Shop Now') }}
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

{{-- Why Choose Us --}}
<section class="py-5 soft-band">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge"><i class="fas fa-shield-alt"></i>{{ __('Our Promise') }}</span>
            <h2 class="section-title display-5 mb-0 mt-2">{{ __('Why Choose Us') }}</h2>
            <div class="section-divider center"></div>
        </div>

        <div class="row g-4">
            @php $features = json_decode($globalSettings['site_why_choose_us'] ?? '[]', true); @endphp
            @forelse($features as $feature)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="icon-box">
                        <div class="icon-wrap">
                            <i class="{{ $feature['icon'] ?? 'fas fa-check' }} fs-2 text-primary-custom"></i>
                        </div>
                        <h4 class="playfair mb-3 text-dark fw-bold">{{ $feature['title'] ?? __('Feature') }}</h4>
                        <p class="text-muted mb-0" style="line-height: 1.8;">{{ $feature['desc'] ?? '' }}</p>
                    </div>
                </div>
            @empty
                @foreach([
                    ['fas fa-truck-fast', __('Free Shipping'), __('Enjoy free shipping on all orders over') . ' ' . ($globalSettings['currency_symbol'] ?? '$') . ' 500.'],
                    ['fas fa-undo-alt', __('Easy Returns'), __('Return within 30 days for a full refund.')],
                    ['fas fa-shield-alt', __('Quality Guarantee'), __('We stand behind every product we sell.')],
                    ['fas fa-headset', __('24/7 Support'), __('Our dedicated team is here for you.')],
                ] as $i => $f)
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="icon-box">
                            <div class="icon-wrap">
                                <i class="{{ $f[0] }} fs-2 text-primary-custom"></i>
                            </div>
                            <h4 class="playfair mb-3 text-dark fw-bold">{{ $f[1] }}</h4>
                            <p class="text-muted mb-0" style="line-height: 1.8;">{{ $f[2] }}</p>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- New Arrivals --}}
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end gap-3 flex-wrap mb-5">
            <div data-aos="fade-right">
                <span class="section-badge"><i class="fas fa-magic"></i>{{ __('Just Arrived') }}</span>
                <h2 class="section-title display-5 mb-0 mt-1">{{ __('New Arrivals') }}</h2>
                <div class="section-divider"></div>
            </div>
            <div class="d-flex gap-2" data-aos="fade-left">
                @if(app()->getLocale() == 'ur')
                    <button class="slider-btn new-arrivals-next" type="button" aria-label="{{ __('Next') }}"><i class="fas fa-chevron-left"></i></button>
                    <button class="slider-btn new-arrivals-prev" type="button" aria-label="{{ __('Previous') }}"><i class="fas fa-chevron-right"></i></button>
                @else
                    <button class="slider-btn new-arrivals-prev" type="button" aria-label="{{ __('Previous') }}"><i class="fas fa-chevron-left"></i></button>
                    <button class="slider-btn new-arrivals-next" type="button" aria-label="{{ __('Next') }}"><i class="fas fa-chevron-right"></i></button>
                @endif
            </div>
        </div>

        <div class="swiper new-arrivals-slider pb-4">
            <div class="swiper-wrapper">
                @forelse($newArrivals as $product)
                    <div class="swiper-slide h-auto">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="swiper-slide h-auto">
                        <div class="empty-card w-100">{{ __('New products will appear here soon.') }}</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Blog --}}
<section class="py-5 home-blog-section soft-band">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge"><i class="fas fa-book-open"></i>{{ __('Our Blog') }}</span>
            <h2 class="section-title display-5 mb-0 mt-2">{{ __('Health & Wellness Tips') }}</h2>
            <div class="section-divider center"></div>
            <p class="text-muted mt-3 mb-0">{{ __('Expert advice on herbal remedies and daily wellness.') }}</p>
        </div>

        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 120 }}">
                    @include('partials.blog-card', ['post' => $post])
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-card">{{ __('Articles will appear here soon.') }}</div>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('blog.index') }}" class="home-outline-btn">
                {{ __('Read All Articles') }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge"><i class="fas fa-comments"></i>{{ __('Reviews') }}</span>
            <h2 class="section-title display-5 mb-0 mt-2">{{ __('What Our Clients Say') }}</h2>
            <div class="section-divider center"></div>
        </div>

        <div class="swiper testimonial-slider col-lg-8 mx-auto pb-5" data-aos="fade-up">
            <div class="swiper-wrapper">
                @forelse($reviews as $review)
                    <div class="swiper-slide">
                        <div class="testimonial-card text-center">
                            <div class="text-warning mb-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? '' : 'opacity-25' }}"></i>
                                @endfor
                            </div>
                            <p class="fs-5 fst-italic mb-5 text-muted" style="line-height: 1.85;">
                                "{{ $review->body }}"
                            </p>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <img src="https://picsum.photos/seed/{{ $review->user->id }}/80/80"
                                    class="testimonial-avatar"
                                    alt="{{ $review->user->name }}">
                                <div class="text-start">
                                    <h6 class="playfair fw-bold mb-1 text-dark">{{ $review->user->name }}</h6>
                                    <small class="text-muted" style="letter-spacing: 1px;">{{ __('Verified Customer') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="empty-card">{{ __('Customer reviews will appear here soon.') }}</div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination mt-4"></div>
        </div>
    </div>
</section>

{{-- Expert Help CTA --}}
@php
    $supportLink = \Illuminate\Support\Facades\Route::has('contact')
        ? route('contact')
        : route('shop.index');
@endphp
<section class="py-5 bg-white">
    <div class="container">
        <div class="expert-help-panel" data-aos="fade-up">
            <div>
                <span class="newsletter-kicker d-inline-block mb-3">{{ __('Need a Better Pick?') }}</span>
                <h2 class="playfair fw-bold mb-3">{{ __('Not Sure Which Herbal Product Fits You?') }}</h2>
                <p class="mb-0">
                    {{ __('Guide customers toward the right product with a confident next step instead of leaving them at the bottom of the page.') }}
                </p>
            </div>
            <div class="expert-help-actions">
                <a href="{{ route('shop.index') }}" class="hero-btn-primary">
                    {{ __('Start Shopping') }} <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ $supportLink }}" class="home-outline-btn">
                    {{ __('Ask Support') }} <i class="fas fa-headset"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Newsletter --}}
@php
    $newsletterAction = \Illuminate\Support\Facades\Route::has('newsletter.subscribe')
        ? route('newsletter.subscribe')
        : (\Illuminate\Support\Facades\Route::has('subscribe') ? route('subscribe') : '#');
@endphp
<section class="newsletter-section py-5">
    <div class="container py-5 position-relative" style="z-index: 1;">
        <div class="newsletter-panel" data-aos="zoom-in">
            <div class="text-white">
                <div class="newsletter-kicker mb-3">{{ __('Stay Updated') }}</div>
                <h2 class="playfair display-5 mb-3 fw-bold text-white">
                    {{ __('Join 5,000+ Healthy Customers') }}
                </h2>
                <p class="lead mb-0 text-white" style="opacity: 0.82; line-height: 1.75;">
                    {{ __('Get health tips, early product access, and exclusive herbal care offers without a noisy inbox.') }}
                </p>

                <div class="newsletter-perks">
                    <div class="newsletter-perk">
                        <i class="fas fa-leaf"></i>
                        {{ __('Weekly wellness tips') }}
                    </div>
                    <div class="newsletter-perk">
                        <i class="fas fa-tag"></i>
                        {{ __('Private offers') }}
                    </div>
                    <div class="newsletter-perk">
                        <i class="fas fa-box-open"></i>
                        {{ __('New arrivals first') }}
                    </div>
                </div>
            </div>

            <div class="newsletter-form-card">
                <h5 class="playfair fw-bold mb-3" style="color: var(--green);">{{ __('Subscribe to Updates') }}</h5>
                <div class="newsletter-form-wrap">
                    <form id="newsletter-form" class="d-flex gap-2" method="POST" action="{{ $newsletterAction }}">
                        @csrf
                        <input type="email"
                            name="email"
                            class="newsletter-input form-control flex-grow-1"
                            placeholder="{{ __('Enter your email...') }}"
                            required>
                        <button type="submit" id="newsletter-submit" class="newsletter-btn btn">
                            {{ __('Subscribe') }}
                        </button>
                    </form>
                </div>
                <p class="newsletter-note mb-0">
                    {{ __('No spam. Only useful wellness updates and offers you can actually use.') }}
                </p>
                <div id="newsletter-message" class="mt-3" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

</main>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const isRtl = document.documentElement.getAttribute('dir') === 'rtl';
    const hasSwiper = typeof Swiper !== 'undefined';
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const finePointer = window.matchMedia('(pointer: fine)').matches;
    const progressBar = document.querySelector('.home-scroll-progress span');
    const floatingCta = document.querySelector('.floating-wellness-cta');

    function updateScrollEnhancements() {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const maxScroll = Math.max(document.documentElement.scrollHeight - window.innerHeight, 1);
        const progress = Math.min((scrollTop / maxScroll) * 100, 100);

        if (progressBar) {
            progressBar.style.width = progress + '%';
        }

        if (floatingCta) {
            floatingCta.classList.toggle('is-visible', scrollTop > 520);
        }
    }

    updateScrollEnhancements();
    window.addEventListener('scroll', updateScrollEnhancements, { passive: true });

    if (!reduceMotion && finePointer) {
        const pointerReactiveCards = document.querySelectorAll([
            '.category-card',
            '.concern-card',
            '.routine-card',
            '.icon-box',
            '.testimonial-card',
            '.best-sellers-slider .card',
            '.new-arrivals-slider .card',
            '.home-blog-section .card',
            '.newsletter-form-card',
            '.expert-help-panel',
            '.buy-guide-panel',
            '.buy-guide-item'
        ].join(','));

        pointerReactiveCards.forEach(card => {
            card.addEventListener('pointermove', event => {
                const rect = card.getBoundingClientRect();
                const x = ((event.clientX - rect.left) / rect.width) * 100;
                const y = ((event.clientY - rect.top) / rect.height) * 100;

                card.style.setProperty('--mouse-x', x.toFixed(2) + '%');
                card.style.setProperty('--mouse-y', y.toFixed(2) + '%');
            });

            card.addEventListener('pointerleave', () => {
                card.style.setProperty('--mouse-x', '50%');
                card.style.setProperty('--mouse-y', '50%');
            });
        });

        document.querySelectorAll('.category-card, .expert-help-panel').forEach(card => {
            card.classList.add('hover-tilt-card');

            card.addEventListener('pointermove', event => {
                const rect = card.getBoundingClientRect();
                const x = ((event.clientX - rect.left) / rect.width) * 100;
                const y = ((event.clientY - rect.top) / rect.height) * 100;
                const rotateY = ((x - 50) / 50) * 4.2;
                const rotateX = -((y - 50) / 50) * 4.2;

                card.style.transform = `perspective(900px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-8px)`;
                card.classList.add('is-tilting');
            });

            card.addEventListener('pointerleave', () => {
                card.classList.remove('is-tilting');
                card.style.removeProperty('transform');
            });
        });
    }

    if (hasSwiper && document.querySelector('.hero-slider')) {
        new Swiper('.hero-slider', {
            loop: true,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            rtl: isRtl,
            autoplay: { delay: 6000, disableOnInteraction: false },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.custom-swiper-pagination',
                clickable: true,
            },
            speed: 1000,
        });
    }

    function initProductSlider(selector, nextEl, prevEl) {
        if (!hasSwiper || !document.querySelector(selector)) return;

        new Swiper(selector, {
            slidesPerView: 1,
            spaceBetween: 18,
            loop: true,
            rtl: isRtl,
            watchOverflow: true,
            navigation: { nextEl, prevEl },
            breakpoints: {
                576: { slidesPerView: 2, spaceBetween: 18 },
                768: { slidesPerView: 3, spaceBetween: 20 },
                1200: { slidesPerView: 4, spaceBetween: 22 }
            }
        });
    }

    initProductSlider('.best-sellers-slider', '.best-sellers-next', '.best-sellers-prev');
    initProductSlider('.new-arrivals-slider', '.new-arrivals-next', '.new-arrivals-prev');

    if (hasSwiper && document.querySelector('.testimonial-slider')) {
        new Swiper('.testimonial-slider', {
            slidesPerView: 1,
            loop: true,
            rtl: isRtl,
            autoHeight: true,
            autoplay: { delay: 7000, disableOnInteraction: false },
            pagination: {
                el: '.testimonial-slider .swiper-pagination',
                clickable: true,
            },
        });
    }

    function animateCountUp(el) {
        if (el.dataset.done === 'true') return;

        const target = Number(el.dataset.target || 0);
        const suffix = el.dataset.suffix || '';
        const format = el.dataset.format || '';
        const duration = 1800;
        const start = 1;
        const startTime = performance.now();

        el.dataset.done = 'true';
        el.classList.add('is-counting');

        function formatNumber(value) {
            const rounded = Math.floor(value);
            if (format === 'short' && rounded >= 1000) {
                return Math.floor(rounded / 1000) + 'K';
            }
            return rounded.toLocaleString();
        }

        function tick(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 4);
            const current = start + (target - start) * eased;

            el.textContent = formatNumber(current) + suffix;

            if (progress < 1) {
                requestAnimationFrame(tick);
            } else {
                el.textContent = formatNumber(target) + suffix;
                el.classList.remove('is-counting');
            }
        }

        requestAnimationFrame(tick);
    }

    const statsObserver = 'IntersectionObserver' in window
        ? new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.querySelectorAll('.count-up').forEach(animateCountUp);
                }
            });
        }, { threshold: 0.35 })
        : null;

    document.querySelectorAll('.hero-stats').forEach(stats => {
        if (statsObserver) {
            statsObserver.observe(stats);
        } else {
            stats.querySelectorAll('.count-up').forEach(animateCountUp);
        }
    });

    const countdown = document.getElementById('promo-countdown');
    if (countdown) {
        const explicitDeadline = countdown.dataset.deadline ? new Date(countdown.dataset.deadline) : null;
        const deadline = explicitDeadline && !Number.isNaN(explicitDeadline.getTime())
            ? explicitDeadline
            : new Date(Date.now() + (7 * 24 * 60 * 60 * 1000));

        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');

        function twoDigits(value) {
            return String(value).padStart(2, '0');
        }

        function updateCountdown() {
            const distance = Math.max(deadline.getTime() - Date.now(), 0);
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((distance / (1000 * 60)) % 60);
            const seconds = Math.floor((distance / 1000) % 60);

            if (daysEl) daysEl.textContent = twoDigits(days);
            if (hoursEl) hoursEl.textContent = twoDigits(hours);
            if (minutesEl) minutesEl.textContent = twoDigits(minutes);
            if (secondsEl) secondsEl.textContent = twoDigits(seconds);
        }

        updateCountdown();
        window.setInterval(updateCountdown, 1000);
    }

    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterMessage = document.getElementById('newsletter-message');
    const newsletterSubmit = document.getElementById('newsletter-submit');

    function showNewsletterMessage(type, message) {
        if (!newsletterMessage) return;

        newsletterMessage.style.display = 'block';
        newsletterMessage.className = type === 'success'
            ? 'mt-3 alert alert-success py-2 px-3'
            : 'mt-3 alert alert-danger py-2 px-3';
        newsletterMessage.textContent = message;
    }

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            const action = newsletterForm.getAttribute('action');
            const formData = new FormData(newsletterForm);

            if (!action || action === '#') {
                showNewsletterMessage('success', "{{ __('Thank you for subscribing.') }}");
                newsletterForm.reset();
                return;
            }

            if (newsletterSubmit) {
                newsletterSubmit.disabled = true;
                newsletterSubmit.textContent = "{{ __('Subscribing...') }}";
            }

            try {
                const response = await fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json().catch(() => ({}));

                if (!response.ok) {
                    throw new Error(data.message || "{{ __('Please enter a valid email address.') }}");
                }

                showNewsletterMessage('success', data.message || "{{ __('Thank you for subscribing.') }}");
                newsletterForm.reset();
            } catch (error) {
                showNewsletterMessage('error', error.message || "{{ __('Something went wrong. Please try again.') }}");
            } finally {
                if (newsletterSubmit) {
                    newsletterSubmit.disabled = false;
                    newsletterSubmit.textContent = "{{ __('Subscribe') }}";
                }
            }
        });
    }
});
</script>
@endpush
