<?php

namespace Ordinary9843\Sources;

use Ordinary9843\Traits\ConfigTrait;
use GuzzleHttp\Exception\ClientException;
use Ordinary9843\Constants\SourceConstant;
use Ordinary9843\Exceptions\BaseException;
use Ordinary9843\Constants\CurrencyConstant;
use Ordinary9843\Exceptions\SourceException;
use Ordinary9843\Interfaces\SourceInterface;

class BotSource extends BaseSource implements SourceInterface
{
    use ConfigTrait;

    /** @var string */
    protected $baseUrl = SourceConstant::SOURCES[SourceConstant::BOT];

    /**
     * @return array
     */
    public function fetch(): array
    {
        try {
            return $this->parseRows($this->getRows());
        } catch (BaseException | ClientException $exception) {
            throw new SourceException($exception->getMessage(), SourceException::CODE_FETCH, [
                'baseUrl' => $this->baseUrl
            ], $exception);
        }
    }

    /**
     * @return array
     */
    private function getRows(): array
    {
        $sourceType = $this->getSourceType();
        $cacheTimeInSeconds = $this->getCacheTimeInSeconds();
        if ($this->isCached($sourceType, $cacheTimeInSeconds)) {
            return json_decode($this->readCache($sourceType, $cacheTimeInSeconds), true);
        }

        $response = $this->getClient()->get('/xrt/fltxt/0/day');
        $contents = $response->getBody()->getContents();
        if (empty($contents)) {
            throw new SourceException('Unexpected status code returned from BotSource', SourceException::CODE_REQUEST_FAILED);
        }

        $rows = array_slice(array_filter(explode("\n", $contents), 'trim'), 1);

        $this->writeCache($sourceType, json_encode($rows));

        return $rows;
    }

    /**
     * @param array $rows
     * 
     * @return array
     */
    private function parseRows(array $rows): array
    {
        $mapping = [
            'cashBuy' => 2,
            'cashSell' => 12,
            'spotBuy' => 3,
            'spotSell' => 13
        ];
        $exchangeRates = [
            CurrencyConstant::TWD => [
                'currency' => CurrencyConstant::TWD,
                'cashBuy' => 1,
                'cashSell' => 1,
                'spotBuy' => 1,
                'spotSell' => 1
            ]
        ];
        foreach ($rows as $row) {
            $columns = array_values(array_filter(array_map('trim', preg_split('/\s+/', $row))));
            $exchangeRate = ['currency' => $columns[0] ?? null];
            if (!isset(CurrencyConstant::CURRENCIES[$exchangeRate['currency']])) {
                continue;
            }

            foreach ($mapping as $field => $position) {
                $exchangeRate[$field] = isset($columns[$position]) ? (float)$columns[$position] : null;
            }

            $exchangeRates[$exchangeRate['currency']] = $exchangeRate;
        }

        return $exchangeRates;
    }
}
