<?php


namespace Honki\KdBird;


class Logistics
{
    /**
     * 通过单号直接获取物流信息
     * @param string $logisticsNo
     * @return mixed
     */
    public function getLogistics($logisticsNo)
    {
        $kdBird = new KdBird();
        $name = $kdBird->getName($logisticsNo);
        $nameArray = json_decode($name, true);
        $shipper = $nameArray['Shippers'];

        if ($shipper == []) {
            return [];
        }

        if (count($shipper) == 1) {
            $result = $kdBird->getOrderTraces($shipper[0]['ShipperCode'], $logisticsNo);
            $resJson = json_decode($result, true);
            if ($resJson['State'] == 0) {
                return [];
            }
        }

        foreach ($shipper as $v) {
            $result = $kdBird->getOrderTraces($v['ShipperCode'], $logisticsNo);
            $resJson = json_decode($result, true);
            //单号可能对应多个物流公司 存在空数据
            if ($resJson['State'] == 0) {
                continue;
            }

            $logistics = $kdBird->getOrderTraces($v['ShipperCode'], $logisticsNo);
        }

        return json_decode($logistics, true);
    }

}