<?php

namespace Tests\Factories;

use Tests\BaseTestCase;
use Ordinary9843\Handlers\BaseHandler;
use Ordinary9843\Factories\HandlerFactory;
use Ordinary9843\Exceptions\NotFoundException;
use Ordinary9843\Handlers\GetExchangeRatesHandler;

class HandlerFactoryTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testCreateBaseHandlerShouldSucceed(): void
    {
        $handler = (new HandlerFactory)->create('base');
        $this->assertInstanceOf(BaseHandler::class, $handler);
    }

    /**
     * @return void
     */
    public function testCreateGetExchangeRatesHandlerShouldSucceed(): void
    {
        $handler = (new HandlerFactory)->create('getExchangeRates');
        $this->assertInstanceOf(GetExchangeRatesHandler::class, $handler);
    }

    /**
     * @return void
     */
    public function testCreateBaseHandlerShouldThrowNotFoundException(): void
    {
        $this->expectException(NotFoundException::class);
        (new HandlerFactory)->create('');
    }
}
