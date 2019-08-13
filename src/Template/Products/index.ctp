<!-- <p id="demo"></p> -->
<!-- section -->
<div class="section">
	<!-- container -->
	<div class="container">
		<div class="col-md-2">
			<div>
				<?php foreach ($attributes as $attribute): ?>
					<div class="form-group">
						<label><?= $attribute['name'] ?></label>
						<?php foreach ($attribute['options'] as $attr): ?>
							<!-- <a href="/search/<?= strtolower(str_replace(' ','-',$attribute['name'])).'='.$attr['id'] ?>"><p><?= $attr['name'] ?></p></a> -->
							<a type="submit" href="javascript:setParam('<?= strtolower(str_replace(' ','-',$attribute['name'])) ?>','<?= $attr['id'] ?>');"><p <?php if(isset($options) && in_array($attr['id'], $options)) { ?> style="color: red;" <?php } ?>><?= $attr['name'] ?></p></a>
						<?php endforeach ?> 
						<hr>   
					</div>
				<?php endforeach ?> 
			</div>
		</div>
		<!-- row -->
		<div class="row col-md-10">
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- Search -->
						<div class="header-search">
							<div>
							<!-- <form id="keyword_form"> -->
								<input class="input search-input" id="keyword" name="keyword" type="text" placeholder="Enter your keyword" <?php if (isset($keyword)) { ?> value="<?= $keyword ?>" <?php } ?>>
								<button class="search-btn"><i class="fa fa-search"></i></button>
							<!-- </form> -->
							</div>
							<select class="form-control" id="price" name="price">
								<option value="" selected disabled hidden>--Choose price--</option>
								<option <?php if (isset($price) && $price == 'asc') { ?> selected <?php } ?> value="asc">Low to High</option>
								<option <?php if (isset($price) && $price == 'desc') { ?> selected <?php } ?> value="desc">High to Low</option>
							</select>
						</div>
						<!-- /Search -->

						<!-- section title -->
						<div class="col-md-12">
							<div class="section-title">
								<h2 class="title">List Products</h2>
							</div>
						</div>
						<!-- section title -->
						<div id="product_list">
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
												<button product_id="<?= h($product->id) ?>" class="main-btn icon-btn compare"><i class="fa fa-exchange"></i></button>
												<input type="hidden" name="quantity" value=1>
												<button product_id="<?= h($product->id) ?>" class="primary-btn add2cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
											</div>
										</div>
									</div>
								</div>
								<!-- /Product Single -->
							<?php endforeach; ?>
						</div>
					</div>
					<div class="paginator">
						<ul class="pagination">
							<?= $this->Paginator->first('<< ' . __('first')) ?>
							<?= $this->Paginator->prev('< ' . __('previous')) ?>
							<?= $this->Paginator->numbers() ?>
							<?= $this->Paginator->next(__('next') . ' >') ?>
							<?= $this->Paginator->last(__('last') . ' >>') ?>
						</ul>
						<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>

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
				<!-- section-title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">Deals Of The Day</h2>
						<div class="pull-right">
							<div class="product-slick-dots-1 custom-dots"></div>
						</div>
					</div>
				</div>
				<!-- /section-title -->

				<!-- banner -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="banner banner-2">
						<img src="/Home/img/banner14.jpg" alt="">
						<div class="banner-caption">
							<h2 class="white-color">NEW<br>COLLECTION</h2>
							<button class="primary-btn">Shop Now</button>
						</div>
					</div>
				</div>
				<!-- /banner -->

				<!-- Product Slick -->
				<div class="col-md-9 col-sm-6 col-xs-6">
					<div class="row">
						<div id="product-slick-1" class="product-slick">
							<!-- Product Single -->
							<div class="product product-single">
								<div class="product-thumb">
									<div class="product-label">
										<span>New</span>
										<span class="sale">-20%</span>
									</div>
									<ul class="product-countdown">
										<li><span>00 H</span></li>
										<li><span>00 M</span></li>
										<li><span>00 S</span></li>
									</ul>
									<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
									<img src="/Home/img/product01.jpg" alt="">
								</div>
								<div class="product-body">
									<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
									<div class="product-rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-o empty"></i>
									</div>
									<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
									<div class="product-btns">
										<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
										<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
										<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<!-- Product Single -->
							<div class="product product-single">
								<div class="product-thumb">
									<div class="product-label">
										<span class="sale">-20%</span>
									</div>
									<ul class="product-countdown">
										<li><span>00 H</span></li>
										<li><span>00 M</span></li>
										<li><span>00 S</span></li>
									</ul>
									<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
									<img src="/Home/img/product07.jpg" alt="">
								</div>
								<div class="product-body">
									<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
									<div class="product-rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-o empty"></i>
									</div>
									<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
									<div class="product-btns">
										<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
										<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
										<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<!-- Product Single -->
							<div class="product product-single">
								<div class="product-thumb">
									<div class="product-label">
										<span>New</span>
										<span class="sale">-20%</span>
									</div>
									<ul class="product-countdown">
										<li><span>00 H</span></li>
										<li><span>00 M</span></li>
										<li><span>00 S</span></li>
									</ul>
									<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
									<img src="/Home/img/product06.jpg" alt="">
								</div>
								<div class="product-body">
									<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
									<div class="product-rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-o empty"></i>
									</div>
									<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
									<div class="product-btns">
										<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
										<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
										<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<!-- Product Single -->
							<div class="product product-single">
								<div class="product-thumb">
									<div class="product-label">
										<span>New</span>
										<span class="sale">-20%</span>
									</div>
									<ul class="product-countdown">
										<li><span>00 H</span></li>
										<li><span>00 M</span></li>
										<li><span>00 S</span></li>
									</ul>
									<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
									<img src="/Home/img/product08.jpg" alt="">
								</div>
								<div class="product-body">
									<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
									<div class="product-rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-o empty"></i>
									</div>
									<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
									<div class="product-btns">
										<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
										<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
										<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
									</div>
								</div>
							</div>
							<!-- /Product Single -->
						</div>
					</div>
				</div>
				<!-- /Product Slick -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
<?= $this->Html->script('home.js') ?>