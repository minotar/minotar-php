<?php

namespace Minotar;


interface MinotarEncoderInterface {
    /**
     * Gets the resource at the given path
     * @param $config array
     * @param $path string
     * @return mixed
     */
    public function get($config, $path);
} 
