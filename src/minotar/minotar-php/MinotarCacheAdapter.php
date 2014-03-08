<?php

namespace Minotar;

use Desarrolla2\Cache\Adapter\AbstractAdapter;

class MinotarCacheAdapter implements MinotarAdapterInterface
{

    /**
     * @var AbstractAdapter The cache adapter
     */
    protected $adapter;

    /**
     * @var array Configuration options we're using
     */
    protected $config;

    /**
     * @var MinotarDl Class used to download the remote Minotars
     */
    protected $dl;

    public function __construct(AbstractAdapter $adapter, MinotarDl $dl)
    {
        $this->adapter = $adapter;
        $this->dl = $dl;
    }

    public function retrieve($config, $path)
    {
        $this->config = $config;

        list($date, $data) = $this->getFromCache(md5($path));

        if ($date + $config['time'] < time()) {
            $data = $this->getFromSource($path);
        }

        return $data;
    }

    /**
     * Gets an image from the cache, if possible.
     * @param $md5_path
     * @return array|bool
     */
    public function getFromCache($md5_path)
    {
        if (!$this->adapter->has($md5_path)) {
            return false;
        }

        return explode('|', $this->adapter->get($md5_path), 2);
    }

    /**
     * Retrieves the image from Minotar's servers, caching it on the way back if it was successful
     * @param $path
     * @return bool|mixed
     */
    public function getFromSource($path)
    {
        $image = $this->dl->download($this->config, $path);

        if (!$image) {
            return false;
        }

        $this->setCache(md5($path), $image);
        return $image;
    }

    /**
     * Sets the cache for the given path with the given data
     * @param $path
     * @param $data
     */
    protected function setCache($path, $data)
    {
        $write = implode('|', array(time(), $data));
        $this->adapter->set($path, $write);
    }
} 
