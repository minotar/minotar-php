<?php

namespace Minotar;


interface MinotarEncoderInterface {
    /**
     * Returns a response for the given image string
     * @param $config array
     * @param $data string
     */
    public function make($config, $data);
} 
