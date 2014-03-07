<?php

namespace Minotar;

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
     * Returns an object, from the given config, that should be used to display Minotars on subsequent pages.
     * @param array $config
     * @return MinotarDisplay
     */
    public static function make($config = array())
    {
        $finalConfig = array_merge(self::$default, $config);

        return new MinotarDisplay($finalConfig);
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

    public static function encoder()
    {
        $args = func_get_args();

        $adapter_name = array_shift($args);
        $adapter_path = 'Encoder\\' . ucfirst($adapter_name);

        $reflection = new \ReflectionClass($adapter_path);

        return $reflection->newInstanceArgs(func_get_args());
    }

    /**
     * Magic method to allow for quick calling of MinotarDisplays with the default config.
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __classStatic($name, $arguments)
    {
        $m = new MinotarDisplay(self::$default);

        if (!method_exists($m, $name)) {
            return \BadMethodCallException('Method ' . $m . ' does not exist on Minotar!');
        }

        return call_user_func_array(array($m, $name), $arguments);
    }
} 
