<?php
require_once 'private/bootstrap.php';
require_once 'private/database.php';

/** @var PDO $dbh データベースハンドラ */

/* ------------------------------
 * 送られてきた値を取得する
 * セッションにも保存しておく
 * ------------------------------ */
session_start();
$name = $_SESSION['name'];
$id = $_POST['id'];
/* --------------------------------------------------
 * 値のバリデーションを行う
 *
 * 1.値が入力されているか
 * 2.データベースに対象IDのレコードが存在するか
 * -------------------------------------------------- */
// 1.値が入力されているか
if(empty($id) == true) {
    redirect('/top.php');
}

// 2.データベースに対象IDのレコードが存在するか
$statement = $dbh->prepare('SELECT * FROM `bbs` WHERE id = :id');
$statement->execute([
    'id' => $id,
    ]);
$article = $statement->fetch();
if($article == false) {
    redirect('/top.php');
}

/* ----------------------------------------
 * 編集画面と編集完了画面で利用するトークンを発行する
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
    <title>投稿編集</title>
    <style>
        textarea {
            resize: vertical;
        }
        textarea, input[type=text] {
            border: solid 1px gray;
            padding: 4px;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>投稿編集</h1>
    </header>
    <main>
      <hr>
          <div>
              <?=htmlspecialchars($article['name']); ?>:&nbsp;<?= $article['created_at'] ?>
          </div>
          <div style="display: inline-flex;">
          <?php
          if(isset($article['picture'])){
          echo "<div>";
          echo '<img src ='.$article['picture'].' class="img-fluid">';
          echo "</div>";
          }
          ?>
          </div>
          <div><?= nl2br(htmlspecialchars($article['content'])); ?></div>
      <br/>
      <br/>
      <br/>
        <form action="comment_complete.php" method="post">
            <input type="hidden" name="token" value="<?= $token ?>">
            <input type="hidden" name="id" value="<?= $id ?>">
            <table>
                <tbody>
                <tr>
                    <th><label for="name">名前</label></th>
                    <td><name="name" id="name"><?= $name ?></td>
                </tr>
                <tr>
                    <th><label for="content">投稿内容</label></th>
                    <td><textarea name="content" id="content" rows="4" required></textarea></td>
                </tr>
                </tbody>
            </table>
            <button type="submit">投稿</button>
        </form>
    </main>
    <footer>
        <hr>
        <div>＿φ(ω　)</div>
    </footer>
</body>
</html>

