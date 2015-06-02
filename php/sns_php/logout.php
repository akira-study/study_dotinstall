<?php

require_once('config.php');
require_once('functions.php');

// ログイン管理セッション
session_start();

// $_SESSION 初期化
$_SESSION = array();

// セッションで使っているクッキーを消去
if (isset($_COOKIE[session_name()])) {
    // 空のデータ('')を与え
    // 有効期限を過去のものにして(86400秒/日)
    // このセッションんが有効だった場所を記述
    setcookie(session_name(), '', time()-86400, '/dotinstall/php/sns_php');
}

// サーバー側のセッション情報の削除
session_destroy();

// login.phpへ
header('Location: '.SITE_URL.'login.php');
