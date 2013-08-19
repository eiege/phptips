<?php
/**
 * 数据库压力测试
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-7
 * Time: 上午9:54
 * To change this template use File | Settings | File Templates.
 */

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());

    return ((float)$usec + (float)$sec);
}

$a          = 0;
while ($a < 1000)
{
$server = "localhost";
$uname  = "root";
$upw    = "123";
$con    = mysql_connect($server, $uname, $upw);
if (!$con)
{
    echo "connect error";
    exit();
}

mysql_selectdb("kefu_xk_stat");
//mysql_query("set names utf8");

$start_time = microtime_float();

    $i          = 0;
    echo PHP_EOL."------";

//    $sql="select count(*) from 1078006_stat_2013";
//    $result = mysql_query($sql);
//    $row = mysql_fetch_array($result);
//    echo PHP_EOL . $row[0];

    mysql_query("BEGIN");
    while ($i < 10000)
    {
        $sql = "insert into 1078006_stat_2013 (serverid,statime,online_c,char_c) values (12," . time() . "," . rand(1, 1000) . ",20002)";
        $result = mysql_query($sql);
        $i++;
    }
    mysql_query("COMMIT");




    $end_time = microtime_float();
    $time = $end_time - $start_time;
    echo PHP_EOL.$time;

    $a++;
    mysql_close();
}





