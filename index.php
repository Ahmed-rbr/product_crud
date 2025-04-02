<?php
require_once "db.php";

$products = [];

try {
    
    if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
      $searchTerm = '%' . trim($_GET['search']) . '%';
       
      $stmt = $pdo->prepare('SELECT * FROM products WHERE title LIKE :term ORc CAST(description AS CHAR) LIKE :descTerm');
      $stmt->bindValue(':term', $searchTerm, PDO::PARAM_STR);
      $stmt->bindValue(':descTerm', $searchTerm, PDO::PARAM_STR);
        
        $stmt->execute();

       
             
             
    } else {
        $stmt = $pdo->prepare('SELECT * FROM products ORDER BY creat_date DESC');
        $stmt->execute();
    }
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log('Failed to get products: ' . $e->getMessage());
    $products = [];
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="div">
      <h1>Product crud!</h1>
      <p>
        <a href="product_form.php" class="btn btn-success">Create</a>
      </p>
    </div>
    
    <form action="index.php" method="get">
      <div class="w-75 input-group mb-3">
        <input type="text" class="form-control" placeholder="enter Product name" 
               name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button class="btn btn-success" type="submit" id="button-addon2">Search</button>
        <a href="index.php" class="btn btn-outline-secondary">Reset</a>

      </div>
    </form>

    
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
  <?php if(isset($_GET['search']) && empty($products)): ?>
      <div class="alert alert-info">No products found matching your search</div>
    <?php endif; ?>
    
  <?php if(!empty($products)): ?>

  <?php foreach($products as $product):?>

  <tr>
      <th scope="row"><?= htmlspecialchars( $product['id']) ?? '' ?></th>
      <td>
    <?= !empty($product['image']) ? '<img src="' . htmlspecialchars($product['image']) . '" width="50" height="50" style="object-fit:cover; border-radius:5px;">' : '<span class="text-muted">No Image</span>' ?>
</td>
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