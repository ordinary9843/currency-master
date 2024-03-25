<?php

namespace Ordinary9843\Interfaces;

interface SourceInterface extends BaseInterface
{
    /**
     * @return array
     */
    public function fetch(): array;

    /**
     * @param string $path
     * @param int $cacheTimeInSeconds
     *
     * @return bool
     */
    public function isCached(string $path, int $cacheTimeInSeconds): bool;

    /**
     * @param string $path
     * @param string $data
     *
     * @return void
     */
    public function writeCache(string $path, string $data): void;

    /**
     * @param string $path
     * @param int $cacheTimeInSeconds
     * 
     * @return string
     */
    public function readCache(string $path, int $cacheTimeInSeconds): string;
}
