<?php

namespace Minotar;


interface MinotarEncoderInterface {
    /**
     * Returns a response for the given image string
     * @param $data string
     */
    public function make($data);
} 
