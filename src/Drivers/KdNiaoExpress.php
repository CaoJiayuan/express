<?php namespace Nerio\Express\Drivers;

use Nerio\Express\Exceptions\ExpressException;

/**
 * @author caojiayuan
 */
class KdNiaoExpress extends SimpleClient
{

    protected $baseUri = 'http://api.kdniao.com';

    protected $path = 'Ebusiness/EbusinessOrderHandle.aspx';
    /**
     * @var string
     */
    protected $ebussionsid;
    /**
     * @var string
     */
    protected $appKey;


    public function __construct($ebussionsid, $appKey)
    {
        $this->ebussionsid = $ebussionsid;
        $this->appKey = $appKey;
        parent::__construct();
    }


    protected function withData($deliverNo, $code): array
    {
        $data = json_encode([
            'OrderCode'    => '',
            'ShipperCode'  => $code ?: '',
            'LogisticCode' => $deliverNo
        ]);

        return [
            'EBusinessID' => $this->ebussionsid,
            'RequestType' => '1002',
            'RequestData' => urlencode($data),
            'DataType'    => '2',
            'DataSign'    => $this->sign($data)
        ];
    }

    private function sign($data)
    {
        return urlencode(base64_encode(md5($data . $this->appKey)));
    }

    protected function handleResponseData($data)
    {
        if (!$data['Success']) {
            throw new ExpressException($data['Reason']);
        }

        return parent::handleResponseData($data);
    }
}