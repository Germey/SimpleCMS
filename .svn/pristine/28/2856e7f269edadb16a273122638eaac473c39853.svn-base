<?php

//格式化RMB
function moneyit($val, $with_sign=true) {
    if(!$val) return '-';
    $n = str_replace(',', '', $val);
    $c = is_float($n) ? 1 : number_format($n,2);
    $d = '.';
    $t = ',';
    $sign = ($n < 0) ? '-' : '';
    $i = $n=number_format(abs($n),2); 
    $j = (($j = $i.length) > 3) ? $j % 3 : 0;
    if($with_sign) {
        $symbol = '<span>￥</span>';
    }  else {
        $symbol = '';
    }
    $res = $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j));
    return str_replace('.00', '', $res);
}