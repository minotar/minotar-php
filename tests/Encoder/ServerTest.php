<?php

use Symfony\Component\HttpFoundation\Response;
use Minotar\Encoder\Server;
use Mockery as m;

class ServerTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testSendsGoodResponse()
    {
        $adapter = m::mock('Minotar\\MinotarAdapterInterface');
        $adapter->shouldReceive('retrieve')->andReturn('foo');
        $encoder = new Server($adapter);
        $response = $encoder->make(array('time' => 60), '');

        $this->assertInstanceOf(
            'Symfony\\Component\\HttpFoundation\\Response',
            $response,
            'Server encoder does not return a Symfony response'
        );

        $this->assertEquals(200, $response->getStatusCode(), 'Server does not return 200 status on successful image.');
    }

    public function testSendsFailedResponse()
    {
        $adapter = m::mock('Minotar\\MinotarAdapterInterface');
        $adapter->shouldReceive('retrieve')->andReturn(false);
        $encoder = new Server($adapter);
        $response = $encoder->make(array('time' => 60), '');

        $this->assertEquals(400, $response->getStatusCode(), 'Server does not return 400 status on failed image.');
    }
} 
