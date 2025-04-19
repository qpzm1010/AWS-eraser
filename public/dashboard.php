<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? '사용자';

// DB 연결
$db = new mysqli('aws-mysql', 'eraser', 'eraserpass', 'awseraser');

// 삭제 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_key_id'])) {
    $delete_id = (int)$_POST['delete_key_id'];
    $stmt = $db->prepare("DELETE FROM access_keys WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $delete_id, $user_id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}

// 키 목록 조회
$stmt = $db->prepare("SELECT id, access_key, secret_key, created_at FROM access_keys WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$saved_keys = [];
while ($row = $result->fetch_assoc()) {
    $saved_keys[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>aws-eraser | 대시보드</title>
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
        .bg-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(6px);
            border-radius: 16px;
            padding: 2rem;
            margin-top: 3rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .btn-logout {
            font-size: 0.9rem;
        }
        footer {
            margin-top: 60px;
            text-align: center;
            color: #888;
            font-size: 0.9rem;
        }
        .dark-mode footer a {
            color: #66b2ff;
        }
        .toggle-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
<div class="toggle-container">
    <button onclick="toggleMode()" class="btn btn-outline-secondary btn-md">🌙 / ☀️</button>
</div>
<div class="container">
    <div class="bg-glass">
        <div class="top-bar mb-4">
            <h2>AWS-EARSER</h2>
            <a href="logout.php" class="btn btn-outline-danger btn-sm btn-logout">로그아웃</a>
        </div>

        <div class="section">
            <h4 class="mb-3">AWS-EARSER 실행</h4>
            <form method="POST" action="run_nuke.php">
                <?php if (!empty($saved_keys)): ?>
                <div class="mb-3">
                    <label class="form-label">저장된 액세스 키 선택</label>
                    <select id="savedKeySelect" class="form-select" onchange="fillKeys()">
                        <option value="">선택 안 함 (새 키 입력)</option>
                        <?php foreach ($saved_keys as $key): ?>
                            <option value="<?= htmlspecialchars($key['id']) ?>"
                                    data-access="<?= htmlspecialchars($key['access_key']) ?>"
                                    data-secret="<?= htmlspecialchars($key['secret_key']) ?>">
                                <?= htmlspecialchars($key['access_key']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Account ID</label>
                    <input name="account_id" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Access Key</label>
                    <input name="access_key" id="accessKeyInput" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Secret Key</label>
                    <input name="secret_key" id="secretKeyInput" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">리전 선택</label>
                    <select name="region" class="form-select" required>
                        <option value="ap-northeast-2">ap-northeast-2 (서울)</option>
                        <option value="us-east-1">us-east-1 (버지니아)</option>
                        <option value="us-west-2">us-west-2 (오레곤)</option>
                    </select>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="real_delete" value="yes" id="realDeleteCheck">
                    <label class="form-check-label" for="realDeleteCheck">
                        실제로 리소스를 삭제합니다 (체크시 삭제 실행 가능)
                    </label>
                </div>
                <button class="btn btn-primary w-100">EXECUTE</button>
            </form>
        </div>

        <div class="section mt-5">
            <h4 class="mb-3">이전에 사용한 Access Key 목록</h4>
            <?php if (!empty($saved_keys)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Access Key</th>
                                <th>Secret Key</th>
                                <th>사용일</th>
                                <th>관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($saved_keys as $key): ?>
                                <tr>
                                    <td><?= htmlspecialchars($key['access_key']) ?></td>
                                    <td><?= htmlspecialchars($key['secret_key']) ?></td>
                                    <td><?= htmlspecialchars($key['created_at']) ?></td>
                                    <td>
                                        <form method="POST" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                            <input type="hidden" name="delete_key_id" value="<?= $key['id'] ?>">
                                            <button class="btn btn-sm btn-outline-danger">삭제</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>저장된 키가 없습니다.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        © 2025 aws-eraser | <a href="https://github.com/qpzm1010" target="_blank">GitHub</a>
    </footer>
</div>
<script>
    function toggleMode() {
        document.body.classList.toggle('dark-mode');
    }
    function fillKeys() {
        const select = document.getElementById('savedKeySelect');
        const selected = select.options[select.selectedIndex];
        document.getElementById('accessKeyInput').value = selected.dataset.access || '';
        document.getElementById('secretKeyInput').value = selected.dataset.secret || '';
    }
</script>
</body>
</html>

