<?php require_once 'showProducts.php'; ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1>Product crud!</h1>
    <table class="table">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">product</th>
      <th scope="col">image</th>
      <th scope="col">price</th>
    </tr>
  </thead>
  <tbody>
  <?php if(!empty($products)){ ?>

  <?php foreach($products as $product){?>

  <tr>
      <th scope="row"><?= $product['id']?></th>
      <td>  <?= $product['title']?></td>
      <td>  <?= $product['image'] ?? 'no img'?></td>
      <td>  <?= $product['price']?></td>
    
    </tr>
    <?php }?>
    <?php }?>

  
  </tbody>
</table>
  </body>
</html>