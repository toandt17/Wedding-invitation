<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $card->seo_title }}</title>
    <meta name="title" content="Thiệp cưới online - {{ $card->groom_name }} ♥ {{ $card->bride_name }}">
    <meta name="description" content="Trân trọng kính mời bạn đến dự lễ thành hôn của chúng tôi vào ngày {{ $card->wedding_date->format('d/m/Y') }}">

    <meta property="og:site_name" content="Thiệp cưới online">
    <meta property="og:title" content="{{ $card->groom_name }} ♥ {{ $card->bride_name }} | Thiệp cưới online">
    <meta property="og:description" content="Trân trọng kính mời bạn đến dự lễ thành hôn của chúng tôi vào ngày {{ $card->wedding_date->format('d/m/Y') }}">
    <meta property="og:image" content="{{ $card->seo_image_url ?? $card->cover_image_url }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Preload Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto+Condensed:ital@0;1&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Gộp các font lại thành một link -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto+Condensed:ital@0;1&family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@400;700&family=Quicksand:wght@300;400;500;600;700&family=Alex+Brush&family=The+Nautigal:wght@400;700&display=swap" rel="stylesheet">
    <!-- Add The Nautigal font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=The+Nautigal:wght@400;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Styles -->
    @stack('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" media="print" onload="this.media='all'">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
</head>
<body>
    @yield('content')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1200,
            once: false,     // Cho phép animation lặp lại
            mirror: true,    // Cho phép animation khi scroll ngược
            offset: 100,
            easing: 'ease-out-cubic'
        });
    </script>
    @stack('scripts')

    <!-- Facebook SDK -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0&appId=YOUR_FACEBOOK_APP_ID"
        nonce="YOUR_NONCE">
    </script>
</body>
</html>
