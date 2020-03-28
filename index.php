<?php
	require_once 'Config.class.php';
	require_once 'Functions.class.php';
	require_once 'Lang.class.php';
	require_once 'Session.class.php';
	require_once 'Cookie.class.php';

	Config::set('langs', [
		'es',
		'en',
	]);

	if (in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), Config::get('langs'))) {
		Config::set('default_lang', (Session::get('lang') ?? Cookie::get('lang') ?? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)));
	} else {
		Config::set('default_lang', (Session::get('lang') ?? Cookie::get('lang') ?? 'en'));
	}

	Lang::load(Config::get('default_lang'));
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Layoud Grid</title>
		<link rel="stylesheet" href="css/all.min.css" />
		<link rel="stylesheet" href="css/main.min.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/main.js"></script>
	</head>
	<body class="">
		<header class="header">
			<a href="" class="logo-img"></a>
			<a href="" class="logo-text">LOGO TEXT</a>
			<button class="button-hamburger"></button>
			<div class="grid-space"></div>
			<button class="switch-audio"></button>
			<button class="switch-full-screen"></button>
			<button class="switch-dark-light"></button>
			<form id="switch-lang" method="post" action="">
				<input type="hidden" name="select_lang" value="<?= (Config::get('default_lang') == 'es') ? 'en' : 'es' ?>" />
				<button type="submit" class="switch-lang"></button>
			</form>
		</header>
		<nav class="nav">
			<a href="" class="active">
				<i class="fas fa-home"></i>
				HOME
			</a>
			<a href="" class="sub">
				<i class="fas fa-folder"></i>
				MENU
				<i class="sub-down fas fa-sort-down"></i>
				<i class="sub-up fas fa-sort-up"></i>
				<div class="sub-nav">
					<a href="">SUB-MENU 1</a>
					<a href="">SUB-MENU 2</a>
					<a href="">SUB-MENU-3</a>
				</div>
			</a>
			<a href="">
				<i class="fas fa-concierge-bell"></i>
				SERVICES
			</a>
			<a href="">
				<i class="fas fa-envelope"></i>
				CONTACT
			</a>
			<a href="">
				<i class="fas fa-address-card"></i>
				ABOUT
			</a>
		</nav>
		<main class="main">MAIN</main>
		<footer class="footer">FOOTER</footer>
	</body>
</html>
