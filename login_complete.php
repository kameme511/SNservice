<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
/* ------------------------------
 * 必要なファイルを読み込む
 * ------------------------------ */
require_once 'private/database.php';

/** @var PDO $dbh データベースハンドラ */

/* --------------------
 * セッション開始
 * -------------------- */
session_start();
/* ------------------------------
 * 送られてきた値を取得する
 * ------------------------------ */
$token = $_POST['token'];
$name = $_POST['name'];
$content = $_POST['content'];

/* --------------------------------------------------
 * 送られてきたトークンのバリデーション
 *
 * セッションに保存されているトークンと比較し、
 * 一致していなかった場合はトップ画面にリダイレクトする
 * -------------------------------------------------- */
 if($token != $_SESSION['token'] || empty($name) == true || empty($content) == true){
     unset($_SESSION['token']);
     require_once 'private/failure_post.php';
 }

/* --------------------
 * データのselect処理
 * -------------------- */
$statement = $dbh->prepare('SELECT content FROM `user_articles` WHERE name=:name');
$statement->execute([
    'name' => $name,
    ]);
$result = $statement->fetch();
/* ----------------------------------------
 * セッション内のデータを削除する
 * ---------------------------------------- */
unset($_SESSION['token']);
if($result['content'] != $content){
  require_once 'private/pfailure_post.php';
}
$_SESSION['name'] = $name;
?>

<!-- 描画するHTML -->
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>おかえりなさい</title>
</head>
<body>
    <header>
        <h1>おかえりなさい、<?= $name ?>さん</h1>
    </header>
    <main>
        <a href="top.php">トップページへ</a>
    </main>
    <footer>
        <hr>
    </footer>
</body>
</html>
