<?php

namespace Tests;

use Tests\BaseTestCase;
use ReflectionClass;
use Ordinary9843\CurrencyMaster;
use Ordinary9843\Constants\SourceConstant;
use Ordinary9843\Constants\CurrencyConstant;
use Ordinary9843\Exceptions\InvalidException;
use Ordinary9843\Interfaces\HandlerInterface;

class CurrencyMasterTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testGetExchangeRatesShouldSucceed(): void
    {
        $exchangeRates = [[
            'currency' => CurrencyConstant::TWD,
            'cashBuy' => 1,
            'cashSell' => 1,
            'spotBuy' => 1,
            'spotSell' => 1
        ]];
        $handler = $this->createMock(HandlerInterface::class);
        $handler->expects($this->once())
            ->method('execute')
            ->willReturn($exchangeRates);
        $currencyMaster = new CurrencyMaster();
        $reflector = new ReflectionClass(CurrencyMaster::class);
        $property = $reflector->getProperty('handlers');
        $property->setAccessible(true);
        $property->setValue($currencyMaster, ['getExchangeRates' => $handler]);
        $this->assertEquals($exchangeRates, $currencyMaster->getExchangeRates());
    }

    /**
     * @return void
     */
    public function testSetSourceTypeShouldEqualGetSourceType(): void
    {
        $sourceType = SourceConstant::BOT;
        $currencyMaster = new CurrencyMaster();
        $currencyMaster->setSourceType($sourceType);
        $this->assertEquals($sourceType, $currencyMaster->getSourceType());
    }

    /**
     * @return void
     */
    public function testSetCacheTimeInSecondsTypeShouldEqualGetCacheTimeInSeconds(): void
    {
        $seconds = 3600;
        $currencyMaster = new CurrencyMaster();
        $currencyMaster->setCacheTimeInSeconds($seconds);
        $this->assertEquals($seconds, $currencyMaster->getCacheTimeInSeconds());
    }

    /**
     * @return void
     */
    public function testInvalidMethodShouldThrowInvalidException(): void
    {
        $this->expectException(InvalidException::class);
        $this->expectExceptionCode(InvalidException::CODE_METHOD);
        (new CurrencyMaster())->test();
    }
}
