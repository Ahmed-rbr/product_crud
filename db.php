<?php


define('DBNAME','products_crud');
define('DBHOST','localhost');
define('DBPWD','');
define('DBUSER','toto');

$dsn=('mysql:host='.DBHOST.';dbname='.DBNAME.';charset=utf8mb4');
$option=[
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_EMULATE_PREPARES=>false,
  PDO::ATTR_PERSISTENT=>false,
  PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
];
try{


$pdo=new PDO($dsn,DBUSER,DBPWD,$option);
}
catch(PDOException $e){
  error_log("connection failed".$e->getMessage()) ;
  die('could not connect to db');
}