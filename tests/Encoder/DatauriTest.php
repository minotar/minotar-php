<?php

use Minotar\Encoder\Datauri;

class DatauriTest extends PHPUnit_Framework_TestCase
{
    public function testEncodes()
    {
        $encoder = new Datauri;
        $str = $encoder->make('foo');

        $this->assertStringEndsWith(base64_encode('foo'), $str, 'Datauri encoder does not successfully encode images.');
    }
} 
