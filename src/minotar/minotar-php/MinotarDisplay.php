<?php

namespace Minotar;

use \Desarrolla2\Cache\Adapter\AbstractAdapter;

class MinotarDisplay {

    /**
     * @var array Array of configuration options for the encoder
     */
    protected $config;

    /**
     * @var MinotarEncoderInterface The encoder to use
     */
    protected $encoder;

    /**
     * @var MinotarEncoderInterface The resource handler to use for displaying graphics
     */
    public $resource;

    public function __construct(array $config, MinotarEncoderInterface $encoder)
    {
        $this->config = $config;
        $this->encoder = $encoder;
    }

    /**
     * Gets the given config on the object.
     * @param string $opt If this is given, it will return the property request. Otherwise, returns the whole config arr
     * @return mixed
     * @throws Exception\ConfigNotFoundException
     */
    public function getConfig($opt = null)
    {
        if (!$opt) {
            return $this->config;
        }

        if ($this->doesConfigExist($opt)) {
            return $this->config[$opt];
        }

        return false;
    }

    /**
     * Sets the config on the MinotarDisplay
     * @param string|array $opt If this is an array, it will be merged with the existing config
     * @param mixed $value
     * @return $this
     */
    public function setConfig($opt, $value = null)
    {
        if ($value === null && is_array($opt)) {
            $this->config = array_merge($this->config, $opt);
        } else {
            $this->config[$opt] = $value;
        }

        return $this;
    }

    /**
     * Checks to see if the config option exists on the object, throwing an exception if it doesn't.
     * @param string $opt
     * @return bool
     * @throws Exception\ConfigNotFoundException
     */
    protected function doesConfigExist($opt)
    {
        if (!array_key_exists($opt, $this->config)) {
            throw new Exception\ConfigNotFoundException('The requested config ' . $opt . ' was not found');
        }

        return true;
    }

    /**
     * Gets a URL (or resource URI) to the avatar for the given username
     * @param $username
     * @param int $size
     * @return string
     */
    public function avatar($username, $size = null)
    {
        return $this->encoder->get($this->config, 'avatar/' . $username . '/size');
    }

    /**
     * Gets a URL (or resource URI) to the user helm for the given username
     * @param $username
     * @param int $size
     * @return string
     */
    public function helm($username, $size)
    {
        return $this->encoder->get($this->$config, 'helm/' . $username . '/size');
    }

    /**
     * Gets a URL (or resource URI) to the user skin for the given username
     * @param $username
     * @param int $size
     * @return string
     */
    public function skin($username, $size)
    {
        return $this->encoder->get($this->$config, 'avatar/' . $username . '/size');
    }
} 
