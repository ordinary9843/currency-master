<?php

namespace Ordinary9843\Traits;

use Ordinary9843\Configs\Config;

trait ConfigTrait
{
    /**
     * @param string $sourceType
     * 
     * @return void
     */
    public function setSourceType(string $sourceType): void
    {
        Config::getInstance()->setSourceType($sourceType);
    }

    /**
     * @return string
     */
    public function getSourceType(): string
    {
        return Config::getInstance()->getSourceType();
    }

    /**
     * @param int $cacheTimeInSeconds
     * 
     * @return void
     */
    public function setCacheTimeInSeconds(int $cacheTimeInSeconds): void
    {
        Config::getInstance()->setCacheTimeInSeconds($cacheTimeInSeconds);
    }

    /**
     * @return int
     */
    public function getCacheTimeInSeconds(): int
    {
        return Config::getInstance()->getCacheTimeInSeconds();
    }
}
