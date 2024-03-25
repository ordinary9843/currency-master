<?php

namespace Ordinary9843\Factories;

use Ordinary9843\Configs\Config;
use Ordinary9843\Factories\SourceFactory;
use Ordinary9843\Interfaces\HandlerInterface;
use Ordinary9843\Exceptions\NotFoundException;

class HandlerFactory
{
    /**
     * @param string $type
     * 
     * @return HandlerInterface
     * 
     * @throws ClassNotFoundException
     */
    public function create(string $type): HandlerInterface
    {
        $class = 'Ordinary9843\\Handlers\\' . ucfirst($type) . 'Handler';
        if (!class_exists($class)) {
            throw new NotFoundException('Classes class "' . $class . '" does not exist.', NotFoundException::CODE_CLASS);
        }

        $sourceType = Config::getInstance()->getSourceType();
        $source = (new SourceFactory())->create($sourceType);

        return new $class($source);
    }
}
