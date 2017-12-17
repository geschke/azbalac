<?php


/**
 * Wrapper for Twig PHP template system
 *
 * @package   Tikva7
 * @subpackage Tikva7
 * @since Tikva7 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Tikva_Template
{

    protected $twig;

    public function __construct()
    {
        $this->initialize();
    }


    public function initialize()
    {


        $twigLoader = new Twig_Loader_Filesystem(get_template_directory() . '/templates/src/');
        $this->twig = new Twig_Environment($twigLoader, array(
            'cache' => get_template_directory() . '/templates/cache/',
            'debug' => true // todo: set to false when upload to WordPress theme repository
        ));
    }

    public function render(string $name, array $context = array())
    {
        return $this->twig->render($name, $context);
    }
}