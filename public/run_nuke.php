<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("로그인이 필요합니다");
}

$uid           = $_SESSION['user_id'];
$account_id    = $_POST['account_id'];
$access_key    = $_POST['access_key'];
$secret_key    = $_POST['secret_key'];
$region        = $_POST['region'];
$is_real_delete = isset($_POST['real_delete']) && $_POST['real_delete'] === 'yes';

$config_path = "/var/www/storage/configs/user_$uid.yaml";
$log_path    = "/var/www/storage/logs/user_$uid.log";
$status_path = "/var/www/storage/logs/user_$uid.status";

// YAML 생성
$config = <<<YAML
regions:
  - "$region"

account-blocklist:
  - "999999999999"

accounts:
  "$account_id":
    filters:
      IAMUser:
        - "ignore me"
YAML;

file_put_contents($config_path, $config);
file_put_contents($status_path, "running");

// DB에 키 저장 (중복 방지)
$db = new mysqli('aws-mysql', 'eraser', 'eraserpass', 'awseraser');
$stmt = $db->prepare("SELECT COUNT(*) FROM access_keys WHERE user_id = ? AND access_key = ? AND secret_key = ?");
$stmt->bind_param("iss", $uid, $access_key, $secret_key);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count == 0) {
    $insert = $db->prepare("INSERT INTO access_keys (user_id, access_key, secret_key) VALUES (?, ?, ?)");
    $insert->bind_param("iss", $uid, $access_key, $secret_key);
    $insert->execute();
    $insert->close();
}

// 쉘 스크립트 호출
$real_delete_flag = $is_real_delete ? "yes" : "no";
$cmd = "nohup bash /var/www/html/run_delete.sh '$config_path' '$log_path' '$status_path' '$access_key' '$secret_key' '$real_delete_flag' >/dev/null 2>&1 &";
shell_exec($cmd);

header("Location: view_log.php?user_id=$uid");
exit;
