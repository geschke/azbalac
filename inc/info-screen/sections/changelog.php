<?php
/**
 * Changelog
 */

$Tikva = wp_get_theme( 'Tikva' );

?>
<div class="tikva-tab-pane" id="changelog">

	<div class="tikva-tab-pane-center">
	
		<h1>Tikva <?php if( !empty($Tikva['Version']) ): ?> <sup id="tikva-theme-version"><?php echo esc_attr( $Tikva['Version'] ); ?> </sup><?php endif; ?></h1>

	</div>

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$Tikva_changelog = $wp_filesystem->get_contents( get_template_directory().'/README.md' );
	$Tikva_changelog_lines = explode(PHP_EOL, $Tikva_changelog);
	foreach($Tikva_changelog_lines as $Tikva_changelog_line){
		if(substr( $Tikva_changelog_line, 0, 3 ) === "###"){
			echo '<h1>'.substr($Tikva_changelog_line,3).'</h1>';
		} else {
			echo $Tikva_changelog_line,'<br/>';
		}
	}

	?>
	
</div>