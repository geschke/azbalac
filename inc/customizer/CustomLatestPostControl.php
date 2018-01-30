<?php
if (!class_exists('WP_Customize_Control'))
    return NULL;

/**
 * Create a Latest Post control
 * 
 * 
 * @link https://premium.wpmudev.org/blog/creating-custom-controls-wordpress-theme-customizer/
 */
class Azbalac_Custom_Latest_Post_Control extends WP_Customize_Control
{

    public $type = 'latest_post_dropdown';

    public function render_content()
    {

        $latest = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        ?>
        <label>
            <span class="customize-control-title "><?php echo esc_html($this->label); ?></span>
            <select <?php $this->link(); ?>>
                <?php
                echo '<option value="">' . __('&mdash; Select &mdash;', 'azbalac') . '</option>';
                while ($latest->have_posts()) {
                    $latest->the_post();
                    echo "<option " . selected($this->value(), get_the_ID()) . " value='" . get_the_ID() . "'>" . the_title('', '', false) . "</option>";
                }
                ?>
            </select>
        </label>
        <?php
    }

}
