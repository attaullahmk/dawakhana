@extends('layouts.app')

@push('styles')
<style>
    .about-page {
        --about-green: var(--primary, #1a3c2e);
        --about-green-soft: rgba(26, 60, 46, 0.08);
        --about-gold: var(--secondary, #c8a165);
        --about-cream: #f8f5f0;
        --about-ink: #1f2f27;
        color: var(--about-ink);
        overflow: hidden;
    }

    .about-hero {
        min-height: 520px;
        height: 68vh;
        background-size: cover;
        background-position: center;
        margin-top: -1px;
        overflow: hidden;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 1;
        background:
            linear-gradient(110deg, rgba(9, 24, 18, 0.94) 0%, rgba(16, 47, 35, 0.72) 52%, rgba(9, 24, 18, 0.34) 100%);
    }

    .about-hero-slideshow,
    .about-image-carousel {
        position: absolute;
        inset: 0;
        overflow: hidden;
    }

    .about-hero-slideshow {
        z-index: 0;
    }

    .about-slide,
    .about-panel-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        background-size: cover;
        background-position: center;
        transform: scale(1);
        will-change: opacity, transform;
    }

    .about-slide {
        animation: aboutHeroPicture 30s infinite;
    }

    .about-panel-slide {
        animation: aboutPanelPicture 24s infinite;
    }

    .about-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: var(--about-gold);
        border: 1px solid rgba(200, 161, 101, 0.42);
        background: rgba(200, 161, 101, 0.13);
        border-radius: 50px;
        padding: 8px 18px;
        font-size: 0.76rem;
        font-weight: 800;
        letter-spacing: 2.6px;
        text-transform: uppercase;
        backdrop-filter: blur(12px);
    }

    .about-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(3rem, 7vw, 5.6rem);
        line-height: 0.98;
        letter-spacing: -1px;
        text-shadow: 0 14px 35px rgba(0, 0, 0, 0.28);
    }

    .about-hero-copy {
        max-width: 690px;
        color: rgba(255, 255, 255, 0.86);
        line-height: 1.85;
    }

    .about-hero-pills {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 32px;
    }

    .about-hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.18);
        background: rgba(255, 255, 255, 0.09);
        border-radius: 50px;
        padding: 10px 16px;
        font-size: 0.86rem;
        font-weight: 700;
        backdrop-filter: blur(12px);
    }

    .about-section {
        background:
            linear-gradient(180deg, #fff 0%, #fff 62%, var(--about-cream) 62%, var(--about-cream) 100%);
    }

    .about-image-panel {
        position: relative;
        padding: 16px;
        border: 1px solid rgba(26, 60, 46, 0.09);
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 22px 55px rgba(26, 60, 46, 0.12);
    }

    .about-image-panel::before {
        content: '';
        position: absolute;
        inset: 36px auto auto -22px;
        width: 78%;
        height: 82%;
        z-index: 0;
        border-radius: 8px;
        background: var(--about-cream);
    }

    .about-image-carousel {
        position: relative;
        z-index: 1;
        width: 100%;
        height: 545px;
        border-radius: 8px;
        background: var(--about-cream);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.18);
    }

    .about-image-carousel::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 2;
        background:
            linear-gradient(180deg, rgba(10, 32, 23, 0) 45%, rgba(10, 32, 23, 0.38) 100%);
        pointer-events: none;
    }

    .about-gallery-label {
        position: absolute;
        left: 34px;
        top: 34px;
        z-index: 3;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border: 1px solid rgba(255, 255, 255, 0.28);
        border-radius: 50px;
        color: #fff;
        background: rgba(8, 31, 22, 0.42);
        backdrop-filter: blur(12px);
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 1.4px;
        text-transform: uppercase;
    }

    .about-floating-note {
        position: absolute;
        z-index: 4;
        right: 34px;
        bottom: 34px;
        width: min(270px, calc(100% - 68px));
        border: 1px solid rgba(200, 161, 101, 0.32);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.94);
        box-shadow: 0 16px 35px rgba(26, 60, 46, 0.16);
        backdrop-filter: blur(12px);
    }

    .about-kicker {
        color: var(--about-gold);
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 2.4px;
        text-transform: uppercase;
    }

    .about-title {
        font-family: 'Playfair Display', serif;
        color: var(--about-green);
        line-height: 1.16;
    }

    .about-copy {
        color: #68746d;
        font-size: 1.03rem;
        line-height: 1.95;
    }

    .about-feature {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px 0;
        border-top: 1px solid rgba(26, 60, 46, 0.08);
    }

    .about-feature-icon,
    .about-stat-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        border-radius: 50%;
        color: var(--about-green);
        background: rgba(200, 161, 101, 0.16);
    }

    .about-founder-card {
        border: 1px solid rgba(26, 60, 46, 0.08);
        border-radius: 8px;
        background: linear-gradient(135deg, #fff 0%, var(--about-cream) 100%);
        box-shadow: 0 16px 40px rgba(26, 60, 46, 0.1);
    }

    .about-founder-card img {
        width: 78px;
        height: 78px;
        object-fit: cover;
        border: 3px solid #fff;
    }

    .about-process {
        background:
            linear-gradient(180deg, #fff 0%, #fff 50%, var(--about-cream) 50%, var(--about-cream) 100%);
    }

    .about-process-card {
        position: relative;
        height: 100%;
        padding: 30px 26px;
        border: 1px solid rgba(26, 60, 46, 0.08);
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 14px 36px rgba(26, 60, 46, 0.08);
        overflow: hidden;
        transition: transform 0.32s ease, box-shadow 0.32s ease, border-color 0.32s ease;
    }

    .about-process-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(200, 161, 101, 0.14), transparent 42%);
        opacity: 0;
        transition: opacity 0.32s ease;
    }

    .about-process-card:hover {
        transform: translateY(-8px);
        border-color: rgba(200, 161, 101, 0.42);
        box-shadow: 0 24px 54px rgba(26, 60, 46, 0.15);
    }

    .about-process-card:hover::before {
        opacity: 1;
    }

    .about-process-card > * {
        position: relative;
        z-index: 1;
    }

    .about-process-step {
        color: rgba(26, 60, 46, 0.2);
        font-family: 'Playfair Display', serif;
        font-size: 3.2rem;
        font-weight: 800;
        line-height: 1;
    }

    .about-process-icon {
        width: 54px;
        height: 54px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--about-green);
        background: rgba(200, 161, 101, 0.18);
    }

    .about-process-card.is-visible .about-process-icon {
        animation: aboutIconPulse 1.5s ease-in-out 1;
    }

    .about-timeline {
        background:
            radial-gradient(circle at 10% 20%, rgba(200, 161, 101, 0.12), transparent 30%),
            #fff;
    }

    .about-timeline-list {
        position: relative;
    }

    .about-timeline-list::before {
        content: '';
        position: absolute;
        top: 18px;
        bottom: 18px;
        left: 50%;
        width: 2px;
        background: linear-gradient(180deg, transparent, rgba(200, 161, 101, 0.65), transparent);
        transform: translateX(-50%);
    }

    .about-timeline-item {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 78px minmax(0, 1fr);
        align-items: center;
        gap: 18px;
        margin-bottom: 26px;
    }

    .about-timeline-card {
        border: 1px solid rgba(26, 60, 46, 0.08);
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 12px 32px rgba(26, 60, 46, 0.08);
        padding: 24px;
        transition: transform 0.32s ease, box-shadow 0.32s ease, border-color 0.32s ease;
    }

    .about-timeline-item:hover .about-timeline-card {
        transform: translateY(-5px);
        border-color: rgba(200, 161, 101, 0.42);
        box-shadow: 0 22px 48px rgba(26, 60, 46, 0.14);
    }

    .about-timeline-marker {
        width: 64px;
        height: 64px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        justify-self: center;
        border-radius: 50%;
        color: var(--about-green);
        background: #fff;
        border: 2px solid rgba(200, 161, 101, 0.58);
        box-shadow: 0 0 0 9px rgba(200, 161, 101, 0.12);
    }

    .about-timeline-item.is-visible .about-timeline-marker {
        animation: aboutIconPulse 1.5s ease-in-out 1;
    }

    .about-timeline-year {
        color: var(--about-gold);
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    .about-cta {
        position: relative;
        background:
            linear-gradient(120deg, rgba(9, 24, 18, 0.96), rgba(26, 60, 46, 0.93)),
            url('https://images.unsplash.com/photo-1471193945509-9ad0617afabf?q=80&w=1920&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        overflow: hidden;
    }

    .about-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(200, 161, 101, 0.14), transparent 55%);
    }

    .about-cta-card {
        position: relative;
        z-index: 1;
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(14px);
    }

    .about-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border-radius: 50px;
        padding: 14px 28px;
        color: var(--about-green) !important;
        background: linear-gradient(135deg, var(--about-gold), #e2c08d);
        text-decoration: none;
        font-weight: 800;
        box-shadow: 0 14px 32px rgba(200, 161, 101, 0.34);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .about-cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 22px 45px rgba(200, 161, 101, 0.42);
    }

    .about-trust {
        background: #fff;
    }

    .about-stories {
        background:
            radial-gradient(circle at 90% 8%, rgba(200, 161, 101, 0.13), transparent 28%),
            #fff;
    }

    .about-story-card {
        position: relative;
        height: 100%;
        padding: 30px 26px;
        border: 1px solid rgba(26, 60, 46, 0.08);
        border-radius: 8px;
        background: linear-gradient(145deg, #fff 0%, rgba(248, 245, 240, 0.72) 100%);
        box-shadow: 0 14px 36px rgba(26, 60, 46, 0.08);
        overflow: hidden;
        transition: transform 0.32s ease, box-shadow 0.32s ease, border-color 0.32s ease;
    }

    .about-story-card::before {
        content: '"';
        position: absolute;
        top: -26px;
        right: 22px;
        color: rgba(200, 161, 101, 0.12);
        font-family: 'Playfair Display', serif;
        font-size: 9rem;
        line-height: 1;
    }

    .about-story-card:hover {
        transform: translateY(-8px);
        border-color: rgba(200, 161, 101, 0.42);
        box-shadow: 0 24px 54px rgba(26, 60, 46, 0.15);
    }

    .about-story-avatar {
        width: 54px;
        height: 54px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        border-radius: 50%;
        color: #fff;
        background: linear-gradient(135deg, var(--about-green), #2d6a4f);
        border: 3px solid rgba(200, 161, 101, 0.22);
        font-weight: 800;
    }

    .about-story-stars {
        color: var(--about-gold);
        letter-spacing: 2px;
        font-size: 0.86rem;
    }

    .about-trust-card {
        position: relative;
        height: 100%;
        padding: 26px 24px;
        border: 1px solid rgba(26, 60, 46, 0.08);
        border-radius: 8px;
        background:
            linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 245, 240, 0.82) 100%);
        box-shadow: 0 12px 32px rgba(26, 60, 46, 0.08);
        overflow: hidden;
        transition: transform 0.32s ease, box-shadow 0.32s ease, border-color 0.32s ease;
    }

    .about-trust-card::before,
    .about-stat-card::after {
        content: '';
        position: absolute;
        top: -70%;
        left: -55%;
        width: 42%;
        height: 240%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.62), transparent);
        transform: rotate(18deg);
        transition: left 0.75s ease;
        pointer-events: none;
    }

    .about-trust-card:hover::before,
    .about-stat-card:hover::after {
        left: 125%;
    }

    .about-trust-card:hover {
        transform: translateY(-8px);
        border-color: rgba(200, 161, 101, 0.42);
        box-shadow: 0 24px 54px rgba(26, 60, 46, 0.15);
    }

    .about-trust-icon {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--about-green);
        background: rgba(200, 161, 101, 0.18);
        box-shadow: inset 0 0 0 1px rgba(200, 161, 101, 0.18);
    }

    .about-trust-number {
        font-family: 'Playfair Display', serif;
        color: var(--about-green);
        font-size: clamp(2.25rem, 4vw, 3.35rem);
        line-height: 1;
    }

    .about-trust-meter,
    .about-stat-meter {
        height: 5px;
        border-radius: 50px;
        background: rgba(26, 60, 46, 0.08);
        overflow: hidden;
    }

    .about-trust-meter span,
    .about-stat-meter span {
        display: block;
        width: 0;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, var(--about-green), var(--about-gold));
        transition: width 1.2s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    .about-trust-card.is-visible .about-trust-meter span,
    .about-stat-card.is-visible .about-stat-meter span {
        width: var(--meter-width, 86%);
    }

    .about-stats {
        background:
            radial-gradient(circle at 50% -10%, rgba(200, 161, 101, 0.14), transparent 34%),
            var(--about-cream);
    }

    .about-stat-card {
        position: relative;
        height: 100%;
        padding: 34px 28px;
        border: 1px solid rgba(26, 60, 46, 0.08);
        border-radius: 8px;
        background:
            linear-gradient(155deg, #fff 0%, #fff 54%, rgba(248, 245, 240, 0.85) 100%);
        box-shadow: 0 12px 32px rgba(26, 60, 46, 0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .about-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 28px;
        right: 28px;
        height: 3px;
        background: linear-gradient(90deg, var(--about-gold), rgba(200, 161, 101, 0));
        border-radius: 0 0 8px 8px;
    }

    .about-stat-card:hover {
        transform: translateY(-8px);
        border-color: rgba(200, 161, 101, 0.45);
        box-shadow: 0 24px 54px rgba(26, 60, 46, 0.16);
    }

    .about-stat-card.is-visible .about-stat-icon,
    .about-trust-card.is-visible .about-trust-icon {
        animation: aboutIconPulse 1.6s ease-in-out 1;
    }

    .about-stat-number {
        font-family: 'Playfair Display', serif;
        color: var(--about-gold);
        font-size: clamp(2.7rem, 5vw, 4.6rem);
        line-height: 1;
    }

    .about-faq {
        background:
            linear-gradient(180deg, var(--about-cream) 0%, #fff 100%);
    }

    .about-faq-panel {
        max-width: 920px;
        margin: 0 auto;
    }

    .about-faq-item {
        border: 1px solid rgba(26, 60, 46, 0.08) !important;
        border-radius: 8px !important;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 12px 30px rgba(26, 60, 46, 0.07);
    }

    .about-faq-item + .about-faq-item {
        margin-top: 14px;
    }

    .about-faq-button {
        gap: 14px;
        padding: 20px 22px;
        color: var(--about-green);
        background: #fff;
        font-weight: 800;
        box-shadow: none !important;
    }

    .about-faq-button:not(.collapsed) {
        color: var(--about-green);
        background: linear-gradient(135deg, #fff 0%, rgba(248, 245, 240, 0.9) 100%);
    }

    .about-faq-button i {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        border-radius: 50%;
        color: var(--about-green);
        background: rgba(200, 161, 101, 0.16);
    }

    .about-faq-body {
        color: #68746d;
        line-height: 1.85;
        padding: 0 22px 22px 74px;
    }

    @keyframes aboutIconPulse {
        0% {
            transform: scale(0.92);
            box-shadow: 0 0 0 0 rgba(200, 161, 101, 0.32);
        }
        55% {
            transform: scale(1.08);
            box-shadow: 0 0 0 12px rgba(200, 161, 101, 0);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(200, 161, 101, 0);
        }
    }

    @keyframes aboutHeroPicture {
        0% {
            opacity: 0;
            transform: scale(1.04) translateX(0);
        }
        4%,
        18% {
            opacity: 1;
        }
        24% {
            opacity: 0;
            transform: scale(1.13) translateX(-1.5%);
        }
        100% {
            opacity: 0;
            transform: scale(1.13) translateX(-1.5%);
        }
    }

    @keyframes aboutPanelPicture {
        0% {
            opacity: 0;
            transform: scale(1.05) translateY(0);
        }
        5%,
        21% {
            opacity: 1;
        }
        28% {
            opacity: 0;
            transform: scale(1.14) translateY(-1.8%);
        }
        100% {
            opacity: 0;
            transform: scale(1.14) translateY(-1.8%);
        }
    }

    [dir="rtl"] .about-image-panel::before {
        inset: 36px -22px auto auto;
    }

    [dir="rtl"] .about-floating-note {
        right: auto;
        left: 34px;
    }

    [dir="rtl"] .about-timeline-list::before {
        left: auto;
        right: 50%;
        transform: translateX(50%);
    }

    .about-page *,
    .about-page *::before,
    .about-page *::after {
        min-width: 0;
    }

    .about-page h1,
    .about-page h2,
    .about-page h3,
    .about-page h4,
    .about-page h5,
    .about-page h6,
    .about-page p,
    .about-page a,
    .about-page button,
    .about-page span {
        overflow-wrap: break-word;
    }

    .about-page .row {
        --bs-gutter-y: 1.5rem;
    }

    @media (max-width: 991.98px) {
        .about-hero {
            min-height: 500px;
            height: auto;
            padding: 130px 0 95px;
        }

        .about-section {
            background: #fff;
        }

        .about-image-carousel {
            height: 430px;
        }

        .about-timeline-list::before {
            left: 31px;
            transform: none;
        }

        [dir="rtl"] .about-timeline-list::before {
            right: 31px;
            transform: none;
        }

        .about-timeline-item {
            grid-template-columns: 64px minmax(0, 1fr);
            gap: 16px;
        }

        .about-timeline-spacer {
            display: none;
        }

        .about-timeline-card {
            grid-column: 2;
        }

        .about-timeline-marker {
            grid-column: 1;
            grid-row: 1;
        }

        .about-cta-card {
            text-align: center;
        }
    }

    @media (max-width: 767.98px) {
        .about-page .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .about-hero {
            min-height: auto;
            padding: 112px 0 82px;
        }

        .about-hero-title {
            font-size: clamp(2.35rem, 12vw, 3.35rem);
            line-height: 1.06;
        }

        .about-title {
            font-size: clamp(2rem, 9vw, 2.55rem);
        }

        .about-hero-copy,
        .about-copy {
            font-size: 0.98rem;
            line-height: 1.78;
        }

        .about-hero-pills {
            gap: 9px;
            margin-top: 24px;
        }

        .about-hero-pill {
            padding: 9px 13px;
            font-size: 0.78rem;
        }

        .about-eyebrow,
        .about-kicker {
            letter-spacing: 1.7px;
        }

        .about-process-card,
        .about-trust-card,
        .about-stat-card,
        .about-story-card,
        .about-timeline-card {
            padding: 22px;
        }

        .about-process-step {
            font-size: 2.65rem;
        }

        .about-trust-number {
            font-size: 2.35rem;
        }

        .about-stat-number {
            font-size: 3rem;
        }

        .about-timeline-list::before {
            left: 26px;
        }

        [dir="rtl"] .about-timeline-list::before {
            right: 26px;
        }

        .about-timeline-item {
            grid-template-columns: 52px minmax(0, 1fr);
            gap: 13px;
            margin-bottom: 18px;
        }

        .about-timeline-marker {
            width: 52px;
            height: 52px;
            box-shadow: 0 0 0 6px rgba(200, 161, 101, 0.12);
        }

        .about-timeline-year {
            font-size: 1.65rem;
        }

        .about-faq-button {
            align-items: flex-start;
            padding: 16px;
            font-size: 0.95rem;
            line-height: 1.45;
        }

        .about-faq-button i {
            width: 34px;
            height: 34px;
        }

        .about-faq-body {
            padding: 0 16px 18px 64px;
        }

        [dir="rtl"] .about-faq-body {
            padding: 0 64px 18px 16px;
        }

        .about-cta-card {
            padding: 2rem 1.25rem !important;
        }

        .about-cta-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 575.98px) {
        .about-hero {
            min-height: 460px;
            padding: 105px 0 76px;
        }

        .about-hero-title {
            letter-spacing: 0;
        }

        .about-image-panel {
            padding: 10px;
        }

        .about-image-panel::before {
            display: none;
        }

        .about-image-carousel {
            height: 330px;
        }

        .about-gallery-label {
            left: 20px;
            top: 20px;
        }

        .about-floating-note {
            position: relative;
            right: auto;
            bottom: auto;
            width: 100%;
            margin-top: 14px;
        }

        [dir="rtl"] .about-floating-note {
            left: auto;
        }

        .about-faq-body {
            padding: 0 20px 20px;
        }
    }

    @media (max-width: 390px) {
        .about-hero {
            padding: 94px 0 66px;
        }

        .about-eyebrow {
            max-width: 100%;
            padding: 7px 12px;
            font-size: 0.68rem;
            letter-spacing: 1.2px;
        }

        .about-hero-pill {
            width: 100%;
            justify-content: center;
        }

        .about-image-carousel {
            height: 285px;
        }

        .about-founder-card,
        .about-story-card .d-flex {
            align-items: flex-start !important;
        }

        .about-founder-card {
            flex-direction: column;
            text-align: center;
        }

        .about-stat-number {
            font-size: 2.65rem;
        }

        .about-process-card,
        .about-trust-card,
        .about-stat-card,
        .about-story-card,
        .about-timeline-card {
            padding: 20px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .about-slide,
        .about-panel-slide {
            animation: none;
        }

        .about-slide:first-child,
        .about-panel-slide:first-child {
            opacity: 1;
        }
    }
</style>
@endpush

@section('content')
@php
    $heroImage = $about->hero_image
        ? asset($about->hero_image)
        : 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?q=80&w=1920&auto=format&fit=crop';
    $visionImage = $about->vision_image
        ? asset($about->vision_image)
        : 'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=900&auto=format&fit=crop';
    $founderImage = $about->founder_image
        ? asset($about->founder_image)
        : 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=150&auto=format&fit=crop';
    $heroSlides = [
        $heroImage,
        'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1471193945509-9ad0617afabf?q=80&w=1920&auto=format&fit=crop',
    ];
    $visionSlides = [
        $visionImage,
        'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?q=80&w=900&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=900&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1471193945509-9ad0617afabf?q=80&w=900&auto=format&fit=crop',
    ];
    $stats = $about->stats ?? [
        ['number' => '15K+', 'label' => __('Trusted Customers'), 'desc' => __('Serving families with trusted herbal wellness knowledge.')],
        ['number' => '50k', 'label' => __('Happy Customers'), 'desc' => __('Helping customers choose natural remedies with confidence.')],
        ['number' => '120+', 'label' => __('Herbal Solutions'), 'desc' => __('Carefully selected products for daily health and wellbeing.')]
    ];
    $statIcons = ['fas fa-leaf', 'fas fa-heart-pulse', 'fas fa-award'];
    $trustHighlights = [
        ['icon' => 'fas fa-certificate', 'number' => '100%', 'label' => __('Quality Checked'), 'desc' => __('Every product is reviewed for purity, reliability, and daily wellness value.'), 'meter' => 100],
        ['icon' => 'fas fa-users', 'number' => '15K+', 'label' => __('Customer Trust'), 'desc' => __('A growing community choosing natural remedies with confidence.'), 'meter' => 92],
        ['icon' => 'fas fa-truck-fast', 'number' => '24/7', 'label' => __('Support Ready'), 'desc' => __('Helpful service and quick order support whenever customers need guidance.'), 'meter' => 86],
        ['icon' => 'fas fa-star', 'number' => '4.9', 'label' => __('Average Rating'), 'desc' => __('Loved for clean product selection, clear information, and dependable care.'), 'meter' => 96],
    ];
    $selectionSteps = [
        ['icon' => 'fas fa-seedling', 'title' => __('Source with care'), 'desc' => __('We choose herbs and wellness products from reliable sources with a focus on purity and usefulness.')],
        ['icon' => 'fas fa-microscope', 'title' => __('Check quality'), 'desc' => __('Products are reviewed for freshness, packaging, ingredients, and customer suitability before they are promoted.')],
        ['icon' => 'fas fa-box-open', 'title' => __('Pack responsibly'), 'desc' => __('Orders are handled carefully so the product reaches customers clean, secure, and ready for use.')],
        ['icon' => 'fas fa-headset', 'title' => __('Support every order'), 'desc' => __('Customers get clear guidance, order help, and a smoother shopping experience from start to finish.')],
    ];
    $journeyItems = [
        ['year' => '2010', 'icon' => 'fas fa-seedling', 'title' => __('Started with herbal care'), 'desc' => __('A small vision began with trusted traditional remedies and personal customer guidance.')],
        ['year' => '2016', 'icon' => 'fas fa-mortar-pestle', 'title' => __('Expanded natural remedies'), 'desc' => __('The collection grew with more wellness products for daily family health needs.')],
        ['year' => '2021', 'icon' => 'fas fa-store', 'title' => __('Modern store experience'), 'desc' => __('Dawakhana moved toward a cleaner shopping journey with better product discovery and service.')],
        ['year' => '2026', 'icon' => 'fas fa-award', 'title' => __('Trusted wellness brand'), 'desc' => __('Today the focus is premium presentation, reliable products, and customer-first herbal care.')],
    ];
    $customerStories = [
        ['name' => 'Ayesha Khan', 'role' => __('Verified Customer'), 'initials' => 'AK', 'body' => __('The product information felt clear and trustworthy. I could choose what I needed without confusion, and the order experience was smooth.')],
        ['name' => 'Bilal Ahmed', 'role' => __('Regular Buyer'), 'initials' => 'BA', 'body' => __('Dawakhana feels professional and reliable. The herbal selection is easy to understand, and the support is helpful when I need guidance.')],
        ['name' => 'Sana Malik', 'role' => __('Wellness Customer'), 'initials' => 'SM', 'body' => __('I like the clean packaging, fast service, and natural product focus. It gives confidence when buying for family wellness.')],
    ];
    $faqs = [
        ['icon' => 'fas fa-leaf', 'question' => __('Are your herbal products natural?'), 'answer' => __('We focus on carefully selected herbal and wellness products, with clear information so customers can understand what they are buying and how it fits their routine.')],
        ['icon' => 'fas fa-truck-fast', 'question' => __('How fast is delivery?'), 'answer' => __('Delivery timing depends on the customer location and order details, but every order is handled with care so products arrive safely and cleanly packed.')],
        ['icon' => 'fas fa-user-doctor', 'question' => __('How do I choose the right product?'), 'answer' => __('Product pages and support guidance are designed to help customers compare options. If you are unsure, you can contact support before placing an order.')],
        ['icon' => 'fas fa-shield-heart', 'question' => __('Why should customers trust Dawakhana?'), 'answer' => __('The store is built around clear product selection, quality-focused presentation, helpful support, and a smoother shopping experience for natural wellness customers.')],
    ];
@endphp

<main class="about-page">
    <!-- Hero / Page Header -->
    <section class="about-hero position-relative d-flex align-items-center justify-content-center"
        style="background-image: url('{{ $heroImage }}');">
        <div class="about-hero-slideshow" aria-hidden="true">
            @foreach($heroSlides as $index => $slide)
                <span class="about-slide"
                    style="background-image: url('{{ $slide }}'); animation-delay: {{ $index * 6 }}s;"></span>
            @endforeach
        </div>

        <div class="container position-relative text-center text-white" style="z-index: 2;">
            <span class="about-eyebrow mb-3">
                <i class="fas fa-leaf"></i>
                {{ __('Discover') }}
            </span>
            <h1 class="about-hero-title fw-bold mb-4">
                {{ $about->hero_title ?? __('Our Story') }}
            </h1>
            <p class="about-hero-copy lead fw-light mx-auto mb-0">
                {{ $about->hero_subtitle ?? __('Rooted in natural care, Dawakhana brings trusted herbal remedies and wellness guidance to every home.') }}
            </p>

            <div class="about-hero-pills">
                <span class="about-hero-pill"><i class="fas fa-seedling text-secondary-custom"></i>{{ __('Authentic Herbs') }}</span>
                <span class="about-hero-pill"><i class="fas fa-shield-heart text-secondary-custom"></i>{{ __('Trusted Quality') }}</span>
                <span class="about-hero-pill"><i class="fas fa-hand-holding-heart text-secondary-custom"></i>{{ __('Family Care') }}</span>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="about-section py-5">
        <div class="container py-4 py-lg-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image-panel">
                        <div class="about-image-carousel" role="img" aria-label="{{ __('Herbal wellness gallery') }}">
                            @foreach($visionSlides as $index => $slide)
                                <span class="about-panel-slide"
                                    style="background-image: url('{{ $slide }}'); animation-delay: {{ $index * 6 }}s;"></span>
                            @endforeach
                            <span class="about-gallery-label">
                                <i class="fas fa-camera-retro"></i>
                                {{ __('Wellness Gallery') }}
                            </span>
                        </div>
                        <div class="about-floating-note p-3 p-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <span class="about-feature-icon">
                                    <i class="fas fa-mortar-pestle"></i>
                                </span>
                                <div>
                                    <div class="fw-bold text-primary-custom">{{ __('Nature-led wellness') }}</div>
                                    <small class="text-muted">{{ __('Carefully selected remedies for everyday health.') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                    <div class="about-kicker mb-3">
                        {{ $about->vision_title ?? __('The Vision') }}
                    </div>
                    <h2 class="about-title display-5 mb-4 fw-bold">
                        {{ $about->vision_heading ?? __('Natural care, trusted knowledge, and better everyday wellness') }}
                    </h2>
                    <p class="about-copy mb-4">
                        {{ $about->vision_description_1 ?? __('Dawakhana was built on a simple promise: make natural remedies easy to trust, easy to understand, and easy to bring into daily life.') }}
                    </p>
                    <p class="about-copy mb-4">
                        {{ $about->vision_description_2 ?? __('We combine traditional herbal wisdom with a careful product selection process, so every customer can shop with confidence and clarity.') }}
                    </p>

                    <div class="about-feature">
                        <span class="about-feature-icon"><i class="fas fa-check"></i></span>
                        <div>
                            <h6 class="fw-bold text-primary-custom mb-1">{{ __('Carefully sourced') }}</h6>
                            <p class="text-muted mb-0">{{ __('Ingredients and products are selected with quality, purity, and customer trust in mind.') }}</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <span class="about-feature-icon"><i class="fas fa-user-doctor"></i></span>
                        <div>
                            <h6 class="fw-bold text-primary-custom mb-1">{{ __('Guided wellness') }}</h6>
                            <p class="text-muted mb-0">{{ __('Clear product information helps families choose remedies that fit their routine.') }}</p>
                        </div>
                    </div>

                    <div class="about-founder-card d-flex align-items-center gap-3 mt-4 p-4">
                        <img src="{{ $founderImage }}" loading="lazy" decoding="async" class="rounded-circle shadow-sm"
                            alt="{{ __('Founder') }}">
                        <div>
                            <h5 class="mb-1 fw-bold text-primary-custom" style="font-family: 'Playfair Display', serif;">
                                {{ $about->founder_name ?? 'Dawakhana Team' }}
                            </h5>
                            <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 1px;">
                                {{ $about->founder_title ?? __('Herbal Wellness Specialists') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Selection Process -->
    <section class="about-process py-5">
        <div class="container py-4 py-lg-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="about-kicker mb-2">{{ __('How We Select Herbs') }}</div>
                <h2 class="about-title display-6 fw-bold mb-3">
                    {{ __('A careful process behind every product') }}
                </h2>
                <p class="about-copy mx-auto mb-0" style="max-width: 720px;">
                    {{ __('Each step is designed to build confidence, from choosing products to delivering them with care.') }}
                </p>
            </div>

            <div class="row g-4">
                @foreach($selectionSteps as $index => $step)
                    <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="{{ $index * 90 }}">
                        <article class="about-process-card js-about-animate">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <span class="about-process-icon">
                                    <i class="{{ $step['icon'] }}"></i>
                                </span>
                                <span class="about-process-step">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h5 class="fw-bold text-primary-custom mb-3">{{ $step['title'] }}</h5>
                            <p class="text-muted mb-0">{{ $step['desc'] }}</p>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Journey Timeline -->
    <section class="about-timeline py-5">
        <div class="container py-4 py-lg-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="about-kicker mb-2">{{ __('Our Journey') }}</div>
                <h2 class="about-title display-6 fw-bold mb-0">
                    {{ __('From traditional care to modern herbal wellness') }}
                </h2>
            </div>

            <div class="about-timeline-list">
                @foreach($journeyItems as $index => $item)
                    <div class="about-timeline-item js-about-animate" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        @if($index % 2 === 0)
                            <article class="about-timeline-card text-lg-end">
                                <div class="about-timeline-year mb-2">{{ $item['year'] }}</div>
                                <h5 class="fw-bold text-primary-custom mb-2">{{ $item['title'] }}</h5>
                                <p class="text-muted mb-0">{{ $item['desc'] }}</p>
                            </article>
                            <span class="about-timeline-marker">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                            <div class="about-timeline-spacer"></div>
                        @else
                            <div class="about-timeline-spacer"></div>
                            <span class="about-timeline-marker">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                            <article class="about-timeline-card">
                                <div class="about-timeline-year mb-2">{{ $item['year'] }}</div>
                                <h5 class="fw-bold text-primary-custom mb-2">{{ $item['title'] }}</h5>
                                <p class="text-muted mb-0">{{ $item['desc'] }}</p>
                            </article>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trust Highlights -->
    <section class="about-trust py-5">
        <div class="container py-4 py-lg-5">
            <div class="row align-items-end mb-4 mb-lg-5">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="about-kicker mb-2">{{ __('Why Customers Trust Us') }}</div>
                    <h2 class="about-title display-6 fw-bold mb-0">
                        {{ __('A professional herbal store experience built around care and confidence') }}
                    </h2>
                </div>
                <div class="col-lg-5 mt-3 mt-lg-0" data-aos="fade-left">
                    <p class="about-copy mb-0">
                        {{ __('From product selection to customer support, every detail is designed to make natural wellness feel clear, premium, and dependable.') }}
                    </p>
                </div>
            </div>

            <div class="row g-4">
                @foreach($trustHighlights as $index => $item)
                    <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 90 }}">
                        <article class="about-trust-card js-about-animate h-100" style="--meter-width: {{ $item['meter'] }}%;">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <span class="about-trust-icon">
                                    <i class="{{ $item['icon'] }}"></i>
                                </span>
                                <span class="small fw-bold text-secondary-custom">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>

                            <h3 class="about-trust-number fw-bold mb-2 js-count-up" data-count-value="{{ $item['number'] }}">
                                {{ $item['number'] }}
                            </h3>
                            <h5 class="fw-bold text-primary-custom mb-2">{{ $item['label'] }}</h5>
                            <p class="text-muted mb-4">{{ $item['desc'] }}</p>

                            <div class="about-trust-meter">
                                <span></span>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="about-stats py-5">
        <div class="container py-4 py-lg-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="about-kicker mb-2">{{ __('Our Impact') }}</div>
                <h2 class="about-title display-6 fw-bold mb-0">{{ __('Trusted by customers who choose natural care') }}</h2>
            </div>

            <div class="row text-center g-4">
                @foreach($stats as $index => $stat)
                    @php
                        $label = is_array($stat['label'] ?? null)
                            ? ($stat['label'][app()->getLocale()] ?? $stat['label']['en'] ?? '')
                            : __($stat['label'] ?? '');
                        $desc = is_array($stat['desc'] ?? null)
                            ? ($stat['desc'][app()->getLocale()] ?? $stat['desc']['en'] ?? '')
                            : __($stat['desc'] ?? '');
                    @endphp
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                        <article class="about-stat-card js-about-animate" style="--meter-width: {{ 78 + (($index % 3) * 8) }}%;">
                            <span class="about-stat-icon mx-auto mb-4">
                                <i class="{{ $statIcons[$index % count($statIcons)] }}"></i>
                            </span>
                            <h3 class="about-stat-number fw-bold mb-3 js-count-up" data-count-value="{{ $stat['number'] ?? '' }}">
                                {{ $stat['number'] ?? '' }}
                            </h3>
                            <h5 class="fw-bold text-primary-custom text-uppercase mb-3" style="letter-spacing: 1px;">
                                {{ $label }}
                            </h5>
                            <p class="text-muted mb-4">{{ $desc }}</p>
                            <div class="about-stat-meter">
                                <span></span>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Customer Stories -->
    <section class="about-stories py-5">
        <div class="container py-4 py-lg-5">
            <div class="row align-items-end mb-4 mb-lg-5">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="about-kicker mb-2">{{ __('Customer Stories') }}</div>
                    <h2 class="about-title display-6 fw-bold mb-0">
                        {{ __('Real confidence from people choosing natural wellness') }}
                    </h2>
                </div>
                <div class="col-lg-5 mt-3 mt-lg-0" data-aos="fade-left">
                    <p class="about-copy mb-0">
                        {{ __('Short, honest customer moments help new visitors feel that Dawakhana is dependable, human, and ready to help.') }}
                    </p>
                </div>
            </div>

            <div class="row g-4">
                @foreach($customerStories as $index => $story)
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <article class="about-story-card js-about-animate">
                            <div class="about-story-stars mb-4">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="text-muted mb-4" style="line-height: 1.9;">
                                "{{ $story['body'] }}"
                            </p>
                            <div class="d-flex align-items-center gap-3">
                                <span class="about-story-avatar">{{ $story['initials'] }}</span>
                                <div>
                                    <h6 class="fw-bold text-primary-custom mb-1">{{ $story['name'] }}</h6>
                                    <small class="text-muted text-uppercase fw-semibold" style="letter-spacing: 1px;">
                                        {{ $story['role'] }}
                                    </small>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="about-faq py-5">
        <div class="container py-4 py-lg-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="about-kicker mb-2">{{ __('Questions Before You Order') }}</div>
                <h2 class="about-title display-6 fw-bold mb-3">
                    {{ __('Everything customers usually want to know') }}
                </h2>
                <p class="about-copy mx-auto mb-0" style="max-width: 720px;">
                    {{ __('Clear answers make the buying decision easier and help visitors feel comfortable before they shop.') }}
                </p>
            </div>

            <div class="accordion about-faq-panel" id="aboutFaqAccordion" data-aos="fade-up">
                @foreach($faqs as $index => $faq)
                    <div class="accordion-item about-faq-item">
                        <h3 class="accordion-header" id="aboutFaqHeading{{ $index }}">
                            <button class="accordion-button about-faq-button {{ $index === 0 ? '' : 'collapsed' }}"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#aboutFaqCollapse{{ $index }}"
                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-controls="aboutFaqCollapse{{ $index }}">
                                <i class="{{ $faq['icon'] }}"></i>
                                <span>{{ $faq['question'] }}</span>
                            </button>
                        </h3>
                        <div id="aboutFaqCollapse{{ $index }}"
                            class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                            aria-labelledby="aboutFaqHeading{{ $index }}"
                            data-bs-parent="#aboutFaqAccordion">
                            <div class="about-faq-body">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="about-cta py-5">
        <div class="container py-4 py-lg-5">
            <div class="about-cta-card p-4 p-lg-5 text-center text-white" data-aos="zoom-in">
                <span class="about-eyebrow mb-3">
                    <i class="fas fa-leaf"></i>
                    {{ __('Start Naturally') }}
                </span>
                <h2 class="about-hero-title fw-bold mb-3" style="font-size: clamp(2.3rem, 5vw, 4.3rem);">
                    {{ __('Begin your wellness journey with Dawakhana') }}
                </h2>
                <p class="about-hero-copy mx-auto mb-4">
                    {{ __('Explore trusted herbal products selected for everyday care, better routines, and natural confidence.') }}
                </p>
                <a href="{{ route('shop.index') }}" class="about-cta-btn">
                    {{ __('Shop Herbal Products') }}
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const animatedCards = document.querySelectorAll('.js-about-animate');
    const counters = document.querySelectorAll('.js-count-up');

    function splitMetric(rawValue) {
        const raw = String(rawValue || '').trim();
        const match = raw.match(/^([^0-9]*)([0-9]+(?:\.[0-9]+)?)(.*)$/);

        if (!match) {
            return { prefix: '', number: 0, decimals: 0, suffix: raw };
        }

        const decimals = match[2].includes('.') ? match[2].split('.')[1].length : 0;

        return {
            prefix: match[1],
            number: parseFloat(match[2]),
            decimals: decimals,
            suffix: match[3]
        };
    }

    function animateCounter(el) {
        if (el.dataset.counted === 'true') {
            return;
        }

        const metric = splitMetric(el.dataset.countValue || el.textContent);
        const duration = 1500;
        const start = performance.now();

        el.dataset.counted = 'true';

        function tick(now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 4);
            const value = metric.number * eased;

            el.textContent = metric.prefix + value.toLocaleString(undefined, {
                minimumFractionDigits: metric.decimals,
                maximumFractionDigits: metric.decimals
            }) + metric.suffix;

            if (progress < 1) {
                requestAnimationFrame(tick);
            } else {
                el.textContent = metric.prefix + metric.number.toLocaleString(undefined, {
                    minimumFractionDigits: metric.decimals,
                    maximumFractionDigits: metric.decimals
                }) + metric.suffix;
            }
        }

        requestAnimationFrame(tick);
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-visible');
            entry.target.querySelectorAll('.js-count-up').forEach(animateCounter);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.28 });

    animatedCards.forEach(card => observer.observe(card));

    counters.forEach(counter => {
        if (!counter.closest('.js-about-animate')) {
            observer.observe(counter);
        }
    });
});
</script>
@endpush
