<?php

namespace Honki\KdBird;

class KdBird
{
    /**
     * @var 用户id
     */
    protected $userid;

    /**
     * @var apikey
     */
    protected $apikey;


    public function __construct()
    {
        $this->userid=env('KDBIRD_USERID','');
        $this->apikey=env('KDBIRD_APIKEY','');
    }

    /**
     * @param $requestData, json类型,提交的数据,{'OrderCode':'','ShipperCode':'','LogisticCode':''},OrderCode:订单编号,选填;ShipperCode:快递公司编号;LogisticCode:物流单号
     * @return string
     */
    public function getOrderTracesByJson($requestData)
    {
        if (!$this->is_not_json($requestData))
        {
            return '$requestData,必须是json类型';
        }

        $datas=array(
            'EBusinessID'=>$this->userid,
            'RequestType'=>'1002',
            'RequestData'=>urlencode($requestData),
            'DataType'=>'2',
        );

        $datas['DataSign']=$this->encrypt($requestData);
        $result=$this->sendTracesPost($datas);

        return $result;
    }


    /**
     * @param $requestData
     * @return string
     */
    public function getNameByJson($requestData){
        if (!$this->is_not_json($requestData))
        {
            return '$requestData,必须是json类型';
        }

        $datas = array(
            'EBusinessID' => $this->userid,
            'RequestType' => '2002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData);
        $result=$this->sendTracesPost($datas);

        return $result;
    }


    /**
     * 参数为快递单号
     * @param $LogisticCode
     * @return string
     */
    public function getName($LogisticCode)
    {
        $json="{'LogisticCode':"."'".$LogisticCode."'}";
        return $this->getNameByJson($json);
    }


    /**
     * @param $shipperCode,快递公司编码
     * @param $LogisticCode,快递单号
     * @return string
     */
    public function getOrderTraces($shipperCode,$LogisticCode)
    {
        $json="{'OrderCode':'','ShipperCode':"."'".$shipperCode."'".",'LogisticCode':"."'".$LogisticCode."'}";
        return $this->getOrderTracesByJson($json);
    }



    /**
     * @param $str
     * @return bool
     */
    private function is_not_json($str)
    {
        return is_null(json_decode($str));
    }

    /**
     * post提交
     * @param $datas
     * @return string,
     */
    private function sendTracesPost($datas)
    {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url("http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx");
        if(empty($url_info['port']))
        {
            $url_info['port']=80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }

    /**
     * 电商sign签名
     * @param $data
     * @return string
     */
    private function encrypt($data)
    {
        return urlencode(base64_encode(md5($data.$this->apikey)));
    }
}