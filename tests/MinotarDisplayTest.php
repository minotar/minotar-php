<?php

use \Minotar\MinotarDisplay;
use Mockery as m;

class MinotarDisplayTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    protected function make($config)
    {
        return new MinotarDisplay(
            $config,
            m::mock('Minotar\\MinotarEncoderInterface'),
            m::mock('Minotar\\MinotarAdapterInterface')
        );
    }

    public function testGetConfig()
    {
        $m = $this->make(array('foo' => 'bar'));
        $this->assertEquals($m->getConfig('foo'), 'bar', 'MinotarDisplay does not retrieve the given config by string');

        $o = $m->getConfig();

        $this->assertEquals($o['foo'], 'bar', 'MinotarDisplay does not retrieve the general config');
    }

    public function testSetConfigByString()
    {
        $m = $this->make(array('foo' => 'asdf'));
        $m->setConfig('foo', 'bar');

        $this->assertEquals($m->getConfig('foo'), 'bar', 'MinotarDisplay does not set the given config by string');
    }

    public function testSetConfigByArray()
    {
        $m = $this->make(array());
        $m->setConfig(array('foo' => 'bar'));

        $this->assertEquals($m->getConfig('foo'), 'bar', 'MinotarDisplay does not set the given config by array');
    }

    public function testThrowsExceptionOnInvalidConfig()
    {
        $this->setExpectedException('Minotar\Exception\ConfigNotFoundException');

        $m = $this->make(array());
        $m->getConfig('foo');
    }

    protected function makeForReqs()
    {
        $e = m::mock('Minotar\\MinotarEncoderInterface');
        $e->shouldReceive('make')->andReturn('baz');

        return new MinotarDisplay(array(), $e);
    }

    public function testAvatar()
    {
        $m = $this->makeForReqs();

        $this->assertEquals($m->avatar('foo'), 'baz', 'Avatar is not retrieved');
    }

    public function testHelm()
    {
        $m = $this->makeForReqs();

        $this->assertEquals($m->helm('foo'), 'baz', 'Helm is not retrieved');
    }

    public function testSkin()
    {
        $m = $this->makeForReqs();

        $this->assertEquals($m->skin('foo'), 'baz', 'Skin is not retrieved');
    }
} 
