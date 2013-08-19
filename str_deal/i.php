<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>
<body>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-13
 * Time: 下午5:11
 * To change this template use File | Settings | File Templates.
 */
require_once("strdeal.php");
$sd=new Strdeal();

op($sd->rand_number(1,5000),"rand_number");
op($sd->rand_string(8,5),"rand_string");


function op($vname,$show="#")
{
    $tem_str="<h4>".$show."</h4>";
    $tem_str.="<hr /><pre>";
    ob_start();
    var_dump($vname);
    $tem_str.=ob_get_clean();
    $tem_str.="</pre><br />";
    echo $tem_str;

}
?>

</body>
</html>
