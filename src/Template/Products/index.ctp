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
						<div>
							<div class="header-search col-md-3">
								<div>
									<input class="input search-input" id="keyword" name="keyword" type="text" placeholder="Enter your keyword" <?php if (isset($keyword)) { ?> value="<?= $keyword ?>" <?php } ?>>
									<button class="search-btn"><i class="fa fa-search"></i></button>
								</div>
							</div>
							<div class="col-md-2">
								<select class="form-control" id="price" name="price">
									<option value="" selected disabled hidden>--Choose price--</option>
									<option <?php if (isset($price) && $price == 'asc') { ?> selected <?php } ?> value="asc">Low to High</option>
									<option <?php if (isset($price) && $price == 'desc') { ?> selected <?php } ?> value="desc">High to Low</option>
								</select>
							</div>
							<div class="col-md-2">
								<select class="form-control" id="sale" name="sale">
									<option value="" selected disabled hidden>--Choose sale--</option>
									<option value="asc">Low to High</option>
									<option value="desc">High to Low</option>
								</select>
							</div>
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
													<?php $this->Sale->time($product); ?>

													<?php if($product->Images['name'] !== null){ ?>
														<img src="img/<?= $product->Images['name'] ?>" alt="">
													<?php }else{ ?>
														<img src="img/default.PNG" alt="">
													<?php } ?>
												</div>
											</a>
											<div class="product-body">
												<?php $this->Sale->price($product); ?>
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
	<?= $this->Html->script('home.js') ?>