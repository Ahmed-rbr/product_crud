<?php 
require_once('db.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
$id=$_POST['id'];

}
try{
$pdo->beginTransaction();

$stmt=$pdo->prepare('DELETE from products where id=:id');

$stmt->execute([':id'=>$id]);
$pdo->commit();
header('Location: index.php');
exit();
}
catch(PDOException $e){
error_log("fialed to conect".$e->getMessage());

header('Location: index.php');
exit();
}
