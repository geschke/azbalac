<?php
/**
 * Getting started template
 */

$customizer_url = admin_url() . 'customize.php' ;
$Tikva = wp_get_theme( 'tikva' );
?>

 <div role="tabpanel" class="tab-pane  fade in  active" id="tikva-tab-getting-started">
 
        <h1 class="tikva-welcome-title"><?php _e('Welcome to Tikva', 'tikva'); ?> 
            <?php
        if( !empty($Tikva['Version']) ) { 
            echo sprintf(__("- Version %s",'tikva'), esc_attr( $Tikva['Version'] )); 
        } ?></h1>

	<hr />

	<div class="tikva-tab-pane-center">

		<h1><?php esc_html_e( 'Getting started', 'tikva' ); ?></h1>

		<h4><?php esc_html_e( 'Customize whole theme in a single place.' ,'tikva' ); ?></h4>
		<p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'tikva' ); ?></p>
		<p><a href="<?php echo esc_url( $customizer_url ); ?>" class="button button-primary"><?php esc_html_e( 'Go to Customizer', 'tikva' ); ?></a></p>
	</div>

	<hr />
	
	<div class="tikva-tab-pane-half tikva-tab-pane-first-half">
		<h3><?php esc_html_e( 'About Tikva theme', 'tikva' ); ?></h3>
		<p><?php esc_html_e( 'Tikva is a pure and basic WordPress theme which is based on the Bootstrap HTML, CSS, and JS framework. It implements some customization features, e.g. you can switch between more than a dozen predefined styles (mostly taken from the Bootswatch free themes), two navigation bar styles and 18 footer layouts. You can add a simple slider - the theme uses the "carousel" feature of Boostrap and configure the slider position and timing options.  If you want to make changes to the theme\'s files, those changes are likely to be overwritten when you next update the theme. In order to prevent that from happening, you need to create a child theme. For this, please follow the documentation on the WordPress website.', 'tikva' ); ?></p>

		<hr />

		<h3><?php esc_html_e( 'History', 'tikva' ); ?></h3>
		<p><?php esc_html_e( 'A word from the author: As I switched the blog software from an own development to WordPress, I searched for a Bootstrap-powered theme. As developer I used Bootstrap before in nearly all web development projects of the last years, so I thought it would be easier to work in a well known environment. There were plenty of themes, some were really good and had a large number of features. I bought a commercial licensed theme, but was a little bit disappointed. And many of the themes had more feature than I ever needed. So I tried to create a small theme which only implemented a minimal set of features which I used on my own web page. It should be a general purpose theme, but I tried to keep near to the Bootstrap style. At first, I like the design, and secondly - you know, I\'m a programmer, but not a designer. ;-) That was the birth of Tikva theme, and I\'ll be happy if you find it useful for you.', 'tikva' ); ?></p>
		
	</div>
        
        	<hr />

	<div class="tikva-tab-pane-half">
	
		<h3><?php esc_html_e( 'Feedback and Support', 'tikva' ); ?></h3>
                <p><?php esc_html_e( 'The theme is actively maintained and developed. But due to the history it didn\'t try to implement all imaginable WordPress features. And there is no "pro" or "enhanced" or "commercial" version, no upgrade option or soomething else - and there will never be!', 'tikva' ); ?></p>
                <p>
                <?php esc_html_e( 'The Tikva theme will stay free, with every feature which will be added in future. I have some features in mind, and if there is enough time maybe I will implement them.', 'tikva' ); ?></p>
                <p>
                <?php esc_html_e( 'And it would be nice to hear from you! Which features do you like, which dislike? Do you miss something, a feature, an option, which could be maybe added in future? Did you find an error or an unexpected behavior? Or could you help by translating the theme into your language, add some documentation or something else? Please provide your feedback, you can use the following formular (currently in german language only, but Google helps to translate ;-) )', 'tikva' ); ?></p>
		<p><a href="https://www.kuerbis.org/feedback/" class="button" target="_blank"><?php esc_html_e( 'Your feedback and wishes', 'tikva' ); ?></a></p>
                
                	<hr />
		  <p style="text-align: center;">
                <?php esc_html_e( 'Thanks again for using Tikva theme!', 'tikva' ); ?></p>
                  <p style="text-align: right;"><i>
                <?php esc_html_e( 'Ralf Geschke', 'tikva' ); ?></i></p>
	<hr />

	
	</div>

	<div class="tikva-clear"></div>
    
    </div>
 