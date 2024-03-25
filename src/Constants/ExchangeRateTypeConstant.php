<?php

namespace Ordinary9843\Constants;

class ExchangeRateTypeConstant
{
    /** @var string */
    const CASH_BUY = 'cashBuy';

    /** @var string */
    const CASH_SELL = 'cashSell';

    /** @var string */
    const SPOT_BUY = 'spotBuy';

    /** @var string */
    const SPOT_SELL = 'spotSell';

    /** @var array */
    const TYPES = [
        self::CASH_BUY,
        self::CASH_SELL,
        self::SPOT_BUY,
        self::SPOT_SELL
    ];
}
