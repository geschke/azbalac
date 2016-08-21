<?php
/**
 * Changelog
 */
$Tikva = wp_get_theme('Tikva');
?>

<div role="tabpanel" class="tab-pane fade" id="tikva-tab-changelog">

<?php

function tikva_show_changelog()
{
    WP_Filesystem();
    global $wp_filesystem;
    $changelog = $wp_filesystem->get_contents(get_template_directory() . '/README.md');
    $lines = explode(PHP_EOL, $changelog);
    foreach ($lines as $line) {
        if (substr($line, 0, 2) === "# ") {
            echo '<h1>' . substr($line, 2) . '</h1>';
        } elseif (substr($line, 0, 3) === "## ") {
            echo '<h2>' . substr($line, 3) . '</h2>';
        } elseif (substr($line, 0, 4) === "### ") {
            echo '<h3>' . substr($line, 4) . '</h3>';
        } elseif (substr($line, 0, 2) === "- ") {
            echo '<li>' . substr($line, 2) . '</li>';
        } elseif (substr($line, 0, 3) === " - ") {
            echo '<li>' . substr($line, 3) . '</li>';
        } else {
            echo $line, '<br/>';
        }
    }
}

tikva_show_changelog();
?>

</div>