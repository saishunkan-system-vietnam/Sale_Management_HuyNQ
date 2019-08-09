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
	<?= $this->Html->css('tab.css') ?>
	<?= $this->Html->css('product.css') ?>
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
										<strong class="text-uppercase" data-toggle="modal" data-target="#profile"><?= $auth['User']['email'] ?></i></strong>
									</div>
									<a href="/logout" class="text-uppercase">Logout</a>
									<div id="profile" class="modal fade" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Profile</h4>
												</div>
												<div class="modal-body">

													<div>
														<div class="form-group form">
															<label>Name</label>
															<input type="text" class="form-control" name="name1" placeholder="Name" value="<?= $auth['User']['name'] ?>">
															<p id="errname1" class="error" style="color: red;"></p>
														</div>
														<div class="form-group form">
															<label>Phone</label>
															<input type="number" class="form-control" name="phone1" placeholder="Phone" value="0<?= $auth['User']['phone'] ?>">
															<p id="errphone1" class="error" style="color: red;"></p>
														</div>
														<div class="form-group form">
															<label>Address</label>
															<input type="text" class="form-control" name="address1" placeholder="Address" value="<?= $auth['User']['address'] ?>">
															<p id="erraddress1" class="error" style="color: red;"></p>
														</div>
														<button id="btn_profile" type="submit" class="btn btn-primary">Submit</button>
													</div>	

												</div>
												<div class="modal-footer">
												</div>
											</div>

										</div>
									</div>
								<?php }else{ ?>
									<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
										<div class="header-btns-icon">
											<i class="fa fa-user-o"></i>
										</div>
										<strong class="text-uppercase">My Account</i></strong>
									</div>
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
															<div class="tab">
																<button class="tablinks" onclick="openCity(event, 'Signin')">Sign in</button>
																<button class="tablinks" onclick="openCity(event, 'Signup')">Sign up</button>
															</div>

															<div id="Signin" class="tabcontent">
																<form>
																	<div class="form-group form">
																		<label>Your email</label>
																		<input name="email" class="form-control" placeholder="Email" type="email">
																		<p id="erremail" class="error" style="color: red;"></p>
																	</div> 
																	<div class="form-group form">
																		<a class="float-right" href="#">Forgot?</a>
																		<label>Your password</label>
																		<input class="form-control" name="password" placeholder="******" type="password">
																		<p id="errpassword" class="error" style="color: red;"></p>
																	</div> 
																	<div class="form-group"> 
																		<div class="checkbox">
																			<label> <input type="checkbox"> Save password </label>
																		</div> 
																	</div>   
																	<div class="form-group">
																		<button id="btn_login" type="button" class="btn btn-primary btn-block"> Login  </button>
																	</div>                             
																</form>
															</div>

															<div id="Signup" class="tabcontent">
																<form>
																	<div class="form-group form">
																		<label>Name</label>
																		<input name="name" class="form-control" placeholder="Name" type="text">
																		<p id="errname" class="error" style="color: red;"></p>
																	</div> 
																	<div class="form-group form">
																		<label>Phone</label>
																		<input name="phone" class="form-control" placeholder="Phone" type="number">
																		<p id="errphone" class="error" style="color: red;"></p>
																	</div>
																	<div class="form-group form">
																		<label>Address</label>
																		<input name="address" class="form-control" placeholder="Address" type="text">
																		<p id="erraddress" class="error" style="color: red;"></p>
																	</div>  
																	<div class="form-group form">
																		<label>Email</label>
																		<input name="email1" class="form-control" placeholder="Email" type="email">
																		<p id="erremail1" class="error" style="color: red;"></p>
																	</div> 
																	<div class="form-group form">
																		<label>Password</label>
																		<input class="form-control" name="password1" placeholder="******" type="password">
																		<p id="errpassword1" class="error" style="color: red;"></p>
																	</div>  
																	<div class="form-group">
																		<button id="btn_register" type="button" class="btn btn-primary btn-block"> Register  </button>
																	</div>                             
																</form>
															</div>
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

							<!-- Compare -->
							<li class="header-cart dropdown default-dropdown">
								<a style="cursor: pointer;" data-toggle="modal" data-target="#compare">
									<div class="header-btns-icon">
										<i class="fa fa-balance-scale"></i>
									</div>
									<strong class="text-uppercase">Compare</strong>
									<br>
									<span>Check</span>
								</a>
							</li>
							<div id="compare" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Compare</h4>
										</div>
										<div class="modal-body">
											<div class="row">
												<?php if ($compare !== null) { ?>
												<?php foreach ($compare as $key => $product): ?>
													<div class="col-md-6">
														<table class="shopping-cart-table table">
													        <?php foreach ($product['attributes'] as $attribute): ?>
													            <tr>
													                <th scope="row"><?= $attribute->parentName ?></th>
													                <td><?= $attribute->name ?></td>
													            </tr>
													        <?php endforeach ?>
													    </table>
													</div>
												<?php endforeach ?>
											<?php }else{ ?>
												<h3>Not product to compare</h3>
											<?php } ?>
											</div>	
										</div>
										<div class="modal-footer">
										</div>
									</div>

								</div>
							</div>
							<!-- /Compare -->

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
							<?php $this->Select->getCategories($categories); ?>
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
	<script>
		$("#btn_profile").click(function(){
			var name = $("input[name=name1]").val();
			var phone = $("input[name=phone1]").val();
			var address = $("input[name=address1]").val();

			$.ajax({        
				url: '/profile',
				method: 'POST',
				data: {
					name : name,
					phone: phone,
					address: address
				}
			}).done(function(rep){
				console.log(rep);
				if (typeof(rep[0]['name']) != "undefined" && rep[0]['name'] !== "") {
					$("#errname1").css({"display": "block"});
					document.getElementById("errname1").innerHTML = rep[0]['name'];
					$('input[name="name1"]').val(rep[2]['name']);
				}
				if (typeof(rep[0]['phone']) != "undefined" && rep[0]['phone'] !== "") {
					$("#errphone1").css({"display": "block"});
					document.getElementById("errphone1").innerHTML = rep[0]['phone'];
					$('input[name="phone1"]').val(rep[2]['phone']);
				}
				if (typeof(rep[0]['address']) != "undefined" && rep[0]['address'] !== "") {
					$("#erraddress1").css({"display": "block"});
					document.getElementById("erraddress1").innerHTML = rep[0]['address'];
					$('input[name="address1"]').val(rep[2]['address']);
				}
				if (rep[0] == "") {
					toastr.success(rep[1]);
				}else {
					toastr.warning(rep[1]);
				}	
			});
		});

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
				if (typeof(rep['email']) != "undefined" && rep['email'] !== "") {
					$("#erremail").css({"display": "block"});
					document.getElementById("erremail").innerHTML = rep['email'];
				}
				if (typeof(rep['password']) != "undefined" && rep['password'] !== "") {
					$("#errpassword").css({"display": "block"});
					document.getElementById("errpassword").innerHTML = rep['password'];
				}
				if (rep == "") {
					location.reload();
				}	
			});
		});	

		$("#btn_register").click(function(){
			var email = $("input[name=email1]").val();
			var password = $("input[name=password1]").val();
			var name = $("input[name=name]").val();
			var phone = $("input[name=phone]").val();
			var address = $("input[name=address]").val();

			$.ajax({        
				url: '/signup',
				method: 'POST',
				data: {
					email : email,
					password: password,
					name: name,
					phone: phone,
					address: address
				}
			}).done(function(rep){
				console.log(rep);
				if (typeof(rep['email']) != "undefined" && rep['email'] !== "") {
					$("#erremail1").css({"display": "block"});
					document.getElementById("erremail1").innerHTML = rep['email'];
				}
				if (typeof(rep['password']) != "undefined" && rep['password'] !== "") {
					$("#errpassword1").css({"display": "block"});
					document.getElementById("errpassword1").innerHTML = rep['password'];
				}
				if (typeof(rep['name']) != "undefined" && rep['name'] !== "") {
					$("#errname").css({"display": "block"});
					document.getElementById("errname").innerHTML = rep['name'];
				}
				if (typeof(rep['phone']) != "undefined" && rep['phone'] !== "") {
					$("#errphone").css({"display": "block"});
					document.getElementById("errphone").innerHTML = rep['phone'];
				}
				if (typeof(rep['address']) != "undefined" && rep['address'] !== "") {
					$("#erraddress").css({"display": "block"});
					document.getElementById("erraddress").innerHTML = rep['address'];
				}
				if (rep == "") {
					location.reload();
				}	
			});
		});	

		function openCity(evt, cityName) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById(cityName).style.display = "block";
			evt.currentTarget.className += " active";
		}	

		$(".form").click(function(){
			$(this).find(".error").css({"display": "none"});
		});	

		$(".search_cate").click(function(){
			var category_id = $(this).attr('category_id');
			$.ajax({
				url: '/search',
				method: 'POST',
				data: {category_id: category_id}
			}).done(function(rep){
				console.log(rep);
				$("#product_list").remove(".product");
	        // rep = rep.replace(/\s/g,'');
	        if(rep !== ""){
	        	$("#product_list").html(rep);
	        }else{
	        	$("#product_list").html("Not data");
	        } 
	    });
		});		
	</script>
	</html>