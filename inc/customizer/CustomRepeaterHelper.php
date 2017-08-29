<?php


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
                'show_option_none'  => __( '&mdash; Select &mdash;' ),
                'option_none_value' => '0',
                'selected'          => 0,
            )
        );
        //print_r($dropdown);
    
        if (function_exists('simplexml_load_string')) {
            $document = '<temp>' . html_entity_decode($dropdown) . '</temp>'; 
            $xml = simplexml_load_string($document);
            $options = $xml->select->option;
            $pageEntries = array();
            foreach ($options as $option) {
                $pageEntries[] = array('name' => htmlentities((string) $option),
                'class' => (string) $option['class'],
                'value' => (string) $option['value']);
            }
        } else {
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
                        
        }
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
