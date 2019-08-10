## 快递鸟即时查询
### 安装
```
composer require 
```
### 配置
在.env文件中添加
```
KDBIRD_USERID=
KDBIRD_APIKEY=
```

### 使用
```
  $kdbird = new KdBird();
  return $kdbird->getOrderTraces('要查询的快递公司','运单号');
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
