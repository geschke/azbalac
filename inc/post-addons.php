<?php

/**
 * Created by PhpStorm.
 * User: geschke
 * Date: 20.02.14
 * Time: 18:54
 */
class AzbalacMetaboxes
{

    public function __construct()
    {
        global $data;
        $this->data = $data;

        add_action('add_meta_boxes', array($this, 'azbalac_add_meta_boxes'));
        add_action('save_post', array($this, 'azbalac_save_meta_boxes'));
    }

    public function azbalac_add_meta_boxes()
    {
        $this->azbalac_add_meta_box('azbalac_post_options', 'Post Options', 'post');
        $this->azbalac_add_meta_box('azbalac_page_options', 'Page Options', 'page');
    }

    public function azbalac_add_meta_box($id, $label, $post_type)
    {
        add_meta_box(
            'azbalac_' . $id,
            $label,
            array($this, $id),
            $post_type
        );
    }

    public function azbalac_save_meta_boxes($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        foreach ($_POST as $key => $value) {
            if (strstr($key, 'azbalac_')) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    public function pageOptions()
    {
        echo '<h2 style="margin-top:0;">' . _e('Theme Options:', 'azbalac') . '</h2>';
        $this->azbalac_select('featured_post',
            __('Featured Post', 'azbalac'),
            array('_0' => __('Not featured', 'azbalac'),
                '_1' => __('Large Feature (Jumbotron)', 'azbalac'),
                '_2' => __('Featured Classic', 'azbalac'),
                '_3' => __('Featured Mag Style 1', 'azbalac')
            ),
            ''
        );

    }

    public function azbalac_post_options()
    {
        $data = $this->data;
        $this->pageOptions(); //        get_template_part('inc/page_options');
        //require_once( get_template_directory() . '/inc/page_options.php' );
    }

    public function azbalac_page_options()
    {
        $this->pageOptions(); //        get_template_part('inc/page_options');
        //get_template_part('inc/page_options');
        //require_once( get_template_directory() . '/inc/page_options.php' );
    }

    public function azbalac_select($id, $label, $options, $desc = '')
    {
        global $post;

        $html = '';
        $html .= '<div class="azbalac_metabox_field">';
        $html .= '<label for="azbalac_' . $id . '">';
        $html .= $label;
        $html .= '</label>';
        $html .= '<div class="field">';
        $html .= '<select id="azbalac_' . $id . '" name="azbalac_' . $id . '">';
        foreach ($options as $key => $option) {
            if (get_post_meta($post->ID, 'azbalac_' . $id, true) == $key) {
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

$metaboxes = new AzbalacMetaboxes();
