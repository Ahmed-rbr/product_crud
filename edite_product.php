<?php
require_once "db.php";

session_start();
$_SESSION['title']=null;
$_SESSION['description']=null;
$_SESSION['img']=null;
$_SESSION['price']=null;
$_SESSION['id']=null;
$_SESSION['err']=null;

if(isset($_POST['edite'])){
 $id=$_POST['id'];
try{
  $pdo->beginTransaction();

  $stmt=$pdo->prepare('SELECT * from products where id=:id');

  $stmt->execute([':id'=>$id]);

  $result=$stmt->fetch();
  if($result){
  $_SESSION['title']=$result['title'];
  $_SESSION['description']=$result['description'];
  $_SESSION['img']=$result['image'];
  $_SESSION['price']=$result['price'];
  $_SESSION['id']=$result['id'];
  $pdo->commit();

header('Location: edit_form.php');exit();
}else{
  $pdo->rollBack();
  $_SESSION['err']='Product do not existe';
  header('Location: index.php');
            exit();
}

}
catch(PDOException $e){
  if($pdo->inTransaction()){
    $pdo->rollBack();
  }
  error_log("fialed to conect".$e->getMessage());
  
  header('Location: index.php');
  exit();
  }
  
}

elseif(isset($_POST['edt-form'])){
$id=$_POST['id'];
$title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');

    $errors = [];
    
    if (empty($title)) $errors[] = "Title is required";
    if (empty($description)) $errors[] = "Description is required";
    if (!is_numeric($price) || $price <= 0) $errors[] = "Price must be a positive number";

if(empty($errors)){
  $img = $_FILES['img']?? '';
$imgPath='';

if($img && $img['error']=== UPLOAD_ERR_OK){
  $allowsExt = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
  $fileExt = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
if(!in_array($fileExt,$allowsExt)){
  $errors[] = "select only png jpg gif  images ";
}else{
$uplodePath='img/'.uniqid().'/';
if(!file_exists($uplodePath)){
  mkdir($uplodePath,0755,true);
}else{
  $errors[] = "failed to create dir";

}
$imgPath=$uplodePath.basename($img['name']);
if(!move_uploaded_file($img['tmp_name'], $imgPath)){
  $errors[] = "failed to save image";

}


}

}else{
  $errors[] = "please selecte valid img";

}


}


    if(empty($errors)){
try{$pdo->beginTransaction();
  $stmt=$pdo->prepare('UPDATE products SET title=:title, description=:description, image=:image, price=:price WHERE id=:id');
  $stmt->execute([':title'=>$title,
  ':description'=>$description,':image'=>$imgPath ,':price'=>$price,':id'=>$id
]);
$pdo->commit();
header('Location: index.php');
exit();

}
catch(PDOException $e){
  if($pdo->inTransaction()) {
    $pdo->rollBack();
}
error_log('Failed to update: '.$e->getMessage());
$_SESSION['err'] = ['Failed to update product'];
$_SESSION['title'] = $title;
$_SESSION['description'] = $description;
$_SESSION['img'] = $imgPath;
$_SESSION['price'] = $price;
$_SESSION['id'] = $id;
header('Location: edit_form.php?id='.$id);
exit();
}
} else {
$_SESSION['err'] = $errors;
$_SESSION['title'] = $title;
$_SESSION['description'] = $description;
$_SESSION['img'] = $imgPath;
$_SESSION['price'] = $price;
$_SESSION['id'] = $id;
header('Location: edit_form.php?id='.$id);
exit();
}
} else {
header('Location: index.php');
exit();
}