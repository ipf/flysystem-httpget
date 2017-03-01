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

    /**
     * @param string $path
     * @return bool
     */
    public function has($path)
    {
        return $this->client->head($path)->getStatusCode() === 200;
    }

    /**
     * @param string $path
     * @return array
     */
    public function read($path)
    {
        $returner = [];
        $fetched = $this->client->get($path)->getBody();
        $returner['contents'] = $fetched->getContents();

        return $returner;
    }

    /**
     * @param string $path
     * @return \Psr\Http\Message\StreamInterface
     */
    public function readStream($path)
    {
        return $this->client->get($path)->getBody();
    }

    public function listContents($directory = '', $recursive = false)
    {
        throw new NotSupportedException(self::UNSUPPORTED_MESSAGE);
    }

    /**
     * @param string $path
     * @return array|mixed|null
     */
    public function getMetadata($path)
    {
        return $this->client->get($path)->getBody()->getMetadata();
    }

    /**
     * @param string $path
     * @return \string[]
     */
    public function getSize($path)
    {
        return [$this->client->get($path)->getHeader('content-length')];
    }

    /**
     * @param string $path
     * @return \string[]
     */
    public function getMimetype($path)
    {
        return [$this->client->get($path)->getHeader('content-type')];
    }

    /**
     * @param string $path
     * @return \string[]
     */
    public function getTimestamp($path)
    {
        return [$this->client->get($path)->getHeader('date')];
    }

    /**
     * @param string $path
     * @return string
     */
    public function getVisibility($path)
    {
        return 'public';
    }
}
