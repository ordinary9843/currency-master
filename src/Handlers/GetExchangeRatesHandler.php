<?php

namespace Ordinary9843\Handlers;

use Ordinary9843\Exceptions\BaseException;
use Ordinary9843\Exceptions\HandlerException;
use Ordinary9843\Interfaces\HandlerInterface;

class GetExchangeRatesHandler extends BaseHandler implements HandlerInterface
{
    /**
     * @return mixed ...$arguments
     * 
     * @throws HandlerException
     */
    public function execute(...$arguments): array
    {
        $this->mapArguments($arguments);

        try {
            return $this->getSource()->fetch();
        } catch (BaseException $exception) {
            throw new HandlerException($exception->getMessage(), HandlerException::CODE_EXECUTE, [
                'arguments' => $arguments
            ], $exception);
        }
    }
}
