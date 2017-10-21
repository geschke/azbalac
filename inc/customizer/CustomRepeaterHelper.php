<?php

/**
 * Walker to generate array of pages with ids and indents
 */
class Tikva_Walker_Page extends Walker_Page {
    

    /**
     * Array to store page values
     */
    public $pageEntries;

        /**
         * Outputs the beginning of the current level in the tree before elements are output.
         *
         * @since 2.1.0
         * @access public
         *
         * @see Walker::start_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Optional. Depth of page. Used for padding. Default 0.
         * @param array  $args   Optional. Arguments for outputting the next level.
         *                       Default empty array.
         */
      /*  public function start_lvl( &$output, $depth = 0, $args = array() ) {
            //echo "in start_lvl";
            //print_r($output);
            //echo "\n";
            if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
                $t = "\t";
                $n = "\n";
            } else {
                $t = '';
                $n = '';
            }
            $indent = str_repeat( $t, $depth );

            //echo "depth: " . $depth . "<br>>\n";
            $output .= "{$n}{$indent}<div class='children'>{$n}";
        }*/
    
        /**
         * Outputs the end of the current level in the tree after elements are output.
         *
         * @since 2.1.0
         * @access public
         *
         * @see Walker::end_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int    $depth  Optional. Depth of page. Used for padding. Default 0.
         * @param array  $args   Optional. Arguments for outputting the end of the current level.
         *                       Default empty array.
         */
      /*  public function end_lvl( &$output, $depth = 0, $args = array() ) {
            if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
                $t = "\t";
                $n = "\n";
            } else {
                $t = '';
                $n = '';
            }
            $indent = str_repeat( $t, $depth );
            $output .= "{$indent}</div>{$n}";
        }
    */
        /**
         * Outputs the beginning of the current element in the tree.
         *
         * @see Walker::start_el()
         * @since 2.1.0
         * @access public
         *
         * @param string  $output       Used to append additional content. Passed by reference.
         * @param WP_Post $page         Page data object.
         * @param int     $depth        Optional. Depth of page. Used for padding. Default 0.
         * @param array   $args         Optional. Array of arguments. Default empty array.
         * @param int     $current_page Optional. Page ID. Default 0.
         */
        public function start_el( &$output, $page, $depth = 0, $args = array(), 
        $current_page = 0 ) {
/*            echo "in start_el\n";
            //print_r($output);
            print_r($page->ID);
            print_r($page->post_title);
            
            var_dump($depth);
            echo "<br>\n";
*/
$t = "&nbsp;&nbsp;";
            if ( $depth ) {
                $indent = str_repeat( $t, $depth );
            } else {
                $indent = '';
            }
            $this->pageEntries[] = array('name' => $indent . $page->post_title,
            'class' => 'level-' . $depth,
            'value' => $page->ID);

##########################
       /*     if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
                $t = "\t";
                $n = "\n";
            } else {
                $t = '';
                $n = '';
            }
            if ( $depth ) {
                $indent = str_repeat( $t, $depth );
            } else {
                $indent = '';
            }
    
            $css_class = array( 'page_item', 'page-item-' . $page->ID );
    
            if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
                $css_class[] = 'page_item_has_children';
            }
    
            if ( ! empty( $current_page ) ) {
                $_current_page = get_post( $current_page );
                if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
                    $css_class[] = 'current_page_ancestor';
                }
                if ( $page->ID == $current_page ) {
                    $css_class[] = 'current_page_item';
                } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
                    $css_class[] = 'current_page_parent';
                }
            } elseif ( $page->ID == get_option('page_for_posts') ) {
                $css_class[] = 'current_page_parent';
            }
    */
            /**
             * Filters the list of CSS classes to include with each page item in the list.
             *
             * @since 2.8.0
             *
             * @see wp_list_pages()
             *
             * @param array   $css_class    An array of CSS classes to be applied
             *                              to each list item.
             * @param WP_Post $page         Page data object.
             * @param int     $depth        Depth of page, used for padding.
             * @param array   $args         An array of arguments.
             * @param int     $current_page ID of the current page.
             */
           /*  $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );
    
            if ( '' === $page->post_title ) {
                // translators: %d: ID of a post 
                $page->post_title = sprintf( __( '#%d (no title)' ), $page->ID );
            }
    
            $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
            $args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];
    
            $atts = array();
            $atts['href'] = get_permalink( $page->ID );
    */
            /**
             * Filters the HTML attributes applied to a page menu item's anchor element.
             *
             * @since 4.8.0
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             *     @type string $href The href attribute.
             * }
             * @param WP_Post $page         Page data object.
             * @param int     $depth        Depth of page, used for padding.
             * @param array   $args         An array of arguments.
             * @param int     $current_page ID of the current page.
             */
        /*    $atts = apply_filters( 'page_menu_link_attributes', $atts, $page, $depth, $args, $current_page );
    
            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
    */
         /*   $output .= $indent . sprintf(
                '<div class="%s"><a%s>%s%s%s</a>',
                $css_classes,
                $attributes,
                $args['link_before'],
                // This filter is documented in wp-includes/post-template.php 
                apply_filters( 'the_title', $page->post_title, $page->ID ),
                $args['link_after']
            );
    */
         /*   if ( ! empty( $args['show_date'] ) ) {
                if ( 'modified' == $args['show_date'] ) {
                    $time = $page->post_modified;
                } else {
                    $time = $page->post_date;
                }
    
                $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
                $output .= " " . mysql2date( $date_format, $time );
            }*/
        }
    
