<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">List</li>
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
            <div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
                <!-- Search -->
					<div class="header-search">
						<form>
							<input class="input search-input" type="text" placeholder="Enter your keyword">
							<!-- <select class="input search-categories">
								<option value="0">Search Products</option>
                            </select> -->
                            <b class="input search-categories" style="text-align: center; padding-top: 10px; color: #F8694A;">Search Product</b>
							<button class="search-btn"><i class="fa fa-search"></i></button>
						</form>
					</div>
                    <!-- /Search -->
                    
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">List Products</h2>
					</div>
				</div>
				<!-- section title -->

                <?php foreach ($products as $product): ?>
				<!-- Product Single -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="product product-single">
						<div class="product-thumb">
							<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
							<img src="../Home/img/product01.jpg" alt="">
						</div>
						<div class="product-body">
							<h3 class="product-price"><?= $this->Number->format($product->price) ?> VNĐ</h3>
							<h2 class="product-name"><a href="#"><?= h($product->name) ?></a></h2>
							<div class="product-btns">
								<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
								<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
								<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
							</div>
						</div>
					</div>
				</div>
                <!-- /Product Single -->
                <?php endforeach; ?>
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