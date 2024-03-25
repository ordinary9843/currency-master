<?php

namespace Ordinary9843\Interfaces;

interface HandlerInterface extends BaseInterface
{
    /**
     * @param mixed ...$arguments
     * 
     * @return mixed
     */
    public function execute(...$arguments);

    /**
     * @param SourceInterface $source
     *
     * @return void
     */
    public function setSource(SourceInterface $source): void;

    /**
     * @return SourceInterface
     */
    public function getSource(): SourceInterface;
}
