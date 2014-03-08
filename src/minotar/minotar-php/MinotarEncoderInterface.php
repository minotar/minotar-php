<?php

namespace Minotar;


interface MinotarEncoderInterface {
    /**
     * Returns a response for the given image string
     * @param $config array
     * @param $data string|\Symfony\Component\HttpFoundation\Response
     */
    public function make($config, $data);
} 
