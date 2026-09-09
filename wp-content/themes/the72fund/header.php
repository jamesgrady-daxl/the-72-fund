<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-8T0ETTEN20"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-8T0ETTEN20');
	</script>
	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '|', true, 'right' ); // echo get_bloginfo('name'); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Averia+Serif+Libre:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">

	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/slick/slick-theme.css"/>

	<?php $aosStyleVersion = filemtime(get_stylesheet_directory() . '/js/aos/aos.css'); ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/aos/aos.css"/>

    <?php $customModalstyleVersion = filemtime(get_stylesheet_directory() . '/js/customModal/customModal.css'); ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/customModal/customModal.css?v=<?php echo $customModalstyleVersion; ?>"/>

    <?php $styleVersion = filemtime(get_stylesheet_directory() . '/style.css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>?v=<?php echo $styleVersion; ?>">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="page-wrapper">
	<a class="skip-link" href="#main-content">Skip to content</a>
	
	<header class="header" id="header">
		<div class="container large">

			<a class="header-logo" href="<?php echo home_url(); ?>">
				<?php $header_logo_desktop = get_field('header_logo', 'options'); ?>
					<img src="<?php echo $header_logo_desktop; ?>" alt="<?php esc_attr_e( 'The 72 Fund', 'the-72-fund' ); ?>" />
			</a>

			<nav class="header-menu" aria-label="<?php esc_attr_e( 'Primary', 'the-72-fund' ); ?>">
				<?php wp_nav_menu( array( 'theme_location' => 'header_menu', 'menu_class' => 'header_menu', 'depth' => 1) ); ?>
			</nav>
			<a class="special-btn btn icon-btn secondary-btn primary-hvr secondary-bdr" href="<?php echo home_url(); ?>/our-insights/">
				<img class="icon" src="<?php bloginfo('template_directory'); ?>/images/icon-star.png" alt="" aria-hidden="true">Insights
			</a>
			<button class="slicknav-btn slicknav-open" type="button" aria-label="Open menu" aria-controls="slicknav" aria-expanded="false">
				<img src="<?php bloginfo('template_directory'); ?>/images/hamburger.png" alt="" aria-hidden="true" />
			</button>

		</div>

		<div class="slicknav-overlay"></div>
		<div id="slicknav" class="slicknav" aria-hidden="true" inert>
			<button class="slicknav-btn slicknav-close" type="button" aria-label="Close menu" aria-controls="slicknav">
				<img src="<?php bloginfo('template_directory'); ?>/images/x-close.png" alt="" aria-hidden="true" />
			</button>
			<div class="slicknav-content">
				<nav class="slicknav-content-inner" aria-label="<?php esc_attr_e( 'Mobile', 'the-72-fund' ); ?>">
					<?php wp_nav_menu( array( 'theme_location' => 'slideout_menu', 'menu_class' => 'slideout_menu', 'depth' => 2) ); ?>
					<?php get_template_part( 'template-parts/templates/template', 'social_links_options' ); ?>
				</nav>
			</div>
		</div>
	</header>
		
	<main id="main-content" class="page-content" tabindex="-1">
		<?php get_template_part( 'template-parts/modules/module', 'wc_bg_options' ); ?>
