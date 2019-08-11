<?php


namespace Honki\KdBird;


class Logistics
{
    /**
     * 通过单号直接获取物流信息
     * @param $logistics_no
     * @return mixed
     */
    public function getLogistics($logistics_no)
    {
        $kdbird = new KdBird();
        $name = $kdbird->getName($logistics_no);
        $arr = json_decode($name, true);
        $shipper = $arr['Shippers'];

        foreach ($shipper as $v) {
            $result = $kdbird->getOrderTraces($v['ShipperCode'], $logistics_no);
            $res_json = json_decode($result, true);
            //单号对应多个公司其中一个出错
            if ($res_json['State'] == 0) {
                continue;
            }

            $logistics = $kdbird->getOrderTraces($v['ShipperCode'], $logistics_no);
        }
        return json_decode($logistics, true);
    }

}