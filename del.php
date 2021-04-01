<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
session_start();
if($_SESSION['name'] != "developer") {
    redirect('/top.php');
}
?>
<!doctype html>
<?php
  require_once 'private/database.php';
  require_once 'private/bootstrap.php';
  $statement = $dbh->prepare('SELECT * FROM  `bbs` ORDER BY `id` DESC');
  $statement->execute();
  $articles = $statement->fetchAll();
?>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>onegai</title>
    <nav role="navigation">
      <div class="center-block">
        <a href="top.php" class="btn btn-danger">戻る</a>
      </div>
    </nav>
</head>
  <body>
    <header>
      <h1>SNS</h1>
    </header>
     <form action="del_complete.php" method="post">
     <input type="submit" value="削除" class="btn btn-outline-danger">
<?php  foreach ($articles as $article) { ?>
      <hr>
          <div>
          <input type="checkbox" name="id[]" value="<?= $article['id']; ?>"
          </div>
          <div>
          <?= htmlspecialchars($article['name']); ?>:&nbsp;<?= $article['created_at'] ?>
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
  <?php } ?>
   </form>
   </div>
</body>
<footer>
<a href="">削除依頼ご意見ご要望</a>
</footer>
</html>

