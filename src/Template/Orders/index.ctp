<!-- BREADCRUMB -->
<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Order</li>
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
				<?php if(isset($auth['User'])){ ?>
					<div class="col-md-6">
						<div class="billing-details">
							<p>Already a customer ? <a href="/login">Login</a></p>
							<form action="" method="post">
								<div class="section-title">
									<h3 class="title">Billing Details</h3>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="name" placeholder="Your Name">
								</div>
								<div class="form-group">
									<input class="input" type="email" name="email" placeholder="Email">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="address" placeholder="Address">
								</div>
								<div class="form-group">
									<input class="input" type="tel" name="phone" placeholder="Telephone">
								</div>
								<!-- <div class="form-group">
									<div class="input-checkbox">
										<input class="input" type="password" name="password" placeholder="Enter Your Password">
									</div>
								</div> -->
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
						</div>
					</div>
				<?php }else{ ?>
					<div class="col-md-6">
						<div class="billing-details">
							<form action="" method="post">
								<div class="section-title">
									<h3 class="title">Billing Details</h3>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="name" placeholder="Your Name">
								</div>
								<div class="form-group">
									<input class="input" type="email" name="email" placeholder="Email">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="address" placeholder="Address">
								</div>
								<div class="form-group">
									<input class="input" type="tel" name="phone" placeholder="Telephone">
								</div>
								<!-- <div class="form-group">
									<div class="input-checkbox">
										<input class="input" type="password" name="password" placeholder="Enter Your Password">
									</div>
								</div> -->
							</form>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
<!-- <?= $this->Html->script('checkout.js') ?> -->