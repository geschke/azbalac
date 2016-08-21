<?php
/**
 * Getting started template
 */

$customizer_url = admin_url() . 'customize.php' ;
$Tikva = wp_get_theme( 'tikva' );
?>

 <div role="tabpanel" class="tab-pane  fade in  active" id="tikva-tab-getting-started">
 
        <h1 class="tikva-welcome-title"><?php _e('Welcome to Tikva!', 'tikva'); if( !empty($Tikva['Version']) ): ?> <sup id="tikva-theme-version"><?php echo esc_attr( $Tikva['Version'] ); ?> </sup><?php endif; ?></h1>

	<hr />

	<div class="tikva-tab-pane-center">

		<h1><?php esc_html_e( 'Getting started', 'tikva' ); ?></h1>

		<h4><?php esc_html_e( 'Customize Whole theme in a single place.' ,'tikva' ); ?></h4>
		<p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'tikva' ); ?></p>
		<p><a href="<?php echo esc_url( $customizer_url ); ?>" class="button button-primary"><?php esc_html_e( 'Go to Customizer', 'tikva' ); ?></a></p>
	</div>

	<hr />
	<div class="tikva-tab-pane-center">
		<h1><?php esc_html_e( 'FAQ', 'tikva' ); ?></h1>
	</div>
	<div class="tikva-tab-pane-half tikva-tab-pane-first-half">
		<h4><?php esc_html_e( 'Create a child theme', 'tikva' ); ?></h4>
		<p><?php esc_html_e( 'If you want to make changes to the theme\'s files, those changes are likely to be overwritten when you next update the theme. In order to prevent that from happening, you need to create a child theme. For this, please follow the documentation below.', 'tikva' ); ?></p>
		<p><a href="http://demo.webhuntinfotech.com/blog/2016/01/11/how-to-create-a-child-theme/" class="button" target="_blank"><?php esc_html_e( 'View how to do this', 'tikva' ); ?></a></p>

		<hr />

		<h4><?php esc_html_e( 'Gallery in Blog Posts', 'tikva' ); ?></h4>
		<p><?php esc_html_e( 'If you want to use more than one images in your post or want to make gallery images in your post. This can be accomplished by following the documention below.', 'tikva' ); ?></p>
		<p><a href="http://demo.webhuntinfotech.com/blog/2016/01/11/add-gallery-posts-in-matrix-or-kyma-theme/" class="button" target="_blank"><?php esc_html_e( 'View how to do this', 'tikva' ); ?></a></p>
	</div>

	<div class="tikva-tab-pane-half">
	
		<h4><?php esc_html_e( 'Translate Tikva', 'tikva' ); ?></h4>
		<p><?php esc_html_e( 'In the below documentation you will find an easy way to translate tikva into your native language or any other language you need for you site.', 'tikva' ); ?></p>
		<p><a href="http://demo.webhuntinfotech.com/blog/2016/01/11/how-to-translate-any-translation-ready-theme/" class="button" target="_blank"><?php esc_html_e( 'View how to do this', 'tikva' ); ?></a></p>
		
	<hr />

	<h4><?php esc_html_e( 'How To Setup Home Page', 'tikva' ); ?></h4>
		<p><?php esc_html_e( 'See below document. It will help you to setup Home Page' , 'tikva' ); ?></p>
		<p><a href="http://demo.webhuntinfotech.com/blog/2016/02/02/how-to-setup-home-page-in-matrix-or-kyma-lite/" class="button" target="_blank"><?php esc_html_e( 'View how to do this', 'tikva' ); ?></a></p>

	</div>

	<div class="tikva-clear"></div>
    
    </div>
 