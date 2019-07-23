
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
							<h3 class="product-price"><?= $product['price'] ?> VNĐ</h3>
							<p><strong>Availability:</strong> In Stock</p>
							<p><strong>Brand:</strong> <?= $product['category']['parentName'] ?></p>
							<div class="product-options">
								<table class="shopping-cart-table table">
							        <?php foreach ($product['attributes'] as $attribute): ?>
							            <tr>
							                <th scope="row"><?= $attribute->parentName ?></th>
							                <td><?= $attribute->name ?></td>
							            </tr>
							        <?php endforeach ?>
							    </table>
							</div>

							<div class="product-btns">
								<div class="qty-input">
									<span class="text-uppercase">QTY: </span>
									<input class="input" type="number">
								</div>
								<button product_id="<?= h($product->id) ?>" class="primary-btn add2cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
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

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">Picked For You</h2>
					</div>
				</div>
				<!-- section title -->
				<?php foreach ($moreProduct as $value): ?>
				<!-- Product Single -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="product product-single">
						<div class="product-thumb">
							<img style="width: 262px; height: 250px;" src="/img/<?= $value['image'] ?>" alt="">
						</div>

						<div class="product-body">
							<h3 class="product-price"><?= $value['price'] ?></h3>
							<h2 class="product-name"><a href="/products/<?= $value->id ?>"><?= $value['name'] ?></a></h2>
							<div class="product-btns">
								<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
								<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
								<button product_id="<?= h($value->id) ?>" class="primary-btn add2cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /Product Single -->
				<?php endforeach ?>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>

<?= $this->Html->script('home.js') ?>
