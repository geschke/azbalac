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

        if (wp_is_post_revision($post_id)) {
            return;
        }

        if (
            !isset($_POST['azbalac_meta_box_nonce'])
            || !is_string($_POST['azbalac_meta_box_nonce'])
        ) {
            return;
        }

        $nonce = sanitize_text_field(
            wp_unslash($_POST['azbalac_meta_box_nonce'])
        );

        if (!wp_verify_nonce($nonce, 'azbalac_save_meta_boxes')) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (!in_array(get_post_type($post_id), array('post', 'page'), true)) {
            return;
        }

        if (
            !isset($_POST['azbalac_featured_post'])
            || !is_string($_POST['azbalac_featured_post'])
        ) {
            return;
        }

        $featured_post = sanitize_key(
            wp_unslash($_POST['azbalac_featured_post'])
        );

        $allowed_values = array('_0', '_1', '_2', '_3');

        if (!in_array($featured_post, $allowed_values, true)) {
            return;
        }

        update_post_meta(
            $post_id,
            'azbalac_featured_post',
            $featured_post
        );
    }

    public function pageOptions()
    {
        wp_nonce_field(
            'azbalac_save_meta_boxes',
            'azbalac_meta_box_nonce'
        );

        echo '<h2 style="margin-top:0;">'
            . esc_html__('Theme Options:', 'azbalac')
            . '</h2>';
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
