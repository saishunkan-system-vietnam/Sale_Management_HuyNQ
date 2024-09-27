
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li><a href="#">Products</a></li>
				<li><a href="#">Category</a></li>
				<li class="active">Product Name Goes Here</li>
			</ul>
		</div>
	</div>
	<!-- /BREADCRUMB -->

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!--  Product Details -->
				<div class="product product-details clearfix">
					<div class="col-md-6">
						<div id="product-main-view">
							<?php foreach ($product['images'] as $value): ?>
								<div class="product-view">
									<img src="/img/<?= $value['name'] ?>" alt="">
								</div>
							<?php endforeach ?>
						</div>
						<div id="product-view">
							<?php foreach ($product['images'] as $value): ?>
								<div class="product-view">
									<img src="/img/<?= $value['name'] ?>" alt="">
								</div>
							<?php endforeach ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="product-body">
							<!-- <div class="product-label">
								<span>New</span>
								<span class="sale">-20%</span>
							</div> -->
							<h2 class="product-name"><?= $product['name'] ?></h2>
							<?php if (empty($product['Sales']['id'])) { ?>
								<h3 class="product-price"><?= $this->number->format($product['price']) ?> đ</h3>
							<?php } else { ?>
								<h3 class="product-price"><?= $this->Number->format($product['price'] - $product['price']*$product['Sales']['value']/100) ?> đ <del class="product-old-price"><?= $this->Number->format($product->price) ?> đ</del></h3>
							<?php } ?>
							<p><strong>Quantity:</strong> <?= $this->number->format($product['quantity']) ?></p>
							<p><strong>Availability:</strong> In Stock</p>
							<p><strong>Brand:</strong> <?= $product['category']['parentName'] ?></p>
							<div class="product-options">
								<table class="shopping-cart-table table">
							        <?php foreach ($product['attributes'] as $attribute): ?>
							            <tr>
							                <!-- <th scope="row"><?= $attribute->parentName ?></th> -->
							                <td><?= $attribute->name ?></td>
							            </tr>
							        <?php endforeach ?>
							    </table>
							</div>

							<div class="product-btns">
								<input style="text-align: center;" type="number" name="quantity" value="1" min="1" max="5" />
								<button  style="margin-left: 20px;" product_id="<?= h($product->id) ?>" class="primary-btn add2cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="product-tab">
							<ul class="tab-nav">
								<li><a data-toggle="tab" href="#tab1">Description</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab1" class="tab-pane fade in active">
									<p><?= $product['description'] ?></p>
								</div>
							</div>
						</div>
				</div>
				<!-- /Product Details -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

<?= $this->Html->script('home.js') ?>
