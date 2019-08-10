##快递鸟即时查询
###安装
```
composer require 
```
###配置
在.env文件中添加
```
KDNIAO_EBUSSINESSID=
KDNIAO_APPKEY=
```

###使用
```
return Kdniao::getOrderTraces('HHTT','580334019453');
```
```
返回数据为:
{
"EBusinessID": "1272627",
"ShipperCode": "HHTT",
"Success": true,
"LogisticCode": "580334019453",
"State": "3",
"Traces": [
    //快递物流信息
]
}
```