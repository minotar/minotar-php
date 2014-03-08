<?php

use Minotar\MinotarCacheAdapter;
use Mockery as m;

class MinotarCacheAdapterTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFailsToGetFromCacheIfDNE()
    {
        $adapter = m::mock('Desarrolla2\\Cache\\Adapter\\AbstractAdapter');
        $adapter->shouldReceive('has')->andReturn(false);
        $dl = m::mock('Minotar\\MinotarDl');

        $cache = new MinotarCacheAdapter($adapter, $dl);

        $this->assertFalse(
            $cache->getFromCache('foo'),
            'CacheAdapter is not failing to load from cache if items do not exist.'
        );
    }

    public function testGetsFromCacheIfExists()
    {
        $adapter = m::mock('Desarrolla2\\Cache\\Adapter\\AbstractAdapter');
        $adapter->shouldReceive('has')->andReturn(true);
        $adapter->shouldReceive('get')->with('foo')->andReturn('date|data');
        $dl = m::mock('Minotar\\MinotarDl');

        $cache = new MinotarCacheAdapter($adapter, $dl);

        $this->assertEquals(
            $cache->getFromCache('foo'),
            array('date', 'data'),
            'CacheAdapter is not loading/exploding items from cache.'
        );
    }

    public function testFailsIfDownloadFails()
    {
        $adapter = m::mock('Desarrolla2\\Cache\\Adapter\\AbstractAdapter');
        $dl = m::mock('Minotar\\MinotarDl');
        $dl->shouldReceive('download')->andReturn(false);

        $cache = new MinotarCacheAdapter($adapter, $dl);

        $this->assertFalse($cache->getFromSource('foo'), 'CacheAdapter does not fail if download returns false.');
    }

    public function testSetsCacheAndReturnsIfDownloadWorks()
    {
        $adapter = m::mock('Desarrolla2\\Cache\\Adapter\\AbstractAdapter');
        $adapter->shouldReceive('set');
        $dl = m::mock('Minotar\\MinotarDl');
        $dl->shouldReceive('download')->andReturn('bar');

        $cache = new MinotarCacheAdapter($adapter, $dl);

        $this->assertEquals($cache->getFromSource('foo'), 'bar', 'CacheAdapter does net return downloaded image.');
    }

    public function testRenewsCacheIfOld()
    {
        $adapter = m::mock('Desarrolla2\\Cache\\Adapter\\AbstractAdapter');
        $adapter->shouldReceive('has')->andReturn(true);
        $adapter->shouldReceive('get')->with('foo')->andReturn('0|data');
        $adapter->shouldReceive('set')->andReturn(true);
        $dl = m::mock('Minotar\\MinotarDl');
        $dl->shouldReceive('download')->andReturn('bar');

        $cache = new MinotarCacheAdapter($adapter, $dl);

        $this->assertEquals(
            'bar',
            $cache->retrieve(array('time' => 0), 'foo'),
            'CacheAdapter is not refreshing old image.'
        );
    }

    public function testPassesCacheIfUpdated()
    {
        $adapter = m::mock('Desarrolla2\\Cache\\Adapter\\AbstractAdapter');
        $adapter->shouldReceive('has')->andReturn(true);
        $adapter->shouldReceive('get')->with('foo')->andReturn('999999999|data');
        $dl = m::mock('Minotar\\MinotarDl');

        $cache = new MinotarCacheAdapter($adapter, $dl);

        $this->assertEquals(
            'data',
            $cache->retrieve(array('time' => 999999999), 'foo'),
            'CacheAdapter is not refreshing old image.'
        );
    }
} 
