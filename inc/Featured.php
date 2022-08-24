<?php

/**
 * Implements Featured Posts Access Functions
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */

class Azbalac_Featured 
{

    private $featuredPosts = null;

    private $postsLarge = null;
    private $postsStandard = null;
    private $postsFeaturedMagStyle1 = null;

    public function __construct()
    {


    }

    public function getFeaturedPosts()
    {
        
        return ['posts_large' => $this->getLargePosts(),
                'posts_standard' => $this->getStandardPosts(),
                'posts_mag_style1' => $this->getMagStyle1Posts()];
        
    }

    public function getMagStyle1Posts()
    {
        // todo later: generalize
        $this->parsePosts();

        $azbalacContainer = Azbalac_DataContainer::getInstance();


        global $post; // blergh!!!
        
        // if available, get all posts with this identifier _3
        if (isset($this->postsFeaturedMagStyle1) && is_array($this->postsFeaturedMagStyle1) && count($this->postsFeaturedMagStyle1)) {
            //$postIndex = 1; // we're using Twig, so this is not necessary
            foreach ( $this->postsFeaturedMagStyle1 as $order => $post) {
                setup_postdata( $post );
                //$post->postIndex = $postIndex;

                get_template_part('content','featured-post-mag-style1');
                
                $contentFeatured[] = $azbalacContainer->contentFeaturedPostMagStyle1;

                //$postIndex++;
            }

            return $contentFeatured;
        }
        return null;
        
    }

    public function getLargePosts() 
    {
        $this->parsePosts();

        $azbalacContainer = Azbalac_DataContainer::getInstance();


        global $post; // blergh!!!
        
        // if available, use jumbotron with one and only large featured post
        if (isset($this->postsLarge) && is_array($this->postsLarge) && count($this->postsLarge)) {
            foreach ( $this->postsLarge as $order => $post) {
                setup_postdata( $post );
                get_template_part('content','featured-post-large');

                $contentFeatured[] = $azbalacContainer->contentFeaturedPostLarge;

            }

            return $contentFeatured;
        }
        return null;
        
    }

    public function getStandardPosts() 
    {
        $this->parsePosts();
        $azbalacContainer = Azbalac_DataContainer::getInstance();
        
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
                    $post->linebreak = false;
                    if ($countFeaturedStandard > $postNumber - $colsFeaturedFirst + 1 &&
                        ($postNumber - $colsFeaturedFirst + 1) % $colsFeaturedLast == 1 &&
                        $postNumber != 0) {
                            $post->linebreak = true;
                        #echo '</div><div class="row">';
                    }
                }
                $post->postNumber = $postNumber++;
    
                    // Include the featured content template.
                get_template_part( 'content', 'featured-post' );
                
              
                $contentFeatured[] = $azbalacContainer->contentFeaturedPost;
              
            }
           
            return $contentFeatured;
        }
        return null;
    }

    protected function getPosts()
    {
        if (!$this->featuredPosts) {
            $this->featuredPosts = azbalac_get_featured_posts();
        }
        return $this->featuredPosts;
    }

    protected function parsePosts()
    {
        $featuredPosts = $this->getPosts();

        if ($this->postsLarge !== null && $this->postsStandard !== null && $this->postsFeaturedMagStyle1 !== null) {
            return;
        }
        $this->postsLarge = [];
        $this->postsStandard = [];
        $this->postsFeaturedMagStyle1 = [];
        foreach ($featuredPosts as $featuredPost) {
            $featured = get_post_meta($featuredPost->ID, 'azbalac_featured_post', true);
            //print "post: " . $featuredPost->ID . "<br/>";
            //var_dump($featured);
            if ($featured == '_1') {
                $this->postsLarge[] = $featuredPost;
            } elseif ($featured == '_2') {
                $this->postsStandard[] = $featuredPost;
            } elseif ($featured == '_3') {
                $this->postsFeaturedMagStyle1[] = $featuredPost;
            }
        }

    }

    
    
}