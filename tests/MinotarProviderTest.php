<?php

use Minotar\Minotar;

class MinotarProvideTest extends PHPUnit_Framework_TestCase {

    public function testGivesMinotarDisplay()
    {
        $this->assertInstanceOf(
            'Minotar\MinotarDisplay',
            Minotar::make(),
            'Minotar is not given by the provider, nothing works D:'
        );
    }

    public function testSetsDisplayConfig()
    {
        $m = Minotar::make(array('time' => 42));

        $this->assertEquals($m->getConfig('time'), 42, 'MinotarDisplay\'s config is not set by the instantiator.');
    }
} 
