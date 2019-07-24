<!-- BREADCRUMB -->
<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Checkout</li>
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

					<div class="col-md-12">
						<div class="order-summary clearfix">
							<div class="section-title">
								<h3 class="title">Order Review</h3>
							</div>
							<table class="shopping-cart-table table">
								<thead>
									<tr>
										<th>Product</th>
										<th class="text-center">Price</th>
										<th class="text-center">Quantity</th>
										<th class="text-center">Total</th>
										<th class="text-right"></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($cart as $value): ?>
									<tr>
										<td class="thumb"><img src="../img/<?= $value['image'] ?>" alt=""><?= $value['name'] ?></td>
										<td class="price text-center"><strong><?= $this->Number->format($value['price']) ?></strong></td>
										<td class="qty text-center">
											<button product_id="<?= $value['id'] ?>" type="button" id="sub" class="sub">-</button>
										    <input style="text-align: center;" type="number" id="1" value="<?= $this->Number->format($value['quantity']) ?>" min="1" max="5" />
										    <button product_id="<?= $value['id'] ?>" type="button" id="add" class="add">+</button>
										<td class="total text-center"><strong class="primary-color"><?= $this->Number->format($value['quantity']*$value['price']) ?></strong></td>
										<td class="text-right"><button product_id="<?= $value['id'] ?>" class="delete_cart main-btn icon-btn"><i class="fa fa-close"></i></button></td>
									</tr>
									<?php endforeach ?>
								</tbody>
								<tfoot>
									<tr>
										<th class="empty" colspan="3"></th>
										<th>TOTAL</th>
										<th colspan="2" class="total"><?= $this->Number->format($total) ?> VNĐ</th>
									</tr>
								</tfoot>
							</table>
							<div class="pull-right">
								<a href="/orders" class="primary-btn">Place Order</a>
							</div>
						</div>
					</div>
				<!-- </form> -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
<?= $this->Html->script('checkout.js') ?>