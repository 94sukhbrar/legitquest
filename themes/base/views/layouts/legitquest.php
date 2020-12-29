<?php

use app\assets\AppAsset;
use app\components\FlashMessage;
use app\modules\notification\widgets\NotificationWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

$user = Yii::$app->user->identity;

/* @var $this \yii\web\View */
/* @var $content string */
// $this->title = yii::$app->name;

AppAsset::register($this);
?>
<?php

$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
	<?php

	$this->head() ?>
	<meta charset="<?= Yii::$app->charset ?>" />
	<?= Html::csrfMetaTags() ?>


	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?= $this->theme->getUrl('assets/images/favicon.png') ?>">
	<title><?= Html::encode($this->title) ?></title>




	<!-- legitquest Theme CSS -->
	<link rel="shortcut icon" href="<?= $this->theme->getUrl('legitquest/assets/images/lq-logo-m.png') ?>">

	<!-- Bootstrap Css -->
	<link href="<?= $this->theme->getUrl('legitquest/assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
	<!-- Icons Css -->
	<link href="<?= $this->theme->getUrl('legitquest/assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
	<!-- App Css-->
	<link href="<?= $this->theme->getUrl('legitquest/assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?= $this->theme->getUrl('legitquest/assets/css/style.css') ?>" rel="stylesheet" type="text/css" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body data-topbar="colored">
	<?php

	$this->beginBody();
	?>

	<div id="layout-wrapper">
		<header id="page-topbar">
			<div class="navbar-header">
				<div class="d-flex">
					<!-- LOGO -->
					<div class="navbar-brand-box">
						<a href="index.html" class="logo logo-dark text-left">
							<span class="logo-sm">
								<img src="<?= $this->theme->getUrl('legitquest/assets/images/lq-logo-m.png') ?>" alt="" height="30">
							</span>
							<span class="logo-lg">
								<img src="<?= $this->theme->getUrl('legitquest/assets/images/lq-logo.png') ?>" alt="" height="35">
							</span>
						</a>

						<a href="index.html" class="logo logo-light">
							<span class="logo-sm">
								<img src="<?= $this->theme->getUrl('legitquest/assets/images/logo-sm-light.png') ?>" alt="" height="22">
							</span>
							<span class="logo-lg">
								<img src="<?= $this->theme->getUrl('legitquest/assets/images/logo-light.png') ?>" alt="" height="20">
							</span>
						</a>
					</div>

					<button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
						<i class="mdi mdi-backburger"></i>
					</button>

					<!-- App Search-->
					<form class="app-search d-none d-lg-block">
						<div class="position-relative">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="mdi mdi-magnify"></span>
						</div>
					</form>
				</div>

				<div class="d-flex">

					<div class="dropdown d-inline-block d-lg-none ml-2">
						<button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="mdi mdi-magnify"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">

							<form class="p-3">
								<div class="form-group m-0">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
										<div class="input-group-append">
											<button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>


					<div class="dropdown d-inline-block">
						<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img class="rounded-circle header-profile-user" src="<?= $this->theme->getUrl('legitquest/assets/images/users/avatar-1.jpg') ?>" alt="Header Avatar">
							<span class="d-none d-sm-inline-block ml-1">Legitquest</span>
							<i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a class="dropdown-item" href="#"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profile</a>
							<a class="dropdown-item" href="#"><i class="mdi mdi-credit-card-outline font-size-16 align-middle mr-1"></i> Billing</a>
							<a class="dropdown-item" href="#"><i class="mdi mdi-account-settings font-size-16 align-middle mr-1"></i> Settings</a>
							<a class="dropdown-item" href="#"><i class="mdi mdi-lock font-size-16 align-middle mr-1"></i> Lock screen</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#"><i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout</a>
						</div>
					</div>

				</div>
			</div>

		</header>

		<div class="vertical-menu">

			<div data-simplebar class="h-100">

				<!--- Sidemenu -->
				<div id="sidebar-menu">
					<!-- Left Menu Start -->
					<ul class="metismenu list-unstyled" id="side-menu">
						<li class="menu-title">Menu</li>

						<li>
							<a href="<?= Url::toRoute(['/dashboard/scrapper']); ?>" class="waves-effect">
								<div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div>
								<span>Data scraper</span>
							</a>
						</li>


						<li>
							<a href="<?= Url::toRoute(['/dashboard/index']); ?>" class="waves-effect">
								<div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div>
								<span>Dashboard</span>
							</a>
						</li>


					</ul>

				</div>
				<!-- Sidebar -->
			</div>
		</div>

		<div class="main-content">

			<div class="page-content">
				<!-- Page-Title -->
				<div class="page-title-box">
					<div class="container-fluid">
						<div class="row align-items-center">
							<div class="col-md-8">
								<h4 class="page-title mb-1"> Select resective court to view data in System</h4>
							</div>

						</div>

					</div>
				</div>
				<!-- end page title end breadcrumb -->
				<div class="page-content-wrapper">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<?= $content; ?>
							</div>
						</div>
					</div>
				</div>

				<footer class="footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6 mx-auto text-center">
								2020 © Legitquest case Monitoring System.
							</div>

						</div>
					</div>
				</footer>
			</div>
		</div>
	</div>

	<script src="<?= $this->theme->getUrl('legitquest/assets/libs/jquery/jquery.min.js') ?>"></script>
	<script src="<?= $this->theme->getUrl('legitquest/assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?= $this->theme->getUrl('legitquest/assets/libs/metismenu/metisMenu.min.js') ?>"></script>
	<script src="<?= $this->theme->getUrl('legitquest/assets/libs/simplebar/simplebar.min.js') ?>"></script>
	<script src="<?= $this->theme->getUrl('legitquest/assets/libs/node-waves/waves.min.js') ?>"></script>
	<script src="<?= $this->theme->getUrl('legitquest/assets/js/pages/bundle.js') ?>"></script>
	<script src="<?= $this->theme->getUrl('legitquest/assets/js/pages/dashboard.init.js') ?>"></script>
	<script src="<?= $this->theme->getUrl('legitquest/assets/js/app.js') ?>"></script>
	<script>
		$("#page-header-user-dropdown").click(function() {
			$(".dropdown-menu-right").toggleClass("show");
		});
	</script>


	<?php

	$this->endBody();
	?>
</body>
<?php

$this->endPage() ?>

</html>