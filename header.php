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
      <!-- <title><?php wp_title(); ?></title> -->
      <title><?php wp_title( '|', true, 'right' );
          bloginfo( 'name' ); ?></title>
        
      <meta name="description" content="<?php bloginfo( 'description' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php


$layoutStyle = jfl_get_layout();

global $jfl_theme;
    // maybe find a better solution...
// todo: show different kinds of navigation and header
// todo: use header image, if available
// todo: set header background color
        if (isset($jfl_theme['navbar-fixed']) && $jfl_theme['navbar-fixed'] == 'fixed-top') {
            $navbarFixed = 'fixed-top';
        }
        else {
            $navbarFixed = 'default';
        }

        if ($navbarFixed == 'fixed-top') {
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
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

</head>


    <body <?php body_class(); ?>>

<?php



$navbarStyleClass = '';

if (isset($jfl_theme['navbar-style-inverse']) && $jfl_theme['navbar-style-inverse'] == 'inverse') {
    $navbarStyleClass .= ' navbar-inverse';
}
else {
    $navbarStyleClass .= ' navbar-default';
}

if ($navbarFixed == 'fixed-top') {
    $navbarStyleClass .= ' navbar-fixed-top';
}
else {
    $navbarStyleClass .= ' '; // todo: set css style when not fixed... or if fixed. hm
}


if (isset($jfl_theme['color-bg-header']) && $jfl_theme['color-bg-header']) {
    $headerStyleColorBg = $jfl_theme['color-bg-header'];
}
else {
    $headerStyleColorBg = '#000000';
}
if (isset($jfl_theme['color-fg-header']) && $jfl_theme['color-fg-header'] && stripos($jfl_theme['color-fg-header'], 'transparent') !== false ) {
    $headerStyleColorFg = '';
}
elseif (isset($jfl_theme['color-fg-header']) && $jfl_theme['color-fg-header'] ) {
    $headerStyleColorFg = ' color: ' . $jfl_theme['color-fg-header'] .';';
}
else {
    $headerStyleColorFg = '';
}



?>

<?php
$description = get_bloginfo( 'name', 'display' );
$description .= ' ' . get_bloginfo( 'description', 'display' );
?>
<?php if ($navbarFixed == 'default') {
?>
    <div style="background-color: <?php echo $headerStyleColorBg; ?>; <?php echo $headerStyleColorFg; ?>;">

<div class="container">
    <div class="masthead col-md-12 col-sm-12 col-xs-12">
        <h3 class="text-muted"><a class="header-url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $description ); ?></a></h3>
        <?php
        if (isset($jfl_theme['header-image']['url']) && $jfl_theme['header-image']['url']) {
            echo '<img height="' . $jfl_theme['header-image']['height'] . '" width="' . $jfl_theme['header-image']['width'] . '" src="' . $jfl_theme['header-image']['url'] .'"/>';
        }
        ?>
    </div>
 </div>
<?php }
?>

<?php if ($navbarFixed == 'default') {
?>
<div class="container">
<?php }
?>
    <!-- Fixed navbar -->
    <div class="navbar <?php echo $navbarStyleClass; ?>" role="navigation">
        <?php if ($navbarFixed == 'fixed-top') {
        ?><div class="container">
         <?php } ?>   <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
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
                    wp_nav_menu( array( 'items_wrap' => '%3$s',
                    'container' => '',
                    'menu_class'     => 'nav navbar-nav',
                    'walker' => new HeaderMenuWalker()) );
                    ?>
                </ul>
            </div><!--/.nav-collapse -->
            <?php if ($navbarFixed == 'fixed-top') {
            ?></div>
            <?php } ?>
    </div>

    <?php if ($navbarFixed == 'default') {
    ?>
</div> <!-- container -->
    </div> <!-- header in default navbar -->

<?php }
?>
    <?php //wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>

        <div class="container">

        <div id="main" class="site-main">

