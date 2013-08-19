<?php
/**
 * 输出图片
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-13
 * Time: 下午4:40
 * To change this template use File | Settings | File Templates.
 */


   require_once("vcode.php");
    $vcimg=new Vcode();

$rand_str=substr(md5(time()+rand(0,100)),0,4);
//echo $rand_str;
   $vcimg->getVcimg($rand_str);