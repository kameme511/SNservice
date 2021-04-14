<?php
require_once 'private/database.php';

/** @var PDO $dbh データベースハンドラ */

/* --------------------
 * セッション開始
 * -------------------- */
session_start();
/* ------------------------------
 * 送られてきた値を取得する
 * ------------------------------ */
if(isset($_POST['id']) && is_array($_POST['id'])) {
    $value = $_POST['id'];
}
if(isset($_POST['com_id']) && is_array($_POST['com_id'])){
    $com_value = $_POST['com_id'];
}
/* --------------------------------------------------
 * 送られてきたトークンのバリデーション
 *
 * セッションに保存されているトークンと比較し、
 * 一致していなかった場合はトップ画面にリダイレクトする
 * -------------------------------------------------- */
if($_SESSION['name'] != "developer"){
    redirect('/top.php');
}
if(empty($value) == true && empty($com_value) == true) {
    header('location:/del.php');
}
/* --------------------
 * データのデリート処理
 * -------------------- */
if(isset($value)){
foreach($value as $id){
  $statement = $dbh->prepare('UPDATE `bbs` SET name = "あぼん", content = "削除されました", picture = "" WHERE id = :id');
  $statement->execute([
  'id' => $id,
]);
  }
}
if(isset($com_value)){
foreach($com_value as $com_id){
  $statement2 = $dbh->prepare('UPDATE `comments` SET name = "あぼん", content = "削除されました" WHERE id = :id');
  $statement2->execute([
  'id' => $com_id,
]);
  }
}

?>

<!-- 描画するHTML -->
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>削除成功</title>
</head>
<body>
    <header>
        <h1>削除成功</h1>
    </header>
    <main>
        <a href="top.php">戻る</a>
    </main>
    <footer>
        <hr>
        <div>o(ωk)</div>
    </footer>
</body>
</html>

