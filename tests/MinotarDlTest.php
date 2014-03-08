<?php

use Minotar\MinotarDl;
use Minotar\Exception\MissingExtensionException;

class MinotarDlTest extends PHPUnit_Framework_TestCase
{
    public function testDoesntSpazz()
    {
        // Sadly we can't do much to actually test curl itself... but we'll run it and make sure it doesn't throw any
        // strange errors anyway.

        $c = new MinotarDl;
        try {
            $c->download(array('timeout' => 1), 'avatar/connor4312');
        } catch (MissingExtensionException $e) {
        } // Don't particularly care if Curl isn't installed during testing
    }
} 
