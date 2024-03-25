<?php

namespace Tests\Handlers;

use Tests\BaseTestCase;
use GuzzleHttp\Client;
use Ordinary9843\Sources\BaseSource;
use Ordinary9843\Exceptions\SourceException;

class BaseSourceTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testFetchShouldThrowSourceException(): void
    {
        $baseSource = new BaseSource();
        $this->expectException(SourceException::class);
        $this->expectExceptionCode(SourceException::CODE_FETCH);
        $baseSource->fetch();
    }

    /**
     * @return void
     */
    public function testSetClientShouldEqualGetClient(): void
    {
        $client = $this->createMock(Client::class);
        $baseSource = new BaseSource($client);
        $baseSource->setClient($client);
        $this->assertEquals($client, $baseSource->getClient());
    }
}
