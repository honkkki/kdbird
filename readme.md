## 快递鸟即时查询

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
```
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
