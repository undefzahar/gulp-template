<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title><?php wp_title(); ?></title>

	<?php wp_head(); ?>
</head>

<body>
	
<header class="header">
	<div class="container">
		<a href="/" class="header__logo">
			Logo
		</a>

		<ul class="header__menu">
			<li>Home</li>
			<li>About</li>
			<li>Contact</li>
		</ul>
	</div>
</header>

<main <?php body_class(); ?>>