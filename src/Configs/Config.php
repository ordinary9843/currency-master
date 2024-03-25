<?php

namespace Ordinary9843\Configs;

use Ordinary9843\Constants\SourceConstant;
use Ordinary9843\Exceptions\ConfigException;

class Config
{
    /** @var Config */
    private static $instance = null;

    /** @var string */
    protected $sourceType = SourceConstant::DEFAULT_SOURCE;

    /** @var int */
    protected $cacheTimeInSeconds = 60;

    /**
     * @throws ConfigException
     */
    public function __clone()
    {
        throw new ConfigException('Cannot clone a singleton instance.', ConfigException::CODE_CLONE);
    }

    /**
     * @throws ConfigException
     */
    public function __wakeup()
    {
        throw new ConfigException('Cannot unserialize a singleton instance.', ConfigException::CODE_WAKEUP);
    }

    /**
     * @param array $arguments
     * 
     * @return void
     */
    public static function initialize(array $arguments = []): void
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        (isset($arguments['sourceType'])) && self::$instance->setSourceType($arguments['sourceType']);
        (isset($arguments['cacheTimeInSeconds'])) && self::$instance->setCacheTimeInSeconds($arguments['cacheTimeInSeconds']);
    }

    /**
     * @param array $arguments
     * 
     * @return Config
     */
    public static function getInstance(array $arguments = []): Config
    {
        self::initialize($arguments);

        return self::$instance;
    }

    /**
     * @param string $sourceType
     * 
     * @return void
     */
    public function setSourceType(string $sourceType): void
    {
        (!isset(SourceConstant::SOURCES[$sourceType])) && $sourceType = SourceConstant::DEFAULT_SOURCE;
        $this->sourceType = $sourceType;
    }

    /**
     * @return string
     */
    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    /**
     * @param int $cacheTimeInSeconds
     * 
     * @return void
     */
    public function setCacheTimeInSeconds(int $cacheTimeInSeconds): void
    {
        ($cacheTimeInSeconds < 60) && $cacheTimeInSeconds = 60;
        ($cacheTimeInSeconds >= 3600) && $cacheTimeInSeconds = 3600;
        $this->cacheTimeInSeconds = $cacheTimeInSeconds;
    }

    /**
     * @return int
     */
    public function getCacheTimeInSeconds(): int
    {
        return $this->cacheTimeInSeconds;
    }
}
