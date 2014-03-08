<?php

use Minotar\Minotar;
use Mockery as m;

class MinotarProvideTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGivesMinotarDisplay()
    {
        $m = m::mock('Minotar\\MinotarDisplay');
        Minotar::app()->instance('Minotar\\MinotarDisplay', $m);

        $this->assertEquals($m, Minotar::make(), 'Minotar is not given by the provider, nothing works D:');
    }

    public function testProvidesAdapter()
    {
        $m = m::mock('Desarrolla2\\Cache\\Adapter\\AbstractAdapter');
        Minotar::app()->instance('Desarrolla2\\Cache\\Adapter\\Foo', $m);
        $a = Minotar::adapter('foo');

        $this->assertEquals($m, $a, 'Minotar does not return the expected adapter.');
    }

    public function testProvidesEncoder()
    {
        $m = m::mock('Minotar\\MinotarEncoderInterface');
        Minotar::app()->instance('Minotar\\Encoder\\Foo', $m);
        $e = Minotar::encoder('foo');

        $this->assertEquals($m, $e, 'Minotar does not return the expected adapter.');
    }

    public function testPassesStaticToMinotarDisplay()
    {
        $m = m::mock('Minotar\\MinotarDisplay');
        $m->shouldReceive('bar')->once()->andReturn('foo');

        Minotar::app()->instance('Minotar\\MinotarDisplay', $m);

        $this->assertEquals(Minotar::bar(), 'foo', 'Minotar does not pass static calls to default display');
    }

    public function testPassesConstructionToAdapter()
    {
        $e = Minotar::encoder('url', 'foo');

        $this->assertEquals($e->url, 'foo', 'Minotar does not pass contructors to encoders.');
    }
} 
