// QR Scanner functionality
function openQRScanner() {
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.capture = 'environment';
        input.click();
    } else {
        alert('Vui lòng sử dụng điện thoại di động để quét mã QR');
    }
}

// Modal functions
function openConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.style.display = 'flex';
}

function openGiftModal() {
    const modal = document.getElementById('giftModal');
    modal.style.display = 'flex';
    // Prevent body scrolling when modal is open
    document.body.style.overflow = 'hidden';
}

function openAttendModal() {
    const modal = document.getElementById('attendModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';

        // Reset form nếu là modal tham dự
        if (modalId === 'attendModal') {
            const form = modal.querySelector('form');
            if (form) form.reset();
        }
    }
}

function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Đã sao chép số tài khoản!');
    });
}

// Calendar functionality
function createCalendar(year, month, highlightDay) {
    const daysContainer = document.querySelector('.days');
    const date = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0).getDate();
    const firstDayIndex = date.getDay();

    daysContainer.innerHTML = '';

    for(let i = 0; i < firstDayIndex; i++) {
        const dayElement = document.createElement('div');
        daysContainer.appendChild(dayElement);
    }

    for(let day = 1; day <= lastDay; day++) {
        const dayElement = document.createElement('div');
        dayElement.textContent = day;

        if(day === highlightDay) {
            dayElement.classList.add('highlight');
        }

        if((day + firstDayIndex - 1) % 7 === 0) {
            dayElement.style.color = '#ff6b6b';
        }

        daysContainer.appendChild(dayElement);
    }
}

// Music functionality
function initBackgroundMusic() {
    const music = document.getElementById('background-music');
    if (!music) return;

    // Set volume
    music.volume = 0.3;

    // Try to play immediately
    const playPromise = music.play();

    if (playPromise !== undefined) {
        playPromise.catch(() => {
            // Auto-play was prevented
            // Show a "Play" button so that user can start playback
        });
    }

    // Play when tab becomes visible
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden && music.paused) {
            music.play().catch(() => {
                // Ignore autoplay errors when switching tabs
            });
        }
    });

    // Try to play on any user interaction with the page
    document.addEventListener('click', () => {
        if (music.paused) {
            music.play().catch(() => {});
        }
    });

    // Additional attempt to autoplay
    window.addEventListener('load', () => {
        music.play().catch(() => {});
    });
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo calendar với ngày cưới
    if (window.weddingDate) {
        createCalendar(
            window.weddingDate.year,
            window.weddingDate.month,
            window.weddingDate.day
        );
    }

    // Modal outside click handler
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // Close button click handler
    const closeButtons = document.querySelectorAll('.close-btn');
    closeButtons.forEach(button => {
        button.onclick = function() {
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
    });

    // Form submission handler
    const confirmForm = document.getElementById('confirmForm');
    if (confirmForm) {
        confirmForm.onsubmit = function(e) {
            e.preventDefault();
            alert('Cảm ơn bạn đã xác nhận tham dự!');
            closeModal('confirmModal');
        }
    }

    // RSVP button ripple effect
    const rsvpButton = document.querySelector('.rsvp-button.gift');
    if (rsvpButton) {
        rsvpButton.addEventListener('click', function(e) {
            let ripple = document.createElement('div');
            ripple.className = 'ripple';
            this.appendChild(ripple);

            let rect = this.getBoundingClientRect();
            let x = e.clientX - rect.left;
            let y = e.clientY - rect.top;

            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }

    // Initialize background music
    initBackgroundMusic();
});

// Form submission
function submitAttendForm(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Gửi dữ liệu đến server
    fetch('/api/wedding-rsvp', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert('Cảm ơn bạn đã xác nhận tham dự!');
        closeModal('attendModal');
        form.reset();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại sau.');
    });
}

// Thêm các functions mới
function showThankModal(coverImageUrl) {
    const modal = document.getElementById('thankModal');
    const modalContent = modal.querySelector('.thank-modal-content');

    if (coverImageUrl) {
        modalContent.style.backgroundImage = `url('${coverImageUrl}')`;
    }
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeThankModal() {
    const modal = document.getElementById('thankModal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

// Cập nhật function submitForm
function submitForm(e) {
    e.preventDefault();
    const form = e.target;

    const data = {
        couple_email: form.couple_email.value,
        name: form.name.value,
        phone: form.phone.value,
        relationship: form.relationship.value,
        message: form.message.value
    };

    const scriptURL = 'https://script.google.com/macros/s/AKfycbx0LNRYBE8Q0H7KCQYjHsuCvI_aaN_8R_U0Ihu3Ro53dzSApdOXLkVHrJQ6xFe0TUWb/exec';

    // Thêm loading state
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = 'Đang gửi...';

    fetch(scriptURL, {
        method: 'POST',
        mode: 'no-cors',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.type === 'opaque') {
            // Đóng modal form bằng style.display
            const attendModal = document.getElementById('attendModal');
            if (attendModal) attendModal.style.display = 'none';

            // Reset form
            form.reset();

            // Lấy URL ảnh bìa và hiển thị modal cảm ơn
            const coverImage = document.querySelector('[data-cover-image]');
            const coverImageUrl = coverImage ? coverImage.getAttribute('data-cover-image') : '';
            showThankModal(coverImageUrl);

            // Reset button state
            submitButton.disabled = false;
            submitButton.textContent = 'Gửi xác nhận';
        }
    })
    .catch(error => {
        console.error('Error!', error.message);
        alert('Có lỗi xảy ra, vui lòng thử lại!');
        submitButton.disabled = false;
        submitButton.textContent = 'Gửi xác nhận';
    });
}

// Thêm event listener cho nút đóng modal cảm ơn khi click outside
document.addEventListener('click', function(event) {
    const thankModal = document.getElementById('thankModal');
    if (event.target === thankModal) {
        closeThankModal();
    }
});

function downloadQR() {
    const qrImage = document.getElementById('qrImage');
    const link = document.createElement('a');
    link.href = qrImage.src;
    link.download = 'QR_MungCuoi.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