        /**
         * Outputs the end of the current element in the tree.
         *
         * @since 2.1.0
         * @access public
         *
         * @see Walker::end_el()
         *
         * @param string  $output Used to append additional content. Passed by reference.
         * @param WP_Post $page   Page data object. Not used.
         * @param int     $depth  Optional. Depth of page. Default 0 (unused).
         * @param array   $args   Optional. Array of arguments. Default empty array.
         */
      /*  public function end_el( &$output, $page, $depth = 0, $args = array() ) {
            if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
                $t = "\t";
                $n = "\n";
            } else {
                $t = '';
                $n = '';
            }
            $output .= "</div>{$n}";
        }*/
    
    }
    

/**
 * Customizer Control: Repeater Helper.
 *
 * @package     Tikva Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       2.0
 */
class Tikva_Custom_Repeater_Helper
{

    /**
    * Get list of page entries to use in a dropdown field. 
    * It takes the results of wp_dropdown_pages() and parses the html content. 
    * The first attempt is to use the simplexml functions, but it has a fallback to regular expressions. 
    * Unfortunately it seemed easier to take the output of wp_dropdown_pages() instead of parse the raw 
    * input, because there are many efforts to build a tree-like structure in the output. 
    * 
    */
    public static function getPageDropdownOptions()
    {
        $dropdown = wp_dropdown_pages(
            array(
                'echo'              => 0,
                'show_option_none'  => __( '&mdash; Select &mdash;', 'tikva' ),
                'option_none_value' => '0',
                'selected'          => 0,
            )
        );
       // print_r($dropdown);
    
/*        $pages = get_pages(); 
        foreach ( $pages as $page ) {
            echo "\n" . $page->ID . "\n";
            echo "\n" . $page->post_title . "\n";
            var_dump($page);
            
        }
*/
        $walker = new Tikva_Walker_Page();
        wp_list_pages(array('echo' => false, 
        'title_li' => '',
        'walker' => $walker));
        //print_r($p);
        //print_r($walker->pageEntries);
        $pageEntries = $walker->pageEntries;
        array_unshift($pageEntries,array('name' =>  __( '&mdash; Select &mdash;', 'tikva' ),
        'class' => 'level-0',
        'value' => 0));
       return $pageEntries;
    
      /*  if (function_exists('simplexml_load_string')) {
            //libxml_use_internal_errors(true);
            $document = '<temp>' . html_entity_decode($dropdown) . '</temp>'; 
            print_r($document);
            $xml = simplexml_load_string($document);
            $options = $xml->select->option;
            $pageEntries = array();
            foreach ($options as $option) {
                $pageEntries[] = array('name' => htmlentities((string) $option),
                'class' => (string) $option['class'],
                'value' => (string) $option['value']);
            }
            
            print_r($pageEntries);
            die;
        } else {*/
            $dropdownLines = preg_split("/\n/",$dropdown);
            $pageEntries = array();
            foreach ($dropdownLines as $pageEntry) {
                if (!preg_match("/.*<option[\s.]*(class=\"(.*)\"){0,1}\s{0,1}.*value.*=.*\"(.*)\".*>(.*)<.*/",$pageEntry,$ma)) {
                    continue;
                }
                $pageEntries[] = array('name' => $ma[4],
                'class' => $ma[2],
                'value' => $ma[3]);
    
                //print "matched: " . $pageEntry . "\n";
                //print_r($ma);
            }
                        
        /*}*/
        return $pageEntries;
    }

    /**
    * Get a list of posts ordered by date descending to use in a dropdown field. 
    * The return array is fully compatible to getPageDropdownOptions()
    *
    * @see getPageDropdownOptions()
    */
    public static function getPostDropdownOptions()
    {
        $pageEntries = array();
        $pageEntries[] = array('name' => __('&mdash; Select &mdash;', 'tikva'),
        'class' => '',
        'value' => 0 );
        $latest = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        while ($latest->have_posts()) {
            $latest->the_post();
            $pageEntries[] = array('name' => the_title('', '', false),
            'class' => '',
            'value' => get_the_ID());
            //echo "<option " . " value='" . get_the_ID() . "'>" . the_title('', '', false) . "</option>";
        }
        return $pageEntries;
    }
}
