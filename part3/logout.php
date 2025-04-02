<?php
// logout.php
session_start();
session_unset(); // 모든 세션 변수 초기화
session_destroy(); // 세션 종료
header("Location: index.php"); // 홈 페이지로 리다이렉션
exit();
?>
