<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once 'private/database.php';
session_start();
$name = $_SESSION['name'];
if(empty($_SESSION['name']) == true){
   require_once'private/failure_post.php';
}
$statement = $dbh->prepare('SELECT * FROM  `bbs` ORDER BY `id` DESC');
$statement->execute();
$articles = $statement->fetchAll();
?>
<!doctype html>
<?php require_once 'private/database.php'; ?>
<html lang="ja">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>onegai</title>
    <nav role="navigation">
      <div class="center-block">
        <a href="logout.php" class="btn btn-danger">ログアウト</a>
        </div>
                </nav>
</head>
  <body>
    <header>
      <h1>SNS</h1>
    </header>
    <div>
        <form action="confirm.php" method="post">
            <table>
                <thead>
                <tr>
                    <th colspan="2">新規投稿</th>
                  </tr>
              </thead>
              <tbody>
              <tr>
                  <th><label for="name">名前</label></th>
                  <td><name="name" id="name"><?= $name ?></td>
              </tr>
              <tr>
                  <th><label for="content">投稿内容</label></th>
                  <td><textarea name="content" id="content" rows="2" required></textarea></td>
              </tr>
              <tr>
                  <th><label for="picture">画像</th>
                  <td><input type="file" name="picture" accept="image/*"></td>
              </tr>
              <tr>
                  <td><button type="submit" class="btn btn-outline-success">投稿</button></td>
              </tr>
              </tbody>
          </table>
      </form>
  </div>
  <?php foreach ($articles as $article) { ?>
      <li>
          <div>
              <?= $article['id'] ?>:&nbsp;<?=htmlspecialchars($article['name']); ?>:&nbsp;<?= $article['created_at'] ?>
          </div>
          <div><?= nl2br(htmlspecialchars($article['content'])); ?></div>
          <div style="display: inline-flex;">
              &nbsp;
              <form action="confirm_delete.php" method="post">
                  <input type="hidden" name="id" value="<?= $article['id'] ?>">
                  <button type="submit" class="btn btn-outline-warning" style="width:90px;height:40px">削除依頼</button>
              </form>
          </div>
      </li>
      <br/>
  <?php } ?>
</body>
</html>
