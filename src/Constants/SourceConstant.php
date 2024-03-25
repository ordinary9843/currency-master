<?php

namespace Ordinary9843\Constants;

class SourceConstant
{
    /** @var string */
    const DEFAULT_SOURCE = self::BOT;

    /** @var string */
    const BOT = 'Bot';

    /** @var array */
    const SOURCES = [
        self::BOT => 'https://rate.bot.com.tw'
    ];
}
