<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage tikva
 * @since tikva 0.1
 */

get_header(); ?>

<div class="row">


    <div id="main-content" class="main-content">

<?php
$layoutStyle = tikva_get_layout();

if ( is_front_page() && tikva_has_featured_posts() ) {
    // Include the featured content template.
    get_template_part( 'featured-content' );
    //   echo "<h1>show featured content</h1>";
}


if ($layoutStyle['content'] == 2) {
    ?>
    <div class="<?php echo $layoutStyle['col_2']; ?>">
        <?php get_sidebar( 'content' );
        get_sidebar();
        ?>
    </div>
<?php
}
?>

    <div class="<?php echo $layoutStyle['col_1']; ?>">

        <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'tikva' ), get_search_query() ); ?></h1>
			</header><!-- .page-header -->

				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

					endwhile;
					// Previous/next post navigation.
					tikva_paging_nav();

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>

		    </div><!-- #content -->
        </div><!-- #primary -->
    </div>

    <?php

    if ($layoutStyle['columns'] == 2) {
        if ($layoutStyle['content'] == 1) {
            ?>
            <div class="<?php echo $layoutStyle['col_2']; ?>">
                <?php get_sidebar( 'content' );
                get_sidebar();
                ?>
            </div>
        <?php
        }
    } ?>


</div><!-- #main-content -->

    </div><!-- row -->

<?php
get_footer();
