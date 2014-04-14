<?php

/**
 * Created by PhpStorm.
 * User: geschke
 * Date: 20.02.14
 * Time: 18:54
 */
class JflMetaboxes
{

    public function __construct()
    {
        global $data;
        $this->data = $data;

        add_action('add_meta_boxes', array($this, 'jfl_add_meta_boxes'));
        add_action('save_post', array($this, 'jfl_save_meta_boxes'));
    }

    public function jfl_add_meta_boxes()
    {
        $this->jfl_add_meta_box('jfl_post_options', 'Post Options', 'post');
        $this->jfl_add_meta_box('jfl_page_options', 'Page Options', 'page');
    }

    public function jfl_add_meta_box($id, $label, $post_type)
    {
        add_meta_box(
            'jfl_' . $id,
            $label,
            array($this, $id),
            $post_type
        );
    }

    public function jfl_save_meta_boxes($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        foreach ($_POST as $key => $value) {
            if (strstr($key, 'jfl_')) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    public function pageOptions()
    {
        echo '<h2 style="margin-top:0;">' . _e('Theme Options:', 'jfl') . '</h2>';
        $this->jfl_select('featured_post',
            __('Featured Post', 'jfl'),
            array('_0' => __('Not featured', 'jfl'),
                '_1' => __('Large Feature (Jumbotron)', 'jfl'),
                '_2' => __('Featured', 'jfl')),
            ''
        );

    }

    public function jfl_post_options()
    {
        $data = $this->data;
        $this->pageOptions(); //        get_template_part('inc/page_options');
        //require_once( get_template_directory() . '/inc/page_options.php' );
    }

    public function jfl_page_options()
    {
        $this->pageOptions(); //        get_template_part('inc/page_options');
        //get_template_part('inc/page_options');
        //require_once( get_template_directory() . '/inc/page_options.php' );
    }

    public function jfl_select($id, $label, $options, $desc = '')
    {
        global $post;

        $html = '';
        $html .= '<div class="jfl_metabox_field">';
        $html .= '<label for="jfl_' . $id . '">';
        $html .= $label;
        $html .= '</label>';
        $html .= '<div class="field">';
        $html .= '<select id="jfl_' . $id . '" name="jfl_' . $id . '">';
        foreach ($options as $key => $option) {
            if (get_post_meta($post->ID, 'jfl_' . $id, true) == $key) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }

            $html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
        }
        $html .= '</select>';
        if ($desc) {
            $html .= '<p>' . $desc . '</p>';
        }
        $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

}

$metaboxes = new JflMetaboxes();
