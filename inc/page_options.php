
<h2 style="margin-top:0;"><?php _e( 'Theme Options:', 'jfl' ); ?></h2>
<?php
$this->jfl_select(	'featured_post',
                    __( 'Featured Post', 'jfl' ),
				array('_0' =>  __( 'Not featured', 'jfl' ),
                    '_1' =>  __( 'Large Feature (Jumbotron)', 'jfl' ),
                    '_2' =>  __( 'Featured', 'jfl' )),
				''
			);
?>
