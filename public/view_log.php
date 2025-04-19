<?php
// view_log.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$log_path = "/var/www/storage/logs/user_$uid.log";
$status_path = "/var/www/storage/logs/user_$uid.status";
$status = file_exists($status_path) ? trim(file_get_contents($status_path)) : "unknown";
$status_display = match($status) {
    "running" => "🟡 실행 중",
    "done"    => "🟢 완료됨",
    default   => "⚪ 상태 알 수 없음",
};
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>aws-eraser | 로그 보기</title>
    <link rel="icon" href="main.icon" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ($status === "running"): ?>
        <meta http-equiv="refresh" content="5">
    <?php endif; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('back.png');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-color: #f8f9fa;
        }
        .bg-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(6px);
            border-radius: 16px;
            padding: 2rem;
            margin-top: 3rem;
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
    <div class="bg-glass">
        <h3>실행 로그</h3>
        <p><strong>상태:</strong> <?= $status_display ?></p>

        <?php if (!file_exists($log_path)): ?>
            <div class="alert alert-warning">로그 파일이 아직 생성되지 않았습니다. 잠시 후 새로고침 해보세요.</div>
        <?php else: ?>
            <pre style="background:#f1f1f1; padding: 1rem; border-radius: 8px; height: 400px; overflow:auto;"><?php echo htmlspecialchars(file_get_contents($log_path)); ?></pre>
        <?php endif; ?>

        <a href="dashboard.php" class="btn btn-primary mt-3">대시보드로 돌아가기</a>
    </div>

    <footer>
        © 2025 aws-eraser | <a href="https://github.com/qpzm1010" target="_blank">GitHub</a>
    </footer>
</div>
</body>
</html>

