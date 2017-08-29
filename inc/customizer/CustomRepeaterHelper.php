<?php


class Tikva_Custom_Repeater_Helper
{

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
}
