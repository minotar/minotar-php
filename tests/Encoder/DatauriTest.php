<?php

use Minotar\Encoder\Datauri;
use Mockery as m;

class DatauriTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testEncodes()
    {
        $adapter = m::mock('Minotar\\MinotarAdapterInterface');
        $adapter->shouldReceive('retrieve')->andReturn('foo');
        $encoder = new Datauri($adapter);
        $str = $encoder->make(array(), '');

        $this->assertStringEndsWith(base64_encode('foo'), $str, 'Datauri encoder does not successfully encode images.');
    }
} 
