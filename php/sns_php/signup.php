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
    if (empty($_SESSION['token']) || ($_SESSION['token']) != $_POST['token']) {
        echo "不正なPOSTが行われました！";
        exit;
    }
}

function emailExists($email, $dbh) {
    $sql = "select * from users where email = :email limit 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(":email" => $email));
    $user = $stmt->fetch();
    return $user ? true : false;
}

function getSha1Password($s) {
    return (sha1(PASSWORD_KEY.$s));
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
        $sql = "insert into users
                 (name, email, password, created, modified)
                 values
                 (:name, :email, :password,  now(), now())";
        $stmt = $dbh->prepare($sql);
        var_dump($stmt);
        $params = array(
             ":name" => $name,
             ":email" => $email,
             ":password" => getSha1Password($password)
         );
         var_dump($params);
         exit;
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
