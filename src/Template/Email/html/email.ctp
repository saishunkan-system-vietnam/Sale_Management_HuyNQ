<div class="container">
  <h2>Thanks for shopping!</h2>
  <p>Name: <?= $user['name'] ?></p>
  <p>Email: <?= $user['email'] ?></p>
  <p>Phone: <?= $user['phone'] ?></p>
  <p>Address: <?= $user['address'] ?></p>
  <?php if ($password !== ""): ?>
    <p>Your password: <?= $password ?></p>
  <?php endif ?>
  <h2>Product List</h2>          
  <table class="table table-striped">
    <thead>   
      <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr> 
    </thead>
    <tbody>
      <?php foreach ($cart as $value): ?>
      <tr>
        <td><?= $value['name'] ?></td>
        <td><?= $this->Number->format($value['price']) ?></td>
        <td><?= $this->Number->format($value['quantity']) ?></td>
        <td><?= $this->Number->format($value['price']*$value['quantity']) ?></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <h3>Total: <?= $this->Number->format($total) ?> VNĐ</h3>
</div>