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


$layoutStyle = tikva_get_layout();

global $tikva_theme;
    // maybe find a better solution...
        if (isset($tikva_theme['navbar-fixed']) && $tikva_theme['navbar-fixed'] == 'fixed-top') {
            $navbarFixed = 'fixed-top';
        }
        else {
            $navbarFixed = 'default';
        }

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
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

</head>


    <body <?php body_class(); ?>>

<?php



$navbarStyleClass = '';

if (isset($tikva_theme['navbar-style-inverse']) && $tikva_theme['navbar-style-inverse'] == 'inverse') {
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


if (isset($tikva_theme['color-bg-header']) && $tikva_theme['color-bg-header']) {
    $headerStyleColorBg = $tikva_theme['color-bg-header'];
}
else {
    $headerStyleColorBg = '#000000';
}
if (isset($tikva_theme['color-fg-header']) && $tikva_theme['color-fg-header'] && stripos($tikva_theme['color-fg-header'], 'transparent') !== false ) {
    $headerStyleColorFg = '';
}
elseif (isset($tikva_theme['color-fg-header']) && $tikva_theme['color-fg-header'] ) {
    $headerStyleColorFg = ' color: ' . $tikva_theme['color-fg-header'] .';';
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
        if ( get_header_image() ) : ?>
            <div id="site-header">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
                </a>
            </div>
        <?php endif;
        ?>
    </div>
 </div>
<?php }
?>

<?php if ($navbarFixed == 'default') {
?>
<div class="container">
<?php }
if (has_nav_menu('header-menu')) {
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
                    wp_nav_menu( array( 'theme_location' => 'header-menu',
                        'items_wrap' => '%3$s',
                    'container' => '',
                    'menu_class'     => 'nav navbar-nav',
                    'walker' => new HeaderMenuWalker()
                    ) );

                    ?>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display: block; position: static; margin-bottom: 5px; *width: 180px;">

                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">More options</a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#">Second level</a></li>
                            <li class="dropdown-submenu">
                                <a href="#">More..</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">3rd level</a></li>
                                    <li><a href="#">3rd level</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Second level</a></li>
                            <li><a href="#">Second level</a></li>
                        </ul>
                    </li>
                    </ul>

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

