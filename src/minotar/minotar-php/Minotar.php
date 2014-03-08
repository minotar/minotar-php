<?php

namespace Minotar;

use \Illuminate\Container\Container;

/**
 * This class is responsible for instantiation of new MinotarDisplay's
 * @package Minotar
 */
class Minotar
{

    /**
     * @var array List of default configurations, as used in make(). The "cache" is capitalized and passed off to
     *            desarrolla2/Cache. See the docs on that here: https://github.com/desarrolla2/Cache
     */
    protected static $config = array(
        'time' => 60,
        'timeout' => 2
    );

    /**
     * @var Container IoC container from Laravel, to make testing happier!
     */
    protected static $container;

    /**
     * Returns an object, from the given config, that should be used to display Minotars on subsequent pages.
     * @param array $config
     * @return MinotarDisplay
     */
    public static function config($config = array())
    {
        self::$config = array_merge(self::$config, $config);
    }

    /**
     * Returns a new cache adapter, for use in the make()
     * @return object
     */
    public static function adapter()
    {
        $instance = self::spawn(func_get_args(), 'Desarrolla2\\Cache\\Adapter');

        self::app()->instance('Desarrolla2\\Cache\\Adapter\\AbstractAdapter', $instance);

        return $instance;
    }

    /**
     * Returns a new image encoder, for use in the make()
     * @return object
     */
    public static function encoder()
    {
        $instance = self::spawn(func_get_args(), 'Minotar\\Encoder');

        self::app()->instance('Minotar\\MinotarEncoderInterface', $instance);

        return $instance;
    }

    /**
     * Generates an object, with the given array of instantiation arguments
     * @param array $args The first element should be the name of the object
     * @param string $base Base namespace
     * @return object
     */
    protected static function spawn($args, $base)
    {
        $obj_name = array_shift($args);
        $obj_path = $base . '\\' . ucfirst($obj_name);

        return self::app()->make($obj_path, $args);
    }

    /**
     * Retrieve the IoC container for Minotar
     * @return Container
     */
    public static function app()
    {
        if (!self::$container) {
            self::$container = new Container;
            self::loadHooks();
        }

        return self::$container;
    }

    /**
     * Loads hooks.php and binds to the IoC container.
     */
    protected static function loadHooks()
    {
        $hooks = (require dirname(__FILE__) . '/hooks.php');

        foreach ($hooks as $abstract => $concrete) {
            self::app()->bind($abstract, $concrete);
        }
    }

    /**
     * Magic method to allow for quick calling of MinotarDisplays with the current config.
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $m = self::app()->make('Minotar\\MinotarDisplay', array(self::$config));

        return call_user_func_array(array($m, $name), $arguments);
    }
} 
