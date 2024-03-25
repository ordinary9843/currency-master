<?php

namespace Tests\Handlers;

use GuzzleHttp\Client;
use Tests\BaseTestCase;
use Ordinary9843\Sources\BotSource;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Ordinary9843\Constants\SourceConstant;
use Ordinary9843\Constants\CurrencyConstant;
use Ordinary9843\Exceptions\SourceException;
use Ordinary9843\Constants\ExchangeRateTypeConstant;

class BotSourceTest extends BaseTestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteSourceCacheFile();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->deleteSourceCacheFile();
    }

    /**
     * @return void
     */
    public function testFetchWhenNoCacheShouldReturnRows(): void
    {
        $body = $this->createMock(StreamInterface::class);
        $body->method('getContents')->willReturn("幣別        匯率             現金        即期        遠期10天        遠期30天        遠期60天        遠期90天       遠期120天       遠期150天       遠期180天 匯率             現金        即期        遠期10天        遠期30天        遠期60天        遠期90天       遠期120天       遠期150天       遠期180天\nUSD         本行買入     31.55500    31.88000        31.88300        31.79100        31.66800        31.55800        31.44600        31.33100        31.22000 本行賣出     32.22500    32.03000        31.98900        31.90500        31.79700        31.70000        31.60000        31.49800        31.40000");
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($body);
        $client = $this->createMock(Client::class);
        $client->method('get')->willReturn($response);
        $botSource = new BotSource();
        $botSource->setClient($client);
        $this->assertEquals([
            CurrencyConstant::TWD => [
                'currency' => CurrencyConstant::TWD,
                ExchangeRateTypeConstant::CASH_BUY => 1,
                ExchangeRateTypeConstant::CASH_SELL => 1,
                ExchangeRateTypeConstant::SPOT_BUY => 1,
                ExchangeRateTypeConstant::SPOT_SELL => 1
            ],
            CurrencyConstant::USD => [
                'currency' => CurrencyConstant::USD,
                ExchangeRateTypeConstant::CASH_BUY => 31.555,
                ExchangeRateTypeConstant::CASH_SELL => 32.225,
                ExchangeRateTypeConstant::SPOT_BUY => 31.88,
                ExchangeRateTypeConstant::SPOT_SELL => 32.03
            ]
        ], $botSource->fetch());
    }

    /**
     * @return void
     */
    public function testFetchWhenCachedShouldReturnRows(): void
    {
        @file_put_contents($this->getSourceCacheFilepath(), '["USD         本行買入     31.55500    31.88000        31.88300        31.79100        31.66800        31.55800        31.44600        31.33100        31.22000 本行賣出     32.22500    32.03000        31.98900        31.90500        31.79700        31.70000        31.60000        31.49800        31.40000\r"]');
        $botSource = new BotSource();
        $this->assertEquals([
            CurrencyConstant::TWD => [
                'currency' => CurrencyConstant::TWD,
                ExchangeRateTypeConstant::CASH_BUY => 1,
                ExchangeRateTypeConstant::CASH_SELL => 1,
                ExchangeRateTypeConstant::SPOT_BUY => 1,
                ExchangeRateTypeConstant::SPOT_SELL => 1
            ],
            CurrencyConstant::USD => [
                'currency' => CurrencyConstant::USD,
                ExchangeRateTypeConstant::CASH_BUY => 31.555,
                ExchangeRateTypeConstant::CASH_SELL => 32.225,
                ExchangeRateTypeConstant::SPOT_BUY => 31.88,
                ExchangeRateTypeConstant::SPOT_SELL => 32.03
            ]
        ], $botSource->fetch());
    }

    /**
     * @return void
     */
    public function testFetchWhenCurrencyNotMatchShouldReturnDefaultRows(): void
    {
        $body = $this->createMock(StreamInterface::class);
        $body->method('getContents')->willReturn("幣別        匯率             現金        即期        遠期10天        遠期30天        遠期60天        遠期90天       遠期120天       遠期150天       遠期180天 匯率             現金        即期        遠期10天        遠期30天        遠期60天        遠期90天       遠期120天       遠期150天       遠期180天\nABC         本行買入     31.55500    31.88000        31.88300        31.79100        31.66800        31.55800        31.44600        31.33100        31.22000 本行賣出     32.22500    32.03000        31.98900        31.90500        31.79700        31.70000        31.60000        31.49800        31.40000");
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($body);
        $client = $this->createMock(Client::class);
        $client->method('get')->willReturn($response);
        $botSource = new BotSource();
        $botSource->setClient($client);
        $this->assertEquals([
            CurrencyConstant::TWD => [
                'currency' => CurrencyConstant::TWD,
                ExchangeRateTypeConstant::CASH_BUY => 1,
                ExchangeRateTypeConstant::CASH_SELL => 1,
                ExchangeRateTypeConstant::SPOT_BUY => 1,
                ExchangeRateTypeConstant::SPOT_SELL => 1
            ]
        ], $botSource->fetch());
    }

    /**
     * @return void
     */
    public function testFetchWhenRequestFailedShouldThrowSourceException(): void
    {
        $this->expectException(SourceException::class);
        $this->expectExceptionCode(SourceException::CODE_FETCH);
        $body = $this->createMock(StreamInterface::class);
        $body->method('getContents')->willReturn('');
        $response = $this->createMock(ResponseInterface::class);
        $client = $this->createMock(Client::class);
        $client->method('get')->willReturn($response);
        $botSource = new BotSource();
        $botSource->setClient($client);
        $botSource->fetch();
    }

    /**
     * @return void
     */
    private function deleteSourceCacheFile(): void
    {
        @unlink($this->getSourceCacheFilepath());
    }

    /**
     * @return string
     */
    private function getSourceCacheFilepath(): string
    {
        return dirname(__DIR__, 2) . '/cache/' . md5(SourceConstant::BOT);
    }
}
