<?php

namespace Ordinary9843\Handlers;

use Ordinary9843\Configs\Config;
use Ordinary9843\Traits\ConfigTrait;
use Ordinary9843\Interfaces\SourceInterface;
use Ordinary9843\Exceptions\HandlerException;
use Ordinary9843\Interfaces\HandlerInterface;

class BaseHandler implements HandlerInterface
{
    use ConfigTrait;

    /** @var SourceInterface */
    protected static $source = null;

    /** @var Config */
    protected $config = null;

    /** @var array */
    protected $argumentsMapping = [];

    /**
     * @param SourceInterface $source
     */
    public function __construct(SourceInterface $source)
    {
        self::$source = $source;
        $this->config = Config::getInstance();
    }

    /**
     * @param mixed ...$arguments
     * 
     * @return mixed
     * 
     * @throws HandlerException
     */
    public function execute(...$arguments)
    {
        throw new HandlerException('The method has not implemented yet.', HandlerException::CODE_EXECUTE);
    }

    /**
     * @param SourceInterface $source
     *
     * @return void
     */
    public function setSource(SourceInterface $source): void
    {
        self::$source = $source;
    }

    /**
     * @return SourceInterface
     */
    public function getSource(): SourceInterface
    {
        return self::$source;
    }

    /**
     * @param array $arguments
     * 
     * @return void
     */
    protected function mapArguments(array &$arguments): void
    {
        if (!empty($this->argumentsMapping)) {
            $arguments += array_fill(0, count($this->argumentsMapping), null);
            $arguments = array_combine($this->argumentsMapping, $arguments);
        }
    }
}
