@extends('layouts.wedding')
@section('content')

    <!-- Audio Player (thêm vào đầu section) -->
    @if($card->music)
    <div id="letter-invitation" class="letter-container">
        <div class="letter">
            <div class="letter-content">
                <div class="letter-header">
                    <h2>Thư mời</h2>
                </div>
                <div class="letter-body">
                    <p>Trân trọng kính mời</p>
                    <p>Tới dự lễ thành hôn của</p>
                    <p class="couple-names-letter">{{ $card->groom_name }} & {{ $card->bride_name }}</p>
                    <p class="wedding-date-letter">{{ $card->wedding_date->format('d.m.Y') }}</p>
                    <button id="open-letter" class="open-letter-btn">
                        <i class="fas fa-envelope-open"></i>
                        Mở thư
                    </button>
                </div>
            </div>
        </div>
        <audio id="background-music" loop>
            <source src="{{ $card->music->file_url }}" type="audio/mpeg">
        </audio>
    </div>
    @endif

    <!-- Cover Section -->
    <section class="cover-section" style="background-image: url('{{ $card->cover_image_url }}')" data-aos="fade" data-aos-duration="1500">
        <div class="cover-content">
            <div class="couple-names" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1200">
                {{ $card->groom_name }} & {{ $card->bride_name }}
            </div>
            <div class="wedding-date" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1200">
                {{ $card->wedding_date->format('d.m.Y') }}
            </div>
        </div>
    </section>

            <!-- Poem Section -->
            @if($card->wedding_poem)
            <section class="section" data-aos="fade-up">
                <h2 class="section-title">Lời chúc</h2>
                <div class="poem">
                    @foreach(explode("\n", $card->wedding_poem) as $line)
                        <p>{{ $line }}</p>
                    @endforeach
                </div>
            </section>
            @endif

    <!-- Families Section -->
    <section class="section" data-aos="fade-up" data-aos-offset="300">
        <h2 class="section-title" data-aos="fade-up" data-aos-offset="300">Hai bên gia đình</h2>
        <div class="container">
            <div class="row g-3">
                <div class="col-6" data-aos="fade-right" data-aos-offset="300" data-aos-delay="200">
                    <div class="family-column">
                        <h3 class="family-title">Nhà trai</h3>
                        <div class="parent-info">
                            <div class="parent-label">Cha:</div>
                            {{ $card->groom_father_name }}
                        </div>
                        <div class="parent-info">
                            <div class="parent-label">Mẹ:</div>
                            {{ $card->groom_mother_name }}
                        </div>
                    </div>
                </div>
                <div class="col-6" data-aos="fade-left" data-aos-offset="300" data-aos-delay="400">
                    <div class="family-column">
                        <h3 class="family-title">Nhà gái</h3>
                        <div class="parent-info">
                            <div class="parent-label">Cha:</div>
                            {{ $card->bride_father_name }}
                        </div>
                        <div class="parent-info">
                            <div class="parent-label">Mẹ:</div>
                            {{ $card->bride_mother_name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Couple Section -->
    <section class="section">
        <h2 class="section-title" data-aos="fade-up" data-aos-offset="300">Cô dâu & Chú rể</h2>
        <div class="couple-photos">
            <div class="person-card" data-aos="fade-right" data-aos-offset="400" data-aos-delay="200">
                <img src="{{ $card->groom_image_url }}" alt="Chú rể" class="couple-photo">
                <div class="person-info">
                    <h3 class="person-name">{{ $card->groom_name }}</h3>
                </div>
            </div>
            <div class="person-card" data-aos="fade-left" data-aos-offset="400" data-aos-delay="400">
                <img src="{{ $card->bride_image_url }}" alt="Cô dâu" class="couple-photo">
                <div class="person-info">
                    <h3 class="person-name">{{ $card->bride_name }}</h3>
                </div>
            </div>
        </div>
    </section>


    <!-- Featured Photos -->
    <section class="section" data-aos="fade-up">
        <h2 class="section-title">Khoảnh khắc đặc biệt</h2>
        <div class="featured-photos">
            @foreach($card->photos()->where('type', 'featured')->take(3)->get() as $photo)
                <img src="{{ $photo->image_url }}" alt="Ảnh cưới" data-aos="zoom-in">
            @endforeach
        </div>
    </section>

    <!-- Venue Section -->
    <section class="section" data-aos="fade-up">
        <h2 class="section-title">Địa điểm tổ chức</h2>
        <div class="venue-info">
            <h3 class="venue-name">{{ $card->venue_name }}</h3>
            <p class="venue-address">{{ $card->venue_address }}</p>
            @if($card->google_map_iframe)
            <div class="map" data-aos="zoom-in">
                {!! $card->google_map_iframe !!}
            </div>
            @endif
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section" data-aos="fade-up">
        <h2 class="section-title">Album ảnh cưới</h2>
        <div class="gallery">
            @foreach($card->photos()->where('type', 'gallery')->orderBy('sort_order')->get() as $photo)
                <img src="{{ $photo->image_url }}" alt="Ảnh cưới" data-aos="zoom-in">
            @endforeach
        </div>
    </section>

    <!-- RSVP Form -->
    <section class="section" data-aos="fade-up">
        <h2 class="section-title">Xác nhận tham dự</h2>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form class="rsvp-form" action="{{ route('wedding.rsvp', $card->slug) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" name="guest_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số người tham dự</label>
                            <input type="number" class="form-control" name="number_of_guests" required min="1" value="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lời nhắn</label>
                            <textarea class="form-control" name="message" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Gửi xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- QR Code Section -->
    @if($card->qr_code_url)
    <section class="section" data-aos="fade-up">
        <h2 class="section-title">Mã QR</h2>
        <div class="qr-code">
            <img src="{{ $card->qr_code_url }}" alt="QR Code" data-aos="zoom-in">
        </div>
    </section>
    @endif
@endsection
@push('css')
<style>
    :root {
        --primary-color: #000000;
        --secondary-color: #ffffff;
        --accent-color: #888888;
        --gold-color: #C0A062;
        --background-light: #f5f5f5;
        --font-main: 'Alex Brush', cursive;  /* Font chính cho toàn bộ template */
        --font-body: 'Montserrat', sans-serif;  /* Font phụ cho text thường */
    }

    /* Font chính cho các tiêu đề */
    .couple-names,
    .section-title,
    .family-title,
    .person-name,
    .venue-name {
        font-family: var(--font-main);
        font-weight: 400;
    }

    /* Điều chỉnh kích thước cụ thể */
    .couple-names {
        font-size: 4.5rem;
        letter-spacing: 1px;
        line-height: 1.2;
    }

    .section-title {
        text-align: center;
        font-size: 3.5rem;
        letter-spacing: 1px;
    }

    .family-title {
        font-size: 3rem;
    }

    .person-name {
        font-size: 3rem;
    }

    .venue-name {
        font-size: 3rem;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .couple-names {
            font-size: 3rem;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
        }

        .family-title {
            font-size: 2rem;
        }

        .person-name {
            font-size: 2rem;
        }

        .venue-name {
            font-size: 2rem;
        }
    }

    body {
        font-family: var(--font-body);
        margin: 0;
        padding: 0;
        color: var(--primary-color);
        line-height: 1.6;
        background-color: var(--secondary-color);
    }

    .cover-section {
        height: 100vh;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .cover-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
    }

    .cover-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 2rem;
        animation: fadeInUp 1.5s ease-out;
    }

    .couple-names {
        font-family: var(--font-main);
        font-size: 5.5rem;
        letter-spacing: 2px;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        animation: fadeInScale 2s ease-out;
    }

    .wedding-date {
        font-family: var(--font-main);
        font-size: 2.2rem;
        letter-spacing: 8px;
        text-transform: uppercase;
        margin-top: 1rem;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        position: relative;
        animation: fadeInUp 2s ease-out 0.5s backwards;
    }

    .wedding-date::before,
    .wedding-date::after {
        content: '♥';
        font-size: 1.5rem;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gold-color);
        opacity: 0.8;
    }

    .wedding-date::before {
        left: -40px;
    }

    .wedding-date::after {
        right: -40px;
    }

    /* Decorative elements */
    .cover-content::before,
    .cover-content::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
    }

    .cover-content::before {
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
    }

    .cover-content::after {
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
    }

    /* Animations */
    @keyframes fadeInScale {
        0% {
            opacity: 0;
            transform: scale(0.9);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .couple-names {
            font-size: 3.5rem;
            letter-spacing: 1px;
        }

        .wedding-date {
            font-size: 1.8rem;
            letter-spacing: 4px;
        }

        .wedding-date::before,
        .wedding-date::after {
            font-size: 1.2rem;
        }

        .wedding-date::before {
            left: -25px;
        }

        .wedding-date::after {
            right: -25px;
        }

        .cover-content::before,
        .cover-content::after {
            width: 150px;
        }
    }

    @media (max-width: 480px) {
        .couple-names {
            font-size: 2.8rem;
        }

        .wedding-date {
            font-size: 1.5rem;
            letter-spacing: 3px;
        }
    }

    .section {
        padding: 120px 20px;
        position: relative;
        overflow: hidden;
    }

    .section:nth-child(even) {
        background-color: var(--background-light);
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 1px;
        background-color: var(--gold-color);
    }

    .families-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .family-column {
        text-align: center;
        padding: 20px;
        margin: 10px 0;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .parent-info {
        margin: 10px 0;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .parent-label {
        color: var(--gold-color);
        font-weight: 500;
    }

    .couple-photos {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .person-card {
        position: relative;
        text-align: center;
        background: white;
        padding: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        transition: transform 0.5s ease;
        height: fit-content;
    }

    .person-card:hover {
        transform: translateY(-10px);
    }

    .couple-photo {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .person-card:hover .couple-photo {
        transform: scale(1.05);
    }

    .person-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 30px;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
    }

    .featured-photos {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .featured-photos img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 15px;
        transition: transform 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .featured-photos img:hover {
        transform: scale(1.05);
    }

    .venue-info {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .venue-address {
        font-size: 1.2rem;
        margin-bottom: 30px;
        color: var(--accent-color);
    }

    .map {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .gallery img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 15px;
        transition: transform 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .gallery img:hover {
        transform: scale(1.05);
    }

    .rsvp-form {
        max-width: 500px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--primary-color);
        font-weight: 500;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-family: 'Montserrat', sans-serif;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--gold-color);
    }

    button[type="submit"] {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    button[type="submit"]:hover {
        background: var(--gold-color);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .section {
            padding: 30px 15px;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .families-info,
        .couple-photos {
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            padding: 0 10px;
        }

        .family-column {
            padding: 20px 15px;
        }

        .family-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .parent-info {
            font-size: 0.9rem;
            margin: 10px 0;
        }

        .gallery {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            padding: 10px;
        }

        .gallery img {
            height: 200px;
        }

        .featured-photos {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            padding: 0 10px;
        }

        .featured-photos img {
            height: 200px;
        }

        .rsvp-form {
            padding: 20px;
            margin: 0 10px;
            border-radius: 15px;
        }

        .form-group input,
        .form-group textarea {
            padding: 8px;
            font-size: 14px;
        }

        .poem {
            padding: 15px;
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0 10px;
        }

        .poem p {
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
            margin: 0.3rem 0;
        }

        .section + .section {
            margin-top: -20px;
        }

        .button[type="submit"] {
            padding: 12px 20px;
            font-size: 0.9rem;
        }

        .form-group label {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .qr-code img {
            max-width: 200px;
            height: auto;
            margin: 0 auto;
            display: block;
        }
    }

    [data-aos] {
        opacity: 0;
        transition-duration: 800ms;
        transition-property: opacity, transform;
    }

    [data-aos].aos-animate {
        opacity: 1;
    }

    .fade-up-slow {
        transform: translateY(100px);
    }

    .fade-up-slow.aos-animate {
        transform: translateY(0);
    }

    .fade-in-slow {
        opacity: 0;
    }

    .fade-in-slow.aos-animate {
        opacity: 1;
    }

    .family-column:hover,
    .person-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }

    button[type="submit"] {
        background: var(--primary-color);
        border: 1px solid var(--gold-color);
        font-family: var(--font-main);
        letter-spacing: 3px;
        font-size: 1rem;
    }

    button[type="submit"]:hover {
        background: var(--gold-color);
        color: var(--primary-color);
    }

    .poem {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px 30px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        font-family: var(--font-body);
        font-size: 1.1rem;
        line-height: 1.8;
        text-align: center;
        color: var(--primary-color);
    }

    .poem p {
        margin: 0.5rem 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Override một số style mặc định của Bootstrap nếu cần */
    .form-control {
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 12px;
    }

    .form-control:focus {
        border-color: var(--gold-color);
        box-shadow: none;
    }

    .btn-primary {
        background: var(--primary-color);
        border-color: var(--gold-color);
        font-family: var(--font-main);
        letter-spacing: 3px;
        border-radius: 10px;
        padding: 12px 30px;
    }

    .btn-primary:hover {
        background: var(--gold-color);
        border-color: var(--gold-color);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
        }

        .form-control {
            padding: 8px;
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .couple-photo {
            height: 250px;
        }
    }

    .audio-control-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.6);
        border: 2px solid var(--gold-color);
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .audio-control-btn:hover {
        background: var(--gold-color);
        transform: scale(1.1);
    }

    .audio-control-btn.muted i:before {
        content: "\f6a9"; /* Font Awesome muted icon */
    }

    .letter-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: all 0.5s ease;
    }

    .letter-container.hidden {
        opacity: 0;
        visibility: hidden;
    }

    .letter {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 0 50px rgba(192, 160, 98, 0.3);
        max-width: 600px;
        width: 90%;
        text-align: center;
        transform: scale(0.9);
        transition: all 0.5s ease;
        position: relative;
    }

    .letter:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 48%, var(--gold-color) 49%, var(--gold-color) 51%, transparent 52%);
        pointer-events: none;
        opacity: 0.1;
        border-radius: 20px;
    }

    .letter-content {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.5s ease;
    }

    .letter-header h2 {
        font-family: var(--font-main);
        font-size: 3rem;
        color: var(--gold-color);
        margin-bottom: 30px;
    }

    .letter-body {
        font-family: var(--font-body);
        line-height: 1.8;
    }

    .couple-names-letter {
        font-family: var(--font-main);
        font-size: 2.5rem;
        color: var(--primary-color);
        margin: 20px 0;
    }

    .wedding-date-letter {
        font-family: var(--font-main);
        font-size: 1.5rem;
        color: var(--gold-color);
        margin: 20px 0;
    }

    .open-letter-btn {
        background: var(--gold-color);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 30px;
        font-family: var(--font-main);
        font-size: 1.2rem;
        cursor: pointer;
        margin-top: 30px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .open-letter-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(192, 160, 98, 0.3);
    }

    @media (max-width: 768px) {
        .letter {
            padding: 30px;
        }

        .letter-header h2 {
            font-size: 2.5rem;
        }

        .couple-names-letter {
            font-size: 2rem;
        }

        .wedding-date-letter {
            font-size: 1.2rem;
        }

        .open-letter-btn {
            padding: 12px 30px;
            font-size: 1rem;
        }
    }

    /* Thêm hiệu ứng trái tim rơi */
    .hearts-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 9998;
    }

    .heart {
        position: absolute;
        width: 20px;
        height: 20px;
        background: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBmaWxsPSJyZ2JhKDE5MiwgMTYwLCA5OCwgMC4zKSIgZD0iTTQ3MS4zODIgNDQuMThjLTI2LjUwNS0yOC4yMzEtNjIuODcxLTQ0LjE4LTEwMC45NTItNDQuMTgtNDkuNzI0IDAtODQuNDE0IDI1LjIxNC0xMTQuNDMgNDguMTQtMzAtMjIuOTI2LTY0LjY4Ny00OC4xNC0xMTQuNDMtNDguMTQtMzguMDg1IDAtNzQuNDUxIDE1Ljk0OS0xMDAuOTUyIDQ0LjE4QzEzLjk1OCA3Mi41MSAwIDEwOC4yMjkgMCAxNDcuNDZjMCA0NS4wMTUgMTcuMDUzIDg0LjkxNyA1My41NzEgMTI0LjI4MSA1MC4zNTQgNTQuMzE2IDEzNy44MjUgMTEwLjMyIDE4NS40MjkgMTQ3LjQ4MSA1LjQyNCA0LjIxNyAxMS45IDYuMzc4IDE4LjQyOCA2LjM3OCA2LjUyOCAwIDEzLjAwNC0yLjE2MSAxOC40MjgtNi4zNzggNDcuNjA0LTM3LjE2MSAxMzUuMDc1LTkzLjE2NSAxODUuNDI5LTE0Ny40ODFDNDk0Ljk0OSAyMzIuMzc3IDUxMiAxOTIuNDc2IDUxMiAxNDcuNDZjMC0zOS4yMzEtMTMuOTU4LTc0Ljk1LTQwLjYxOC0xMDMuMjh6Ii8+PC9zdmc+") no-repeat;
        background-size: contain;
        transform-origin: center;
        animation: heart-fall linear infinite;
    }

    @keyframes heart-fall {
        0% {
            transform: translateY(-100%) rotate(0deg) scale(0.6);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(360deg) scale(1);
            opacity: 0;
        }
    }

    /* Hiệu ứng lấp lánh cho các tiêu đề */
    .sparkle-text {
        background: linear-gradient(120deg, var(--gold-color) 0%, #fff 30%, var(--gold-color) 50%, #fff 70%, var(--gold-color) 100%);
        background-size: 200% auto;
        color: transparent;
        -webkit-background-clip: text;
        background-clip: text;
        animation: sparkle 4s linear infinite;
    }

    @keyframes sparkle {
        to {
            background-position: 200% center;
        }
    }

    /* Hiệu ứng hover cho ảnh */
    .couple-photo {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        filter: grayscale(20%);
    }

    .person-card:hover .couple-photo {
        filter: grayscale(0%);
        transform: scale(1.05);
    }

    /* Hiệu ứng border animation */
    .section {
        position: relative;
        overflow: hidden;
    }

    .section::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        bottom: 20px;
        border: 2px solid transparent;
        animation: border-dance 8s linear infinite;
    }

    @keyframes border-dance {
        0% {
            border-color: transparent;
            transform: scale(1);
        }
        25% {
            border-color: var(--gold-color);
            transform: scale(1.02);
        }
        50% {
            border-color: transparent;
            transform: scale(1);
        }
        75% {
            border-color: var(--gold-color);
            transform: scale(1.02);
        }
        100% {
            border-color: transparent;
            transform: scale(1);
        }
    }

    /* Hiệu ứng nút RSVP */
    .btn-primary {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        100% {
            left: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const letterContainer = document.getElementById('letter-invitation');
    const audio = document.getElementById('background-music');
    const openButton = document.getElementById('open-letter');

    openButton.addEventListener('click', function() {
        // Phát nhạc
        audio.play()
            .then(() => {
                console.log('Audio playing');
                // Thêm hiệu ứng biến mất cho thư
                letterContainer.style.opacity = '0';
                setTimeout(() => {
                    letterContainer.style.display = 'none';
                }, 500);
            })
            .catch((error) => {
                console.log('Playback prevented:', error);
            });
    });

    // Tạo hiệu ứng trái tim rơi
    const heartsContainer = document.createElement('div');
    heartsContainer.className = 'hearts-container';
    document.body.appendChild(heartsContainer);

    function createHeart() {
        const heart = document.createElement('div');
        heart.className = 'heart';
        heart.style.left = Math.random() * 100 + 'vw';
        heart.style.animationDuration = Math.random() * 3 + 2 + 's';
        heartsContainer.appendChild(heart);

        // Xóa trái tim sau khi animation kết thúc
        setTimeout(() => {
            heart.remove();
        }, 5000);
    }

    // Tạo trái tim mới mỗi 300ms
    setInterval(createHeart, 300);

    // Thêm class sparkle-text cho các tiêu đề
    document.querySelectorAll('.section-title, .couple-names, .wedding-date').forEach(el => {
        el.classList.add('sparkle-text');
    });

    // Xử lý scroll mượt
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
</script>
@endpush
