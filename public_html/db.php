<?php
try {
  $db = new PDO("mysql:host=localhost;dbname=chatdb.chattb;charset=utf8","root","");
  echo "接続OK！";
} catch (PDOException $e) {
  echo 'DB接続エラー！: ' . $e->getMessage();
}
?>