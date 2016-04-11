<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  
  /* OptionTree is not loaded yet, or this is not an admin request */
  if ( ! function_exists( 'ot_settings_id' ) || ! is_admin() )
    return false;
    
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( ot_settings_id(), array() );
  
  
   $designStylesheetPath = get_template_directory() . '/css/design/';
            $designStylesheets = array();

            if ( is_dir($designStylesheetPath) )
            {
                if ($alt_stylesheet_dir = opendir($designStylesheetPath) )
                {
                    while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false )
                    {
                        
                        if(stristr($alt_stylesheet_file, ".css"))
                        {
                            $stylesheetElement = array (
                                'value' => $alt_stylesheet_file,
                                'label' => $alt_stylesheet_file,
                                'src' => ''
                            );
                            $designStylesheets[] = $stylesheetElement;
                        }
                    }
                }
            }
            asort($designStylesheets);
/*
 array(
            'value'       => 'bootstap.css',
            'label'       => __( 'bootstap.css', 'tikva' ),
            'src'         => ''
          )
  */
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'home',
        'title'       => __( 'Home Settings', 'tikva' )
      ),
      array(
        'id'          => 'styling_options',
        'title'       => __( 'Styling Options', 'tikva' )
      ),
      array(
        'id'          => 'header_footer_options',
        'title'       => __( 'Header / Footer Options', 'tikva' )
      ),
      array(
        'id'          => 'social_media_buttons',
        'title'       => __( 'Social Media Buttons', 'tikva' )
      ),
      array(
        'id'          => 'documentation',
        'title'       => __( 'Documentation', 'tikva' )
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'featured_articles_max',
        'label'       => __( 'Maximum number of featured articles on homepage', 'tikva' ),
        'desc'        => '',
        'std'         => '5',
        'type'        => 'numeric-slider',
        'section'     => 'home',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '0,100,1',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'layout',
        'label'       => __( 'Layout', 'tikva' ),
        'desc'        => __( 'Set layout of your site.', 'tikva' ),
        'std'         => '2',
        'type'        => 'radio-image',
        'section'     => 'styling_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __( '1 Column', 'tikva' ),
            'src'         => 'OT_URL/assets/images/layout/full-width.png'
          ),
          array(
            'value'       => '2',
            'label'       => __( '2 Columns, Content left, Sidebar right', 'tikva' ),
            'src'         => 'OT_URL/assets/images/layout/right-sidebar.png'
          ),
          array(
            'value'       => '3',
            'label'       => __( '2 Columns, Content right, Sidebar left', 'tikva' ),
            'src'         => 'OT_URL/assets/images/layout/left-sidebar.png'
          )
        )
      ),
      array(
        'id'          => 'stylesheet',
        'label'       => __( 'Theme Stylesheet', 'tikva' ),
        'desc'        => __( 'Select your themes alternative color scheme.', 'tikva' ),
        'std'         => 'slate_accessibility_ready.min.css',
        'type'        => 'select',
        'section'     => 'styling_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => 
          $designStylesheets
/*          array( 
            
          array(
            'value'       => 'bootstap.css',
            'label'       => __( 'bootstap.css', 'tikva' ),
            'src'         => ''
          )
        )*/
      ),
      array(
        'id'          => 'navbar_fixed',
        'label'       => __( 'Navbar fixed options', 'tikva' ),
        'desc'        => '',
        'std'         => 'default',
        'type'        => 'radio',
        'section'     => 'styling_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'default',
            'label'       => __( 'Default', 'tikva' ),
            'src'         => ''
          ),
          array(
            'value'       => 'fixed-top',
            'label'       => __( 'Fixed to top', 'tikva' ),
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'navbar_style_inverse',
        'label'       => __( 'Navbar style', 'tikva' ),
        'desc'        => '',
        'std'         => 'default',
        'type'        => 'radio',
        'section'     => 'styling_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'default',
            'label'       => __( 'Default', 'tikva' ),
            'src'         => ''
          ),
          array(
            'value'       => 'inverse',
            'label'       => __( 'Inverse', 'tikva' ),
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'color_fg_sidebar',
        'label'       => __( 'Sidebar Font Color', 'tikva' ),
        'desc'        => __( 'Pick a foreground color for the sidebar (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva' ),
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'styling_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'color_bg_sidebar',
        'label'       => __( 'Sidebar Background Color', 'tikva' ),
        'desc'        => __( 'Pick a background color for the sidebar (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva' ),
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'styling_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'header_image_large_dontscale',
        'label'       => __( 'Do not resize automatically the default header image', 'tikva' ),
        'desc'        => __( 'If checked, the default header image will <b>not</b> be resized to fit the width of the screen.', 'tikva' ),
        'std'         => '0',
        'type'        => 'checkbox',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __( 'Do not resize', 'tikva' ),
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'header_image_medium',
        'label'       => __( 'Header Image (medium screen)', 'tikva' ),
        'desc'        => __( 'If available, this image will be used with medium devices (desktops, 992px and up). Please use a minimal width of 912px. It is available when chosen default navbar.', 'tikva' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'header_image_medium_dontscale',
        'label'       => __( 'Do not resize automatically the medium screen header image', 'tikva' ),
        'desc'        => __( 'If checked, the medium screen header image will <b>not</b> be resized to fit the width of the screen.', 'tikva' ),
        'std'         => '0',
        'type'        => 'checkbox',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __( 'Do not resize', 'tikva' ),
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'header_image_small',
        'label'       => __( 'Header Image (small screen)', 'tikva' ),
        'desc'        => __( 'If available, this image will be used with small devices (tablets, 768px and up). Please use a minimal width of 690px. It is available when chosen default navbar.', 'tikva' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'header_image_small_dontscale',
        'label'       => __( 'Do not resize automatically the small screen header image', 'tikva' ),
        'desc'        => __( 'If checked, the small screen header image will <b>not</b> be resized to fit the width of the screen.', 'tikva' ),
        'std'         => '0',
        'type'        => 'checkbox',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __( 'Do not resize', 'tikva' ),
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'header_image_xsmall',
        'label'       => __( 'Header Image (extra small screen)', 'tikva' ),
        'desc'        => __( 'If available, this image will be used with extra small devices (phones, less than 768px). Please use a minimal width of 690px. It is available when chosen default navbar.', 'tikva' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'header_image_xsmall_dontscale',
        'label'       => __( 'Do not resize automatically the extra small header image', 'tikva' ),
        'desc'        => __( 'If checked, the extra small header image will <b>not</b> be resized to fit the width of the screen.', 'tikva' ),
        'std'         => '0',
        'type'        => 'checkbox',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __( 'Do not resize', 'tikva' ),
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'header_image_example_tikva',
        'label'       => __( 'Use the example image from the theme if no default header image is set.', 'tikva' ),
        'desc'        => __( 'You can switch off this option, so no image will be displayed.', 'tikva' ),
        'std'         => '1',
        'type'        => 'checkbox',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __( 'Use example image', 'tikva' ),
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'color_bg_header',
        'label'       => __( 'Header Background Color', 'tikva' ),
        'desc'        => __( 'Pick a background color for the header (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva' ),
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'color_fg_footer',
        'label'       => __( 'Footer Font Color', 'tikva' ),
        'desc'        => __( 'Pick a foreground color for the footer (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva' ),
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'color_bg_footer',
        'label'       => __( 'Footer Background Color', 'tikva' ),
        'desc'        => __( 'Pick a background color for the footer (default: transparent, i.e. use color defined in the theme stylesheet).', 'tikva' ),
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'header_footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_buttons',
        'label'       => __( 'Social Media Buttons', 'tikva' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'tab',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_facebook',
        'label'       => __( 'Facebook', 'tikva' ),
        'desc'        => __( 'Enter the complete Facebook profile page URL (please include http or https!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_github',
        'label'       => __( 'Github', 'tikva' ),
        'desc'        => __( 'Enter the complete Gthub profile page URL (please include http or https!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_google',
        'label'       => __( 'Google+', 'tikva' ),
        'desc'        => __( 'Enter the complete Google+ page URL (please include http or https!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_instagram',
        'label'       => __( 'Instagram', 'tikva' ),
        'desc'        => __( 'Enter the complete Instagram page URL (please include http or https!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_linkedin',
        'label'       => __( 'LinkedIn', 'tikva' ),
        'desc'        => __( 'Enter the complete LinkedIn page URL (please include http or https!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_slideshare',
        'label'       => __( 'Slideshare', 'tikva' ),
        'desc'        => __( 'Enter the complete Slideshare page URL (please include http or https!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_twitter',
        'label'       => __( 'Twitter', 'tikva' ),
        'desc'        => __( 'Enter the Twitter profile page URL (please include http!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_vine',
        'label'       => __( 'Vine', 'tikva' ),
        'desc'        => __( 'Enter the complete Vine page URL (please include http or https!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_xing',
        'label'       => __( 'Xing', 'tikva' ),
        'desc'        => __( 'Enter the complete Xing profile page URL (please include http or https!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_youtube',
        'label'       => __( 'YouTube', 'tikva' ),
        'desc'        => __( 'Enter the complete YouTube channel page URL (please include http or https!)', 'tikva' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_button_placement',
        'label'       => __( 'Button Placement', 'tikva' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'tab',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_media_buttons_placement',
        'label'       => __( 'Placement of Social Media Buttons', 'tikva' ),
        'desc'        => '',
        'std'         => '0',
        'type'        => 'select',
        'section'     => 'social_media_buttons',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __( 'Don\'t show', 'tikva' ),
            'src'         => ''
          ),
          array(
            'value'       => '2',
            'label'       => __( 'Between Content and Footer', 'tikva' ),
            'src'         => ''
          ),
          array(
            'value'       => '3',
            'label'       => __( 'Below Footer', 'tikva' ),
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'documentation',
        'label'       => __( 'Documentation', 'tikva' ),
        'desc'        => __( 'Tikva - a small theme based on Bootstrap 3.0
Version 0.2
Version history:
Version 0.2
Bootstrap Version bumped to 3.3.6
Bootswatch themes updated
minor language fixes
Hiding header text enabled
usage of register_sidebar() fixed
Version 0.1.9.1
wording changed
theme url changed to its new home', 'tikva' ),
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'documentation',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( ot_settings_id(), $custom_settings ); 
  }
  
  /* Lets OptionTree know the UI Builder is being overridden */
  global $ot_has_custom_theme_options;
  $ot_has_custom_theme_options = true;
  
}