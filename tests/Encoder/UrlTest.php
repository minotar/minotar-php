<?php

use Minotar\Encoder\Url;

class UrlTest extends PHPUnit_Framework_TestCase
{
    public function testEncodes()
    {
        $encoder = new Url('http://example.com/serve.php');
        $str = $encoder->make(array(), 'foo');

        $this->assertEquals(
            'http://example.com/serve.php?minotar=foo',
            $str,
            'Url encoder does not successfully generate URLs.'
        );
    }
} 
