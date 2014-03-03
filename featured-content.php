<?php
/**
 * The template for displaying featured content
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<div id="featured-content" class="featured-content">
	<div class="featured-content-inner">
	<?php
		/**
		 * Fires before the jfl featured content.
		 *
		 * @since jfl 1.0
		 */
		do_action( 'jfl_featured_posts_before' );

		$featured_posts = jfl_get_featured_posts();
        foreach ($featured_posts as $featured_post) {
            $featured = get_post_meta($featured_post->ID, 'jfl_featured_post', true);
            if ($featured == '_1') {
                $featureLarge[] = $featured_post;
            } elseif ($featured == '_2') {
                $featuredStandard[] = $featured_post;
            }
        }

        // if available, use jumbotron with one and only large featured post
        if (isset($featureLarge) && count($featureLarge)) {
            foreach ( $featureLarge as $order => $post) {
                setup_postdata( $post );
                get_template_part('content','featured-post-large');
            }
        }


    if (isset($featuredStandard) && count($featuredStandard)) {


        $countFeaturedStandard = count($featuredStandard);
        if ($countFeaturedStandard >= 6) {
            $colsFeaturedFirst = $countFeaturedStandard % 3;
            $countFeaturedStandard -= $colsFeaturedFirst;
            $rowsFeaturedLast = $countFeaturedStandard / 3;
            $colsFeaturedLast = 3;
        }
        else {
            if ($countFeaturedStandard % 3 == 0) {
                // 3
                $colsFeaturedFirst = 0;
                $rowsFeaturedLast = $countFeaturedStandard / 3;
                $colsFeaturedLast = 3;
            } elseif ($countFeaturedStandard % 2 == 0) {
                // 4 or 2
                $colsFeaturedFirst = 0;
                $rowsFeaturedLast = $countFeaturedStandard / 2;
                $colsFeaturedLast = 2;
            } elseif ($countFeaturedStandard % 3 == 1) {
                // 5 or 1
                $colsFeaturedFirst = 1;
                $rowsFeaturedLast = (--$countFeaturedStandard) / 2;
                $colsFeaturedLast = 2;
            }

        }


        print "countStandard:" . $countFeaturedStandard . " colsFirst : " . $colsFeaturedFirst . " rowslast: " . $rowsFeaturedLast . " colsLast " . $colsFeaturedLast;
        /*

        10 mod = 1 res 3
        9 mod = 0 res 3
        8 mod = 2 res 2 oder 3 + 3 + 2
        7 mod = 1 res 3 + 3 + 1
        6 mod = 0 res 3
        5 mod = 2 res 2 + 1
        4 mod = 1 res 2
        3 mod = 0 res 3
        2 mod = 2 res 2
        1 mod = 1 res 1
        */
    ?>
        <div class="container marketing">

             <div class="row">
        <?php
        $postNumber = 0;
        $colsFeaturedFirstIndex = 0;
		if ($colsFeaturedFirst)
            $colsFeaturedFirstIndex = $colsFeaturedFirst;

        foreach ( $featuredStandard as $order => $post ) {
			setup_postdata( $post );
            if ($colsFeaturedFirstIndex) {
                // in first row
            }
            $post->postNumber = $postNumber++;

           	 // Include the featured content template.
			get_template_part( 'content', 'featured-post' );
        }


        ?>
            </div>
        </div>

        <?php
    }

		/**
		 * Fires after the jfl featured content.
		 *
		 * @since jfl 1.0
		 */
		do_action( 'jfl_featured_posts_after' );

		wp_reset_postdata();
	?>
	</div><!-- .featured-content-inner -->
</div><!-- #featured-content .featured-content -->
