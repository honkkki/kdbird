<?php

namespace Honki\KdBird;

class KdBird
{
    // 用户id
    protected $userId;

    // api key
    protected $apiKey;

    // 请在env文件中添加对应的key
    public function __construct()
    {
        $this->userId = env('KDBIRD_USERID', '');
        $this->apiKey = env('KDBIRD_APIKEY', '');
    }


    /**
     * 获取接口数据
     *
     * @param array $data
     * @return mixed
     */
    public function getData(array $data)
    {
        $temp = [];
        foreach ($data as $key => $value) {
            $temp[] = sprintf('%s=%s', $key, $value);
        }
        $queryData = implode('&', $temp);

        $headerArray = ["Content-type:application/json;charset='utf-8'", "Accept:application/json"];
        $url = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx?' . $queryData;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }


    /**
     * 获取物流信息
     *
     * @param string $shipperCode 快递公司编码
     * @param string $logisticCode 快递单号
     * @return mixed
     */
    public function getOrderTraces(string $shipperCode, string $logisticCode)
    {
        $requestData = [
            'ShipperCode' => $shipperCode,
            'LogisticCode' => $logisticCode
        ];

        $data = [
            'EBusinessID' => $this->userId,
            'RequestType' => '1002',
            'RequestData' => urlencode(json_encode($requestData)),
            'DataType' => '2',
            'DataSign' => $this->encrypt(json_encode($requestData))
        ];

        return $this->getData($data);
    }


    /**
     * 获取物流公司名称
     *
     * @param string $logisticCode
     * @return mixed
     */
    public function getName(string $logisticCode)
    {
        $requestData = [
            'LogisticCode' => $logisticCode
        ];

        $data = [
            'EBusinessID' => $this->userId,
            'RequestType' => '2002',
            'RequestData' => urlencode(json_encode($requestData)),
            'DataType' => '2',
            'DataSign' => $this->encrypt(json_encode($requestData))
        ];

        return $this->getData($data);
    }


    /**
     * 电商sign签名
     *
     * @param string $data
     * @return string
     */
    private function encrypt(string $data)
    {
        return urlencode(base64_encode(md5($data . $this->apiKey)));
    }
}