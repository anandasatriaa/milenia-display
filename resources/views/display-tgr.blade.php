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
            /* gap: 1rem; */
        }

        .logo {
            width: 80px;
            margin-right: 1rem;
        }

        .company-name {
            line-height: 1;
            font-size: 2.8rem;
            font-weight: 600;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .company-address {
            font-size: 0.7rem;
            color: var(--text-light);
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
            margin-right: 10px;
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
            /* gap: 1rem; */
            position: relative;
            background: linear-gradient(135deg, #696cff, #d46fff);
            border: 2px solid linear-gradient(135deg, #696cff, #d46fff);
            border-radius: 10px;
            padding: 0.3rem 0.3rem;
            width: 36vw;
            min-width: 200px;
            margin: 0 auto;
            overflow: hidden;
        }

        .event i.calendar-icon {
            margin-right: 1rem;
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
            /* margin-top: 10px; */
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
            z-index: 2;
        }

        .event-image-wrapper {
            position: relative;
            width: 36vw;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .event-image {
            position: absolute;
            width: 100%;
            border-radius: 10px;
            will-change: transform, opacity;
            overflow: hidden;
        }

        /* Keyframes untuk keluar ke kiri */
        @keyframes slideOutLeft {
            to {
                transform: translateX(-100%);
                opacity: 0;
            }
        }

        /* Keyframes untuk masuk dari kiri ke kanan */
        @keyframes slideInLeft {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Kelas pembantu */
        .slide-out {
            animation: slideOutLeft 0.6s ease-in-out forwards;
        }

        .slide-in {
            animation: slideInLeft 0.6s ease-in-out forwards;
        }

        .video-container {
            position: relative;
            width: 39vw;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            animation: slideLeft 1s ease-out;
        }

        .video-placeholder {
            font-size: 1.5rem;
            color: var(--text-light);
        }

        .video-player {
            position: absolute;
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: opacity 0.5s ease-in-out;
            will-change: transform, opacity;
        }

        /* Slide keluar ke kanan */
        @keyframes slideOutRight {
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Slide masuk dari kanan */
        @keyframes slideInLeftVideo {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .slide-out-right {
            animation: slideOutRight 0.6s ease-in-out forwards;
        }

        .slide-in-left {
            animation: slideInLeftVideo 0.6s ease-in-out forwards;
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
            animation-name: marquee;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-duration: var(--marquee-duration, 40s);
            animation-delay: -16s;
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
                        Jl. Pemda Tigaraksa Kp.Ciapus Indah, RT.04/RW.02, Budi Mulya, <br> Kec. Cikupa, Kabupaten
                        Tangerang,
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
                    <div class="event-image-wrapper">
                        <!-- gambar sekarang -->
                        <img id="bannerCurrent" src="{{ asset('storage/' . $banners->first()->image) }}"
                            class="event-image" />
                        <!-- gambar pengganti (kosong di awal) -->
                        <img id="bannerNext" class="event-image" style="opacity:0" />
                    </div>
                </div>
            </div>
            <!-- Video -->
            <div class="video-container">
                <video id="videoCurrent" class="video-player" autoplay></video>
                <video id="videoNext" class="video-player" style="opacity: 0;"></video>
            </div>
        </div>

        <!-- 3. Running Text di Bawah -->
        <div class="running">
            <div class="running-text">
                {!! $fullRunningText !!}
            </div>
        </div>
    </div>

    {{-- FORMAT WAKTU --}}
    <script>
        function updateTime() {
            const now = new Date();
            const opts = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('header-time').textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            document.getElementById('header-date').textContent = now.toLocaleDateString('id-ID', opts);
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>

    <!-- BANNER & VIDEO -->
    <script>
        // Gambar
        let bannerIndex = 0;
        const banners = @json($banners->pluck('image_url'));
        const curr = document.getElementById("bannerCurrent");
        const next = document.getElementById("bannerNext");

        function switchBanner() {
            const newIndex = (bannerIndex + 1) % banners.length;

            // 1) Start slide-out pada curr
            curr.classList.add('slide-out');

            // 2) Tunggu sampai slide-out selesai
            curr.addEventListener('animationend', function onOut() {
                curr.removeEventListener('animationend', onOut);

                // 3) Setup gambar baru
                next.src = banners[newIndex];
                next.style.opacity = '1';
                // pastikan mulai dari off-screen kiri
                next.style.transform = 'translateX(-100%)';

                // 4) Mulai slide-in
                next.classList.add('slide-in');

                next.addEventListener('animationend', function onIn() {
                    next.removeEventListener('animationend', onIn);

                    // 5) Reset state: gambar baru jadi current
                    curr.classList.remove('slide-out');
                    next.classList.remove('slide-in');

                    curr.src = next.src;
                    next.style.opacity = '0';
                    next.style.transform = '';

                    bannerIndex = newIndex;
                }, {
                    once: true
                });

            }, {
                once: true
            });
        }

        // jalankan setiap 10 detik
        setInterval(switchBanner, 10000);


        // Video
        const videos = @json($videos->pluck('video')->map(fn($vid) => asset('storage/' . $vid)));
        let videoIndex = 0;

        const videoCurrent = document.getElementById("videoCurrent");
        const videoNext = document.getElementById("videoNext");

        function playVideoWithSound(videoElement) {
            videoElement.muted = false;
            videoElement.volume = 1;

            const playPromise = videoElement.play();
            if (playPromise !== undefined) {
                playPromise.catch(() => {
                    const notice = document.createElement('div');
                    notice.textContent = "🔊 Klik di mana saja untuk memulai video dengan suara";
                    notice.style.position = 'fixed';
                    notice.style.top = '5%';
                    notice.style.left = '50%';
                    notice.style.transform = 'translateX(-50%)';
                    notice.style.zIndex = 9999;
                    notice.style.padding = '15px 30px';
                    notice.style.fontSize = '1.2rem';
                    notice.style.borderRadius = '8px';
                    notice.style.backgroundColor = '#696cff';
                    notice.style.color = 'white';
                    notice.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.2)';
                    notice.style.pointerEvents = 'none'; // agar tidak menghalangi klik
                    document.body.appendChild(notice);

                    const resumeHandler = () => {
                        videoElement.play();
                        notice.remove();
                        document.body.removeEventListener('click', resumeHandler);
                    };

                    // Dengarkan klik di mana saja
                    document.body.addEventListener('click', resumeHandler);
                });
            }
        }

        videoCurrent.src = videos[videoIndex];
        videoCurrent.load();
        playVideoWithSound(videoCurrent);

        function switchVideo() {
            const nextIndex = (videoIndex + 1) % videos.length;

            // Setup videoNext
            videoNext.src = videos[nextIndex];
            videoNext.muted = false;
            videoNext.volume = 1;
            videoNext.style.opacity = '1';
            videoNext.classList.add('slide-in-left');

            // Slide out current
            videoCurrent.classList.add('slide-out-right');

            videoNext.addEventListener("animationend", function onIn() {
                videoNext.removeEventListener("animationend", onIn);

                // Reset class
                videoCurrent.classList.remove('slide-out-right');
                videoNext.classList.remove('slide-in-left');

                // Tukar posisi
                videoCurrent.src = videoNext.src;
                playVideoWithSound(videoCurrent);
                videoNext.style.opacity = '0';

                videoIndex = nextIndex;
            }, {
                once: true
            });
        }

        videoCurrent.addEventListener("ended", switchVideo);
    </script>

    {{-- RUNNING TEXT DURATION --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.running');
            const textEl = container.querySelector('.running-text');
            const speed = 100; // piksel per detik yang diinginkan

            // hitung lebar
            const containerWidth = container.clientWidth;
            const textWidth = textEl.scrollWidth;
            const totalDistance = containerWidth + textWidth;

            // durasi dalam detik
            const durationSec = totalDistance / speed;

            // set ke CSS custom property (tambahkan 's' supaya valid waktu)
            textEl.style.setProperty('--marquee-duration', durationSec + 's');
        });
    </script>

    {{-- DISPLAY AUTO RELOAD KETIKA ADMIN MENGGANTI KONTEN --}}
    @php
        $maxDate = collect([
            $banners->max('updated_at'),
            $videos->max('updated_at'),
            DB::table('runningtexts')->where('active', 1)->where('type', 'tgr')->max('updated_at'),
        ])
            ->filter()
            ->max();

        $initialLast = $maxDate ? \Carbon\Carbon::parse($maxDate)->timestamp : 0;

        $runningTextIds = DB::table('runningtexts')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->orderBy('order')
            ->pluck('id');
    @endphp

    <script>
        let bannerIds = @json($banners->pluck('id'));
        let videoIds = @json($videos->pluck('id'));
        let runningTextIds = @json($runningTextIds);
        let lastUpdate = {{ $initialLast }};

        // console.log('Init state:', {
        //     bannerIds,
        //     videoIds,
        //     runningTextIds,
        //     lastUpdate
        // });
    </script>

    <script>
        async function checkForUpdates() {
            try {
                const res = await fetch('{{ route('tgr.last-update') }}');
                if (!res.ok) return;

                const {
                    banner_ids,
                    video_ids,
                    runningtext_ids,
                    last_update
                } = await res.json();

                // console.log('Polled state:', {
                //     banner_ids,
                //     video_ids,
                //     runningtext_ids,
                //     last_update
                // });

                const sameArray = (a, b) =>
                    a.length === b.length && a.every((val, idx) => val === b[idx]);

                if (
                    !sameArray(bannerIds, banner_ids) ||
                    !sameArray(videoIds, video_ids) ||
                    !sameArray(runningTextIds, runningtext_ids) ||
                    last_update !== lastUpdate
                ) {
                    console.log('Perubahan konten terdeteksi → reload');
                    location.reload();
                }
            } catch (e) {
                console.error('Gagal cek update:', e);
            }
        }

        // polling tiap 1 detik, mulai setelah 1 detik
        setTimeout(() => {
            checkForUpdates();
            setInterval(checkForUpdates, 1000);
        }, 1000);
    </script>
    {{-- END DISPLAY AUTO RELOAD KETIKA ADMIN MENGGANTI KONTEN --}}
</body>

</html>
