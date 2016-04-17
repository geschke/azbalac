<?php
if (!class_exists('WP_Customize_Control'))
    return NULL;

/**
 * Class to create a custom layout control
 */
class Tikva_Custom_Layout_Picker extends WP_Customize_Control
{

    /**
     * Render the content on the theme customizer page
     */
    public function render_content()
    {
        $themeUrl = get_template_directory_uri();
        $imageUrl = $themeUrl . '/images/admin/';
        
        ?>
        <label>
            <span class="customize-layout-control"><?php echo esc_html($this->label); ?></span>
            <ul>
                <li><img src="<?php echo $imageUrl; ?>1col.png" alt="Full Width" /><input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>[full_width]" value="1" /></li>
                <li><img src="/2cl.png" alt="Left Sidebar" /><input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>[left_sidebar]" value="1" /></li>
                <li><img src="/2cr.png" alt="Right Sidebar" /><input type="radio" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>[right_sidebar]" value="1" /></li>
            </ul>
        </label>
        <?php
    }

}
?>