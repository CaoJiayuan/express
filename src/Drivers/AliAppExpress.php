<?php namespace Nerio\Express\Drivers;

use GuzzleHttp\RequestOptions;
use Nerio\Express\Exceptions\ExpressException;

/**
 * @author caojiayuan
 */
class AliAppExpress extends SimpleClient
{
    protected static $dataResolver;
    protected static $responseResolver;
    protected $method = 'GET';
    private $appCode;

    public function __construct($baseUri, $appCode)
    {
        $url = parse_url($baseUri);
        $this->appCode = $appCode;
        $this->baseUri = $url['scheme'] . '://' . $url['host'];
        $this->path = $url['path'];
        parent::__construct();
    }

    /**
     * @param mixed $dataResolver
     */
    public static function setDataResolver($dataResolver)
    {
        self::$dataResolver = $dataResolver;
    }

    public function getDefaultResponseResolver()
    {
        return function ($data) {
            if ($data['status'] != 0) {
                throw new ExpressException($data['msg']);
            }

            return $data;
        };
    }

    protected function withData($deliverNo, $code): array
    {
        if (!self::$dataResolver) {
            self::$dataResolver = $this->getDefaultResolver();
        }
        return call_user_func_array(self::$dataResolver, compact('deliverNo', 'code'));
    }

    public function getDefaultResolver()
    {
        return function ($deliverNo, $code) {
            return [
                'no'   => $deliverNo,
                'type' => $code ?: 'AUTO'
            ];
        };
    }

    protected function withOptions($data)
    {
        $options = parent::withOptions($data);
        $options[RequestOptions::HEADERS] = [
            'Authorization' => 'APPCODE ' . $this->appCode
        ];
        return $options;
    }

    protected function handleResponseData($data)
    {
        if (!self::$responseResolver) {
            self::$responseResolver = $this->getDefaultResponseResolver();
        }

        return call_user_func_array(self::$responseResolver, [$data]);
    }
}