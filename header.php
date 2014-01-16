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

global $jfl_theme;
    // maybe find a better solution...
// todo: show different kinds of navigation and header
// todo: use header image, if available
// todo: set header background color
        if (isset($jfl_theme['navbar-fixed']) && $jfl_theme['navbar-fixed'] == 'fixed-top') {
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

/*

    $menu_name = 'header-menu';

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

    $menu_items = wp_get_nav_menu_items($menu->term_id);

    $headerMenuItems = ''; // '<ul id="menu-' . $menu_name . '">';

        foreach ( $menu_items as $key => $menu_item ) {
        $title = $menu_item->title;
        $url = $menu_item->url;
        $headerMenuItems .= '<li><a href="' . $url . '">' . $title . '</a></li>';
        }
        //$menu_list .= '</ul>';
    } else {
    //$menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
    }
*/
    // $menu_list now ready to output

/*global $jfl_theme;
var_dump($jfl_theme);
die;
*/

$navbarStyle = '';

if (isset($jfl_theme['navbar-style-inverse']) && $jfl_theme['navbar-style-inverse'] == 'inverse') {
    $navbarStyle .= ' navbar-inverse';
}
else {
    $navbarStyle .= ' navbar-default';
}

if (isset($jfl_theme['navbar-fixed']) && $jfl_theme['navbar-fixed'] == 'fixed-top') {
    $navbarStyle .= ' navbar-fixed-top';
}
else {
    $navbarStyle .= ' '; // todo: set css style when not fixed... or if fixed. hm
}

?>

<?php
$description = get_bloginfo( 'name', 'display' );
$description .= ' ' . get_bloginfo( 'description', 'display' );
?>

<div class="container">

    <div class="masthead">
        <h3 class="text-muted"><?php echo $description; ?></h3>
        </div>
    </div>

    <!-- Fixed navbar -->
    <div class="navbar <?php echo $navbarStyle; ?>" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $description ); ?></a>
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
        </div>
    </div>

    <?php //wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>

        <div class="container">

        <div id="main" class="site-main">

