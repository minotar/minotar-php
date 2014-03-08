<?php

use Minotar\MinotarDl;

class MinotarDlTest extends PHPUnit_Framework_TestCase
{
    public function testDoesntSpazz()
    {
        // Sadly we can't do much to actually test curl itself... but we'll run it and make sure it doesn't throw any
        // strange errors anyway.

        $c = new MinotarDl;
        $c->download(array('timeout' => 1), 'avatar/connor4312');
    }
} 
