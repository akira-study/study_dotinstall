<?php

require_once('config.php');
require_once('functions.php');

// ログイン管理セッション
session_start();

// ログインしている場合はindex.phpへ
if (!empty($_SESSION['me'])) {
    header('Location: '.SITE_URL);
    exit;
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
</head>
<body>
<h1>ログイン</h1>
<form action="" method="POST">
    <p>メールアドレス：<input type="text" name="email" value=""></p>
    <p>パスワード<input type="password" name="password" value=""></p>
    <p><input type="submit" value="ログイン"><a href="signup.php">新規登録はこちら！</p>
</form>
</body>
