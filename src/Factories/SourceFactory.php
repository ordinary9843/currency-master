<?php

namespace Ordinary9843\Factories;

use Ordinary9843\Interfaces\SourceInterface;
use Ordinary9843\Exceptions\NotFoundException;

class SourceFactory
{
    /**
     * @param string $type
     * 
     * @return SourceInterface
     * 
     * @throws NotFoundException
     */
    public function create(string $type): SourceInterface
    {
        $class = 'Ordinary9843\\Sources\\' . ucfirst($type) . 'Source';
        if (!class_exists($class)) {
            throw new NotFoundException('Classes class "' . $class . '" does not exist.', NotFoundException::CODE_CLASS);
        }

        return new $class();
    }
}
