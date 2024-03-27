<?php

namespace Tests;

use ReflectionClass;
use GuzzleHttp\Client;
use Tests\BaseTestCase;
use Ordinary9843\Sources\BotSource;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Ordinary9843\Constants\CurrencyConstant;
use Ordinary9843\Interfaces\SourceInterface;
use Ordinary9843\Exceptions\HandlerException;
use Ordinary9843\Handlers\GetExchangeRatesHandler;

class GetExchangeRatesHandlerTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testArgumentsMappingWhenProvidedInputs()
    {
        $source = $this->createMock(SourceInterface::class);
        $handler = new GetExchangeRatesHandler($source);
        $reflection = new ReflectionClass($handler);
        $property = $reflection->getProperty('argumentsMapping');
        $property->setAccessible(true);
        $argumentsMapping = $property->getValue($handler);
        $this->assertCount(0, $argumentsMapping);
    }

    /**
     * @return void
     */
    public function testExecuteWhenNoCacheShouldSucceed(): void
    {
        $exchangeRates = [
            CurrencyConstant::TWD => [
                'currency' => CurrencyConstant::TWD,
                'cashBuy' => 1,
                'cashSell' => 1,
                'spotBuy' => 1,
                'spotSell' => 1
            ]
        ];
        $source = $this->createMock(SourceInterface::class);
        $source->method('fetch')
            ->willReturn($exchangeRates);
        $source->method('isCached')
            ->willReturn(false);
        $handler = new GetExchangeRatesHandler($source);
        $this->assertEquals($exchangeRates, $handler->execute());
    }

    /**
     * @return void
     */
    public function testExecuteWhenCachedShouldSucceed(): void
    {
        $exchangeRates = [
            CurrencyConstant::TWD => [
                'currency' => CurrencyConstant::TWD,
                'cashBuy' => 1,
                'cashSell' => 1,
                'spotBuy' => 1,
                'spotSell' => 1
            ]
        ];
        $source = $this->createMock(SourceInterface::class);
        $source->method('fetch')
            ->willReturn($exchangeRates);
        $source->method('isCached')
            ->willReturn(true);
        $source->method('readCache')
            ->willReturn(json_encode($exchangeRates));
        $handler = new GetExchangeRatesHandler($source);
        $this->assertEquals($exchangeRates, $handler->execute());
    }

    /**
     * @return void
     */
    public function testExecuteShouldThrowHandlerException(): void
    {
        $body = $this->createMock(StreamInterface::class);
        $body->method('getContents')->willReturn('');
        $response = $this->createMock(ResponseInterface::class);
        $client = $this->createMock(Client::class);
        $client->method('get')->willReturn($response);
        $botSource = new BotSource($client);
        $this->expectException(HandlerException::class);
        $this->expectExceptionCode(HandlerException::CODE_EXECUTE);
        $handler = new GetExchangeRatesHandler($botSource);
        $handler->execute();
    }
}
