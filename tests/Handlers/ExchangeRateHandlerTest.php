<?php

namespace Tests;

use ReflectionClass;
use Tests\BaseTestCase;
use Ordinary9843\Constants\CurrencyConstant;
use Ordinary9843\Interfaces\SourceInterface;
use Ordinary9843\Exceptions\HandlerException;
use Ordinary9843\Handlers\ExchangeRateHandler;
use Ordinary9843\Constants\ExchangeRateTypeConstant;

class ExchangeRateHandlerTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testArgumentsMappingWhenProvidedInputs()
    {
        $source = $this->createMock(SourceInterface::class);
        $handler = new ExchangeRateHandler($source);
        $reflection = new ReflectionClass($handler);
        $property = $reflection->getProperty('argumentsMapping');
        $property->setAccessible(true);
        $argumentsMapping = $property->getValue($handler);
        $this->assertCount(5, $argumentsMapping);
        $this->assertContains('fromCurrency', $argumentsMapping);
        $this->assertContains('toCurrency', $argumentsMapping);
        $this->assertContains('exchangeRateType', $argumentsMapping);
        $this->assertContains('amount', $argumentsMapping);
        $this->assertContains('customExchangeRate', $argumentsMapping);
    }

    /**
     * @return void
     */
    public function testExecuteShouldSucceed(): void
    {
        $source = $this->createMock(SourceInterface::class);
        $source->method('fetch')
            ->willReturn([
                CurrencyConstant::TWD => [
                    'currency' => CurrencyConstant::TWD,
                    'cashBuy' => 1,
                    'cashSell' => 1,
                    'spotBuy' => 1,
                    'spotSell' => 1
                ],
                CurrencyConstant::USD => [
                    'currency' => CurrencyConstant::USD,
                    'cashBuy' => 31.555,
                    'cashSell' => 32.225,
                    'spotBuy' => 31.88,
                    'spotSell' => 32.03
                ]
            ]);
        $exchangeRateHandler = new ExchangeRateHandler($source);
        $currencySymbol = CurrencyConstant::CURRENCIES[CurrencyConstant::USD];
        $this->assertEquals([
            'fromCurrency' => CurrencyConstant::TWD,
            'toCurrency' => CurrencyConstant::USD,
            'convertExchangeRate' => '0.031690698779',
            'convertedAmount' => '31.690698779000',
            'formattedConvertedAmount' => $currencySymbol . '31.690698779000',
            'currencySymbol' => $currencySymbol
        ], $exchangeRateHandler->execute(...[CurrencyConstant::TWD, CurrencyConstant::USD, ExchangeRateTypeConstant::CASH_BUY, 1000]));
    }

    /**
     * @return void
     */
    public function testExecuteWhenCurrencyUnitDoesNotExistShouldThrowHandlerException(): void
    {
        $this->expectException(HandlerException::class);
        $source = $this->createMock(SourceInterface::class);
        $source->method('fetch')
            ->willReturn([]);
        $exchangeRateHandler = new ExchangeRateHandler($source);
        $exchangeRateHandler->execute(...['test', CurrencyConstant::USD, ExchangeRateTypeConstant::CASH_BUY, 1000]);
    }

    /**
     * @return void
     */
    public function testExecuteWhenExchangeRateTypeDoesNotExistShouldThrowHandlerException(): void
    {
        $this->expectException(HandlerException::class);
        $source = $this->createMock(SourceInterface::class);
        $source->method('fetch')
            ->willReturn([]);
        $exchangeRateHandler = new ExchangeRateHandler($source);
        $exchangeRateHandler->execute(...[CurrencyConstant::TWD, CurrencyConstant::USD, 'test', 1000]);
    }
}
