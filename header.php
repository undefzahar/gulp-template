<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=wp_get_document_title(); ?></title>

	<link rel="Shortcut Icon" type="image/x-icon" href="<?=get_template_directory_uri(); ?>/build/img/favicon.svg" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header class="header">
	<div class="container">
		<a href="/" class="header__logo"><?php bloginfo( 'name' ); ?></a>

		<div class="header__menu">
			<?php wp_nav_menu(array(
				'menu' => 'header_menu',
				'container' => 'ul',
				'container_class' => '',
				'container_id' => '',
				'menu_class' => 'header__menu-list',
				'menu_id' => 'header__menu-list',
				'echo' => true,
				'fallback_cb' => 'wp_page_menu',
				'before' => '',
				'after' => '',
				'link_before' => '',
				'link_after' => '',
				'depth' => 0,
				'walker' => '',
			)) ?>
		</div>

		<div class="header__burger"></div>
	</div>
</header>

<main>