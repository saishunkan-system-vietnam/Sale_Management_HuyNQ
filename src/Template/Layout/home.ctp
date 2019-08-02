<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrfToken" content="<?php echo $this->Token->getToken(); ?>"> 
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Internship-Shop</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="../Home/css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="../Home/css/slick.css" />
	<link type="text/css" rel="stylesheet" href="../Home/css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="../Home/css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="../Home/css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="../Home/css/style.css" />

	<?= $this->Html->script('jquery-3.4.1.min.js') ?>
	<?= $this->Html->script('toastr.min.js') ?>
	<?= $this->Html->css('toastr.min.css') ?>
	<?= $this->fetch('script') ?>
	<?= $this->fetch('css') ?>


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>
		<!-- HEADER -->
		<header>
			<!-- top Header -->
			<div id="top-header">
				<div class="container">
					<div class="pull-left">
						<span>Welcome to E-shop!</span>
					</div>
					<div class="pull-right">

					</div>
				</div>
			</div>
			<!-- /top Header -->

			<!-- header -->
			<div id="header">
				<div class="container">
					<div class="pull-left">
						<!-- Logo -->
						<div class="header-logo">
							<a class="logo" href="/">
								<img src="../Home/img/logo.png" alt="">
							</a>
						</div>
						<!-- /Logo -->
					</div>
					<div class="pull-right">
						<ul class="header-btns">
							<!-- Account -->
							<li class="header-account dropdown default-dropdown">
								<?php if(isset($auth['User'])){ ?>
								<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
									<div class="header-btns-icon">
										<i class="fa fa-user-o"></i>
									</div>
									<strong class="text-uppercase"><?= $auth['User']['email'] ?></i></strong>
								</div>
								<a href="/logout" class="text-uppercase">Logout</a>
								<?php }else{ ?>
								<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
									<div class="header-btns-icon">
										<i class="fa fa-user-o"></i>
									</div>
									<strong class="text-uppercase">My Account</i></strong>
								</div>
								<!-- <a href="/signin" class="text-uppercase">Login</a> -->
								<a style="cursor: pointer;" class="text-uppercase" data-toggle="modal" data-target="#exampleModal">Login</a>
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>							
											</div>
											<div class="modal-body">
												<div class="card">
													<article class="card-body">
														<h4 class="card-title mb-4 mt-1">Sign in</h4>
														<form>
															<div class="form-group">
																<label>Your email</label>
																<input name="email" class="form-control" placeholder="Email" type="email">
															</div> <!-- form-group// -->
															<div class="form-group">
																<a class="float-right" href="#">Forgot?</a>
																<label>Your password</label>
																<input class="form-control" name="password" placeholder="******" type="password">
															</div> <!-- form-group// --> 
															<div class="form-group"> 
																<div class="checkbox">
																	<label> <input type="checkbox"> Save password </label>
																</div> <!-- checkbox .// -->
															</div> <!-- form-group// -->  
															<div class="form-group">
																<button id="btn_login" type="button" style="width: 49%; float: left; margin-right: 10px;" class="btn btn-primary btn-block"> Login  </button>
																<button type="button" style="width: 49%;" class="btn btn-default btn-block"> Sign up  </button>
															</div> <!-- form-group// -->                                                           
														</form>
													</article>
												</div> <!-- card.// -->

											</div>
											<div class="modal-footer">
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							</li>
							<!-- /Account -->

							<!-- Cart -->
							<li class="header-cart dropdown default-dropdown">
								<a href="/checkout">
									<div class="header-btns-icon">
										<i class="fa fa-shopping-cart"></i>
									</div>
									<strong class="text-uppercase">My Cart:</strong>
									<br>
									<span>Check Out</span>
								</a>
							</li>
							<!-- /Cart -->

							<!-- Mobile nav toggle-->
							<li class="nav-toggle">
								<button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
							</li>
							<!-- / Mobile nav toggle -->
						</ul>
					</div>
				</div>
				<!-- header -->
			</div>
			<!-- container -->
		</header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<div id="navigation">
			<!-- container -->
			<div class="container">
				<div id="responsive-nav">
					<!-- category nav -->
					<div class="category-nav show-on-click">
						<span class="category-header">Categories <i class="fa fa-list"></i></span>
						<ul class="category-list">
							<li class="dropdown side-dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Women’s Clothing <i class="fa fa-angle-right"></i></a>
								<div class="custom-menu">
									<div class="row">
										<div class="col-md-4">
											<ul class="list-links">
												<li>
													<h3 class="list-links-title">Categories</h3></li>
													<li><a href="#">Women’s Clothing</a></li>
													<li><a href="#">Men’s Clothing</a></li>
													<li><a href="#">Phones & Accessories</a></li>
													<li><a href="#">Jewelry & Watches</a></li>
													<li><a href="#">Bags & Shoes</a></li>
												</ul>
												<hr class="hidden-md hidden-lg">
											</div>
											<div class="col-md-4">
												<ul class="list-links">
													<li>
														<h3 class="list-links-title">Categories</h3></li>
														<li><a href="#">Women’s Clothing</a></li>
														<li><a href="#">Men’s Clothing</a></li>
														<li><a href="#">Phones & Accessories</a></li>
														<li><a href="#">Jewelry & Watches</a></li>
														<li><a href="#">Bags & Shoes</a></li>
													</ul>
													<hr class="hidden-md hidden-lg">
												</div>
												<div class="col-md-4">
													<ul class="list-links">
														<li>
															<h3 class="list-links-title">Categories</h3></li>
															<li><a href="#">Women’s Clothing</a></li>
															<li><a href="#">Men’s Clothing</a></li>
															<li><a href="#">Phones & Accessories</a></li>
															<li><a href="#">Jewelry & Watches</a></li>
															<li><a href="#">Bags & Shoes</a></li>
														</ul>
													</div>
												</div>
											</div>
										</li>
										<li><a href="#">Men’s Clothing</a></li>
									</ul>
								</div>
								<!-- /category nav -->

								<!-- menu nav -->
								<div class="menu-nav">
									<span class="menu-header">Menu <i class="fa fa-bars"></i></span>
									<ul class="menu-list">

									</ul>
								</div>
								<!-- menu nav -->
							</div>
						</div>
						<!-- /container -->
					</div>
					<!-- /NAVIGATION -->
					<div class="container clearfix">
						<br>
						<h1><?= $this->Flash->render() ?></h1>
						<?= $this->fetch('content') ?>
					</div>

					<!-- FOOTER -->
					<footer id="footer" class="section section-grey">
						<!-- container -->
						<div class="container">
							<!-- row -->
							<div class="row">
								<!-- footer widget -->
								<div class="col-md-3 col-sm-6 col-xs-6">
									<div class="footer">
										<!-- footer logo -->
										<div class="footer-logo">
											<a class="logo" href="#">
												<img src="../Home/img/logo.png" alt="">
											</a>
										</div>
										<!-- /footer logo -->

										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>

										<!-- footer social -->
										<ul class="footer-social">
											<li><a href="#"><i class="fa fa-facebook"></i></a></li>
											<li><a href="#"><i class="fa fa-twitter"></i></a></li>
											<li><a href="#"><i class="fa fa-instagram"></i></a></li>
											<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
											<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
										</ul>
										<!-- /footer social -->
									</div>
								</div>
								<!-- /footer widget -->
								<div class="clearfix visible-sm visible-xs"></div>
							</div>
							<!-- /row -->
							<hr>

						</div>
						<!-- /container -->
					</footer>
					<!-- /FOOTER -->

					<!-- jQuery Plugins -->
<script src="../Home/js/jquery.min.js"></script>
<script src="../Home/js/bootstrap.min.js"></script>
<script src="../Home/js/slick.min.js"></script>
<script src="../Home/js/nouislider.min.js"></script>
<script src="../Home/js/jquery.zoom.min.js"></script>
<script src="../Home/js/main.js"></script>

</body>
<!-- <script>

$("#btn_login").click(function(){
	var email = $("input[name=email]").val();
	var password = $("input[name=password]").val();

	$.ajax({        
        url: '/signin',
        method: 'POST',
        data: {
            email : email,
            password: password
        }
    }).done(function(rep){
    	console.log(rep);
    	//toastr.success(rep);
    });
});				
</script> -->
</html>