<?php
session_start();
$name = $_SESSION['name'];
if(empty($name) == true){
     require_once 'private/failure_post.php';
 }
unset($_SESSION['name']);
?>

<!-- 描画するHTML -->
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログアウトしました。</title>
</head>
<body>
    <header>
        <h1>またお越しください、<?= $name ?>さん</h1>
    </header>
    <main>
        <a href="/">戻る</a>
    </main>
    <footer>
        <hr>
    </footer>
</body>
</html>
