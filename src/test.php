<?php

namespace honki\KdBird;

require './Logistics.php';
require './KdBird.php';

$obj = new Logistics();
$res = $obj->getLogistics('YT5029062300748');
var_dump($res);
