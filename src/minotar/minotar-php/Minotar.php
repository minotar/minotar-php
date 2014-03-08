<?php

namespace Minotar;

use \Illuminate\Container\Container;

/**
 * This class is responsible for instantiation of new MinotarDisplay's
 * @package Minotar
 */
class Minotar {

    /**
     * @var array List of default configurations, as used in make(). The "cache" is capitalized and passed off to
     *            desarrolla2/Cache. See the docs on that here: https://github.com/desarrolla2/Cache
     */
    protected static $default = array(
        'cache'    => null,
        'time'     => 60,
        'encoder'  => null
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
    public static function make($config = array())
    {
        $finalConfig = array_merge(self::$default, $config);

        return self::app()->make('Minotar\\MinotarDisplay', array($finalConfig));
    }

    /**
     * Returns a new cache adapter, for use in the make()
     * @return object
     */
    public static function adapter()
    {
        $args = func_get_args();

        $adapter_name = array_shift($args);
        $adapter_path = 'Desarrolla2\\Cache\\Adapter\\' . ucfirst($adapter_name);

        $reflection = new \ReflectionClass($adapter_path);

        return $reflection->newInstanceArgs(func_get_args());
    }

    /**
     * Returns a new image encoder, for use in the make()
     * @return object
     */
    public static function encoder()
    {
        $args = func_get_args();

        $adapter_name = array_shift($args);
        $adapter_path = 'Encoder\\' . ucfirst($adapter_name);

        $reflection = new \ReflectionClass($adapter_path);

        return $reflection->newInstanceArgs(func_get_args());
    }

    public static function app()
    {
        if (!self::$container) {
            self::$container = new Container;
        }

        return self::$container;
    }

    /**
     * Magic method to allow for quick calling of MinotarDisplays with the default config.
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $m = self::app()->make('Minotar\\MinotarDisplay', array(self::$default));

        return call_user_func_array(array($m, $name), $arguments);
    }
} 
