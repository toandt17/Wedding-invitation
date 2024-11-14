@extends('layouts.wedding')
@section('content')

    <!-- Audio Player -->
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
        <div class="cover-overlay"></div>
        <div class="cover-content">
            <div class="couple-names" data-aos="fade-up" data-aos-delay="500">
                {{ $card->groom_name }} <span class="and-symbol">&</span> {{ $card->bride_name }}
            </div>
            <div class="wedding-date" data-aos="fade-up" data-aos-delay="800">
                {{ $card->wedding_date->format('d.m.Y') }}
            </div>
        </div>
    </section>

    <!-- Poem Section -->
    @if($card->wedding_poem)
    <section class="section poem-section" data-aos="fade-up">
        <div class="section-inner">
            <h2 class="section-title">Lời chúc</h2>
            <div class="poem">
                @foreach(explode("\n", $card->wedding_poem) as $line)
                    <p>{{ $line }}</p>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Families Section -->
    <section class="section families-section" data-aos="fade-up">
        <div class="section-inner">
            <h2 class="section-title">Hai bên gia đình</h2>
            <div class="families-container">
                <div class="family-column" data-aos="fade-right">
                    <div class="family-content">
                        <h3>Nhà trai</h3>
                        <div class="parent-info">
                            <span class="parent-label">Cha:</span>
                            <span>{{ $card->groom_father_name }}</span>
                        </div>
                        <div class="parent-info">
                            <span class="parent-label">Mẹ:</span>
                            <span>{{ $card->groom_mother_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="family-column" data-aos="fade-left">
                    <div class="family-content">
                        <h3>Nhà gái</h3>
                        <div class="parent-info">
                            <span class="parent-label">Cha:</span>
                            <span>{{ $card->bride_father_name }}</span>
                        </div>
                        <div class="parent-info">
                            <span class="parent-label">Mẹ:</span>
                            <span>{{ $card->bride_mother_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Couple Section -->
    <section class="section couple-section">
        <div class="section-inner">
            <h2 class="section-title" data-aos="fade-up">Cô dâu & Chú rể</h2>
            <div class="couple-container">
                <div class="person-card groom" data-aos="fade-right">
                    <div class="photo-frame">
                        <img src="{{ $card->groom_image_url }}" alt="Chú rể">
                    </div>
                    <h3>{{ $card->groom_name }}</h3>
                </div>
                <div class="heart-divider" data-aos="zoom-in">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="person-card bride" data-aos="fade-left">
                    <div class="photo-frame">
                        <img src="{{ $card->bride_image_url }}" alt="Cô dâu">
                    </div>
                    <h3>{{ $card->bride_name }}</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Sections -->
    <section class="section gallery-section">
        <div class="section-inner">
            <h2 class="section-title" data-aos="fade-up">Album ảnh cưới</h2>
            <div class="gallery-grid">
                @foreach($card->photos()->where('type', 'gallery')->orderBy('sort_order')->get() as $photo)
                    <div class="gallery-item" data-aos="zoom-in">
                        <img src="{{ $photo->image_url }}" alt="Ảnh cưới">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Venue Section -->
    <section class="section venue-section">
        <div class="section-inner">
            <h2 class="section-title" data-aos="fade-up">Địa điểm tổ chức</h2>
            <div class="venue-info" data-aos="fade-up">
                <h3>{{ $card->venue_name }}</h3>
                <p>{{ $card->venue_address }}</p>
                @if($card->google_map_iframe)
                <div class="map-container" data-aos="zoom-in">
                    {!! $card->google_map_iframe !!}
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- RSVP Section -->
    <section class="section rsvp-section">
        <div class="section-inner">
            <h2 class="section-title" data-aos="fade-up">Xác nhận tham dự</h2>
            <div class="rsvp-container">
                <form class="rsvp-form" action="{{ route('wedding.rsvp', $card->slug) }}" method="POST" data-aos="fade-up">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="guest_name" placeholder="Họ và tên" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone_number" placeholder="Số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="number_of_guests" placeholder="Số người tham dự" required min="1" value="1">
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Lời nhắn" rows="4"></textarea>
                    </div>
                    <button type="submit" class="submit-btn">
                        <span>Gửi xác nhận</span>
                    </button>
                </form>
            </div>
        </div>
    </section>

    @if($card->qr_code_url)
    <section class="section qr-section">
        <div class="section-inner">
            <h2 class="section-title" data-aos="fade-up">Mã QR</h2>
            <div class="qr-container" data-aos="zoom-in">
                <img src="{{ $card->qr_code_url }}" alt="QR Code">
            </div>
        </div>
    </section>
    @endif

@endsection

@push('css')
<style>
    :root {
        --primary-color: #FFFFFF;
        --secondary-color: #FFD700;
        --background-color: #B71C1C;
        --text-color: #FFFFFF;
        --font-primary: 'Playfair Display', serif;
        --font-secondary: 'Cormorant Garamond', serif;
        --section-padding: 100px;
    }

    /* Global Styles */
    body {
        font-family: var(--font-secondary);
        color: var(--text-color);
        background-color: var(--background-color);
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    .section {
        padding: var(--section-padding) 0;
        position: relative;
        background: linear-gradient(45deg, #8B0000, #B71C1C);
    }

    .section-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .section-title {
        font-family: var(--font-primary);
        color: var(--primary-color);
        font-size: 4rem;
        text-align: center;
        margin-bottom: 50px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* Cover Section */
    .cover-section {
        height: 100vh;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .cover-overlay {
        background: rgba(139, 0, 0, 0.6);
    }

    .couple-names {
        font-family: var(--font-primary);
        font-size: 6rem;
        margin-bottom: 30px;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.4);
    }

    .and-symbol {
        color: var(--secondary-color);
        font-size: 5rem;
        margin: 0 30px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* Families Section */
    .families-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }

    .family-column {
        text-align: center;
        padding: 30px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(211, 47, 47, 0.1);
    }

    .family-content h3 {
        color: var(--primary-color);
        font-family: var(--font-primary);
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .parent-info {
        margin: 15px 0;
        font-size: 1.1rem;
    }

    .parent-label {
        color: var(--primary-color);
        font-weight: 600;
        margin-right: 10px;
    }

    /* Gallery Section */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .gallery-item img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    /* RSVP Section */
    .rsvp-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .rsvp-form {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(211, 47, 47, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 10px;
        font-family: var(--font-secondary);
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .submit-btn {
        background: var(--primary-color);
        color: var(--secondary-color);
        border: none;
        padding: 15px 40px;
        border-radius: 30px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .submit-btn:hover {
        background: darken(var(--primary-color), 10%);
        transform: translateY(-2px);
    }

    /* Letter Invitation */
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
        z-index: 1000;
    }

    .letter {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        text-align: center;
        max-width: 500px;
        width: 90%;
        position: relative;
    }

    .letter::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 2px solid var(--primary-color);
        border-radius: 15px;
        pointer-events: none;
    }

    .letter-header h2 {
        font-family: var(--font-primary);
        color: var(--primary-color);
        font-size: 3rem;
        margin-bottom: 30px;
    }

    .open-letter-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 30px;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .open-letter-btn:hover {
        background: darken(var(--primary-color), 10%);
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .couple-names {
            font-size: 3rem;
        }

        .wedding-date {
            font-size: 1.4rem;
        }

        .section-title {
            font-size: 2.5rem;
        }

        .couple-container {
            flex-direction: column;
            gap: 40px;
        }

        .photo-frame {
            width: 200px;
            height: 200px;
        }

        .families-container {
            grid-template-columns: 1fr;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    /* Animations */
    [data-aos] {
        opacity: 0;
        transition-duration: 800ms;
        transition-property: opacity, transform;
    }

    [data-aos].aos-animate {
        opacity: 1;
    }

    /* Custom Animations */
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

    .fade-in-scale {
        animation: fadeInScale 1s ease forwards;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Letter and Music Handler
    const letterContainer = document.getElementById('letter-invitation');
    const audio = document.getElementById('background-music');
    const openButton = document.getElementById('open-letter');

    if (openButton) {
        openButton.addEventListener('click', function() {
            audio.play()
                .then(() => {
                    letterContainer.style.opacity = '0';
                    setTimeout(() => {
                        letterContainer.style.display = 'none';
                    }, 500);
                })
                .catch(console.error);
        });
    }

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Parallax Effect
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        document.querySelectorAll('.parallax').forEach(element => {
            const speed = element.dataset.speed || 0.5;
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
});
</script>
@endpush
