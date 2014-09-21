<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>
<html  <?php language_attributes(); ?>>
    <head>
      <meta charset="<?php bloginfo( 'charset' ); ?>" />
      <title><?php wp_title( '|', true, 'right' ); ?></title>
        
      <meta name="description" content="<?php bloginfo( 'description' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php

global $tikva_theme; //ugly, but working... use better solution in next versions...

echo tikva_get_header_image_data();

$layoutStyle = tikva_get_layout();

$navbarFixed = tikva_get_navbar_layout();

        if ($navbarFixed == 'fixed-top' && has_nav_menu('header-menu')) {
            ?>
            <style type="text/css">
                body {
                    padding-top: 70px;
                }
            </style>
        <?php
        }
       ?>

        <?php wp_head(); ?>
        <?php
        /* Unfortunately there is no conditional JavaScript solution as it exists for stylesheets.
        */
        ?>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


    <body <?php body_class(); ?>>
    <div id="skip-link"><a href="#content" class="sr-only element-focusable"><?php _e( 'Skip to main content', 'tikva' ); ?></a></div>
<?php

$headerStyles = tikva_get_header_styles($navbarFixed);
?>

<?php
$description = get_bloginfo( 'name', 'display' );
if ($navbarFixed != 'fixed-top') {
    $description .= ' ' . get_bloginfo( 'description', 'display' );
}
?>
<?php if ($navbarFixed == 'default') {

?>
    <div role="banner" style="background-color: <?php echo $headerStyles['headerStyleColorBg']; ?>; <?php echo $headerStyles['headerStyleColorFg']; ?>;">

<div class="container">
    <div class="masthead col-md-12 col-sm-12">
        <h3><a class="header-url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $description ); ?></a></h3>

            <div id="site-header">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img id="site-header-image" src="<?php header_image(); ?>" width="1" height="1" data-width="<?php echo get_custom_header()->width; ?>" data-height="<?php echo get_custom_header()->height; ?>" alt="<?php _e( 'Header Image - navigate to homepage', 'tikva' ); ?>">
                </a>
            </div>

    </div>
 </div>
<?php }
?>

<?php if ($navbarFixed == 'default') {
?>
<div class="container">
<?php
}
if (has_nav_menu('header-menu')) {
?>
    <!-- Fixed navbar -->
    <div class="navbar <?php echo $headerStyles['navbarStyleClass']; ?>" role="navigation">
        <?php if ($navbarFixed == 'fixed-top') {
        ?><div class="container">
         <?php } ?>   <div id="navbar-header" class="navbar-header">
                <div id="navbar-toggle-screenreader"><a href="#" class="sr-only element-focusable" data-toggle="collapse" data-target=".navbar-collapse"><?php _e( 'Toggle navigation', 'tikva' ); ?></a></div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only"><?php _e( 'Toggle navigation', 'tikva' ); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <?php if ($navbarFixed == 'fixed-top') { ?>
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $description ); ?></a>
                <?php } ?>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php
                    wp_nav_menu( array( 'theme_location' => 'header-menu',
                        'items_wrap' => '%3$s',
                    'container' => '',
                    'menu_class'     => 'nav navbar-nav',
                    'walker' => new HeaderMenuWalker()
                    ) );

                    ?>


                </ul>
            </div><!--/.nav-collapse -->

            <?php
            if ($navbarFixed == 'fixed-top') {
            ?></div>
            <?php } ?>
    </div> <!-- end navbar-->

<?php
}
else
{ ?>
  <p>&nbsp;</p>
<?php }

if ($navbarFixed == 'default') {
    ?>
</div> <!-- container -->
    </div> <!-- header in default navbar -->

<?php }
?>
        <div class="container">

        <div id="main" class="site-main">

