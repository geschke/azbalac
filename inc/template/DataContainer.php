<?php



/**
 * DataContainer is a simple transporter for frontend data
 *
 * @package   Azbalac
 * @subpackage Azbalac
 * @since Azbalac 0.1
 * @copyright Copyright (c) 2017, Ralf Geschke.
 * @license   GPL2+
 */
class Azbalac_DataContainer
{
    private static $instance = null;

    protected $data;

    public function __construct()
    {
    }

    public static function getInstance() 
    {
        if ( self::$instance === null) {
            self::$instance = new Azbalac_DataContainer();
        }
        return self::$instance;
    }


    public function __set(string $key, $value) 
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        return $this->data[$key];
    }


}