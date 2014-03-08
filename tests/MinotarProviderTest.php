<?php

use Minotar\Minotar;
use Mockery as m;

class MinotarProvideTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        m::close();
    }

    public function testGivesMinotarDisplay()
    {
        $this->assertInstanceOf(
            'Minotar\\MinotarDisplay',
            Minotar::make(),
            'Minotar is not given by the provider, nothing works D:'
        );
    }

    public function testSetsDisplayConfig()
    {
        $m = Minotar::make(array('time' => 42));

        $this->assertEquals($m->getConfig('time'), 42, 'MinotarDisplay\'s config is not set by the instantiator.');
    }

    public function testProvidesAdapter()
    {
        m::mock('overload:Desarrolla2\\Cache\\Adapter\\Foo');
        $a = Minotar::adapter('foo');

        $this->assertInstanceOf('Desarrolla2\\Cache\\Adapter\\Foo', $a, 'Minotar does not return the expected adapter.');
    }

    public function testProvidesEncoder()
    {
        m::mock('overload:Encoder\\Foo');
        $e = Minotar::encoder('foo');

        $this->assertInstanceOf('Encoder\\Foo', $e, 'Minotar does not return the expected adapter.');
    }

    public function testPassesStaticToMinotarDisplay()
    {
        $m = m::mock('Minotar\\MinotarDisplay');
        $m->shouldReceive('bar')->once()->andReturn('foo');

        Minotar::app()->instance('Minotar\\MinotarDisplay', $m);

        $this->assertEquals(Minotar::bar(), 'foo', 'Minotar does not pass static calls to default display');
    }
} 
