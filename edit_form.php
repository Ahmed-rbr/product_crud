<?php
session_start();
$title= $_SESSION['title']??'';
$price= $_SESSION['price']??'';
$id= $_SESSION['id']??'';
$description=$_SESSION['description']??'';
$img= $_SESSION['img']??'';
$errors = $_SESSION['err'] ?? [];
 unset($_SESSION['err']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add-product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<form action="edite_product.php" method="post" class="row g-3 mt-5 w-50 mx-auto border border-2 p-4 shadow-sm rounded border-primary">
<a class="btn btn-outline-danger" href="index.php" role="button">back home</a>

<h2>Add Product:</h2>
 
 <?php if(!empty($errors)): ?>
      <div class="alert alert-danger">
        <?php foreach($errors as $error): ?>
          <p class="mb-1"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
 <div class="col-12">
    <label for="title" class="form-label">Title:</label>
    <input type="text" value="<?= htmlspecialchars($title)?>" name="title" class="form-control" id="title">

  </div>
  <div class="col-12">
  <label for="description" class="form-label">description:</label>
  <textarea class="form-control"  placeholder="enter description" name="description" id="description"><?=isset($description)? htmlspecialchars($description):'' ?></textarea>

</div>
  <div class="col-12">
    <label for="price" step="0.01" class="form-label">Price:</label>
    <input type="number" value="<?=htmlspecialchars( $price)?>" name="price" class="form-control" id="price" placeholder="120...">
  </div>
<input type="hidden" name="id" value="<?= htmlspecialchars($id) ?? ''?>">
  <div class="col-12">
    <label for="img" class="form-label">Product img:</label>
    <input type="text" class="form-control" value="<?=htmlspecialchars( $img)?>" name="img" id="img" placeholder="paste your URL">

  </div>
  
 
  
  
  <div class="col-12">
    <button type="submit" name="edt-form" class="btn btn-primary w-100">Submit</button>
  </div>
</form>
</body>
</html>