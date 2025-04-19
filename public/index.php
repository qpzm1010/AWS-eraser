<?php
session_start();
$logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>AWS-eraser</title>
    <link rel="icon" href="main.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eef2f3, #cfd9df);
            transition: background 0.3s ease, color 0.3s ease;
        }
        .dark-mode {
            background: #1e1e2f;
            color: #e0e0e0;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        .logo {
            font-size: 3rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .dark-mode .logo {
            color: #66b2ff;
        }
        .subtitle {
            font-size: 1.2rem;
            color: #555;
        }
        .dark-mode .subtitle {
            color: #ccc;
        }
        .btn-group {
            margin-top: 2rem;
        }
        .btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 0.9rem;
            color: #888;
        }
        footer a {
            text-decoration: none;
            color: #0d6efd;
        }
        .dark-mode footer a {
            color: #66b2ff;
        }
        .toggle-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        /* 애니메이션 */
        .fade-in {
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 1s ease forwards;
        }
        .fade-in-sub {
            opacity: 0;
            animation: fadeIn 2s ease forwards;
            animation-delay: 0.5s;
        }
        @keyframes fadeInDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="toggle-container">
        <button onclick="toggleMode()" class="btn btn-outline-secondary btn-md">🌙 / ☀️</button>
    </div>

    <div class="container hero">
        <div>
            <div class="logo fade-in">
                <img src="main.ico" alt="logo" width="128" class="mb-3">
                <div>aws-eraser</div>
            </div>
            <p class="subtitle fade-in-sub">간편하게 지우는 AWS 리소스</p>
            <div class="btn-group">
                <?php if ($logged_in): ?>
                    <a href="dashboard.php" class="btn btn-primary btn-lg me-2">대시보드로 이동</a>
                    <a href="logout.php" class="btn btn-outline-danger btn-lg">로그아웃</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary btn-lg me-2">로그인</a>
                    <a href="register.php" class="btn btn-outline-primary btn-lg">회원가입</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        © 2025 aws-eraser | <a href="https://github.com/qpzm1010" target="_blank">GitHub</a>
    </footer>

    <script>
        function toggleMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
</body>
</html>

