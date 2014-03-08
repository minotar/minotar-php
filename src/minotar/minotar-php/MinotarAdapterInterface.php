<?php

namespace Minotar;

interface MinotarAdapterInterface
{
    /**
     * Gets the image file, from source or cache, with the config for the given path
     * @param $config array
     * @param $path string
     * @return string
     */
    public function retrieve($config, $path);
} 
