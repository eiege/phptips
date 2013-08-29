<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-13
 * Time: 下午2:22
 * To change this template use File | Settings | File Templates.
 */
require_once("../vcode/vcode.php");
//$vcimg = new Vcode();
if (!empty($_GET['gimg']) && $_GET['gimg'] == "getimg")
{

    $rand_str = substr(md5(time() + rand(0, 100)), 0, 4);
    //  $rand_str=array_rand(array("1111","2222"));
    //  $rand_str="1111";
//echo $rand_str;
    $vcimg->getVcimg($rand_str);

}
else
{
    $vcode =& $_POST['vc'];
    ($vcode === null) and exit("vcode is null");
    $ck_ret = $vcimg->ckvc($vcode);
    if ($ck_ret)
    {
        echo 1;
    } else
    {
        echo $vcimg->getvc() . "\n";
        echo sha1($vcode);
    }
}
