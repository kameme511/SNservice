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

/* --------------------------------------------------
 * 送られてきたトークンのバリデーション
 *
 * セッションに保存されているトークンと比較し、
 * 一致していなかった場合はトップ画面にリダイレクトする
 * -------------------------------------------------- */
if($token != $_SESSION['token']) {
    unset($_SESSION['token']);
    require_once 'private/failure_post.php';
}

/* ----------------------------------------
 * セッション内に保存した投稿内容を取得する
 * ---------------------------------------- */
$name = $_SESSION['name'];
$content = $_SESSION['content'];

/* --------------------
 * データのインサート処理
 * -------------------- */
$statement = $dbh->prepare('INSERT INTO `user_articles`(name, content) VALUE(:name, :content)');
$statement->execute([
    'name' => $name,
    'content' => $content,
    ]);
/* ----------------------------------------
 * セッション内のデータを削除する
 * ---------------------------------------- */
unset($_SESSION['name']);
unset($_SESSION['content']);
unset($_SESSION['token']);

setcookie('userName',$name, time()+60*60*24*14);
?>

<!-- 描画するHTML -->
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登録成功</title>
</head>
<body>
    <header>
        <h1>登録成功</h1>
    </header>
    <main>
        <a href="/">戻る</a>
    </main>
    <footer>
        <hr>
    </footer>
</body>
</html>
