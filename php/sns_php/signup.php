<?php

require_once('config.php');
require_once('functions.php');

session_start();

function setToken() {
    // 乱数を生成してsha1で暗号化
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
}

function checkToken() {
    if (empty($_SESSION['token']) || ($_SESSION['token']) != $_POST) {
        echo "不正なPOSTが行われました！";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // CSRF対策
    // フォームを表示した時にトークンをセット
    // フォームがポストされた時に
    // そのトークンと上記のトークンが一致しているかどうかチェック
    // 不正なポストを防ぐ
    setToken();
} else {
    checkToken();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規ユーザー登録</title>
</head>
<body>
<h1>新規ユーザー登録</h1>
<form action="" method="POST">
    <p>お名前：<input type="text" name="name" value=""></p>
    <p>メールアドレス：<input type="email" name="password" value=""></p>
    <p>パスワード：<input type="password" name="password" value=""></p>
    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']) ?>">
<p><input type="submit" value="新規登録！"><a href="index.php">戻る</a></p>
</form>
</body>
