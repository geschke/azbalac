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
      <meta name="description" content="<?php bloginfo( 'description' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php

echo tikva_get_header_image_data();

$layoutStyle = tikva_get_layout();

$bodyStyles = tikva_get_body_styles();

$navbarFixed = tikva_get_navbar_layout();

        if ($navbarFixed == 'fixed-top' && has_nav_menu('header-menu')) {
            ?>
            <style type="text/css">
                body {
                    padding-top: 70px !important;
                }
                body.admin-bar .navbar-fixed-top { top: 28px !important; }
                
                
                
/* v4 notice above main navbar */
.v4-tease {
  display: block;
  padding: 15px 20px;
  font-weight: bold;
  color: #fff;
  text-align: center;
  background-color: #0275d8;
}
.v4-tease:hover {
  color: #fff;
  text-decoration: none;
  background-color: #0269c2;
}

                
            </style>
        <?php
        }
       ?>

        <?php 
        wp_head(); 
        
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
$subtitleDescription = get_bloginfo( 'description', 'display' );
/*if ($navbarFixed != 'fixed-top') {
    $description .= ' ' . get_bloginfo( 'description', 'display' );
}*/ // todo: don't concat in this way, it is the subtitle!
?>
<?php if ($navbarFixed == 'default') {

?>
    <div>
    <?php      //  tikva_display_social_media_buttons(3); ?>
    </div>
   
    <div id="header" role="banner" style="background-color: <?php echo $headerStyles['headerStyleColorBg']; ?>; <?php echo $headerStyles['headerStyleColorFg'];  ?>">

<div class="container">
    
    <div class="masthead col-md-12 col-sm-12">
        <h1 id="site-header-text"><a class="header-url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $description ); ?></a></h1>
        <div id="site-description"><?php echo esc_html($subtitleDescription); ?></div>
         <div id="site-header">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img id="site-header-image" src="<?php header_image(); ?>" width="1" height="1" data-width="<?php echo get_custom_header()->width; ?>" data-height="<?php echo get_custom_header()->height; ?>" alt="<?php _e( 'Header Image - navigate to homepage', 'tikva' ); ?>">
                </a>
            </div>
      <?php
    
      if ( is_front_page()) {
        tikva_show_slider(1);
      }
?>
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
                <div id="site-header-text"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $description ); ?></a></div>
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
          
            <?php
            if ( is_front_page() ) {
tikva_show_slider(2);
            } 
            ?>
            
        <div id="main" class="site-main">

