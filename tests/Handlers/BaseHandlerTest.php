<?php

namespace Tests\Handlers;

use ReflectionClass;
use Tests\BaseTestCase;
use Ordinary9843\Handlers\BaseHandler;
use Ordinary9843\Interfaces\SourceInterface;
use Ordinary9843\Exceptions\HandlerException;

class BaseHandlerTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testExecuteShouldThrowHandlerException(): void
    {
        $source = $this->createMock(SourceInterface::class);
        $handler = new BaseHandler($source);
        $this->expectException(HandlerException::class);
        $this->expectExceptionCode(HandlerException::CODE_EXECUTE);
        $handler->execute();
    }

    /**
     * @return void
     */
    public function testSetSourceShouldEqualGetSource(): void
    {
        $source = $this->createMock(SourceInterface::class);
        $handler = new BaseHandler($source);
        $handler->setSource($source);
        $this->assertEquals($source, $handler->getSource());
    }

    /**
     * @return void
     */
    public function testMapArgumentsShouldCombineArgumentMapping(): void
    {
        $source = $this->createMock(SourceInterface::class);
        $reflection = new ReflectionClass(BaseHandler::class);
        $handler = $reflection->newInstanceArgs([$source]);
        $property = $reflection->getProperty('argumentsMapping');
        $property->setAccessible(true);
        $property->setValue($handler, ['arg1', 'arg2', 'arg3']);
        $args = [1, 2, 3];
        $method = $reflection->getMethod('mapArguments');
        $method->setAccessible(true);
        $method->invokeArgs($handler, [&$args]);
        $this->assertEquals(['arg1' => 1, 'arg2' => 2, 'arg3' => 3], $args);
    }

    /**
     * @return void
     */
    public function testArgumentsMappingWhenProvidedInputs()
    {
        $source = $this->createMock(SourceInterface::class);
        $handler = new BaseHandler($source);
        $reflection = new ReflectionClass($handler);
        $property = $reflection->getProperty('argumentsMapping');
        $property->setAccessible(true);
        $property->setValue($handler, ['arg1', 'arg2']);
        $arguments = ['value1', 'value2'];
        $method = $reflection->getMethod('mapArguments');
        $method->setAccessible(true);
        $method->invokeArgs($handler, [&$arguments]);
        $this->assertEquals([
            'arg1' => 'value1',
            'arg2' => 'value2'
        ], $arguments);
    }
}
