<?php

namespace Ordinary9843\Handlers;

use Ordinary9843\Exceptions\BaseException;
use Ordinary9843\Constants\CurrencyConstant;
use Ordinary9843\Exceptions\HandlerException;
use Ordinary9843\Interfaces\HandlerInterface;
use Ordinary9843\Constants\ExchangeRateTypeConstant;

class ExchangeRateHandler extends BaseHandler implements HandlerInterface
{
    /** @var array */
    protected $argumentsMapping = ['fromCurrency', 'toCurrency', 'exchangeRateType', 'amount', 'customExchangeRate'];

    /**
     * @return mixed ...$arguments
     * 
     * @throws HandlerException
     */
    public function execute(...$arguments): array
    {
        $this->mapArguments($arguments);

        try {
            $fromCurrency = $arguments['fromCurrency'];
            $toCurrency = $arguments['toCurrency'];
            $exchangeRateType = $arguments['exchangeRateType'];
            $amount = bcmul($arguments['amount'], '1', 12);
            $customExchangeRate = !is_null($arguments['customExchangeRate']) ? bcmul($arguments['customExchangeRate'], '1', 12) : null;
            if (!isset(CurrencyConstant::CURRENCIES[$fromCurrency]) || !isset(CurrencyConstant::CURRENCIES[$toCurrency])) {
                throw new HandlerException('The currency unit does not exist.', HandlerException::CODE_EXECUTE);
            } else if (!in_array($exchangeRateType, ExchangeRateTypeConstant::TYPES)) {
                throw new HandlerException('The exchange rate type does not exist.', HandlerException::CODE_EXECUTE);
            }

            $convertExchangeRate = (!is_null($customExchangeRate)) ? $customExchangeRate : $this->calculateConvertExchangeRate($fromCurrency, $toCurrency, $exchangeRateType);
            $convertedAmount = bcmul($amount, $convertExchangeRate, 12);
            $currencySymbol = CurrencyConstant::CURRENCIES[$toCurrency];

            return [
                'fromCurrency' => $fromCurrency,
                'toCurrency' => $toCurrency,
                'convertExchangeRate' => (string)$convertExchangeRate,
                'convertedAmount' => (string)$convertedAmount,
                'formattedConvertedAmount' => $currencySymbol . $convertedAmount,
                'currencySymbol' => $currencySymbol
            ];
        } catch (BaseException $exception) {
            throw new HandlerException($exception->getMessage(), HandlerException::CODE_EXECUTE, [
                'arguments' => $arguments
            ], $exception);
        }
    }

    /**
     * @param string $fromCurrency
     * @param string $toCurrency
     * @param string $exchangeRateType
     * 
     * @return string
     */
    private function calculateConvertExchangeRate(string $fromCurrency, string $toCurrency, string $exchangeRateType): string
    {
        $exchangeRates = $this->getSource()->fetch();
        $fromExchangeRate = $exchangeRates[$fromCurrency];
        $toExchangeRate = $exchangeRates[$toCurrency];

        return bcdiv($fromExchangeRate[$exchangeRateType], $toExchangeRate[$exchangeRateType], 12) ?: '0';
    }
}
