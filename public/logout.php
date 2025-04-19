<?php
session_start();
session_unset();   // 세션 변수 초기화
session_destroy(); // 세션 종료
header("Location: index.php"); // 메인 페이지로 리디렉션
exit;

