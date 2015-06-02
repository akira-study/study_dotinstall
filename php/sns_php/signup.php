<?php

require_once('config.php');
require_once('functions.php');

// ログイン管理セッション
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    /* 
    CSRF対策
    フォームを表示した時にトークンをセット
    フォームがポストされた時に
    そのトークンと上記のトークンが一致しているかどうかチェック
    不正なポストを防ぐ
    */
    setToken();
} else {
    checkToken();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $dbh = connectDb();
    
    $err = array();

    // 名前が空？
    if ($name == '') {
        $err['name'] = 'お名前を入力してください';
    }
    // メールアドレスが正しい？
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err['email'] = 'メールアドレスの形式が正しくありません';
    }

    if (emailExists($email, $dbh)) {
        $err['email'] = 'このメールアドレスは既に登録されております';
    }

    // メールアドレスが空？
    if ($email == '') {
        $err['email'] = 'Eメールを入力してください';
    }
    //　パスワードが空？
    if ($password == '') {
        $err['password'] = 'パスワードを入力してください';
    }

    if (empty($err)) {
        // 登録処理
        // SQL文発行
        $sql = "insert into users
                 (name, email, password, created, modified)
                 values
                 (:name, :email, :password,  now(), now())";
        // プリペアドステートメント作成
        $stmt = $dbh->prepare($sql);
        $params = array(
             ":name" => $name,
             ":email" => $email,
             ":password" => getSha1Password($password)
        );
        // クエリ実行
        $stmt->execute($params);
        header('Location: '.SITE_URL.'login.php');
    }
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
    <p>お名前：<input type="text" name="name" value="<?php echo h($name); ?>"><?php echo h($err['name']); ?></p>
    <p>メールアドレス：<input type="text" name="email" value="<?php echo h($email); ?>"><?php echo h($err['email']); ?></p>
    <p>パスワード：<input type="password" name="password" value=""><?php echo h($err['password']); ?></p>
    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
<p><input type="submit" value="新規登録！"><a href="index.php">戻る</a></p>
</form>
</body>
