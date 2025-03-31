<?php
require_once('db.php');
session_start();
$_SESSION['err']='';
$eroor='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $title=trim($_POST['title']);
  $description=trim($_POST['description']);
  $price=trim($_POST['price']);
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

  if($isValid){
    $img = $_FILES['img'] ?? null;
        $imgPath='';

    if($img&&$img['error']===UPLOAD_ERR_OK){
$allowsEX=['image/png','image/jpeg','image/gif'];
$fileExt = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));

if(!in_array($fileExt,$allowsEX)){
  $_SESSION['err'] = 'Only chosse PNG,JPG,GIF images.';
  $isValid = false;
}
else{
$uplodPath='img/'.uniqid().'/';
if(!file_exists($uplodPath)){
mkdir($uplodPath,0755,true);

}
$imgPath=$uplodPath.basename($img['name']);

if(!move_uploaded_file($img['tmp_name'],$imgPath)){
  $_SESSION['err'] = 'Failed to save image.';
  $isValid = false;
}}
}
}
else{$_SESSION['err'] = 'Please select a valid image file.';
  $isValid = false;
    }
}

if($isValid){

try{          

   $pdo->beginTransaction();

 $stmt=$pdo->prepare("INSERT into products (title,description,image,price) VALUES (:title,:description,:image,:price)");
 $stmt->execute([':title'=>$title,
 ':description'=>$description,':image'=>$imgPath ,':price'=>$price
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



