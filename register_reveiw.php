<?php
require_once 'private/database.php';
/* --------------------
 * セッション開始
 * -------------------- */
session_start();
/* ------------------------------
 * 送られてきた値を取得する
 * セッションにも保存しておく
 * ------------------------------ */
$name = $_POST['name'];
$content =  $_POST['content'];
$_SESSION['name'] = $name;
$_SESSION['content'] = $content;

/* --------------------------------------------------
 * 値のバリデーションを行う
 *
 * 入力された値が正しいフォーマットで送られているかを確認する
 * 今回は値が入力されているかのみを確認する
 * -------------------------------------------------- */
if(empty($name) == true || empty($content) == true) {
  require_once 'private/failure_post.php';
}

$statement = $dbh->prepare('SELECT name FROM user_articles WHERE name = :name');
$statement->execute([
    'name' => $name,
    ]);
if($statement->rowCount() != 0){
    unset($_SESSION['name']);
    unset($_SESSION['content']);
    header('location:register.php', true, 307);
    exit;
}

/* ----------------------------------------
 * 確認画面と登録画面で利用するトークンを発行する
 * 今回は時刻をトークンとする
 * ---------------------------------------- */
$token = strval(time());
$_SESSION['token'] = $token;
?>
<!-- 描画するHTML -->
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登録確認</title>
</head>
<body>
    <header>
        <h1>確認</h1>
    </header>
    <main>
        <div>下記の内容で登録しますがよろしいですか?</div>
        <table>
            <tbody>
            <tr><th>ユーザー名</th><td><?= htmlspecialchars($name); ?></td></tr>
            <tr><th>パスワード</th><td><?= htmlspecialchars($content); ?></td></tr>
            </tbody>
        </table>
        <form action="register_complete.php" method="post">
            <input type="hidden" name="token" value="<?= $token ?>">
            <button type="submit">登録</button>
        </form>
    </main>
    <footer>
        <hr>
    </footer>
</body>
</html>
