<?php
require_once "db.php";

try{
$sql='SELECT * FROM products order by creat_date desc';
$stmt=$pdo->prepare($sql);
$stmt->execute();
$products=$stmt->fetchAll(PDO::FETCH_ASSOC);


}catch(PDOException $e){

  echo 'failed to get products'.$e->getMessage();
}