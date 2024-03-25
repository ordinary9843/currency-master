<?php

namespace Ordinary9843\Constants;

class CurrencyConstant
{
    /** @var string */
    const USD = 'USD';

    /** @var string */
    const HKD = 'HKD';

    /** @var string */
    const GBP = 'GBP';

    /** @var string */
    const AUD = 'AUD';

    /** @var string */
    const CAD = 'CAD';

    /** @var string */
    const SGD = 'SGD';

    /** @var string */
    const CHF = 'CHF';

    /** @var string */
    const JPY = 'JPY';

    /** @var string */
    const ZAR = 'ZAR';

    /** @var string */
    const SEK = 'SEK';

    /** @var string */
    const NZD = 'NZD';

    /** @var string */
    const THB = 'THB';

    /** @var string */
    const PHP = 'PHP';

    /** @var string */
    const IDR = 'IDR';

    /** @var string */
    const EUR = 'EUR';

    /** @var string */
    const KRW = 'KRW';

    /** @var string */
    const VND = 'VND';

    /** @var string */
    const MYR = 'MYR';

    /** @var string */
    const CNY = 'CNY';

    /** @var string */
    const TWD = 'TWD';

    /** @var array */
    const CURRENCIES = [
        self::TWD => 'NT$',
        self::USD => '$',
        self::HKD => 'HK$',
        self::GBP => '£',
        self::AUD => 'A$',
        self::CAD => 'C$',
        self::SGD => 'S$',
        self::CHF => 'CHF',
        self::JPY => '¥',
        self::ZAR => 'R',
        self::SEK => 'kr',
        self::NZD => 'NZ$',
        self::THB => '฿',
        self::PHP => '₱',
        self::IDR => 'Rp',
        self::EUR => '€',
        self::KRW => '₩',
        self::VND => '₫',
        self::MYR => 'RM',
        self::CNY => '¥'
    ];
}
