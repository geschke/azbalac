<?php


/**
 * Wrapper for Twig PHP template system
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_Template
{

    protected $twig;

    public function __construct()
    {
        $this->initialize();
    }


    public function initialize()
    {

        $twigLoader = new \Twig\Loader\FilesystemLoader(get_template_directory() . '/templates/src/');
        $this->twig = new \Twig\Environment($twigLoader, [
            'cache' => get_template_directory() . '/templates/cache/',
            'debug' => true // todo: set to false when upload to WordPress theme repository
        ]);
        $this->twig->addExtension(new Azbalac_Twig_Section_Extension());
    }

    public function render(string $name, array $context = array())
    {
        return $this->twig->render($name, $context);
    }
}