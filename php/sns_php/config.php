<?php 
// PDOで接続
define('DSN', 'mysql:host=localhost;dbname=dotinstall_sns_php');
// データベースのユーザ名
define('DB_USER', 'dbuser');
// データベースのパスワード
define('DB_PASSWORD', 'vagrant');

// サイトURL
define('SITE_URL', 'http://akira.study/dotinstall/php/sns_php/');
// 暗号化(ハッシュ化?)
define('PASSWORD_KEY', 'vagrant');

// エラー出力(Notice以外全て出力)
error_reporting(E_ALL & ~E_NOTICE);

// セッションによるログイン管理(このディレクトリでのみセッション有効)
session_set_cookie_params(0, 'dotinstall/php/sns_php/'); // 詳しく調べる
