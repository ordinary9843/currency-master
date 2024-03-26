<?php

namespace Tests\Exceptions;

use Tests\BaseTestCase;
use Ordinary9843\Exceptions\SourceException;

class SourceExceptionTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testConstructorShouldSetValuesProperly(): void
    {
        $message = 'message';
        $code = SourceException::CODE_DEFAULT;
        $detail = ['detail' => 'detail'];
        $exception = new SourceException($message, $code, $detail);
        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
        $this->assertEquals($detail, $exception->getDetail());
    }

    /**
     * @return void
     */
    public function testGetDetailShouldReturnExpectedDetail(): void
    {
        $detail = ['detail' => 'detail'];
        $exception = new SourceException('detail', SourceException::CODE_DEFAULT, $detail);
        $this->assertSame($detail, $exception->getDetail());
    }
}
