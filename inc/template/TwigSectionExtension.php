<?php


/**
 * Twig template engine extension for section contents
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.3
 * @copyright Copyright (c) 2018, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Twig_Section_Extension extends \Twig\Extension\AbstractExtension
{



    public function getFunctions()
    {

        return [
            new \Twig\TwigFunction('renderSocialMediaButtons', array($this, 'renderSocialMediaButtons')),
        ];
    }

    /**
     * Render section with social media buttons
     *
     * @param int       $position           Show output only when the position matches. Positions are defined in Customizer.php
     * @param boolean   $contentComplete    Show buttons as complete row (default, true) or buttons only (false)
     *
     * @return string The next value in the cycle
     */
    public function renderSocialMediaButtons($position, $contentComplete = true)
    {

        return Azbalac_Section_Social_Media_Buttons::getButtons($position, $contentComplete);
    }
}