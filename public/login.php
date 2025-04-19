<?php
// login.php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli('aws-mysql', 'eraser', 'eraserpass', 'awseraser');
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "비밀번호가 올바르지 않습니다.";
        }
    } else {
        $error = "사용자가 존재하지 않습니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>aws-eraser | 로그인</title>
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
        .login-box {
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
    <div class="login-box">
        <h3 class="text-center mb-4">aws-eraser 로그인</h3>
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
            <button class="btn btn-primary w-100">로그인</button>
        </form>
        <p class="mt-3 text-center"><a href="register.php">회원가입</a></p>
    </div>

    <footer>
        © 2025 aws-eraser | <a href="https://github.com/qpzm1010" target="_blank">GitHub</a>
    </footer>
</div>
</body>
</html>

