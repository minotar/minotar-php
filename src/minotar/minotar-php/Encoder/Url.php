<?php

namespace Minotar\Encoder;

use Minotar\MinotarEncoderInterface;

class Url implements MinotarEncoderInterface
{

    /**
     * @var string Base URL passed in during instantiation
     */
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function make($config, $path)
    {
        return $this->url . '?minotar=' . urlencode($path);
    }
} 
