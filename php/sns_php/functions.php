<?php 

function connectDb() {
    try {
        // データベースに接続する処理
        return new PDO(DSN, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        // 例外処理
        echo $e->getMessage();
        exit;
    }
}

function h($s) {
    // htmlspecialcharsを短い名前で使用
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

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
    // SQL文発行
    $sql = "select * from users where email = :email limit 1";
    // プリペアドステートメント実行
    $stmt = $dbh->prepare($sql);
    // クエリ実行
    $stmt->execute(array(":email" => $email));
    // 値取得
    $user = $stmt->fetch();
    return $user ? true : false;
}

function getSha1Password($s) {
    return (sha1(PASSWORD_KEY.$s));
}
