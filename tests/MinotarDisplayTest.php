<?php

use Minotar\MinotarDisplay;

class MinotarDisplayTest extends PHPUnit_Framework_TestCase {

    public function testGetConfig()
    {
        $m = new MinotarDisplay(array('foo' => 'bar'));

        $this->assertEquals($m->getConfig('foo'), 'bar', 'MinotarDisplay does not retrieve the given config by string');

        $o = $m->getConfig();

        $this->assertEquals($o['foo'], 'bar', 'MinotarDisplay does not retrieve the general config');
    }

    public function testSetConfigByString()
    {
        $m = new MinotarDisplay(array('foo' => 'asdf'));
        $m->setConfig('foo', 'bar');

        $this->assertEquals($m->getConfig('foo'), 'bar', 'MinotarDisplay does not set the given config by string');
    }

    public function testSetConfigByArray()
    {
        $m = new MinotarDisplay(array());
        $m->setConfig(array('foo' => 'bar'));

        $this->assertEquals($m->getConfig('foo'), 'bar', 'MinotarDisplay does not set the given config by array');
    }

    public function testThrowsExceptionOnInvalidConfig() {
        $this->setExpectedException('Minotar\Exception\ConfigNotFoundException');

        $m = new MinotarDisplay(array());
        $m->getConfig('foo');
    }
} 
