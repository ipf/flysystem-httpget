<?php

namespace Ipf\Flysystem\Httpget;

use GuzzleHttp\Client;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Config;
use League\Flysystem\NotSupportedException;

class HttpGetAdapter implements AdapterInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * HttpGetAdapter constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    const UNSUPPORTED_MESSAGE = 'Method not supported for this adapter';

    public function write($path, $contents, Config $config)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function writeStream($path, $resource, Config $config)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function update($path, $contents, Config $config)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function updateStream($path, $resource, Config $config)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function rename($path, $newpath)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function copy($path, $newpath)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function delete($path)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function deleteDir($dirname)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function createDir($dirname, Config $config)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function setVisibility($path, $visibility)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function has($path)
    {
        return $this->client->head($path)->getStatusCode() === 200;
    }

    public function read($path)
    {
        $returner = [];
        $fetched = $this->client->get($path)->getBody();
        $returner['contents'] = $fetched->getContents();

        return $returner;
    }

    public function readStream($path)
    {
        return $this->client->get($path)->getBody();
    }

    public function listContents($directory = '', $recursive = false)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    public function getMetadata($path)
    {
        return $this->client->get($path)->getBody()->getMetadata();
    }

    public function getSize($path)
    {
        return $this->client->get($path)->getHeader('content-length');
    }

    public function getMimetype($path)
    {
        return $this->client->get($path)->getHeader('content-type');
    }

    public function getTimestamp($path)
    {
        return $this->client->get($path)->getHeader('date');
    }

    public function getVisibility($path)
    {
        return 'public';
    }
}
