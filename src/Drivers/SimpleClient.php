<?php namespace Nerio\Express\Drivers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Cache\Repository;
use Nerio\Express\Express;
use Psr\Http\Message\ResponseInterface;

/**
 * @author caojiayuan
 */
abstract class SimpleClient implements Express
{
    /**
     * @var Repository
     */
    protected static $cache;

    protected $baseUri;

    protected $guzzle;

    protected $path;

    protected $method = 'POST';

    protected $cacheMinute = 120;

    public function __construct()
    {
        $this->guzzle = new Client([
            'base_uri' => $this->baseUri
        ]);
    }

    /**
     * @param mixed $cache
     */
    public static function setCache($cache)
    {
        static::$cache = $cache;
    }

    public function query($deliverNo, $code = null)
    {
        $data = $this->withData($deliverNo, $code);

        if (static::$cache) {
            $key = basename(str_replace('\\', DIRECTORY_SEPARATOR, static::class))
                . ':'
                . $deliverNo
                . $code;

            return static::$cache->remember($key, $this->cacheMinute, function () use ($data) {
                return $this->request($data);
            });
        }

        return $this->request($data);
    }

    protected function handleResponseData($data)
    {
        return $data;
    }

    abstract protected function withData($deliverNo, $code): array;

    protected function request($data, $path = null)
    {
        $path || $path = $this->path;
        $response = $this->guzzle->request($this->method, $path, $this->withOptions($data));

        return $this->handleResponseData($this->parseResponse($response));
    }

    protected function withOptions($data)
    {
        $option = $this->method == 'GET' ? RequestOptions::QUERY : RequestOptions::FORM_PARAMS;

        return [
            $option => $data
        ];
    }

    protected function parseResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody(), true);
    }

    public function delivers()
    {
        return [];
    }
}