<?php

namespace Ordinary9843\Sources;

use GuzzleHttp\Client;
use Ordinary9843\Configs\Config;
use Ordinary9843\Traits\ConfigTrait;
use Ordinary9843\Traits\FileCacheTrait;
use Ordinary9843\Exceptions\SourceException;
use Ordinary9843\Interfaces\SourceInterface;

class BaseSource implements SourceInterface
{
    use ConfigTrait, FileCacheTrait;

    /** @var Config */
    protected $config = null;

    /** @var Client */
    protected $client = null;

    /** @var string */
    protected $baseUrl = null;

    /**
     * @param Client $client
     */
    public function __construct(Client $client = null)
    {
        $this->config = Config::getInstance();
        $this->client = $client !== null ? $client : new Client(['base_uri' => $this->baseUrl]);
    }

    /**
     * @return mixed
     * 
     * @throws SourceException
     */
    public function fetch(): array
    {
        throw new SourceException('The method has not implemented yet.', SourceException::CODE_FETCH);
    }

    /**
     * @param Client $client
     * 
     * @return void
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}
