<?php
/**
 * Getting started template
 */

$customizer_url = admin_url() . 'customize.php' ;
$azbalac = wp_get_theme( get_template() );
?>

 <div role="tabpanel" class="tab-pane fade show active" id="azbalac-tab-getting-started">
 
        <h1 class="azbalac-welcome-title"><?php _e('Welcome to Azbalac One!', 'azbalac-one'); ?> 
            <?php
        if( !empty($azbalac['Version']) ) { 
            echo sprintf(__("- Version %s",'azbalac-one'), esc_attr( $azbalac['Version'] )); 
        } ?></h1>

	<hr />

	<div class="azbalac-tab-pane-center">

		<h1><?php esc_html_e( 'Getting started', 'azbalac-one' ); ?></h1>

		<h4><?php esc_html_e( 'Customize whole theme in a single place.' ,'azbalac-one' ); ?></h4>
		<p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every feature of the theme.', 'azbalac-one' ); ?></p>
		<p><a href="<?php echo esc_url( $customizer_url ); ?>" class="button button-primary"><?php esc_html_e( 'Go to Customizer', 'azbalac-one' ); ?></a></p>
	</div>

	<hr />
	
	<div class="azbalac-tab-pane-half azbalac-tab-pane-first-half">
		<h3><?php esc_html_e( 'About Azbalac One', 'azbalac-one' ); ?></h3>
		<p><?php esc_html_e( 'Azbalac One is a classic WordPress theme based on Bootstrap 5 and Twig 3. It provides a focused set of customization options without introducing a page builder, block-theme architecture, frontend build system, or commercial feature tier.', 'azbalac-one' ); ?></p>
		<p><?php esc_html_e( 'You can choose from multiple Bootswatch designs and customize the navigation, header, footer, colors, typography, featured content, slider, introduction area, and social-media buttons through the WordPress Customizer.', 'azbalac-one' ); ?></p>
		<p><?php esc_html_e( 'Changes to the theme source should preferably be implemented in a child theme because a theme update may overwrite modified files.', 'azbalac-one' ); ?></p>

		<hr />

		<h3><?php esc_html_e( 'History', 'azbalac-one' ); ?></h3>
		<p><?php esc_html_e( 'A word from the author: When I moved my blog from custom software to WordPress, I looked for a Bootstrap-powered theme. I already knew Bootstrap from many web projects, so working in a familiar environment seemed like the natural choice.', 'azbalac-one' ); ?></p>
		<p><?php esc_html_e( 'Many available themes were either too limited or offered far more features and complexity than I needed. I therefore created a small, general-purpose theme that stays close to Bootstrap and contains the features I actually use. I am a programmer rather than a designer, after all. ;-) That was the birth of Azbalac One, and I am happy if you find it useful too.', 'azbalac-one' ); ?></p>
		
	</div>
        
        	<hr />

	<div class="azbalac-tab-pane-half">
	
		<h3><?php esc_html_e( 'Feedback and Support', 'azbalac-one' ); ?></h3>
                <p><?php esc_html_e( 'The theme is actively maintained, but it deliberately does not try to implement every imaginable WordPress feature. There is no "Pro", enhanced, or commercial edition, and there will never be one.', 'azbalac-one' ); ?></p>
                <p>
                <?php esc_html_e( 'Azbalac One will remain free, including features added in the future. I still have some ideas in mind and may implement them when time permits.', 'azbalac-one' ); ?></p>
                <p>
		<?php esc_html_e( 'I would be happy to hear from you. Which features do you like or dislike? Are you missing an option, have you found an error or unexpected behavior, or would you like to help with a translation or documentation? You can use the following feedback form, which is currently available in German only.', 'azbalac-one' ); ?></p>
		<p><a href="https://www.kuerbis.org/feedback/" class="button" target="_blank"><?php esc_html_e( 'Your feedback and wishes', 'azbalac-one' ); ?></a></p>
                
                	<hr />
		  <p style="text-align: center;">
                <?php esc_html_e( 'Thanks again for using Azbalac One!', 'azbalac-one' ); ?></p>
                  <p style="text-align: right;"><i>
                <?php esc_html_e( 'Ralf Geschke', 'azbalac-one' ); ?></i></p>
	<hr />

	
	</div>

	<div class="azbalac-clear"></div>
    
    </div>
 
