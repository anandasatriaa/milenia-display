<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Milenia Display</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f3f5ff, #e8ebff);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 800px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid #e0e0ff;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-align: center;
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0;
            box-shadow: 0 4px 8px rgba(105, 108, 255, 0.1);
            text-decoration: none;
        }

        .card:nth-child(1) {
            animation-delay: 0.2s;
        }

        .card:nth-child(2) {
            animation-delay: 0.4s;
        }

        .card:hover {
            transform: translateY(-10px);
            background: #f9faff;
            border-color: #696cff;
            box-shadow: 0 8px 15px rgba(105, 108, 255, 0.2);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(105, 108, 255, 0.15),
                    transparent);
            transition: 0.5s;
        }

        .card:hover::before {
            left: 100%;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: rgba(105, 108, 255, 0.1);
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #696cff;
            transition: all 0.3s ease;
        }

        h2 {
            color: #2d2d2d;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        p {
            color: #4e4e4e;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .title {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #696cff;
            font-size: 2.5rem;
            text-align: center;
            animation: fadeIn 1s ease forwards;
            opacity: 0;
            text-shadow: 0 2px 4px rgba(105, 108, 255, 0.2);
        }

        .title span {
            font-size: 1.2rem;
            display: block;
            margin-top: 0.5rem;
            color: #2d2d2d;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .card:hover .logo {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(105, 108, 255, 0.3);
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                padding: 1rem;
            }

            .title {
                font-size: 2rem;
                top: 15%;
            }

            .admin-btn {
                top: 15px;
                right: 15px;
                padding: 10px 20px;
                font-size: 0.85rem;
            }
        }

        /* Tambahan efek klik */
        .card:active {
            transform: scale(0.95);
        }

        .ripple {
            position: absolute;
            background: rgba(105, 108, 255, 0.3);
            transform: translate(-50%, -50%);
            pointer-events: none;
            border-radius: 50%;
            animation: rippleEffect 0.6s linear;
        }

        @keyframes rippleEffect {
            from {
                width: 0;
                height: 0;
                opacity: 0.5;
            }

            to {
                width: 500px;
                height: 500px;
                opacity: 0;
            }
        }

        .admin-btn {
            position: fixed;
            top: 20px;
            right: 30px;
            background: linear-gradient(135deg, #696cff, #5a5dff);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(105, 108, 255, 0.3);
            z-index: 1000;
            border: none;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .admin-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(105, 108, 255, 0.4);
            background: linear-gradient(135deg, #5a5dff, #4b4eff);
        }

        .admin-btn:active {
            transform: scale(0.98);
        }

        .admin-btn i {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <h1 class="title">MILENIA DISPLAY TV<span>Pilih lokasi yang ingin ditampilkan</span></h1>

    <div class="container">
        <a href="{{ route('login') }}" class="admin-btn">
            <i class="fas fa-user-shield"></i>
            <span>Admin Login</span>
        </a>

        <a href="{{ route('tgr') }}" class="card">
            <div class="logo">
                <i class="fas fa-tv"></i>
            </div>
            <h2>Tigaraksa</h2>
            <p>Display TV untuk lokasi Tigaraksa. Pilih ini untuk melihat tampilan informasi terkini di cabang
                Tigaraksa.</p>
        </a>

        <a href="{{ route('pb') }}" class="card">
            <div class="logo">
                <i class="fas fa-building"></i>
            </div>
            <h2>Pembangunan</h2>
            <p>Display TV untuk lokasi Pembangunan. Pilih ini untuk melihat tampilan informasi terkini di cabang
                Pembangunan.</p>
        </a>
    </div>

    <script>
        function navigate(location) {
            // Tambahkan efek ripple
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    let x = e.clientX - e.target.offsetLeft;
                    let y = e.clientY - e.target.offsetTop;
                    let ripple = document.createElement('div');
                    ripple.classList.add('ripple');
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        }
    </script>
</body>

</html>
