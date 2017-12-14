<?php

/**
 * Implements Featured Posts Access Functions
 *
 * @package   Tikva7
 * @subpackage Tikva7
 * @since Tikva7 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */

class Tikva_Featured 
{

    private $featuredPosts = null;

    private $postsLarge = null;
    private $postsStandard = null;

    public function __construct()
    {


    }

    public function getFeaturedPosts()
    {
        
        return ['posts_large' => $this->getLargePosts(),
                'posts_standard' => $this->getStandardPosts()];
        
    }

    public function getLargePosts() 
    {
        $this->parsePosts();

        $tikvaContainer = Tikva_DataContainer::getInstance();


        global $post; // blergh!!!

        // if available, use jumbotron with one and only large featured post
        if (isset($this->postsLarge) && is_array($this->postsLarge) && count($this->postsLarge)) {
            foreach ( $this->postsLarge as $order => $post) {
                setup_postdata( $post );
                get_template_part('content','featured-post-large');

                $contentFeatured[] = $tikvaContainer->contentFeaturedPostLarge;

            }

            return $contentFeatured;
        }
        return null;
        
    }

    public function getStandardPosts() 
    {
        $this->parsePosts();
        $tikvaContainer = Tikva_DataContainer::getInstance();
        
        global $post; // blergh!!!
        if (isset($this->postsStandard) && is_array($this->postsStandard) && count($this->postsStandard)) {
            
         
            $countFeaturedStandard = count($this->postsStandard);
            // echo "featuredstandard";
            // var_dump($countFeaturedStandard);
            
            if ($countFeaturedStandard >= 6) {
                $colsFeaturedFirst = $countFeaturedStandard % 3;
                $countFeaturedStandard -= $colsFeaturedFirst;
                $rowsFeaturedLast = $countFeaturedStandard / 3;
                $colsFeaturedLast = 3;
            }
            elseif ($countFeaturedStandard % 3 == 0) {
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
                // 1
                $colsFeaturedFirst = 1;
                $rowsFeaturedLast = 0;
                $colsFeaturedLast = 0;
            } elseif ($countFeaturedStandard % 3 == 2) {
                // 5
                $colsFeaturedFirst = 1;
                $rowsFeaturedLast = (--$countFeaturedStandard) / 2;
                $colsFeaturedLast = 2;
            }

            
    
    
            // print "countStandard:" . $countFeaturedStandard . " colsFirst : " . $colsFeaturedFirst . " rowslast: " . $rowsFeaturedLast . " colsLast " . $colsFeaturedLast;
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
            $postNumber = 0;
            
            $colsFeaturedFirstIndex = 0;
            if ($colsFeaturedFirst) {
                $colsFeaturedFirstIndex = $colsFeaturedFirst;
            
            }
            $colsTranslate = array(3 => 4,
                2 => 6,
                1 => 12);

            foreach ( $this->postsStandard as $order => $post ) {
                setup_postdata( $post );
                if ($colsFeaturedFirstIndex) {
                    // in first row
                    // 3: 4, 2: 6, 1: 12
                    $post->themeCols = $colsTranslate[$colsFeaturedFirst];
                    $colsFeaturedFirstIndex--;
                } else {
                    $post->themeCols = $colsTranslate[$colsFeaturedLast];
                    if ($countFeaturedStandard > $postNumber - $colsFeaturedFirst + 1 &&
                        ($postNumber - $colsFeaturedFirst + 1) % $colsFeaturedLast == 1 &&
                        $postNumber != 0) {
                        echo '</div><div class="row">';
                    }
                }
                $post->postNumber = $postNumber++;
    
                    // Include the featured content template.
                get_template_part( 'content', 'featured-post' );
                
              
                $contentFeatured[] = $tikvaContainer->contentFeaturedPost;
              
            }
            return $contentFeatured;
        }
        return null;
    }

    protected function getPosts()
    {
        if (!$this->featuredPosts) {
            $this->featuredPosts = tikva_get_featured_posts();
        }
        return $this->featuredPosts;
    }

    protected function parsePosts()
    {
        $featuredPosts = $this->getPosts();

        if ($this->postsLarge !== null && $this->postsStandard !== null) {
            return;
        }
        $this->postsLarge = [];
        $this->postsStandard = [];
        foreach ($featuredPosts as $featuredPost) {
            $featured = get_post_meta($featuredPost->ID, 'tikva_featured_post', true);
            //print "post: " . $featuredPost->ID . "<br/>";
            //var_dump($featured);
            if ($featured == '_1') {
                $this->postsLarge[] = $featuredPost;
            } elseif ($featured == '_2') {
                $this->postsStandard[] = $featuredPost;
            }
        }

    }

    
    
}