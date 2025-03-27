<?php


$db_host='localhost';
$db_name='products_crud';
$db_user='toto';
$db_pwd='';
$dsn = "mysql:host={$db_host};dbname={$db_name}";

try{
  $pdo=new PDO($dsn,$db_user,$db_pwd);
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
  echo "connection failed".$e->getMessage();
}