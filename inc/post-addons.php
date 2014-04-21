<?php

/**
 * Created by PhpStorm.
 * User: geschke
 * Date: 20.02.14
 * Time: 18:54
 */
class TikvaMetaboxes
{

    public function __construct()
    {
        global $data;
        $this->data = $data;

        add_action('add_meta_boxes', array($this, 'tikva_add_meta_boxes'));
        add_action('save_post', array($this, 'tikva_save_meta_boxes'));
    }

    public function tikva_add_meta_boxes()
    {
        $this->tikva_add_meta_box('tikva_post_options', 'Post Options', 'post');
        $this->tikva_add_meta_box('tikva_page_options', 'Page Options', 'page');
    }

    public function tikva_add_meta_box($id, $label, $post_type)
    {
        add_meta_box(
            'tikva_' . $id,
            $label,
            array($this, $id),
            $post_type
        );
    }

    public function tikva_save_meta_boxes($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        foreach ($_POST as $key => $value) {
            if (strstr($key, 'tikva_')) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    public function pageOptions()
    {
        echo '<h2 style="margin-top:0;">' . _e('Theme Options:', 'tikva') . '</h2>';
        $this->tikva_select('featured_post',
            __('Featured Post', 'tikva'),
            array('_0' => __('Not featured', 'tikva'),
                '_1' => __('Large Feature (Jumbotron)', 'tikva'),
                '_2' => __('Featured', 'tikva')),
            ''
        );

    }

    public function tikva_post_options()
    {
        $data = $this->data;
        $this->pageOptions(); //        get_template_part('inc/page_options');
        //require_once( get_template_directory() . '/inc/page_options.php' );
    }

    public function tikva_page_options()
    {
        $this->pageOptions(); //        get_template_part('inc/page_options');
        //get_template_part('inc/page_options');
        //require_once( get_template_directory() . '/inc/page_options.php' );
    }

    public function tikva_select($id, $label, $options, $desc = '')
    {
        global $post;

        $html = '';
        $html .= '<div class="tikva_metabox_field">';
        $html .= '<label for="tikva_' . $id . '">';
        $html .= $label;
        $html .= '</label>';
        $html .= '<div class="field">';
        $html .= '<select id="tikva_' . $id . '" name="tikva_' . $id . '">';
        foreach ($options as $key => $option) {
            if (get_post_meta($post->ID, 'tikva_' . $id, true) == $key) {
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

$metaboxes = new TikvaMetaboxes();
