<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tigaraksa | Milenia Display</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        :root {
            --primary-color: #696cff;
            --secondary-color: #d46fff;
            --text-color: #333;
            --text-light: #555;
            --bg-light: #f9faff;
            --bg-lighter: #ffffff;
            --card-bg: rgba(255, 255, 255, 0.8);
            --overlay: rgba(255, 255, 255, 0.6);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--bg-light), var(--bg-lighter));
            color: var(--text-color);
            height: 100vh;
            overflow: hidden;
        }

        /* container grid: header / content / marquee */
        .container {
            display: grid;
            grid-template-rows: auto 1fr auto;
            height: 100%;
            gap: 1rem;
        }

        /* — Header — */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: var(--overlay);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            animation: slideDown 1s ease-out;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            width: 80px;
        }

        .company-name {
            line-height: 1;
            font-size: 3rem;
            font-weight: 600;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .company-address {
            font-size: 0.7rem;
            color: var(--text-light);
            /* max-width: 400px; */
            line-height: 1.4;
        }

        /* kanan header: date/time + live */
        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .header-datetime {
            font-size: 2.3rem;
            color: var(--text-light);
        }

        .header-datetime .separator {
            margin: 0 0.25rem;
        }

        #header-time {
            display: inline-block;
            width: 6ch;
            text-align: center;
            margin-right: 15px;
        }

        .live-status {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: var(--primary-color);
            font-size: 2.3rem;
        }

        .live-status .live-dot {
            display: inline-block;
            width: 15px;
            height: 15px;
            margin-right: 0.5rem;
            background: red;
            border-radius: 50%;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            50%,
            100% {
                opacity: 1
            }

            25%,
            75% {
                opacity: 0
            }
        }

        /* — Main Content: kiri (event) & kanan (video) — */
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            padding: 0 2rem;
        }

        .left-panel {
            display: grid;
            grid-template-rows: auto 1fr;
            /* gap: 1rem; */
            animation: slideRight 1s ease-out;
        }

        /* Kotak Event saja */
        .event {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            position: relative;
            background: linear-gradient(135deg, #696cff, #d46fff);
            border: 2px solid linear-gradient(135deg, #696cff, #d46fff);
            border-radius: 10px;
            padding: 0.3rem 0.3rem;
            width: 42vw;
            min-width: 200px;
            margin: 0 auto;
            overflow: hidden;
        }

        .event::before {
            content: "";
            position: absolute;
            top: -100%;
            left: -100%;
            width: 150%;
            height: 400%;
            background: linear-gradient(120deg,
                    transparent 45%,
                    rgba(255, 255, 255, 0.5) 50%,
                    transparent 55%);
            transform: rotate(20deg);
            animation: shimmer 2.5s infinite linear;
            pointer-events: none;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) rotate(25deg);
            }

            100% {
                transform: translateX(100%) rotate(25deg);
            }
        }

        .event .calendar-icon {
            font-size: 1.5rem;
            color: whitesmoke;
        }

        .event .event-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
        }

        /* Banner/Event image placeholder */
        .event-banner {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .event-image {
            width:42vw;
            height:auto;
            border-radius: 10px;
        }

        .event-banner::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 150%;
            height: 200%;
            background: linear-gradient(120deg,
                    transparent 45%,
                    rgba(255, 255, 255, 0.5) 50%,
                    transparent 55%);
            transform: rotate(20deg);
            animation: shimmer 2.5s infinite linear;
            pointer-events: none;
        }

        .video-container {
            display: flex;
            align-items: center;
            justify-content: center;
            animation: slideLeft 1s ease-out;
        }

        .video-placeholder {
            font-size: 1.5rem;
            color: var(--text-light);
        }

        .video-player {
            width: 45vw;
            height: auto;
            border-radius: 10px;
        }

        .running {
            background: linear-gradient(90deg, var(--primary-color), #d46fff);
            padding: 1rem 0;
            overflow: hidden;
            animation: slideUp 1s ease-out;
        }

        .running-text {
            display: inline-block;
            white-space: nowrap;
            padding-left: 30%;
            animation: marquee 20s linear infinite;
            font-size: 1.5rem;
            color: #fff;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-20px)
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%)
            }

            to {
                transform: translateY(0)
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }

            to {
                transform: translateY(0);
            }
        }

        @keyframes slideRight {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slideLeft {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%)
            }

            100% {
                transform: translateX(-100%)
            }
        }

        @media (max-width:768px) {
            .main-content {
                grid-template-columns: 1fr;
                padding: 0 1rem;
            }

            .event .event-title {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- 1. Header -->
        <header class="header">
            <div class="logo-container">
                <img src="{{ asset('assets/img/logo-milenia-2.png') }}" alt="Logo" class="logo" />
                <div>
                    <h1 class="company-name">MILENIA GROUP</h1>
                    <p class="company-address">
                        Jl. Pemda Tigaraksa Kp.Ciapus Indah, RT.04/RW.02, Budi Mulya, Kec. Cikupa, Kabupaten Tangerang,
                        Banten 15710
                    </p>
                </div>
            </div>
            <div class="header-right">
                <div class="header-datetime">
                    <span id="header-date"></span>
                    <span class="separator">|</span>
                    <span id="header-time"></span>
                </div>
                <div class="live-status">
                    <span class="live-dot"></span> LIVE
                </div>
            </div>
        </header>

        <!-- 2. Main Content -->
        <div class="main-content">
            <div class="left-panel">
                <!-- Kotak Event -->
                <div class="event">
                    <i class="fas fa-calendar-alt calendar-icon"></i>
                    <div class="event-title">EVENT & INFORMATION</div>
                </div>
                <!-- Banner/Event Image -->
                <div class="event-banner">
                    <img id="eventImage" src="{{ asset('storage/' . $banners->first()->image) }}" class="event-image" />
                </div>
            </div>
            <!-- Video -->
            <div class="video-container">
                @if ($videos->isNotEmpty())
                    <video id="videoPlayer" class="video-player" autoplay muted playsinline controls>
                        <source src="{{ asset('storage/' . $videos->first()->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        </div>

        <!-- 3. Running Text di Bawah -->
        <div class="running">
            <div class="running-text">
                {!! $fullRunningText !!}
            </div>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const opts = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('header-time').textContent = now.toLocaleTimeString();
            document.getElementById('header-date').textContent = now.toLocaleDateString('id-ID', opts);
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>

    <!-- BANNER & VIDEO -->
    <script>
        const banners = @json($banners->pluck('image')->map(fn($img) => asset('storage/' . $img)));
        const videos = @json($videos->pluck('video')->map(fn($vid) => asset('storage/' . $vid)));
    </script>
    <script>
        // Gambar
        let bannerIndex = 0;
        const bannerImg = document.getElementById("eventImage");

        function switchBanner() {
            bannerIndex = (bannerIndex + 1) % banners.length;
            bannerImg.src = banners[bannerIndex];
        }

        setInterval(switchBanner, 10000); // Setiap 10 detik

        // Video
        let videoIndex = 0;
        const videoPlayer = document.getElementById("videoPlayer");

        function switchVideo() {
            videoIndex = (videoIndex + 1) % videos.length;
            videoPlayer.src = videos[videoIndex];
            videoPlayer.load();
            videoPlayer.play();
        }

        videoPlayer.addEventListener("ended", switchVideo);
    </script>
</body>

</html>
