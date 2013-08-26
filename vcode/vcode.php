<?php
/**
 * 验证码类
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-13
 * Time: 下午3:13
 * To change this template use File | Settings | File Templates.
 */
class Vcode
{

    public $verify_session_name;

    public function __construct()
    {
        $this->verify_session_name=md5("usa10086");
        if(!isset($_SESSION))
        {
            session_start();
        }
    }

    public function getVcimg($str = "abcd", $type = "png", $width = 48, $height = 22)
    {
        $this->setvc($str);
        $length=strlen($str);
        $width=($length*10+10)>$width?$length*10+10:$width;

        if ($type != 'gif' && function_exists('imagecreatetruecolor'))
        {
            $im = @imagecreatetruecolor($width, $height);
        }
        else
        {
            $im = @imagecreate($width, $height);
        }


        $backColor   = imagecolorallocate($im, 255, 255, 255); //背景色（随机）
        $borderColor = imagecolorallocate($im, 255, 255, 255); //边框色
        $pointColor  = imagecolorallocate($im, 0, 0, 0); //点颜色

        @imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);
        @imagerectangle($im, 0, 0, $width - 1, $height - 1, $borderColor);
        $stringColor = imagecolorallocate($im, 0, 0, 0);

        // 干扰线条
//		for($i=0;$i<3;$i++){
//			$fontcolor=imagecolorallocate($im,0,0,0);
//			imagearc($im,mt_rand(-10,$width),mt_rand(-10,$height),mt_rand(30,300),mt_rand(20,200),55,44,$fontcolor);
//		}
        //干扰点
        for ($i = 0; $i < 100; $i++)
        {
            imagesetpixel($im, mt_rand(0, $width), mt_rand(intval($height / 3), intval($height * 2 / 3)), $pointColor);
        }
        //写字
        for ($i = 0; $i < $length; $i++)
        {
            imagestring($im, 5, $i * 10 + 5, mt_rand(1, 8), $str{$i}, $stringColor);
        }
//        @imagestring($im, 5, 5, 3, $randval, $stringColor);
        $this->output($im, $type);

    }

    public function ckvc($ck_str="")
    {
        $se_str_sha=&$_SESSION[$this->verify_session_name];
        $ck_str_sha=sha1($ck_str);
        return $ck_str_sha == $se_str_sha;
    }

    public function setvc($vc_str="")
    {
        $_SESSION[$this->verify_session_name]=sha1($vc_str);
    }

    public function getvc()
    {
        return $_SESSION[$this->verify_session_name];
    }


    public function output($im, $type = 'png', $filename = '')
    {
        header("Content-type: image/" . $type);
        $ImageFun = 'image' . $type;
        if (empty($filename))
        {
            $ImageFun($im);
        }
        else
        {
            $ImageFun($im, $filename);
        }
        imagedestroy($im);
    }

}