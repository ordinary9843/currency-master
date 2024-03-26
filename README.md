# CurrencyMaster

[![build](https://github.com/ordinary9843/currency-master/actions/workflows/build.yml/badge.svg)](https://github.com/ordinary9843/currency-master/actions/workflows/build.yml)
[![codecov](https://codecov.io/gh/ordinary9843/currency-master/branch/master/graph/badge.svg?token=DMXRZFN55V)](https://codecov.io/gh/ordinary9843/currency-master)

### If there are any features you desire, please open an issue, and I will do our best to meet your requirements!

## Intro

CurrencyMaster is a comprehensive library for managing currency exchange rates. It enables you to retrieve and convert exchange rates efficiently and conveniently. This library eliminates the need to rely heavily on third-party services by implementing a customisable caching system.

## Cores

This library has the following features:

- Full-featured: This library provides comprehensive support for retrieving and converting exchange rates.
- Lower dependency on external libraries.
- Compatible with multiple PHP versions: It can run properly on PHP 7.2 - 8.x.

## Installation

Install `ordinary9843/currency-master`:

```bash
composer require ordinary9843/currency-master
```

## Usage

Example usage:

```php
<?php
require './vendor/autoload.php';

use Ordinary9843\CurrentMaster;
use Ordinary9843\Constants\ExchangeRateTypeConstant;
use Ordinary9843\Constants\SourceConstant;

$currentMaster = new CurrentMaster();

/**
 * Sets the data source to be used.
 */
$currentMaster->setSourceType(SourceConstant::BOT);

/**
 * Sets the duration, in seconds, for which the data source should be cached.
 */
$currentMaster->setCacheTimeInSeconds(60);

/**
 * Retrieves all exchange rates from the source set. 
 *
 * Output:
 * [
 *   'TWD' => [
 *     'currency' => 'TWD',
 *     'cashBuy' => 1,
 *     'cashSell' => 1,
 *     'spotBuy' => 1,
 *     'spotSell' => 1
 *   ],
 *   'USD' => [
 *     'currency' => 'USD',
 *     'cashBuy' => 31.465,
 *     'cashSell' => 32.135,
 *     'spotBuy' => 31.815,
 *     'spotSell' => 31.915
 *   ]
 * ]
 */
$currentMaster->getExchangeRates();

/**
 * Converts a specified amount of money from one currency to another.
 *
 * Output: [
 *  'fromCurrency' => 'TWD',
 *  'toCurrency' => 'USD',
 *  'convertExchangeRate' => '0.031690698779',
 *  'convertedAmount' => '31.690698779000',
 *  'formattedConvertedAmount' => '$31.690698779000',
 *  'currencySymbol' => '$'
 * ]
 */
$currentMaster->exchangeRate(CurrencyConstant::TWD, CurrencyConstant::USD, ExchangeRateTypeConstant::CASH_BUY, 1000);
```

## Testing

Run the tests:

```bash
composer test
```

## Supported Currency Units

The table below lists all the currency units supported by CurrencyMaster.

| Currency Symbol | Currency Code |
|-----------------|---------------|
| NT$             | TWD           |
| $               | USD           |
| HK$             | HKD           |
| £               | GBP           |
| A$              | AUD           |
| C$              | CAD           |
| S$              | SGD           |
| CHF             | CHF           |
| ¥               | JPY           |
| R               | ZAR           |
| kr              | SEK           |
| NZ$             | NZD           |
| ฿               | THB           |
| ₱               | PHP           |
| Rp              | IDR           |
| €               | EUR           |
| ₩               | KRW           |
| ₫               | VND           |
| RM              | MYR           |
| ¥               | CNY           |

**Current Sources for Currency Units:**
- [BOT: Bank of Taiwan](https://rate.bot.com.tw/xrt)

## Licenses

(The [MIT](http://www.opensource.org/licenses/mit-license.php) License)
