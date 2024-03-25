<?php

namespace Tests\Configs;

use Tests\BaseTestCase;
use Ordinary9843\Configs\Config;
use Ordinary9843\Constants\SourceConstant;
use Ordinary9843\Exceptions\ConfigException;

class ConfigTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testCloningSingletonShouldThrowConfigException(): void
    {
        $this->expectException(ConfigException::class);
        $this->expectExceptionCode(ConfigException::CODE_CLONE);
        clone Config::getInstance();
    }

    /**
     * @return void
     */
    public function testWakeupSingletonShouldThrowConfigException(): void
    {
        $this->expectException(ConfigException::class);
        $this->expectExceptionCode(ConfigException::CODE_WAKEUP);
        unserialize(serialize(Config::getInstance()));
    }

    /**
     * @return void
     */
    public function testGetInstanceTwiceToBeSame(): void
    {
        $this->assertEquals(new Config(), Config::getInstance());
        $this->assertEquals(Config::getInstance(), Config::getInstance());
    }

    /**
     * @return void
     */
    public function testGetInstanceWithArgumentsInitializesArguments(): void
    {
        $arguments = [
            'sourceType' => SourceConstant::BOT,
            'cacheTimeInSeconds' => 3600
        ];
        $config = Config::getInstance($arguments);
        $this->assertEquals($arguments['sourceType'], $config->getSourceType());
        $this->assertEquals($arguments['cacheTimeInSeconds'], $config->getCacheTimeInSeconds());
    }

    /**
     * @return void
     */
    public function testSetSourceTypeShouldEqualGetSourceType(): void
    {
        $sourceType = SourceConstant::BOT;
        $config = new Config();
        $config->setSourceType($sourceType);
        $this->assertEquals($sourceType, $config->getSourceType());

        $config->setSourceType('test');
        $this->assertEquals(SourceConstant::DEFAULT_SOURCE, $config->getSourceType());
    }

    /**
     * @return void
     */
    public function testSetCacheTimeInSecondsShouldEqualGetCacheTimeInSeconds(): void
    {
        $cacheTimeInSeconds = 60;
        $config = new Config();
        $config->setCacheTimeInSeconds($cacheTimeInSeconds);
        $this->assertEquals($cacheTimeInSeconds, $config->getCacheTimeInSeconds());

        $config->setCacheTimeInSeconds(59);
        $this->assertEquals($cacheTimeInSeconds, $config->getCacheTimeInSeconds());

        $config->setCacheTimeInSeconds(3601);
        $this->assertEquals(3600, $config->getCacheTimeInSeconds());
    }
}
