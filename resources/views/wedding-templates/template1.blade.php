@extends('layouts.wedding')
@section('content')
<!-- Background Elements -->
<div class="gradient-bg"></div>
<div id="particles-bg"></div>

<!-- Control Buttons -->
<div class="left-controls">
    <button class="control-btn" id="music-toggle" title="Bật/Tắt nhạc">
        <i class="fas fa-volume-up"></i>
    </button>
    <button class="control-btn" onclick="scrollToSection('wishes-form')" title="Gửi lời chúc">
        <i class="fas fa-comment"></i>
    </button>
</div>

<div class="right-controls">
    <button class="control-btn" onclick="scrollToSection('qr-code')" title="Mừng cưới">
        <i class="fas fa-gift"></i>
    </button>
    <button class="control-btn" onclick="shareInvitation()" title="Chia sẻ">
        <i class="fas fa-share-alt"></i>
    </button>
</div>

<!-- Phone Container -->
<div class="phone-wrapper">
    <div class="phone-status-bar">
        <div class="status-bar-time" id="status-bar-time"></div>
    </div>

    <!-- Main Container -->
    <div class="mobile-container">
        <div id="particles-js"></div>
        <div class="hearts-container"></div>
        <!-- Audio Player (thêm vào đầu section) -->
        @if($card->music)
        <audio id="background-music" autoplay loop>
            <source src="{{ $card->music->file_url }}" type="audio/mpeg">
        </audio>
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

            <!-- Wedding Header -->
            <section class="wedding-header">
                <!-- Pink Banner -->
                <div class="banner">
                    <div class="banner-content">
                        <span>W E D D I N G</span>
                    </div>
                </div>

                <!-- Couple Names -->
                <div class="couple-title">
                    {{ $card->groom_name }} ♥ {{ $card->bride_name }}
                </div>

                <!-- Wedding Date -->
                <div class="wedding-date-display">
                    {{ $card->wedding_date->locale('vi')->format('l, d/m/Y') }}
                </div>

                <!-- Large Date Display -->
                <div class="large-date">
                    <span>{{ $card->wedding_date->format('d') }}</span>
                    <span class="heart">♥</span>
                    <span>{{ $card->wedding_date->format('m') }}</span>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="action-btn" onclick="scrollToSection('wishes-form')">
                        <i class="far fa-comment-alt"></i>
                        Gửi lời chúc
                    </button>
                    <button class="action-btn">
                        <i class="far fa-envelope"></i>
                        Xác nhận tham dự
                    </button>
                    <button class="action-btn" onclick="scrollToSection('qr-code')">
                        <i class="fas fa-gift"></i>
                        Mừng cưới
                    </button>
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

            <!-- Countdown Calendar Section -->
            <section class="section" data-aos="fade-up">
                <div class="calendar-container">
                    <div class="calendar-header">
                        <h3 class="couple-names-calendar">{{ $card->groom_name }} ♥ {{ $card->bride_name }}</h3>
                        <div class="calendar-month">THÁNG {{ $card->wedding_date->format('m/Y') }}</div>
                    </div>
                    <div class="calendar-body">
                        <div class="calendar-weekdays">
                            <div>Thứ 2</div>
                            <div>Thứ 3</div>
                            <div>Thứ 4</div>
                            <div>Thứ 5</div>
                            <div>Thứ 6</div>
                            <div>Thứ 7</div>
                            <div>CN</div>
                        </div>
                        <div class="calendar-days" id="calendar-days">
                            <!-- JS will populate this -->
                        </div>
                    </div>
                    <div class="countdown-grid">
                        <div class="countdown-item">
                            <div class="countdown-number" id="countdown-days">00</div>
                            <div class="countdown-label">Ngày</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="countdown-hours">00</div>
                            <div class="countdown-label">Giờ</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="countdown-minutes">00</div>
                            <div class="countdown-label">Phút</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="countdown-seconds">00</div>
                            <div class="countdown-label">Giây</div>
                        </div>
                    </div>
                </div>
            </section>

        <!-- Venue Section -->
        <section class="section venue-section" data-aos="fade-up">
            <h2 class="section-title">Địa điểm tổ chức</h2>
            <div class="venue-container">
                <div class="venue-info">
                    <div class="venue-header">
                        <div class="venue-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="venue-name">{{ $card->venue_name }}</h3>
                    </div>

                    <div class="venue-details">
                        <div class="venue-address">
                            <i class="fas fa-location-dot"></i>
                            <p>{{ $card->venue_address }}</p>
                        </div>

                        <div class="venue-time">
                            <div class="time-item">
                                <i class="far fa-calendar-alt"></i>
                                <span>{{ $card->wedding_date->locale('vi')->format('l, d/m/Y') }}</span>
                            </div>
                            <div class="time-item">
                                <i class="far fa-clock"></i>
                                <span>{{ $card->wedding_date->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($card->google_map_iframe)
                <div class="map-container" data-aos="zoom-in">
                    <div class="map-wrapper">
                        {!! $card->google_map_iframe !!}
                    </div>
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
        <section class="section rsvp-section" id="wishes-form" data-aos="fade-up">
            <h2 class="section-title">Gửi Lời Chúc</h2>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="rsvp-form-container">
                            <div class="form-header">
                                <div class="form-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <p class="form-description">Hãy gửi những lời chúc tốt đẹp nhất đến đôi uyên ương</p>
                            </div>

                            <form class="rsvp-form" action="{{ route('wedding.rsvp', $card->slug) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-icon">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text"
                                               class="form-control"
                                               name="guest_name"
                                               required
                                               placeholder="Họ và tên của bạn">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-icon">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="tel"
                                               class="form-control"
                                               name="phone_number"
                                               required
                                               placeholder="Số iện thoại của bạn">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-icon">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <textarea class="form-control"
                                                  name="message"
                                                  rows="4"
                                                  placeholder="Gửi lời chúc của bạn đến cặp đôi"></textarea>
                                    </div>
                                </div>

                                <button type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

            <!-- Invitation Message Section -->
            <section class="invitation-section">
                <div class="ribbon-container">
                    <div class="ribbon">
                        <span>Lời Ngỏ</span>
                    </div>
                </div>

                <div class="invitation-content">
                    <div class="invitation-subtitle">
                        <span>I N V I T A T I O N</span>
                    </div>

                    <div class="invitation-message">
                        <p>Cm ơn tất cả những người bạn thân yêu của tôi!</p>
                        <p>Tôi bit các bạn rất bận rộn, bận rộn với công việc, bận rộn với công việc gia đình...</p>
                        <p>Nhưng tất cả đã có mặt hôm nay để chúc mừng tình yêu và hạnh phúc của chúng tôi.</p>
                        <p>Một lần nữa chân thành cảm ơn tất cả các bạn!</p>
                    </div>
                </div>
            </section>

        <!-- QR Code Section -->
        <section class="section qr-code-section" id="qr-code" data-aos="fade-up">
            <div class="qr-code-container">
                <div class="qr-code-border">
                    <div class="qr-code-content">
                        <h2 class="qr-title">Hộp Mừng Cưới</h2>
                        <p class="qr-subtitle">Quý khch vui lòng quét mã QR để gửi lời chúc mừng</p>

                        <img src="{{ $card->qr_code_url }}"
                             alt="QR Code"
                             class="qr-code-image"
                             data-aos="zoom-in">

                        <div class="bank-info">
                            <p><strong>Chủ tài khoản:</strong> {{ $card->bank_account_name }}</p>
                            <p><strong>Số tài khoản:</strong> {{ $card->bank_account_number }}</p>
                            <p><strong>Ngân hàng:</strong> {{ $card->bank_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>



@endsection
@push('css')
<style>
    :root {
        --primary-color: #000000;          /* Đen */
        --secondary-color: #ffffff;        /* Trắng */
        --accent-color: #FF0000;          /* Đỏ */
        --gold-color: #CC0000;            /* Đỏ đậm */
        --background-light: #f5f5f5;      /* Xám nhạt */
        --font-main: 'Alex Brush', cursive;
        --font-body: 'Montserrat', sans-serif;
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

    /* Điều chỉnh kích thước c thể */
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
        /* background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent); */
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
        background: transparent;
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
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
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
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
        font-size: 40px;
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
        background: linear-gradient(120deg, #CC0000 0%, #fff 30%, #FF0000 50%, #fff 70%, #CC0000 100%);
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

    /* Calendar Styles */
    .calendar-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 30px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .calendar-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .couple-names-calendar {
        font-family: var(--font-body);
        font-size: 1.5rem;
        color: var(--primary-color);
        margin-bottom: 15px;
        font-weight: normal;
    }

    .calendar-month {
        font-family: var(--font-body);
        color: #CC0000;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .calendar-body {
        margin-bottom: 30px;
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        text-align: center;
        margin-bottom: 10px;
    }

    .calendar-weekdays div {
        font-family: var(--font-body);
        color: #666;
        font-size: 0.9rem;
        padding: 5px;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-body);
        font-size: 1rem;
        color: #666;
        position: relative;
    }

    .calendar-day.wedding-day {
        color: white;
    }

    .calendar-day.wedding-day::after {
        content: '';
        position: absolute;
        width: 32px;
        height: 32px;
        background-color: #FF0000;
        border-radius: 50%;
        z-index: -1;
    }

    /* Countdown Grid */
    .countdown-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-top: 30px;
    }

    .countdown-item {
        text-align: center;
    }

    .countdown-number {
        font-family: var(--font-body);
        font-size: 2rem;
        color: #CC0000;
        margin-bottom: 5px;
    }

    .countdown-label {
        font-family: var(--font-body);
        color: #666;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .calendar-container {
            padding: 20px;
            margin: 0 15px;
        }

        .couple-names-calendar {
            font-size: 1.2rem;
        }

        .calendar-weekdays div,
        .calendar-day {
            font-size: 0.8rem;
        }

        .countdown-number {
            font-size: 1.5rem;
        }

        .countdown-label {
            font-size: 0.8rem;
        }
    }

    .wedding-header {
        text-align: center;
        background: white;
        padding: 40px 0;
        margin-bottom: 40px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .banner {
        background: linear-gradient(to right, #990000, #CC0000, #990000);
        height: 70px;
        position: relative;
        margin-bottom: 50px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .banner-content {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: -20px;
        background: linear-gradient(45deg, #CC0000, #FF0000);
        padding: 10px 50px;
        clip-path: polygon(15% 0%, 85% 0%, 100% 50%, 85% 100%, 15% 100%, 0% 50%);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .banner-content span {
        color: white;
        font-size: 16px;
        letter-spacing: 4px;
        font-weight: 500;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .couple-title {
        font-family: var(--font-main);
        font-size: 48px;
        color: #333;
        margin: 30px 0;
        font-weight: normal;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .wedding-date-display {
        color: #CC0000;
        font-size: 22px;
        margin: 20px 0;
        font-weight: 500;
        letter-spacing: 1px;
    }

    .large-date {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin: 30px 0;
        font-size: 56px;
        color: #333;
        font-family: var(--font-main);
    }

    .large-date span {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .large-date .heart {
        color: #FF0000;
        font-size: 40px;
        animation: heartbeat 1.5s ease-in-out infinite;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        padding: 0 20px;
        margin-top: 40px;
    }

    .action-btn {
        flex: 1;
        max-width: 200px;
        background: linear-gradient(45deg, #CC0000, #FF0000); /* Gradient đỏ đậm sang đỏ tươi */
        border: none;
        padding: 15px 25px;
        border-radius: 50px;
        color: white;
        font-size: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(204, 0, 0, 0.3);
    }

    /* Hiệu ứng lướt sáng */
    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -75%;
        width: 50%;
        height: 100%;
        background: linear-gradient(
            to right,
            transparent,
            rgba(255, 255, 255, 0.4),
            transparent
        );
        transform: skewX(-25deg);
        transition: 0.75s;
    }

    /* Hover effect */
    .action-btn:hover {
        background: linear-gradient(45deg, #FF0000, #CC0000); /* Đảo ngược gradient khi hover */
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(204, 0, 0, 0.4);
    }

    .action-btn:hover::before {
        left: 125%;
    }

    /* Màu riêng cho từng nút */
    .action-btn:nth-child(1) {
        background: linear-gradient(45deg, #990000, #FF0000);
    }

    .action-btn:nth-child(2) {
        background: linear-gradient(45deg, #CC0000, #FF1111);
    }

    .action-btn:nth-child(3) {
        background: linear-gradient(45deg, #FF0000, #CC0000);
    }

    /* Hover states */
    .action-btn:nth-child(1):hover {
        background: linear-gradient(45deg, #FF0000, #990000);
    }

    .action-btn:nth-child(2):hover {
        background: linear-gradient(45deg, #FF1111, #CC0000);
    }

    .action-btn:nth-child(3):hover {
        background: linear-gradient(45deg, #CC0000, #FF0000);
    }

    /* Icon trong nút */
    .action-btn i {
        font-size: 18px;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .action-btn {
            width: 100%;
            max-width: 280px;
            padding: 12px 20px;
            font-size: 14px;
        }
    }

    .album-section {
        padding: 60px 20px;
        background: white;
        text-align: center;
    }

    .album-title {
        font-family: 'Dancing Script', cursive; /* Hoặc font script tương t�� */
        font-size: 48px;
        color: #666;
        margin-bottom: 20px;
    }

    .album-quote {
        font-size: 16px;
        color: #666;
        max-width: 800px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }

    .wedding-photos {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .photo-item {
        aspect-ratio: 3/4;
        overflow: hidden;
        border-radius: 8px;
    }

    .wedding-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .wedding-photo:hover {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .album-title {
            font-size: 36px;
        }

        .album-quote {
            font-size: 14px;
            padding: 0 20px;
        }

        .wedding-photos {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }

    .invitation-section {
        padding: 60px 20px;
        background: white;
        position: relative;
        max-width: 1000px;
        margin: 0 auto;
    }

    .ribbon-container {
        position: relative;
        text-align: center;
        height: 60px;
        margin-bottom: 30px;
    }

    .ribbon {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 200px;
    }

    .ribbon span {
        position: relative;
        display: inline-block;
        width: 100%;
        padding: 10px 0;
        background: #CC0000;
        color: white;
        font-size: 20px;
        font-weight: 300;
        letter-spacing: 2px;
        clip-path: polygon(10% 0%, 90% 0%, 100% 50%, 90% 100%, 10% 100%, 0% 50%);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .ribbon::before,
    .ribbon::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 120px;
        height: 1px;
        background: linear-gradient(90deg, transparent, #CC0000);
    }

    .ribbon::before {
        right: 100%;
        margin-right: 20px;
    }

    .ribbon::after {
        left: 100%;
        margin-left: 20px;
        transform: rotate(180deg);
    }

    .invitation-content {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px;
        background: white;
        border: 1px solid #FFE4E4;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(204, 0, 0, 0.1);
    }

    .invitation-subtitle {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
    }

    .invitation-subtitle span {
        display: inline-block;
        color: #666;
        font-size: 16px;
        letter-spacing: 4px;
        padding: 0 20px;
        background: white;
        position: relative;
        z-index: 1;
    }

    .invitation-subtitle::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 1px;
        background: #FFE4E4;
        z-index: 0;
    }

    .invitation-message {
        text-align: center;
        color: #666;
        line-height: 2;
        font-size: 16px;
    }

    .invitation-message p {
        margin-bottom: 20px;
    }

    .invitation-message p:last-child {
        margin-bottom: 0;
    }

    /* Hover effect */
    .invitation-content:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
        box-shadow: 0 15px 35px rgba(204, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
        .invitation-section {
            padding: 40px 15px;
        }

        .ribbon span {
            font-size: 18px;
            padding: 8px 0;
        }

        .ribbon::before,
        .ribbon::after {
            width: 60px;
        }

        .invitation-content {
            padding: 25px;
        }

        .invitation-message {
            font-size: 14px;
            line-height: 1.8;
        }
    }

    /* Form Section Styles */
    #wishes-form {
        background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9));
        padding: 80px 0;
    }

    .rsvp-form {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    /* Form Group Styles */
    .mb-3 {
        margin-bottom: 25px !important;
    }

    .form-label {
        display: block;
        margin-bottom: 10px;
        color: #333;
        font-weight: 600;
        font-size: 1rem;
        font-family: var(--font-body);
    }

    .form-control {
        width: 100%;
        padding: 15px 20px;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fff;
        color: #333;
        font-family: var(--font-body);
    }

    .form-control:focus {
        border-color: #CC0000;
        box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.1);
        outline: none;
    }

    /* Textarea Specific Styles */
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }

    /* Submit Button Styles - Được làm mới hoàn toàn */
    .btn-primary {
        width: 100%;
        padding: 16px 32px;
        background: #CC0000;
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 1rem;
        font-weight: 600;
        font-family: var(--font-body);
        letter-spacing: 1px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(204, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-primary:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent,
            rgba(255, 255, 255, 0.3),
            transparent
        );
        transition: 0.5s;
    }

    .btn-primary:hover {
        background: #FF0000;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(204, 0, 0, 0.3);
    }

    .btn-primary:hover:before {
        left: 100%;
    }

    .btn-primary:active {
        transform: translateY(1px);
    }

    /* Thêm icon cho button */
    .btn-primary i {
        font-size: 1.2rem;
    }

    /* Placeholder Styles */
    .form-control::placeholder {
        color: #999;
        opacity: 0.7;
        font-family: var(--font-body);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .rsvp-form {
            padding: 25px;
            margin: 0 15px;
        }

        .form-control {
            padding: 12px 15px;
            font-size: 0.95rem;
        }

        .btn-primary {
            padding: 14px 28px;
        }

        .form-label {
            font-size: 0.95rem;
        }
    }

    /* QR Code Section Styles */
    .qr-code-section {
        text-align: center;
        padding: 40px 20px;
    }

    .qr-code-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 30px;
        position: relative;
    }

    /* Border Animation */
    .qr-code-border {
        position: relative;
        padding: 40px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .qr-code-border:before,
    .qr-code-border:after {
        content: '';
        position: absolute;
        width: calc(100% + 4px);
        height: calc(100% + 4px);
        top: -2px;
        left: -2px;
        background: linear-gradient(45deg, #CC0000, transparent 30%, transparent 70%, #CC0000);
        border-radius: 22px;
        z-index: 1;
    }

    .qr-code-border:after {
        filter: blur(5px);
        z-index: 0;
    }

    /* QR Code Content */
    .qr-code-content {
        position: relative;
        z-index: 2;
        background: white;
        padding: 20px;
        border-radius: 15px;
    }

    .qr-title {
        font-family: var(--font-main);
        font-size: 2.5rem;
        color: #CC0000;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .qr-subtitle {
        font-family: var(--font-body);
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 30px;
    }

    .qr-code-image {
        max-width: 250px;
        height: auto;
        margin: 0 auto;
        display: block;
        border-radius: 10px;
        padding: 10px;
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .bank-info {
        margin-top: 25px;
        padding: 15px;
        background: #f8f8f8;
        border-radius: 10px;
    }

    .bank-info p {
        margin: 5px 0;
        color: #333;
        font-size: 1rem;
    }

    .bank-info strong {
        color: #CC0000;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .qr-code-container {
            padding: 20px;
        }

        .qr-code-border {
            padding: 25px;
        }

        .qr-title {
            font-size: 2rem;
        }

        .qr-subtitle {
            font-size: 1rem;
        }

        .qr-code-image {
            max-width: 200px;
        }

        .bank-info {
            padding: 12px;
        }
    }

    /* Cover Section Styles */
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

    /* Overlay gradient */
    .cover-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.5) 100%);
        z-index: 1;
    }

    /* Thêm hiệu ứng particles */
    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
        pointer-events: none;
    }

    .cover-content {
        position: relative;
        z-index: 3;
        text-align: center;
        color: white;
        padding: 2rem;
        animation: contentFadeIn 2s ease-out;
        /* background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(5px); */
    }

    /* Couple Names */
    .couple-names {
        font-family: var(--font-main);
        font-size: 5.5rem;
        letter-spacing: 2px;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        animation: fadeInScale 2s ease-out;
        background: linear-gradient(45deg, #fff, #f0f0f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
    }

    .couple-names::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 2px;
        background: linear-gradient(90deg, transparent, #CC0000, transparent);
    }

    /* Wedding Date */
    .wedding-date {
        font-family: var(--font-main);
        font-size: 2.2rem;
        letter-spacing: 8px;
        text-transform: uppercase;
        margin-top: 2rem;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        position: relative;
        animation: dateFadeIn 2s ease-out 0.5s backwards;
    }

    /* Decorative elements */
    .wedding-date::before,
    .wedding-date::after {
        content: '♥';
        font-size: 1.5rem;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: #CC0000;
        animation: heartbeat 1.5s infinite;
    }

    .wedding-date::before {
        left: -40px;
    }

    .wedding-date::after {
        right: -40px;
    }

    /* Animations */
    @keyframes contentFadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes dateFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes heartbeat {
        0% { transform: translateY(-50%) scale(1); }
        50% { transform: translateY(-50%) scale(1.1); }
        100% { transform: translateY(-50%) scale(1); }
    }

    /* Floating hearts animation */
    .floating-hearts {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 2;
    }

    .heart {
        position: absolute;
        width: 20px;
        height: 20px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Cpath fill='%23CC0000' d='M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z'/%3E%3C/svg%3E") no-repeat center/contain;
        opacity: 0;
        animation: floatingHeart 6s linear infinite;
    }

    @keyframes floatingHeart {
        0% {
            transform: translateY(100vh) scale(0);
            opacity: 0;
        }
        50% {
            opacity: 0.8;
        }
        100% {
            transform: translateY(-100vh) scale(1);
            opacity: 0;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .couple-names {
            font-size: 3.5rem;
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

        .cover-content {
            padding: 1.5rem;
        }
    }

    /* Particles và Hearts container */
    #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
        pointer-events: none;
    }

    .hearts-container {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 2;
        pointer-events: none;
        overflow: hidden;
    }

    /* Hearts Animation */
    .heart {
        position: absolute;
        width: 20px;
        height: 20px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Cpath fill='%23CC0000' d='M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z'/%3E%3C/svg%3E") no-repeat center/contain;
        animation: heartFall linear infinite;
    }

    @keyframes heartFall {
        0% {
            transform: translateY(-10%) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(360deg);
            opacity: 0;
        }
    }

    /* Gradient Animation */
    .gradient-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        background: linear-gradient(45deg, #FF0000, #CC0000, #990000);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        opacity: 0.1;
        pointer-events: none;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Bubble Animation */
    .bubble {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.1));
        animation: bubbleFloat linear infinite;
        pointer-events: none;
    }

    @keyframes bubbleFloat {
        0% {
            transform: translateY(100vh) scale(0);
            opacity: 0;
        }
        50% {
            opacity: 0.5;
        }
        100% {
            transform: translateY(-20vh) scale(1);
            opacity: 0;
        }
    }

    /* Section Animation */
    .section {
        opacity: 0;
        transform: translateY(50px);
        transition: all 1s ease;
    }

    /* Smooth Scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Content z-index */
    .section, .cover-section, .wedding-header {
        position: relative;
        z-index: 3;
    }

    /* Venue Section Styles */
    .venue-section {
        background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9));
        padding: 80px 0;
    }

    .venue-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .venue-info {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        margin-bottom: 40px;
        text-align: center;
        border: 1px solid rgba(204, 0, 0, 0.1);
    }

    .venue-header {
        margin-bottom: 30px;
    }

    .venue-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, #CC0000, #FF0000);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 5px 15px rgba(204, 0, 0, 0.2);
    }

    .venue-icon i {
        font-size: 32px;
        color: white;
    }

    .venue-name {
        font-family: var(--font-main);
        font-size: 2.5rem;
        color: #333;
        margin: 0;
        padding: 0;
        position: relative;
        display: inline-block;
    }

    .venue-name:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 2px;
        background: linear-gradient(90deg, transparent, #CC0000, transparent);
    }

    .venue-details {
        margin-top: 30px;
    }

    .venue-address {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-bottom: 25px;
        padding: 15px;
        background: #f8f8f8;
        border-radius: 10px;
    }

    .venue-address i {
        color: #CC0000;
        font-size: 24px;
    }

    .venue-address p {
        margin: 0;
        font-size: 1.1rem;
        color: #333;
        line-height: 1.6;
    }

    .venue-time {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 20px;
    }

    .time-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        background: #fff;
        border: 1px solid rgba(204, 0, 0, 0.1);
        border-radius: 50px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .time-item i {
        color: #CC0000;
        font-size: 20px;
    }

    .time-item span {
        color: #333;
        font-size: 1rem;
    }

    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(204, 0, 0, 0.1);
    }

    .map-wrapper {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
    }

    .map-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* Hover Effects */
    .venue-info:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
        box-shadow: 0 15px 35px rgba(204, 0, 0, 0.1);
    }

    .time-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(204, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .venue-section {
            padding: 40px 0;
        }

        .venue-info {
            padding: 25px;
        }

        .venue-icon {
            width: 60px;
            height: 60px;
        }

        .venue-icon i {
            font-size: 24px;
        }

        .venue-name {
            font-size: 2rem;
        }

        .venue-time {
            flex-direction: column;
            gap: 15px;
        }

        .time-item {
            width: 100%;
            justify-content: center;
        }

        .venue-address p {
            font-size: 1rem;
        }
    }

    /* RSVP Form Section Styles */
    .rsvp-section {
        background: linear-gradient(rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.95));
        padding: 80px 0;
        position: relative;
    }

    .rsvp-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(204, 0, 0, 0.2), transparent);
    }

    .rsvp-form-container {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(204, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .form-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(45deg, #CC0000, #FF0000);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 5px 15px rgba(204, 0, 0, 0.2);
    }

    .form-icon i {
        font-size: 28px;
        color: white;
    }

    .form-description {
        color: #666;
        font-size: 1.1rem;
        margin: 0;
        font-style: italic;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: flex-start;
    }

    .input-group-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #CC0000;
        font-size: 18px;
    }

    .input-group textarea + .input-group-icon {
        top: 20px;
        transform: none;
    }

    .form-control {
        width: 100%;
        padding: 15px 20px 15px 45px;
        border: 2px solid rgba(204, 0, 0, 0.1);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fff;
        color: #333;
    }

    .form-control:focus {
        border-color: #CC0000;
        box-shadow: 0 0 0 3px rgba(204, 0, 0, 0.1);
        outline: none;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        padding-top: 20px;
    }

    .submit-btn {
        width: 100%;
        padding: 16px 32px;
        background: linear-gradient(45deg, #CC0000, #FF0000);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(204, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent,
            rgba(255, 255, 255, 0.3),
            transparent
        );
        transition: 0.5s;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(204, 0, 0, 0.3);
    }

    .submit-btn:hover::before {
        left: 100%;
    }

    .submit-btn:active {
        transform: translateY(1px);
    }

    .submit-btn i {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .submit-btn:hover i {
        transform: translateX(5px);
    }

    /* Placeholder Styles */
    .form-control::placeholder {
        color: #999;
        opacity: 0.7;
        font-family: var(--font-body);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .rsvp-form-container {
            padding: 25px;
            margin: 0 15px;
        }

        .form-control {
            padding: 12px 15px;
            font-size: 0.95rem;
        }

        .submit-btn {
            padding: 14px 28px;
        }

        .form-label {
            font-size: 0.95rem;
        }
    }

    /* Container giới hạn chiều rộng */
    .mobile-container {
        min-height: 100vh;
        margin: 0 auto;
        position: relative;
        background: white;
        box-shadow: 0 0 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    /* Nút điều khiển hai bên */
    .left-controls, .right-controls {
        position: fixed;
        right: 20px; /* Thay đổi từ left sang right */
        display: flex;
        flex-direction: column;
        gap: 20px;
        z-index: 1000;
    }

    .left-controls {
        top: 20px; /* Điều chỉnh khoảng cách từ top */
    }

    .right-controls {
        bottom: 20px; /* Điều chỉnh khoảng cách từ bottom */
    }

    /* Style cho nút điều khiển */
    .control-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(204, 0, 0, 0.9);
        border: 2px solid rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(5px);
    }

    .control-btn:hover {
        background: #FF0000;
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(204, 0, 0, 0.3);
    }

    .control-btn i {
        font-size: 24px;
        transition: all 0.3s ease;
    }

    .control-btn:hover i {
        transform: scale(1.1);
    }

    /* Background trang */
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow-x: hidden;
    }

    /* Hiệu ứng particles cho background */
    #particles-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    /* Container wrapper để tạo hiệu ứng điện thoại */
    .phone-wrapper {
        position: relative;
        width: 550px;
        margin: 20px auto;
        border-radius: 40px;
        background: white;
        box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* Thanh trạng thái giả lập điện thoại */
    .phone-status-bar {
        height: 30px;
        background: #000;
        border-top-left-radius: 40px;
        border-top-right-radius: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
    }

    .status-bar-time {
        color: white;
        font-size: 14px;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .mobile-container {
            width: 100%;
        }

        .phone-wrapper {
            width: 100%;
            margin: 0;
            border-radius: 0;
        }

        .phone-status-bar {
            border-radius: 0;
        }

        .left-controls,
        .right-controls {
            display: none;
        }
    }

    /* Hiệu ứng gradient cho background */
    .gradient-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            45deg,
            rgba(255, 0, 0, 0.05),
            rgba(255, 255, 255, 0.1),
            rgba(255, 0, 0, 0.05)
        );
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        z-index: -1;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .control-btn {
        transition: all 0.3s ease;
    }

    .control-btn:hover {
        transform: scale(1.1);
    }

    #music-toggle {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    #music-toggle i {
        color: #CC0000;
    }
</style>
@endpush

@push('scripts')
<!-- Thêm particles.js -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<script>
// Update status bar time
function updateStatusBarTime() {
    const timeElement = document.getElementById('status-bar-time');
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    timeElement.textContent = `${hours}:${minutes}`;
}

// Share function
function shareInvitation() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $card->groom_name }} & {{ $card->bride_name }} Wedding Invitation',
            text: 'You are cordially invited to our wedding celebration!',
            url: window.location.href
        })
        .catch(console.error);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateStatusBarTime();
    setInterval(updateStatusBarTime, 60000);

    // Your existing initialization code...
});

