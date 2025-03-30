<?php
require_once('db.php');
session_start();
$_SESSION['err']='';
$eroor='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $title=trim($_POST['title']);
  $description=trim($_POST['description']);
  $price=trim($_POST['price']);
  $img=trim($_POST['img']);
  $isValid = true;
    
  if (empty($title)) {
      $_SESSION['err'] = 'Title is required.';
      $isValid = false;
  }
  elseif (empty($description)) {
      $_SESSION['err'] = 'Description is required.';
      $isValid = false;
  }
  elseif (!is_numeric($price) || $price <= 0) {
      $_SESSION['err'] = 'Price must be a positive number.';
      $isValid = false;
  }
  elseif (empty($img)) {
      $_SESSION['err'] = 'Image URL is required.';
      $isValid = false;
  }
  elseif (!filter_var($img, FILTER_VALIDATE_URL)) {
      $_SESSION['err'] = 'Invalid image URL.';
      $isValid = false;
  }
if($isValid)
{
try{            $pdo->beginTransaction();

$stmt=$pdo->prepare("INSERT into products (title,description,image,price) VALUES (:title,:description,:image,:price)");
$stmt->execute([':title'=>$title,
':description'=>$description,':image'=>$img ,':price'=>$price
]);
$pdo->commit();
unset($_SESSION['err']);

header('Location: index.php');
exit();

}
catch(PDOException $e){
  $pdo->rollBack();

error_log('failed to add product'.$e->getMessage());
$_SESSION['err'] = 'Failed to save product. Please try again.';

exit();
}
}else{
  $eroor='please fill all fildes';
  header('Location: product_form.php');
}

}