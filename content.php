<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package tikva
 * @subpackage Themes
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php //tikva_post_thumbnail(); ?>

	<header class="entry-header">

        <?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
		?>

		<div class="entry-meta">
			<?php
				if ( 'post' == get_post_type() )
					tikva_posted_on();

				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :

                ?>
            &nbsp;&nbsp;<span class="comments-link"><?php
                    comments_popup_link( sprintf( __( '<span class="byline-icon fa fa-comment" aria-hidden="true"></span> Leave a comment<span class="screen-reader-text"> on %s</span>', 'tikva' ), get_the_title()),
                    __( '1 Comment', 'tikva' ), __( '% Comments', 'tikva' ) ); ?></span>&nbsp;&nbsp;
			<?php
				endif;

				edit_post_link( sprintf( __( ' <span class="byline-icon fa fa-pencil-square-o" aria-hidden="true"></span>Edit <span class="screen-reader-text">%s</span>', 'tikva' ), get_the_title()), '<span class="edit-link">', '</span>' );
			?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('medium');
        }

			the_content( '<br/><span class="btn btn-primary">'. sprintf( __('Continue reading<span class="screen-reader-text"> on %s</span><span class="meta-nav"> &raquo;</span>', 'tikva'), get_the_title()) );
		    wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:',
                        'tikva' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php the_tags( __('<span class="byline-icon fa fa-tags"></span> Tags: ','tikva'), ' ','' );

    $categories = get_the_category();
    $separator = ' ';
    $output = '';
    if($categories){
        echo "<div>";
        echo _n( 'Category:', 'Categories:', count($categories), 'tikva' );
        echo '<ul class="nav nav-pills">';
        foreach($categories as $category) {
            $output .= '<li><a href="'.get_category_link( $category->term_id ).'"
                title="' .
                esc_attr( sprintf( __( "View all posts in %s",'tikva' ), $category->name ) ) . '">'.$category->cat_name
                .'</a></li>'.$separator;
        }
        echo trim($output, $separator);
        echo '</ul></div>';

    }

    ?>
</article><!-- #post-## -->
