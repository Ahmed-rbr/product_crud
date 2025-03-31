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
  <body><div class="div"><h1>Product crud!</h1>
    <p>
      <a href="product_form.php" class="btn btn-success">Create</a>
    </p></div>
    
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">image</th>

      <th scope="col">product</th>
      <th scope="col">description</th>
      <th scope="col">price</th>
      <th  scope="col"> Create Date</th>
      <th  scope="col"> Action</th>
      </tr>
  </thead>
  <tbody>
  <?php if(!empty($products)): ?>

  <?php foreach($products as $product):?>

  <tr>
      <th scope="row"><?= htmlspecialchars( $product['id']) ?? '' ?></th>
      <td><?= !empty($product['image']) ? '<img src="' . htmlspecialchars($product['image']) . '" width="50">' : 'no img' ?></td>
      <td>  <?=htmlspecialchars( $product['title'])?? '' ?></td>
      <td>  <?=htmlspecialchars( $product['description'])?? '' ?></td>
      <td>  <?=htmlspecialchars( $product['price'])??''?></td>
      <td>  <?= htmlspecialchars($product['creat_date'])?? ''?></td>
    <td>
     <form style="display:inline-block ;" action="edite_product.php" method="post">
      <input type="hidden" name="id" value="<?= htmlspecialchars( $product['id']) ?? '' ?>" >
      <button type="submit" name="edite" class="btn btn-sm btn-outline-primary">Edit</button>
      </form>



     <form style="display:inline-block ;" action="delete_product.php" method="post">
      <input type="hidden" name="id" value="<?= htmlspecialchars( $product['id']) ?? '' ?>" >
      <button type="submit" name="delete" class="btn btn-sm btn-outline-danger">Delete</button></form>

  </td>
    </tr>
    <?php endforeach;?>
    <?php endif?>

  
  </tbody>
</table>
  </body>
</html>