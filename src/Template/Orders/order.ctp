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
				<?php if(!isset($auth['User'])){ ?>
					<div class="col-md-6">
						<div class="billing-details">
							<p>Already a customer ? <a href="/login">Login</a></p>
							<form action="/order" method="post">
								<div class="section-title">
									<h3 class="title">Billing Details</h3>
								</div>
								<div class="form-group form">
									<input class="input" id="name" type="text" name="name" placeholder="Your Name" <?php if (!empty($request['name'])) { ?> value="<?= $request['name'] ?>" <?php } ?>>
									<?php if (isset($errname)): ?>
					                    <p class="error" style="color: red;"><?= $errname ?></p>
					                <?php endif ?>
								</div>
								<div class="form-group form">
									<input class="input" id="email" type="email" name="email" placeholder="Email" <?php if (!empty($request['email'])) { ?> value="<?= $request['email'] ?>" <?php } ?>>
									<?php if (isset($erremail)): ?>
					                    <p class="error" style="color: red;"><?= $erremail ?></p>
					                <?php endif ?>
								</div>
								<div class="form-group form">
									<input class="input" id="address" type="text" name="address" placeholder="Address" <?php if (!empty($request['address'])) { ?> value="<?= $request['address'] ?>" <?php } ?>>
									<?php if (isset($erraddress)): ?>
					                    <p class="error" style="color: red;"><?= $erraddress ?></p>
					                <?php endif ?>
								</div>
								<div class="form-group form">
									<input class="input" id="phone" type="number" name="phone" placeholder="Telephone" <?php if (!empty($request['phone'])) { ?> value="<?= $request['phone'] ?>" <?php } ?>>
									<?php if (isset($errphone)): ?>
					                    <p class="error" style="color: red;"><?= $errphone ?></p>
					                <?php endif ?>
								</div>
								<div class="form-group">
									<button type="submit" id="btn_submit1" class="btn btn-primary">Submit</button>
								</div>
							</form>
						</div>
					</div>
				<?php }else{ ?>
					<div class="col-md-6">
						<div class="billing-details">
							<form action="/order" method="post">
								<div class="section-title">
									<h3 class="title">Billing Details</h3>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="name" style="pointer-events: none;" placeholder="Your Name" value="<?= $user['name'] ?>">
								</div>
								<div class="form-group">
									<input class="input" type="email" name="email" style="pointer-events: none;" placeholder="Email" value="<?= $user['email'] ?>">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="address" style="pointer-events: none;" placeholder="Address" value="<?= $user['address'] ?>">
								</div>

								<div class="form-group">
									<div class="input-checkbox">
										<input type="checkbox" id="register">
										<label class="font-weak" for="register">New address delivery?</label>
										<div class="caption">
											<p>We will ship to this new address.<p>
											<input class="input" type="text" disabled id="new_address" name="new_address" placeholder="Enter Your New Address">
											<p id="errnew_address" style="color: red;"></p>
										</div>
									</div>
								</div>

								<div class="form-group">
									<input class="input" type="tel" name="phone" style="pointer-events: none;" placeholder="Telephone" value="0<?= $user['phone'] ?>">
								</div>
								<div class="form-group">
									<button type="submit" id="btn_submit" class="btn btn-primary">Submit</button>
								</div>
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
<?= $this->Html->script('checkout.js') ?>