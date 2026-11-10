<?php
/**
 * Changelog
 */
$azbalac = wp_get_theme('azbalac');
?>

<div role="tabpanel" class="tab-pane fade" id="azbalac-tab-changelog">

<?php

function azbalac_show_changelog()
{
    global $wp_filesystem;

    if (empty($wp_filesystem)) {
        require_once ABSPATH . '/wp-admin/includes/file.php';

        if (!WP_Filesystem()) {
            echo '<p>' . esc_html__('The changelog could not be loaded.', 'azbalac') . '</p>';
            return;
        }
    }

    $changelog = $wp_filesystem->get_contents(get_template_directory() . '/CHANGELOG.md');

    if ($changelog === false) {
        echo '<p>' . esc_html__('The changelog could not be loaded.', 'azbalac') . '</p>';
        return;
    }

    $lines = preg_split('/\R/', $changelog);
    $listOpen = false;

    foreach ($lines as $line) {
        if (str_starts_with($line, '- ')) {
            if (!$listOpen) {
                echo '<ul>';
                $listOpen = true;
            }

            echo '<li>' . esc_html(substr($line, 2)) . '</li>';
            continue;
        }

        if ($listOpen) {
            echo '</ul>';
            $listOpen = false;
        }

        if (str_starts_with($line, '# ')) {
            echo '<h1>' . esc_html(substr($line, 2)) . '</h1>';
        } elseif (str_starts_with($line, '## ')) {
            echo '<h2>' . esc_html(substr($line, 3)) . '</h2>';
        } elseif (str_starts_with($line, '### ')) {
            echo '<h3>' . esc_html(substr($line, 4)) . '</h3>';
        } elseif ($line !== '') {
            echo '<p>' . esc_html($line) . '</p>';
        }
    }

    if ($listOpen) {
        echo '</ul>';
    }
}

azbalac_show_changelog();
?>

</div>
