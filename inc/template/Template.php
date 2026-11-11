<?php


/**
 * Wrapper for Twig PHP template system
 *
 * @package Azbalac_One
 * @since 0.1
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
        $cacheDirectory = WP_CONTENT_DIR . '/cache/azbalac-one/twig';
        $twigCache = false;

        if ((is_dir($cacheDirectory) || wp_mkdir_p($cacheDirectory)) && is_writable($cacheDirectory)) {
            $twigCache = $cacheDirectory;
        }

        $this->twig = new \Twig\Environment($twigLoader, [
            'cache' => $twigCache,
            'debug' => defined('WP_DEBUG') && WP_DEBUG,
            'auto_reload' => true,
        ]);
        $this->twig->addExtension(new Azbalac_Twig_Section_Extension());
    }

    public function render(string $name, array $context = array())
    {
        return $this->twig->render($name, $context);
    }
}
