<?php

namespace Tests\Traits;

use Tests\BaseTestCase;
use Ordinary9843\Traits\FileCacheTrait;

class FileCacheTraitTest extends BaseTestCase
{
    use FileCacheTrait;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteSourceCacheFile();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->deleteSourceCacheFile();
    }

    /**
     * @return void
     */
    public function testIsCachedShouldReturnTrue(): void
    {
        $key = 'test';
        @file_put_contents($this->getCacheFilepath($key), '');
        $this->assertTrue($this->isCached($key, 60));
    }

    /**
     * @return void
     */
    public function testIsCachedShouldReturnFalse(): void
    {
        $key = 'test';
        @unlink($this->getCacheFilepath($key));
        $this->assertFalse($this->isCached($key, 60));
    }

    /**
     * @return void
     */
    public function testWriteCacheShouldSucceed(): void
    {
        $key = 'test';
        $data = 'data';
        $this->writeCache($key, $data);
        $this->assertFileExists($this->getCacheFilepath($key));
        $this->assertEquals($data, @file_get_contents($this->getCacheFilepath($key)));
    }

    /**
     * @return void
     */
    public function testReadCacheShouldReturnData(): void
    {
        $key = 'test';
        $data = 'data';
        @file_put_contents($this->getCacheFilepath($key), $data);
        $this->assertEquals($data, $this->readCache($key, 60));
    }

    /**
     * @return void
     */
    public function testReadCacheShouldReturnEmptyString(): void
    {
        $key = 'test';
        $data = '';
        @unlink($this->getCacheFilepath($key));
        $this->assertEquals($data, $this->readCache($key, 60));
    }

    /**
     * @return void
     */
    private function deleteSourceCacheFile(): void
    {
        @unlink($this->getCacheFilepath('test'));
    }
}
