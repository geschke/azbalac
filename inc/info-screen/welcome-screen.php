<?php
/**
 * Welcome Screen Class
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Tikva_Welcome')) {
class Tikva_Welcome {
	/**
	 * Constructor for the welcome screen
	 */
	public function __construct() {
		
		/* create dashbord page */
		add_action( 'admin_menu', array( $this, 'Tikva_welcome_register_menu' ) );

		/* activation notice */
		add_action( 'load-themes.php', array( $this, 'Tikva_activation_admin_notice' ) );

		/* enqueue script and style for welcome screen */
		add_action( 'admin_enqueue_scripts', array( $this, 'Tikva_welcome_style_and_scripts' ) );

		/* enqueue script for customizer */
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'Tikva_welcome_scripts_for_customizer' ) );

		/* load welcome screen */
		add_action( 'Tikva_welcome', array( $this, 'Tikva_welcome_getting_started' ), 	    10 );
		
		add_action( 'Tikva_welcome', array( $this, 'Tikva_welcome_changelog' ), 				50 );

		/* ajax callback for dismissable required actions */
		add_action( 'wp_ajax_Tikva_dismiss_required_action', array( $this, 'Tikva_dismiss_required_action_callback') );
		add_action( 'wp_ajax_nopriv_Tikva_dismiss_required_action', array($this, 'Tikva_dismiss_required_action_callback') );

	}
	
	
	/**
	 * Creates the dashboard page
	 * @see  add_theme_page()
	 * @since 1.8.2.4
	 */
	public function Tikva_welcome_register_menu() {
		add_theme_page( 'About Tikva', 'About Tikva', 'activate_plugins', 'tikva-welcome', array( $this, 'Tikva_welcome_screen' ) );
	}

	/**
	 * Adds an admin notice upon successful activation.
	 * @since 1.8.2.4
	 */
	public function Tikva_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'Tikva_welcome_admin_notice' ), 99 );
		}
	}

	/**
	 * Display an admin notice linking to the welcome screen
	 * @since 1.8.2.4
	 */
	public function Tikva_welcome_admin_notice() {
		?>
			<div class="updated notice is-dismissible">
				<p><?php echo sprintf( esc_html__( 'Welcome! Thank you for choosing Tikva Theme! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'tikva' ), '<a href="' . esc_url( admin_url( 'themes.php?page=tikva-welcome' ) ) . '">', '</a>' ); ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=tikva-welcome' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with Tikva', 'tikva' ); ?></a></p>
			</div>
		<?php
	}

	/**
	 * Load welcome screen css and javascript
	 * @since  1.8.2.4
	 */
	public function Tikva_welcome_style_and_scripts( $hook_suffix ) {

		if ( 'appearance_page_tikva-welcome' == $hook_suffix ) {
			wp_enqueue_style( 'tikva-welcome-screen-css', get_template_directory_uri() . '/inc/info-screen/css/welcome.css' );
			wp_enqueue_script( 'tikva-welcome-screen-js', get_template_directory_uri() . '/inc/info-screen/js/welcome.js', array('jquery') );

			global $Tikva_required_actions;

			$nr_actions_required = 0;

			wp_localize_script( 'tikva-welcome-screen-js', 'tikvaWelcomeScreenObject', array(
				'nr_actions_required' => $nr_actions_required,
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'template_directory' => get_template_directory_uri(),
				'no_required_actions_text' => __( 'Hooray! There are no required actions for you right now.','tikva' )
			) );
		}
	}

	/**
	 * Load scripts for customizer page
	 * @since  1.8.2.4
	 */
	public function Tikva_welcome_scripts_for_customizer() {

		wp_enqueue_style( 'tikva-welcome-screen-customizer-css', get_template_directory_uri() . '/inc/info-screen/css/welcome_customizer.css' );
		wp_enqueue_script( 'tikva-welcome-screen-customizer-js', get_template_directory_uri() . '/inc/info-screen/js/welcome_customizer.js', array('jquery'), '20120206', true );

		global $Tikva_required_actions;

		$nr_actions_required = 0;

		wp_localize_script( 'tikva-welcome-screen-customizer-js', 'tikvaWelcomeScreenCustomizerObject', array(
			'nr_actions_required' => $nr_actions_required,
			'aboutpage' => esc_url( admin_url( 'themes.php?page=tikva-welcome#actions_required' ) ),
			'customizerpage' => esc_url( admin_url( 'customize.php#actions_required' ) ),
			'themeinfo' => __('View Theme Info','tikva'),
		) );
	}

	/**
	 * Dismiss required actions
	 * @since 1.8.2.4
	 */
	public function Tikva_dismiss_required_action_callback() {

		global $Tikva_required_actions;

		$Tikva_dismiss_id = (isset($_GET['dismiss_id'])) ? $_GET['dismiss_id'] : 0;

		echo $Tikva_dismiss_id; /* this is needed and it's the id of the dismissable required action */

		if( !empty($Tikva_dismiss_id) ):

			/* if the option exists, update the record for the specified id */
			if( get_option('Tikva_show_required_actions') ):

				$Tikva_show_required_actions = get_option('Tikva_show_required_actions');

				$Tikva_show_required_actions[$Tikva_dismiss_id] = false;

				update_option( 'Tikva_show_required_actions',$Tikva_show_required_actions );

			/* create the new option,with false for the specified id */
			else:

				$Tikva_show_required_actions_new = array();

				if( !empty($Tikva_required_actions) ):

					foreach( $Tikva_required_actions as $Tikva_required_action ):

						if( $Tikva_required_action['id'] == $Tikva_dismiss_id ):
							$Tikva_show_required_actions_new[$Tikva_required_action['id']] = false;
						else:
							$Tikva_show_required_actions_new[$Tikva_required_action['id']] = true;
						endif;

					endforeach;

				update_option( 'Tikva_show_required_actions', $Tikva_show_required_actions_new );

				endif;

			endif;

		endif;

		die(); // this is required to return a proper result
	}


	/**
	 * Welcome screen content
	 * @since 1.8.2.4
	 */
	public function Tikva_welcome_screen() {

		require_once( ABSPATH . 'wp-load.php' );
		require_once( ABSPATH . 'wp-admin/admin.php' );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );
		?>

		<ul class="tikva-nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#getting_started" aria-controls="getting_started" role="tab" data-toggle="tab"><?php esc_html_e( 'Getting started','tikva'); ?></a></li>
			<li role="presentation"><a href="#changelog" aria-controls="changelog" role="tab" data-toggle="tab"><?php esc_html_e( 'Changelog','tikva'); ?></a></li>
		</ul>

		<div class="tikva-tab-content">

			<?php
			/**
			 * @hooked Tikva_welcome_getting_started - 10
			 * @hooked Tikva_welcome_actions_required - 20
			 * @hooked Tikva_welcome_changelog - 50
			 */
			do_action( 'Tikva_welcome' ); ?>

		</div>
		<?php
	}

	/**
	 * Getting started
	 * @since 1.8.2.4
	 */
	public function Tikva_welcome_getting_started() {
		require_once( get_template_directory() . '/inc/info-screen/sections/getting-started.php' );
	}

	/**
	 * Changelog
	 * @since 1.8.2.4
	 */
	public function Tikva_welcome_changelog() {
		require_once( get_template_directory() . '/inc/info-screen/sections/changelog.php' );
	}

}

$GLOBALS['Tikva_Welcome'] = new Tikva_Welcome();
}
?>