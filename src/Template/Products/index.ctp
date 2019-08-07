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
							<a href="/search/<?= strtolower(str_replace(' ','-',$attribute['name'])).'='.$attr['id'] ?>"><p><?= $attr['name'] ?></p></a>
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
							<?= $this->Form->create("",["type" => 'get']) ?>
							<input class="input search-input" id="keyword" name="keyword" type="text" placeholder="Enter your keyword">
							<button class="search-btn"><i class="fa fa-search"></i></button>
							<select class="form-control" name="price">
								<option value="" selected disabled hidden>--Choose price--</option>
								<option value="asc">Low to High</option>
								<option value="desc">High to Low</option>
							</select>
							<button type="submit" class="btn btn-primary">Submit</button>
							<?= $this->Form->end() ?>
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
												<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
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