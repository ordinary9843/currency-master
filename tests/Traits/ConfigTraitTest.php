<?php

namespace Tests\Traits;

use Tests\BaseTestCase;
use Ordinary9843\Traits\ConfigTrait;
use Ordinary9843\Constants\SourceConstant;

class ConfigTraitTest extends BaseTestCase
{
    use ConfigTrait;

    /**
     * @return void
     */
    public function testSetSourceTypeShouldEqualGetSourceType(): void
    {
        $sourceType = SourceConstant::BOT;
        $this->setSourceType($sourceType);
        $this->assertEquals($sourceType, $this->getSourceType());
    }

    /**
     * @return void
     */
    public function testSetCacheTimeInSecondsTypeShouldEqualGetCacheTimeInSeconds(): void
    {
        $seconds = 3600;
        $this->setCacheTimeInSeconds($seconds);
        $this->assertEquals($seconds, $this->getCacheTimeInSeconds());
    }
}
