<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package jfl
 * @subpackage Themes
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php //twentyfourteen_post_thumbnail(); ?>

	<header class="entry-header">

        <?php




			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			endif;
		?>

		<div class="entry-meta">
			<?php
				if ( 'post' == get_post_type() )
					//twentyfourteen_posted_on();

				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'jfl' ),
                    __( '1 Comment', 'jfl' ), __( '% Comments', 'jfl' ) ); ?></span>
			<?php
				endif;

				edit_post_link( __( 'Edit', 'jfl' ), '<span class="edit-link">', '</span>' );
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
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'jfl' ) );
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:',
                        'jfl' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php the_tags( __('Tags: ','jfl'), ' ','' );

    $categories = get_the_category();
    $separator = ' ';
    $output = '';
    if($categories){
        echo "<div>Kategorien: ";
        echo '<ul class="nav nav-pills">';
        foreach($categories as $category) {
            $output .= '<li><a href="'.get_category_link( $category->term_id ).'"
                title="' .
                esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name
                .'</a></li>'.$separator;
        }
        echo trim($output, $separator);
        echo '</ul></div>';
    }

    ?>
</article><!-- #post-## -->
