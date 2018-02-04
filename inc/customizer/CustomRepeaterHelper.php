<?php

/**
 * Walker to generate array of pages with ids and indents
 *
 * @package     Azbalac Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       0.5.2
 */
class Azbalac_Walker_Page extends Walker_Page
{
    

    /**
     * Array to store page values
     */
    public $pageEntries;

    
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
    public function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0) 
    {
        $t = "&nbsp;&nbsp;";
        if ($depth) {
            $indent = str_repeat( $t, $depth );
        } else {
            $indent = '';
        }
        $this->pageEntries[] = array('name' => $indent . $page->post_title,
        'class' => 'level-' . $depth,
        'value' => $page->ID);
    }
}
    

/**
 * Customizer Control: Repeater Helper.
 *
 * @package     Azbalac Controls
 * @subpackage  Controls
 * @copyright   Copyright (c) 2018, Ralf Geschke
 * @license     https://opensource.org/licenses/MIT
 * @since       0.1.0
 */
class Azbalac_Custom_Repeater_Helper
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
    
        $walker = new Azbalac_Walker_Page();
        wp_list_pages(array('echo' => false,
        'title_li' => '',
        'walker' => $walker));
       
        $pageEntries = $walker->pageEntries;
        array_unshift($pageEntries, array('name' =>  __( '&mdash; Select &mdash;', 'azbalac' ),
        'class' => 'level-0',
        'value' => 0));
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
        $pageEntries[] = array('name' => __('&mdash; Select &mdash;', 'azbalac'),
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
         
        }
        return $pageEntries;
    }
}