document.addEventListener('DOMContentLoaded', function() {
    // Particles.js Configuration
    particlesJS('particles-js', {
        particles: {
            number: {
                value: 80,
                density: {
                    enable: true,
                    value_area: 800
                }
            },
            color: {
                value: '#CC0000'
            },
            shape: {
                type: 'circle'
            },
            opacity: {
                value: 0.5,
                random: true
            },
            size: {
                value: 3,
                random: true
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: '#CC0000',
                opacity: 0.2,
                width: 1
            },
            move: {
                enable: true,
                speed: 2,
                direction: 'none',
                random: true,
                straight: false,
                out_mode: 'out',
                bounce: false
            }
        },
        interactivity: {
            detect_on: 'canvas',
            events: {
                onhover: {
                    enable: true,
                    mode: 'repulse'
                },
                resize: true
            }
        },
        retina_detect: true
    });

    // Hearts Animation
    function createHeart() {
        const heart = document.createElement('div');
        heart.className = 'heart';
        heart.style.left = Math.random() * 100 + 'vw';
        heart.style.animationDuration = Math.random() * 3 + 2 + 's';
        heart.style.opacity = Math.random() * 0.5 + 0.5;
        heart.style.transform = `scale(${Math.random() * 0.5 + 0.5})`;
        document.querySelector('.hearts-container').appendChild(heart);

        setTimeout(() => {
            heart.remove();
        }, 5000);
    }

    setInterval(createHeart, 300);

    // Bubbles Animation
    function createBubble() {
        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        bubble.style.left = Math.random() * 100 + 'vw';
        bubble.style.width = bubble.style.height = Math.random() * 30 + 20 + 'px';
        bubble.style.animationDuration = Math.random() * 3 + 2 + 's';
        document.querySelector('.hearts-container').appendChild(bubble);

        setTimeout(() => {
            bubble.remove();
        }, 5000);
    }

    setInterval(createBubble, 500);

    // Gradient Background
    const gradientBg = document.createElement('div');
    gradientBg.className = 'gradient-bg';
    document.body.appendChild(gradientBg);

    // Scroll Animation
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const sections = document.querySelectorAll('.section');

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (scrolled >= sectionTop - window.innerHeight / 2) {
                section.style.opacity = '1';
                section.style.transform = 'translateY(0)';
            }
        });
    });

    // Scroll function
    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            const offset = 100; // Điều chỉnh offset nếu cần
            const elementPosition = section.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }

    // Make scrollToSection available globally
    window.scrollToSection = scrollToSection;

    // Calendar and Countdown
    function generateCalendar() {
        const weddingDate = new Date('{{ $card->wedding_date }}');
        const firstDay = new Date(weddingDate.getFullYear(), weddingDate.getMonth(), 1);
        const lastDay = new Date(weddingDate.getFullYear(), weddingDate.getMonth() + 1, 0);

        const calendarDays = document.getElementById('calendar-days');
        calendarDays.innerHTML = '';

        // Add empty cells for days before first day of month
        for (let i = 0; i < firstDay.getDay(); i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day empty';
            calendarDays.appendChild(emptyDay);
        }

        // Add days of month
        for (let i = 1; i <= lastDay.getDate(); i++) {
            const dayDiv = document.createElement('div');
            dayDiv.className = 'calendar-day';
            dayDiv.textContent = i;

            if (i === weddingDate.getDate()) {
                dayDiv.classList.add('wedding-day');
            }

            calendarDays.appendChild(dayDiv);
        }
    }

    function updateCountdown() {
        const weddingDate = new Date('{{ $card->wedding_date }}');
        const now = new Date();
        const diff = weddingDate - now;

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
        document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
    }

    // Initialize calendar and countdown
    generateCalendar();
    updateCountdown();
    setInterval(updateCountdown, 1000);
});

