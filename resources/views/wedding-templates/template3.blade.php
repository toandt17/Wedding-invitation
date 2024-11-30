@extends('layouts.wedding')
@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-4 p-0">
            <!-- Main mobile container -->
            <div class="mobile-view bg-white">
                <audio id="background-music" loop autoplay style="display: none;">
                    <source src="{{ asset($card->music->file_url) }}" type="audio/mpeg">
                </audio>
                <!-- Cover section -->
                <div class="wedding-cover">
                    <img src="{{ asset($card->cover_image_url) }}" class="img-fluid w-100" data-aos="fade-in">
                    <div class="couple-names text-center w-100" data-aos="fade-down" data-aos-delay="300">
                        <h1 class="font-script">
                            {{ implode(' ', array_slice(explode(' ', $card->groom_name), 1)) }}
                            -
                            {{ implode(' ', array_slice(explode(' ', $card->bride_name), 1)) }}
                        </h1>
                    </div>
                    <div class="wedding-details text-center" data-aos="fade-up" data-aos-delay="500">
                        <h2 class="invitation-title">THƯ MỜI TIỆC CƯỚI</h2>
                        <div class="divider">
                            <div class="line"></div>
                        </div>
                        <div class="date-time">
                            <p class="time mb-2">
                                @php
                                    $dayOfWeek = [
                                        'Monday' => 'THỨ HAI',
                                        'Tuesday' => 'THỨ BA',
                                        'Wednesday' => 'THỨ TƯ',
                                        'Thursday' => 'THỨ NĂM',
                                        'Friday' => 'THỨ SÁU',
                                        'Saturday' => 'THỨ BẢY',
                                        'Sunday' => 'CHỦ NHẬT'
                                    ];
                                    $dayName = $dayOfWeek[$card->wedding_date->format('l')];
                                @endphp
                                <span class="day-text">{{ $dayName }}</span> - {{ $card->party_time->format('H\hi') }}
                            </p>
                            <div class="divider">
                                <div class="line"></div>
                            </div>
                            <p class="date-format mb-0">
                                @php
                                    $day = str_pad($card->wedding_date->format('d'), 2, '0', STR_PAD_LEFT);
                                    $month = str_pad($card->wedding_date->format('m'), 2, '0', STR_PAD_LEFT);
                                    $year = $card->wedding_date->format('Y');
                                @endphp
                                {{ "{$day[0]} {$day[1]} . {$month[0]} {$month[1]} . {$year[0]} {$year[1]} {$year[2]} {$year[3]}" }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quote section -->
                <div class="quote-section text-center" data-aos="fade-up" data-aos-duration="1500">
                    @php
                        $poems = explode("\n", $card->wedding_poem);
                    @endphp
                    @foreach($poems as $line)
                        <p class="font-script-small">{{ $line }}</p>
                    @endforeach
                </div>

                <!-- Family section -->
                <div class="family-section text-center">
                    <div class="row mx-0">
                        <div class="col-6" data-aos="fade-right" data-aos-duration="1500">
                            <h3 class="family-side">NHÀ TRAI</h3>
                            <div class="parents mb-3">
                                <p class="mb-1 parent-name">ÔNG {{ strtoupper($card->groom_father_name) }}</p>
                                <p class="parent-name">BÀ {{ strtoupper($card->groom_mother_name) }}</p>
                            </div>
                        </div>
                        <div class="col-6" data-aos="fade-left" data-aos-duration="1500">
                            <h3 class="family-side">NHÀ GÁI</h3>
                            <div class="parents mb-3">
                                <p class="mb-1 parent-name">ÔNG {{ strtoupper($card->bride_father_name) }}</p>
                                <p class="parent-name">BÀ {{ strtoupper($card->bride_mother_name) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Couple section -->
                <div class="couple-section text-center">
                    <!-- Heart icon -->
                    <div class="heart-icon mb-4" data-aos="zoom-in" data-aos-duration="1500">
                        <svg width="50" height="50" viewBox="0 0 50 50">
                            <path d="M25,45 C25,45 45,25 45,15 C45,5 35,5 25,15 C15,5 5,5 5,15 C5,25 25,45 25,45 Z"
                                  fill="none"
                                  stroke="#000"
                                  stroke-width="1.5"/>
                        </svg>
                    </div>

                    <!-- Couple names -->
                    <div class="row mx-0 mb-4" data-aos="fade-up" data-aos-duration="1500">
                        <div class="col-6">
                            <p class="role mb-1">Chú Rể</p>
                            <p class="couple-name font-script-medium">{{ $card->groom_name }}</p>
                            <p class="role mb-1">(Út Nam)</p>
                        </div>
                        <div class="col-6">
                            <p class="role mb-1">Cô Dâu</p>
                            <p class="couple-name font-script-medium">{{ $card->bride_name }}</p>
                            <p class="role mb-1">(Trưởng Nữ)</p>

                        </div>
                    </div>

                    <!-- Couple photos -->
                    <div class="couple-photos">
                        <div class="photo-container">
                            <div class="photo-frame" data-aos="custom-slide-right" data-aos-duration="2000" data-aos-mirror="true">
                                <img src="{{ asset($card->groom_image_url) }}" alt="Chú rể">
                            </div>
                            <div class="photo-frame" data-aos="custom-slide-left" data-aos-duration="2000" data-aos-mirror="true">
                                <img src="{{ asset($card->bride_image_url) }}" alt="Cô dâu">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wedding gallery -->
                <div class="wedding-gallery">
                    <div class="gallery-title text-center" data-aos="fade-up" data-aos-duration="1500">
                        <div class="divider">
                            <div class="line"></div>
                        </div>
                        <h2 class="font-script-large">Thư Mời</h2>
                        <p class="subtitle">THAM DỰ LỄ CƯỚI CỦA
                            {{ mb_strtoupper(Str::of($card->groom_name)->explode(' ')->last()) }}
                            &
                            {{ mb_strtoupper(Str::of($card->bride_name)->explode(' ')->last()) }}
                        </p>
                    </div>

                    <div class="gallery-grid">
                        @foreach($card->photos()->where('wedding_card_id', $card->id)
                            ->where('type', 'featured')
                            ->orderBy('sort_order')
                            ->take(3)
                            ->get() as $index => $photo)
                            @if($index === 1)
                                <div class="center-image" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="1500">
                                    <img src="{{ asset($photo->image_url) }}" alt="{{ $photo->image_url }}">
                                </div>
                            @else
                                <div class="side-image" data-aos="fade-up" data-aos-delay="{{ $index * 200 }}" data-aos-duration="1500">
                                    <img src="{{ asset($photo->image_url) }}" alt="{{ $photo->image_url }}">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Calendar section -->
                <div class="calendar-section" data-aos="fade-up" data-aos-duration="1500">
                    <div class="event-title text-center">
                        <h3 class="title font-script-medium-1" data-aos="fade-up" data-aos-duration="1500">Tiệc Mừng Lễ Vu Quy</h3>
                        <p class="event-time" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1500">
                            Vào lúc <span class="time-highlight">{{ $card->party_time->format('H\hi') }}</span> <span class="separator">|</span> <span class="day-highlight">{{ $dayName }}</span>
                        </p>

                        <div class="date-display">
                            <span data-aos="fade-right" data-aos-duration="2000" data-aos-delay="200" data-aos-mirror="true">Tháng {{ $card->wedding_date->format('m') }}</span>
                            <span class="separator">|</span>
                            <span class="date-number" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="400" data-aos-mirror="true"> {{ $card->wedding_date->format('d') }}</span>
                            <span class="separator">|</span>
                            <span data-aos="fade-left" data-aos-duration="2000" data-aos-delay="200" data-aos-mirror="true">{{ $card->wedding_date->format('Y') }}</span>
                        </div>

                        @php
                            $lunarYears = [
                                '2020' => 'Canh Tý',
                                '2021' => 'Tân Sửu',
                                '2022' => 'Nhâm Dần',
                                '2023' => 'Quý Mão',
                                '2024' => 'Giáp Thìn',
                                '2025' => 'Ất Tỵ',
                                '2026' => 'Bính Ngọ',
                                '2027' => 'Đinh Mùi',
                                '2028' => 'Mậu Thân',
                                '2029' => 'Kỷ Dậu',
                                '2030' => 'Canh Tuất',
                                '2031' => 'Tân Hợi',
                                '2032' => 'Nhâm Tý',
                                '2033' => 'Quý Sửu',
                                '2034' => 'Giáp Dần',
                                '2035' => 'Ất Mão',
                                '2036' => 'Bính Thìn',
                                '2037' => 'Đinh Tỵ',
                                '2038' => 'Mậu Ngọ',
                                '2039' => 'Kỷ Mùi',
                                '2040' => 'Canh Thân'
                            ];
                            $lunarYear = $lunarYears[$card->lunar_wedding_date->format('Y')] ?? '';
                        @endphp

                        <p class="lunar-date">
                            (Nhằm ngày {{ $card->lunar_wedding_date->format('d') }}
                            tháng {{ $card->lunar_wedding_date->format('m') }}
                            năm {{ $lunarYear }})
                        </p>
                    </div>

                    <div class="calendar-container">
                        <div class="calendar-header">
                            <div class="header-grid">
                                <div class="month-text">tháng</div>
                                <div class="month-number">{{ $card->wedding_date->format('m') }}</div>
                                <div class="empty-cell"></div>
                                <div class="year-cell">{{ $year[0] }}</div>
                                <div class="year-cell">{{ $year[1] }}</div>
                                <div class="year-cell">{{ $year[2] }}</div>
                                <div class="year-cell">{{ $year[3] }}</div>
                            </div>
                        </div>
                        <div class="weekdays">
                            <div>CN</div>
                            <div>T2</div>
                            <div>T3</div>
                            <div>T4</div>
                            <div>T5</div>
                            <div>T6</div>
                            <div>T7</div>
                        </div>
                        <div class="days"></div>
                        <div class="calendar-footer">
                            <svg class="heart-line" viewBox="0 0 100 20">
                                <path d="M0,10 Q40,10 45,10 T100,10" stroke="#4A3F35" fill="none" stroke-width="0.8"/>
                                <path d="M90,10 Q95,10 95,7.5 T90,5 T85,7.5 T90,10" fill="#4A3F35"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Venue section -->
                <div class="venue-section">
                    <h2 class="venue-title font-script-large" data-aos="fade-up" data-aos-duration="1500">Địa điểm tổ chức</h2>

                    <div class="venue-info" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1500">
                        <h3 class="venue-name">{{ mb_strtoupper($card->venue_name) }}</h3>
                        <p class="venue-address">{{ $card->venue_address }}</p>
                    </div>

                    <div class="map-container" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="1500">
                        <div class="map-frame">
                            <iframe
                                src="{{ $card->google_map_iframe }}"
                                width="100%"
                                height="300"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        @if($card->google_map)
                            <a href="{{ $card->google_map }}" class="map-button" target="_blank">
                                XEM TRÊN GOOGLE MAP
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Wedding Album Section -->
                <div class="wedding-album">
                    <h2 class="album-title font-script-large" data-aos="fade-up" data-aos-duration="1500">Album hình cưới</h2>

                    <div class="album-grid">
                        <div class="column">
                            @php
                                $leftPhotos = $card->photos()
                                    ->where('type', 'gallery')
                                    ->whereIn('sort_order', [4, 5, 6])  // Lấy ảnh có sort_order là 1,2,3
                                    ->orderBy('sort_order')
                                    ->get();
                                $rightPhotos = $card->photos()
                                    ->where('type', 'gallery')
                                    ->whereIn('sort_order', [7, 8, 9])  // Lấy ảnh có sort_order là 4,5,6
                                    ->orderBy('sort_order')
                                    ->get();
                            @endphp

                            <!-- Cột trái (1, 2, 3) -->
                            <div class="photo-item large" data-aos="fade-right" data-aos-duration="1500">
                                <img src="{{ asset($leftPhotos[0]->image_url) }}" alt="Gallery photo 1">
                            </div>
                            <div class="photo-item large" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">
                                <img src="{{ asset($leftPhotos[1]->image_url) }}" alt="Gallery photo 2">
                            </div>
                            <div class="photo-item small" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="400">
                                <img src="{{ asset($leftPhotos[2]->image_url) }}" alt="Gallery photo 3">
                            </div>
                        </div>

                        <!-- Cột phải (4, 5, 6) -->
                        <div class="column">
                            <div class="photo-item large" data-aos="fade-left" data-aos-duration="1500">
                                <img src="{{ asset($rightPhotos[0]->image_url) }}" alt="Gallery photo 4">
                            </div>
                            <div class="photo-item small" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="200">
                                <img src="{{ asset($rightPhotos[1]->image_url) }}" alt="Gallery photo 5">
                            </div>
                            <div class="photo-item large" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="400">
                                <img src="{{ asset($rightPhotos[2]->image_url) }}" alt="Gallery photo 6">
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $coverImageThanks = $card->photos()->where('type', 'cover')->where('sort_order', 2)->first();
                    $coverImageUrlThanks = $coverImageThanks ? asset($coverImageThanks->image_url) : '';
                @endphp
                <!-- Thank You Section -->
                <div class="thank-you-section" style="background-image: url('{{ $coverImageUrlThanks }}')">
                    <div class="thank-you-overlay"></div>
                    <div class="thank-you-content">
                        <h2 class="font-script-large">Thank You</h2>
                        <p class="thank-you-text">Rất hân hạnh được đón tiếp</p>
                    </div>
                </div>

                <!-- RSVP Section -->
                <div class="rsvp-section" style="background-image: url('{{ asset($card->cover_image_url)}}')">
                    <div class="rsvp-overlay"></div>
                    <div class="rsvp-container">
                        <!-- Nút tham dự -->
                        <button class="attend-button" onclick="openAttendModal()">
                            <div class="attend-content">
                                <div class="attend-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="attend-text">
                                    <span class="attend-title">THAM DỰ LỄ CƯỚI</span>
                                    <span class="attend-subtitle">Xác nhận tham dự & Gửi lời chúc</span>
                                </div>
                            </div>
                        </button>

                        <!-- Nút mừng cưới -->
                        <button class="gift-button" onclick="openGiftModal()">
                            <div class="gift-content">
                                <div class="gift-icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <div class="gift-text">
                                    <span class="gift-title">GỬI MỪNG CƯỚI</span>
                                    <span class="gift-subtitle">Gửi lời chúc đến đôi uyên ương</span>
                                </div>
                            </div>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác nhận tham dự -->
<div id="attendModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('attendModal')">&times;</span>
        <h3 class="modal-title">Xác nhận tham dự</h3>
        <form id="attendForm" onsubmit="submitForm(event)">
            <input type="hidden" name="card_id" value="{{ $card->id }}">
            <input type="hidden" name="couple_email" value="{{ $card->couple_email }}">

            <div class="form-group">
                <input type="text" name="name" placeholder="Họ và tên" required>
            </div>
            <div class="form-group">
                <input type="tel" name="phone" placeholder="Số điện thoại" required>
            </div>
            <div class="form-group">
                <input type="text" name="relationship" placeholder="Bạn là gì của cô dâu/chú rể?" required>
            </div>
            <div class="form-group">
                <textarea name="message" placeholder="Gửi lời chúc đến đôi uyên ương" rows="4"></textarea>
            </div>
            <button type="submit" class="submit-button">
                Gửi xác nhận
            </button>
        </form>
    </div>
</div>

<!-- Modal Gửi mừng cưới -->
<div id="giftModal" class="modal gift-modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('giftModal')">&times;</span>
        <h3 class="modal-title">Mừng cưới</h3>
        <div class="qr-container">
            <div class="qr-code">
                <img src="{{ asset($card->qr_code_url) }}" alt="QR Code" id="qrImage">
            </div>
            <div class="qr-buttons">
                <button class="qr-btn outline" onclick="openQRScanner()">
                    <i class="fas fa-qrcode"></i> Quét mã
                </button>
                <button class="qr-btn" onclick="downloadQR()">
                    <i class="fas fa-download"></i> Tải về
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Truyền ngày cưới từ PHP sang JS
    window.weddingDate = {
        year: {{ $card->wedding_date->format('Y') }},
        month: {{ $card->wedding_date->format('n') }}, // Sử dụng n để lấy số tháng không có số 0 ở đầu
        day: {{ $card->wedding_date->format('j') }}    // Sử dụng j để lấy ngày không có số 0 ở đầu
    };
</script>

@php
    $coverImage = $card->photos()->where('type', 'cover')->where('sort_order', 3)->first();
    $coverImageUrl = $coverImage ? asset($coverImage->image_url) : '';
@endphp
<div data-cover-image="{{ $coverImageUrl }}" style="display: none;"></div>

<div id="thankModal" class="thank-modal">
    <div class="thank-modal-content">
        <div class="thank-modal-overlay"></div>
        <div class="thank-modal-inner">
            <h2 class="thank-modal-title">Cảm ơn bạn</h2>
            <p class="thank-modal-message">Cảm ơn bạn đã gửi lời chúc mừng.<br>Rất hân hnh được đón tiếp!</p>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/clients/templates/template3/template3.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/clients/templates/template3/template3.js') }}"></script>

{{-- <script>
    function submitForm(e) {
        e.preventDefault();
        const form = e.target;

        const data = {
            couple_email: form.couple_email.value,  // Vẫn cần email để phân biệt
            name: form.name.value,
            phone: form.phone.value,
            relationship: form.relationship.value,
            message: form.message.value
        };

        const scriptURL = 'https://script.google.com/macros/s/AKfycbx0LNRYBE8Q0H7KCQYjHsuCvI_aaN_8R_U0Ihu3Ro53dzSApdOXLkVHrJQ6xFe0TUWb/exec';

        fetch(scriptURL, {
            method: 'POST',
            mode: 'no-cors',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            alert('Cảm ơn bạn đã gửi thông tin!');
            form.reset();
        })
        .catch(error => {
            console.error('Error!', error.message);
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        });
    }

    // Thêm hàm mở/đóng modal
    function openAttendModal() {
        const modal = document.getElementById('attendModal');
        if (modal) modal.style.display = 'block';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'none';
    }
    </script> --}}
@endpush





