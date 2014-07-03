<?php
/**
 * Custom template tags for this theme.
 *
 * @package Tikva
 */

if (!function_exists('tikva_paging_nav')) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     *
     * @return void
     */
    function tikva_paging_nav()
    {
        // Don't print empty markup if there's only one page.
        if ($GLOBALS['wp_query']->max_num_pages < 2) {
            return;
        }

        $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $query_args = array();
        $url_parts = explode('?', $pagenum_link);

        if (isset($url_parts[1])) {
            wp_parse_str($url_parts[1], $query_args);
        }

        $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
        $pagenum_link = trailingslashit($pagenum_link) . '%_%';

        $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

// Set up paginated links.
        $links = paginate_links(array(
            'base' => $pagenum_link,
            'format' => $format,
            'total' => $GLOBALS['wp_query']->max_num_pages,
            'current' => $paged,
            'mid_size' => 1,
            'add_args' => array_map('urlencode', $query_args),
            'prev_text' => __('&laquo; Previous', 'tikva'),
            'next_text' => __('Next &raquo;', 'tikva'),
            'type' => 'array'
        ));

        if ($links) :

            ?>
            <nav class="navigation paging-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php _e('Posts navigation', 'tikva'); ?></h2>
                <ul class="pagination loop-pagination">
                    <?php
                    foreach ($links as $link) {
                        echo '<li>' . $link . '</li>';
                    }
                    ?>
                </ul>
                <!-- .pagination -->
            </nav><!-- .navigation -->
        <?php
        endif;
    }
endif;


if (!function_exists('tikva_posted_on')) :
    /**
     * Print HTML with meta information for the current post-date/time and author.
     *
     * @since Tikva 0.1.5
     */
    function tikva_posted_on()
    {
        if (is_sticky() && is_home() && !is_paged()) {
            echo '<span class="featured-post">' . __('Sticky', 'tikva') . '</span>&nbsp;&nbsp;';
        }
        // Set up and print post meta information.
        printf('<span class="entry-date"><a href="%1$s" rel="bookmark"><span class="byline-icon glyphicon glyphicon-time"></span>' . __('<span class="screen-reader-text">Date: </span>', 'tikva') . '<time class="entry-date" datetime="%2$s">%3$s</time></a></span>&nbsp;&nbsp;&nbsp;',
            esc_url(get_permalink()),
            esc_attr(get_the_date('c')),
            esc_html(get_the_date())
        );
        printf('<span class="byline"><span class="author vcard"><a class="url fn n" href="%1$s" rel="author"><span class="byline-icon glyphicon glyphicon-user"></span>' . __('<span class="screen-reader-text">Author: </span>', 'tikva') . '%2$s</a></span></span>',
            esc_url(get_author_posts_url(get_the_author_meta('ID'))),
            esc_html(get_the_author())
        );


    }
endif;