document.addEventListener('DOMContentLoaded', function() {
    const music = document.getElementById('background-music');
    const musicToggle = document.getElementById('music-toggle');
    const musicIcon = musicToggle.querySelector('i');

    // Lưu trạng thái âm thanh
    let isMuted = false;

    // Function để phát nhạc
    function playMusic() {
        music.play();
        musicIcon.classList.remove('fa-volume-mute');
        musicIcon.classList.add('fa-volume-up');
        isMuted = false;
    }

    // Xử lý khi click nút toggle
    musicToggle.addEventListener('click', function() {
        if (isMuted) {
            playMusic();
        } else {
            music.pause();
            musicIcon.classList.remove('fa-volume-up');
            musicIcon.classList.add('fa-volume-mute');
            isMuted = true;
        }
    });

    // Tự động phát nhạc khi có tương tác người dùng
    function attemptAutoplay() {
        playMusic().catch(function(error) {
            console.log("Autoplay prevented:", error);
            musicIcon.classList.remove('fa-volume-up');
            musicIcon.classList.add('fa-volume-mute');
            isMuted = true;
        });
    }

    // Thêm các event listener để bắt tương tác người dùng
    const userInteractionEvents = ['click', 'touchstart', 'scroll'];

    function handleFirstInteraction() {
        attemptAutoplay();
        // Xóa tất cả event listener sau lần tương tác đầu tiên
        userInteractionEvents.forEach(event => {
            document.removeEventListener(event, handleFirstInteraction);
        });
    }

    // Thêm event listener cho mỗi loại tương tác
    userInteractionEvents.forEach(event => {
        document.addEventListener(event, handleFirstInteraction);
    });

    // Thử phát nhạc ngay khi trang load
    attemptAutoplay();
});
</script>
@endpush
