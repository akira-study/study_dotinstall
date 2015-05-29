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
