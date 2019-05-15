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

    public function delivers()
    {
        return [
            'AAEWEB'        => 'AAE',
            'ARAMEX'        => 'Aramex',
            'DHL'           => 'DHL国内件',
            'DHL_EN'        => 'DHL国际件',
            'DPEX'          => 'DPEX',
            'DEXP'          => 'D速',
            'EMS'           => 'EMS(国内和国际)',
            'EWE'           => 'EWE',
            'FEDEX'         => 'FEDEX',
            'FEDEXIN'       => 'FedEx国际',
            'PCA'           => 'PCA',
            'TNT'           => 'TNT',
            'UPS'           => 'UPS',
            'ANJELEX'       => '安捷快递',
            'ANE'           => '安能快递',
            'ANEEX'         => '安能快递',
            'ANXINDA'       => '安信达',
            'EES'           => '百福东方',
            'HTKY'          => '百世快递',
            'BSKY'          => '百世快运',
            'FLYWAYEX'      => '程光',
            'DTW'           => '大田',
            'DEPPON'        => '德邦快递',
            'GCE'           => '飞洋',
            'PHOENIXEXP'    => '凤凰',
            'FTD'           => '富腾达',
            'GSD'           => '共速达',
            'GTO'           => '国通快递',
            'BLACKDOG'      => '黑狗',
            'HENGLU'        => '恒路',
            'HYE'           => '鸿远',
            'HQKY'          => '华企',
            'JOUST'         => '急先达',
            'TMS'           => '加运美',
            'JIAJI'         => '佳吉',
            'JIAYI'         => '佳怡',
            'KERRY'         => '嘉里物流',
            'HREX'          => '锦程快递',
            'PEWKEE'        => '晋越',
            'JD'            => '京东快递',
            'KKE'           => '京广快递',
            'JIUYESCM'      => '九曳供应链',
            'KYEXPRESS'     => '跨越',
            'FASTEXPRESS'   => '快捷',
            'BLUESKY'       => '蓝天',
            'LTS'           => '联昊通',
            'LBEX'          => '龙邦快递',
            'CAE'           => '民航',
            'ND56'          => '能达',
            'PEISI'         => '配思航宇',
            'EFSPOST'       => '平安快递',
            'CHINZ56'       => '秦远物流',
            'QCKD'          => '全晨',
            'QFKD'          => '全峰快递',
            'APEX'          => '全一',
            'RFD'           => '如风达',
            'SFC'           => '三态',
            'STO'           => '申通快递',
            'SFWL'          => '盛丰',
            'SHENGHUI'      => '盛辉',
            'SDEX'          => '顺达快递',
            'SFEXPRESS'     => '顺丰',
            'SUNING'        => '苏宁',
            'SURE'          => '速尔',
            'HOAU'          => '天地华宇',
            'TTKDEX'        => '天天',
            'VANGEN'        => '万庚',
            'WANJIA'        => '万家物流',
            'EWINSHINE'     => '万象',
            'GZWENJIE'      => '文捷航空',
            'XBWL'          => '新邦',
            'XFEXPRESS'     => '信丰',
            'BROADASIA'     => '亚风',
            'YIEXPRESS'     => '宜送',
            'QEXPRESS'      => '易达通',
            'ETD'           => '易通达',
            'UC56'          => '优速快递',
            'CHINAPOST'     => '邮政包裹',
            'YFHEX'         => '原飞航',
            'YTO'           => '圆通快递',
            'YADEX'         => '源安达',
            'YCGWL'         => '远成',
            'YFEXPRESS'     => '越丰',
            'YTEXPRESS'     => '运通',
            'YUNDA'         => '韵达快递',
            'ZJS'           => '宅急送',
            'ZMKMEX'        => '芝麻开门',
            'COE'           => '中国东方',
            'CRE'           => '中铁快运',
            'ZTKY'          => '中铁物流',
            'ZTO'           => '中通快递',
            'ZTO56'         => '中通快运(物流)',
            'CNPL'          => '中邮',
            'YIMIDIDA'      => '壹米滴答',
            'PJKD'          => '品俊快递',
            'RRS'           => '日日顺物流',
            'YXWL'          => '宇鑫物流',
            'DJ56'          => '东骏快捷',
            'AYCA'          => '澳邮专线',
            'BDT'           => '八达通',
            'CITY100'       => '城市100',
            'CJKD'          => '城际快递',
            'D4PX'          => '递四方速递',
            'FKD'           => '飞康达',
            'GTSD'          => '广通',
            'HQSY'          => '环球速运',
            'HYLSD'         => '好来运快递',
            'JAD'           => '捷安达',
            'JTKD'          => '捷特快递',
            'JGWL'          => '景光物流',
            'MB'            => '民邦快递',
            'MK'            => '美快',
            'MLWL'          => '明亮物流',
            'PADTF'         => '平安达腾飞快递',
            'PANEX'         => '泛捷快递',
            'QRT'           => '全日通快递',
            'QXT'           => '全信通',
            'RFEX'          => '瑞丰速递',
            'SAD'           => '赛澳递',
            'SAWL'          => '圣安物流',
            'SDWL'          => '上大物流',
            'ST'            => '速通物流',
            'STWL'          => '速腾快递',
            'SUBIDA'        => '速必达物流',
            'WJK'           => '万家康',
            'XJ'            => '新杰物流',
            'ZENY'          => '增益快递',
            'ZYWL'          => '中邮物流',
            'AOL'           => '澳通速递',
            'ANXL'          => '安迅物流',
            'EXFRESH'       => '安鲜达',
            'AJWL'          => '安捷物流',
            'ANTS'          => 'ANTS',
            'ASTEXPRESS'    => '安世通快递',
            'IBUY8'         => '爱拜物流',
            'ADODOXOM'      => '澳多多国际速递',
            'APLUSEX'       => 'Aplus物流',
            'ADAPOST'       => '安达速递',
            'AUSEXPRESS'    => '澳世速递',
            'MAXEEDEXPRESS' => '澳洲迈速快递',
            'ONWAY'         => '昂威物流',
            'AOTSD'         => '澳天速运',
            'HEMA'          => '河马动力'
        ];
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

    public function getDefaultResponseResolver()
    {
        return function ($data) {
            if ($data['status'] != 0) {
                throw new ExpressException($data['msg']);
            }

            return $data;
        };
    }
}