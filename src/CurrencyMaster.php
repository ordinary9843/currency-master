<?php

namespace Ordinary9843;

use Ordinary9843\Configs\Config;
use Ordinary9843\Factories\HandlerFactory;
use Ordinary9843\Exceptions\InvalidException;
use Ordinary9843\Interfaces\HandlerInterface;

/**
 * @method array getExchangeRates()
 * @method array exchangeRate(string $fromCurrency, string $toCurrency, string $exchangeRateType, float $amount, float $customExchangeRate = null)
 * @method void setSourceType(string $sourceType)
 * @method string getSourceType()
 * @method void setCacheTimeInSeconds(int $cacheTimeInSeconds)
 * @method int getCacheTimeInSeconds()
 */
class CurrencyMaster
{
    /** @var HandlerInterface[] */
    protected $handlers = [];

    /** @var array */
    protected $arguments = [];

    /**
     * @param array $arguments
     */
    public function __construct(array $arguments = [])
    {
        $this->arguments = $arguments;

        Config::initialize($this->arguments);
    }

    /**
     * @param string $name
     * @param array $arguments
     * 
     * @return mixed
     * 
     * @throws InvalidException
     */
    public function __call(string $name, array $arguments)
    {
        switch ($name) {
            case 'getExchangeRates':
            case 'exchangeRate':
                $handler = $this->createHandler($name);

                return $handler->execute(...$arguments);
            case 'getSourceType':
            case 'getCacheTimeInSeconds':
                $handler = $this->createBaseHandler();

                return $handler->{$name}();
            case 'setSourceType':
            case 'setCacheTimeInSeconds':
                $handler = $this->createBaseHandler();

                return $handler->{$name}(current($arguments));
            default:
                throw new InvalidException('Invalid method: "' . $name . '".', InvalidException::CODE_METHOD, [
                    'name' => $name,
                    'arguments' => $arguments
                ]);
        }
    }

    /**
     * @param string $name
     * 
     * @return HandlerInterface
     */
    private function createHandler(string $name): HandlerInterface
    {
        if (isset($this->handlers[$name])) {
            return $this->handlers[$name];
        }

        $this->handlers[$name] = (new HandlerFactory())->create($name);

        return $this->handlers[$name];
    }

    /**
     * @return HandlerInterface
     */
    private function createBaseHandler(): HandlerInterface
    {
        return $this->createHandler('base');
    }
}
