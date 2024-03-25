<?php

namespace Tests\Factories;

use Tests\BaseTestCase;
use Ordinary9843\Sources\BotSource;
use Ordinary9843\Sources\BaseSource;
use Ordinary9843\Factories\SourceFactory;
use Ordinary9843\Exceptions\NotFoundException;

class SourceFactoryTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testCreateBaseSourceShouldSucceed(): void
    {
        $source = (new SourceFactory)->create('base');
        $this->assertInstanceOf(BaseSource::class, $source);
    }

    /**
     * @return void
     */
    public function testCreateBotSourceShouldSucceed(): void
    {
        $source = (new SourceFactory)->create('bot');
        $this->assertInstanceOf(BotSource::class, $source);
    }

    /**
     * @return void
     */
    public function testCreateBaseSourceShouldThrowNotFoundException(): void
    {
        $this->expectException(NotFoundException::class);
        (new SourceFactory)->create('');
    }
}
