<?php foreach ($products as $product): ?>
<!-- Product Single -->
<div class="product col-md-3 col-sm-6 col-xs-6">
	<div class="product product-single">
		<a href="/products/<?= $product->id ?>">
			<div style="width: 262px; height: 262px;"  class="product-thumb">
				<?php if($product->Images['name'] !== null){ ?>
				<img src="img/<?= $product->Images['name'] ?>" alt="">
				<?php }else{ ?>
				<img src="img/default.PNG" alt="">
				<?php } ?>
			</div>
		</a>
		<div class="product-body">
			<h3 class="product-price"><?= $this->Number->format($product->price) ?> VNĐ</h3>
			<h2 class="product-name"><a href="/products/<?= $product->id ?>"><?= h($product->name) ?></a></h2>
			<div class="product-btns">
				<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
				<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
				<input type="hidden" name="quantity" value=1>
				<button product_id="<?= h($product->id) ?>" class="primary-btn add2cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
			</div>
		</div>
	</div>
</div>
<!-- /Product Single -->
<?php endforeach; ?>
