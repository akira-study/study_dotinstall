<?php

require_once('config.php');
require_once('functions.php');

// ログイン管理セッション
session_start();

// ログインしていない場合場合ログイン画面に飛ばす
if (empty($_SESSION['me'])) {
    header('Location: '.SITE_URL.'login.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム画面</title>
</head>
<body>
<h1>ユーザー一覧</h1>
</body>
</html>

