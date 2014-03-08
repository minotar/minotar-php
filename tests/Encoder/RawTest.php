<?php

use Minotar\Encoder\Raw;

class RawTest extends PHPUnit_Framework_TestCase
{
    public function testEncodes()
    {
        $encoder = new Raw();
        $str = $encoder->make(array(), 'foo');

        $this->assertEquals('https://minotar.net/foo', $str, 'Raw encoder does not successfully generate URLs.');
    }
} 
