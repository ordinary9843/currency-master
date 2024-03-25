<?php

namespace Ordinary9843\Traits;

trait FileCacheTrait
{
    /**
     * @param string $key
     * @param int $cacheTimeInSeconds
     *
     * @return bool
     */
    public function isCached(string $key, int $cacheTimeInSeconds): bool
    {
        $cachePath = $this->getCacheFilepath($key);
        if ($this->isFile($cachePath)) {
            return (time() - filemtime($cachePath)) <= $cacheTimeInSeconds;
        }

        return false;
    }

    /**
     * @param string $key
     * @param string $data
     *
     * @return void
     */
    public function writeCache(string $key, string $data): void
    {
        @file_put_contents($this->getCacheFilepath($key), $data);
    }

    /**
     * @param string $key
     * @param int $cacheTimeInSeconds
     * 
     * @return string
     */
    public function readCache(string $key, int $cacheTimeInSeconds): string
    {
        $cachePath = $this->getCacheFilepath($key);
        if ($this->isCached($key, $cacheTimeInSeconds)) {
            return @file_get_contents($cachePath);
        }

        return '';
    }

    /**
     * @param string $path
     */
    private function getCacheFilepath(string $path): string
    {
        $cachePath = dirname(__DIR__, 2) . '/cache/';
        (!$this->isDir($cachePath)) && @mkdir($cachePath, 0755);

        return $cachePath . md5($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    private function isDir(string $path): bool
    {
        return ($path && is_dir($path));
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    private function isFile(string $path): bool
    {
        return ($path && is_file($path));
    }
}
