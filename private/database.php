<?php
/* ----------------------------------------------------------------------
 * データベースの設定定義
 *
 * DB_HOST: データベースサーバのホスト名
 * DB_PORT: データベースサーバのポート
 * DB_NAME: データベース名
 * DB_USER: データベースにアクセスする際に利用するユーザ
 * DB_PASSWORD: データベースにアクセスする際に利用するユーザのパスワード
 * ---------------------------------------------------------------------- */
define('DB_HOST', 'database-k.cqri7qvgc2h0.ap-northeast-1.rds.amazonaws.com');
define('DB_PORT', 3306);
define('DB_NAME', 'users');
define('DB_USER', 'developer');
define('DB_PASSWORD', 'Jagapote0511');

/* ------------------------------
 * データベースハンドラ
 * データベースへの各種操作を行う
 * ------------------------------ */
$dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4;', DB_USER, DB_PASSWORD);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラー発生時は例外を出すようにする
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
