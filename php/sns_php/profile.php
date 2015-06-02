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

// ユーザー情報
$me = $_SESSION['me'];

$dbh = connectDb();

// SQL文発行
$sql = "select * from users where id = :id limit 1";
// プリペアドステートメント作成
$stmt = $dbh->prepare($sql);
// クエリ実行
$stmt->execute(array(":id" => (int)$_GET['id']));
//値取得
$user = $stmt->fetch();

if (!$user) {
    echo "そのようなユーザーはおりません";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザープロフィール</title>
</head>
<body>
<p>
Logged in as <?php echo h($me['name']); ?> (<?php echo h($me['email']); ?>) <a href="logout.php">[logout]</a>
</p>
<h1>ユーザープロフィール</h1>
<p>お名前：<?php echo h($user['name']); ?></p>
<p>メールアドレス：<?php echo h($user['email']); ?></p>
<p><a href="index.php">一覧へ</a></p>
</body>
</html>
