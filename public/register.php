<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli('aws-mysql', 'eraser', 'eraserpass', 'awseraser');
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $code     = $_POST['code'];

    if ($code !== SIGNUP_SECRET_CODE) {
        $error = "보안 코드가 틀렸습니다.";
    } else {
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "회원가입 실패: 사용자명 중복?";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>aws-eraser | 회원가입</title>
    <link rel="icon" href="main.icon" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('back.png');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-color: #f8f9fa;
        }
        .register-box {
            max-width: 400px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        footer {
            margin-top: 60px;
            text-align: center;
            color: #888;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="register-box">
        <h3 class="text-center mb-4">AWS-ERASER</h3>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">아이디</label>
                <input name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">비밀번호</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">보안 코드</label>
                <input type="password" name="code" class="form-control" required>
                <div class="form-text">회원가입을 위해 보안 코드가 필요합니다.</div>
            </div>
            <button class="btn btn-primary w-100">회원가입</button>
        </form>
        <p class="mt-3 text-center"><a href="login.php">로그인</a>으로 돌아가기</p>
    </div>

    <footer>
        © 2025 aws-eraser | <a href="https://github.com/qpzm1010" target="_blank">GitHub</a>
    </footer>
</div>
</body>
</html>

