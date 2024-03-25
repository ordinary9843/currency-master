<?php

namespace Ordinary9843\Exceptions;

class SourceException extends BaseException
{
    /** @var int */
    const CODE_DEFAULT = 5000;

    /** @var int */
    const CODE_FETCH = 5001;

    /** @var int */
    const CODE_REQUEST_FAILED = 5002;

    /**
     * @param string $message
     * @param int $code
     * @param array $detail
     * @param BaseException $previous
     */
    public function __construct(string $message, int $code = self::CODE_DEFAULT, array $detail = [], BaseException $previous = null)
    {
        parent::__construct($message, $code, $detail, $previous);
    }
}
