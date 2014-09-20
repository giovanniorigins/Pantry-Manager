<!doctype html>
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Marketplace</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic"
	      type="text/css">
	<!-- needs images, font... therefore can not be part of ui.css -->
	<link rel="stylesheet" href="/views/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/views/bower_components/weather-icons/css/weather-icons.min.css">
	<!-- end needs images -->

	<!-- StrapSlide -->
	<link rel="stylesheet" href="/views/strapslide/css/strapslide.css" media="screen" />
	<link rel="stylesheet" href="/views/strapslide/css/strapslide-default-v3.css" media="screen" />
	<!-- //StrapSlide-->

	<link rel="stylesheet" href="/views/styles/main.css">

</head>
<body data-ng-app="app" id="app" data-custom-background="" data-off-canvas-nav="">
<!--[if lt IE 9]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
	your browser</a> to improve your experience.</p>
<![endif]-->

<div data-ng-controller="AppCtrl">
	<div data-ng-hide="isSpecificPage()" data-ng-cloak="" class="no-print">
		<section data-ng-include=" '/views/views/header.html' " id="header" class="top-header"></section>

		<aside data-ng-include=" '/views/views/nav.html' " id="nav-container"></aside>
	</div>
	<div class="no-print navbar-wrapper"  data-ng-hide="!isSpecificPage()" data-ng-cloak="">
		<div class="container">
			<nav class="navbar navbar-inverse" ng-class="{true:'navbar-static-top', false:'navbar-fixed-top'}[isHome()]" role="navigation" data-ng-show="!isLockScreen()">
				<div class="" ng-class="{true:'container', false:'container-fluid'}[isHome()]">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse"
						        data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Marketplace</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" front-nav>
						<ul class="nav navbar-nav">
							<li><a href="/home">Home</a></li>
							<li><a href="/about">About</a></li>
							<li><a href="/pricing">Pricing</a></li>
							<li><a href="/services">Services</a></li>
							<li><a href="/contact">Contact</a></li>
							<li><a href="/login">Login</a></li>
							<!--<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li class="divider"></li>
									<li><a href="#">Separated link</a></li>
									<li class="divider"></li>
									<li><a href="#">One more separated link</a></li>
								</ul>
							</li>-->
						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</div>
				<!-- /.container-fluid -->
			</nav>
		</div>
	</div>
	<div class="view-container">
		<section data-ng-view="" id="content" class="animate-fade-up"></section>
	</div>
</div>


<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="/views/scripts/vendor.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.3.1/json3.min.js"></script>

<script src="/views/strapslide/js/jquery.touchSwipe.min.js"></script>
<script src="/views/strapslide/js/jquery.transit.min.js"></script>
<script src="/views/strapslide/js/jquery.mousewheel.js"></script>
<script src="/views/strapslide/js/jquery.fitVids.js"></script>
<!-- Slider plugin -->
<script src="/views/strapslide/js/strapslide.js"></script>

<!-- AngularJS -->
<script src="/views/scripts/angularjs/angular.js"></script>
<script src="/views/scripts/angularjs/angular-animate.js"></script>
<script src="/views/scripts/angularjs/angular-resource.js"></script>
<script src="/views/scripts/angularjs/angular-cookies.js"></script>
<script src="/views/scripts/angularjs/angular-route.js"></script>

<script src="/views/scripts/image_crop/crop.js"></script>
<script src="/views/scripts/angular-dreamfactory.js"></script>
<script src="/views/scripts/dreamfactory-user-management.js"></script>
<script src="/views/scripts/modules.js"></script>

<script src="/views/scripts/ui.js"></script>

<script src="/views/scripts/app.js"></script>
<script src="/views/scripts/services.js"></script>
<script src="/views/scripts/directives.js"></script>
<script src="/views/scripts/controllers.js"></script>
</body>
</html>