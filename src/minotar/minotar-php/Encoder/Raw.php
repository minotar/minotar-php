<?php

namespace Minotar\Encoder;

use Minotar\MinotarEncoderInterface;
use Minotar\MinotarDl;

class Raw implements MinotarEncoderInterface
{

    public function make($config, $path)
    {
        return MinotarDl::makeUrl($path);
    }
} 
