## 快递鸟物流查询

### 安装
```
composer require honki/kdbird
```
### 配置
在.env文件中添加


```
KDBIRD_USERID=                //对应用户ID
KDBIRD_APIKEY=                //对应API key
```

### 如何使用
##### 物流轨迹即时查询
```
  use Honki\KdBird\KdBird;

  $kdbird = new KdBird();
  return $kdbird->getOrderTraces('快递公司编码','运单号');
```
```
返回数据为:
{
"EBusinessID": "",
"ShipperCode": "",
"Success": true,
"LogisticCode": "",
"State": "3",
"Traces": [
    //快递物流信息
]
}
```
##### 通过单号查询物流公司
```
  $kdbird = new KdBird();
  return $kdbird->getName('运单号');
```
```
返回数据为:
{
"LogisticCode" : "",
"Shippers" : [ {
"ShipperName" : "圆通速递",
"ShipperCode" : "YTO"
} ],
"EBusinessID" : "",
"Code" : "",
"Success" : true
}
```