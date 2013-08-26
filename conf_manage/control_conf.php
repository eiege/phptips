<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-15
 * Time: 上午10:40
 * To change this template use File | Settings | File Templates.
 */

include("Econf.php");

/**
 * Class margeconf
 * 管理和配置类
 */
class margeconf
{
    public $ec;//econf 对象

    public function __construct()
    {
        $iniconf = array(
            "v" => array(
                "main_path" => "conftest",
                "conf_path" => "10068",
            ),

        );
        $this->ec = new Econf($iniconf);
        $this->ec->debug=true;
    }

    /**
     * 添加配置
     */
    public function addconf()
    {
        $confname=$_POST['addconfname'];
        $showname=$_POST['addshowname'];
        if($confname === null || $showname === null)
        {
            $r=array(
                "ero"=>1,
                "msg"=>"Confname and Showname is must[14:41:52]",
            );
            $this->rejs($r);
        }
        $add_conf_pars=array(
            "v"=>array(
                "confname"=>$confname,
                "showname"=>$showname,
            ),
        );
        $addret=$this->ec->add_conf_file($add_conf_pars);
        if($addret['e'] === false)
        {
            $r=array(
                "ero"=>0,
                "msg"=>"Add success",
            );
            $this->rejs($r);
        }
        else{
            $r=array(
                "ero"=>1,
                "msg"=>$addret['i'],
            );
        }
        $this->rejs($r);
    }

    /**
     * 获取配置索引
     */
    public function getindex($rn=false)
    {
        $index_conf=array(
            "v"=>array(
                "confname"=>$this->ec->iniconf,
            ),
        );
        $index_ret=$this->ec->get_conf_file($index_conf);
        $ret=array(
            "ero"=>($index_ret['e'] === false)?0:1,
            "msg"=>$index_ret['i'],
        );
        if($rn)
        {
            return $ret;
        }
        else
        {
            $this->rejs($ret);
        }
    }

    /**
     * 获取特定的配置内容
     */
    public function getconf()
    {
        $confname=&$_POST['confname'];
        if(empty($confname))
        {
            $this->rejs(array("ero"=>1,"msg"=>"Error:confname is must"));
        }
        $conf_pars=array(
            "v"=>array(
                "confname"=>$confname,
            ),
        );
        $ret_conf=$this->ec->get_conf_file($conf_pars);
        $ret=array(
            "ero"=>($ret_conf['e']=== false)?0:1,
            "msg"=>$ret_conf['i'],
        );
        $this->rejs($ret);
    }

    /**
     * 设置配置
     */
    public function setconf()
    {
        $confname=&$_POST['confname'];
        $confdata=&$_POST['confdata'];
        $setconf_pars=array(
            "v"=>array(
                "confname"=>$confname,
                "confdata"=>$confdata,
            ),
        );
        $set_ret=$this->ec->set_conf_file($setconf_pars);
        $ret=array(
            "ero"=>($set_ret['e'] === false)?0:1,
            "msg"=>$set_ret['i'],
        );
        $this->rejs($ret);
    }

    /**
     * 删除索引
     */
    public function delconf()
    {
        $confname=&$_POST['confname'];
        $conf_pars=array(
            "v"=>array(
                "confname"=>($confname === null)?$this->rejs(array("ero"=>1,"msg"=>"Error:confname is must")):$confname,
            ),
        );
        $ret_conf=$this->ec->del_conf_file($conf_pars);
        $ret=array(
            "ero"=>($ret_conf['e']=== false)?0:1,
            "msg"=>$ret_conf['i'],
        );
        $this->rejs($ret);
    }

    public function revconf()
    {
        $rev_id=$_POST['rev_id'];
        $rev_name=$_POST['rev_name'];
        $conf_arys=array(
            "v"=>array(
                "rev_id"=>$rev_id,
                "rev_name"=>$rev_name,
            ),
        );
        $rev_ret=$this->ec->rev_conf_file($conf_arys);
        $ret=array(
            "ero"=>($rev_ret['e'] === false)?0:1,
            "msg"=>$rev_ret['i'],
        );
        $this->rejs($ret);
    }


    /**
     * 返回json
     */
    public function rejs($pars)
    {
        echo json_encode($pars);
        exit();
    }
}

$margeconf=new margeconf();

if(!empty($_GET['ctl']))
{
    $ctl=$_GET['ctl'];
    $margeconf->$ctl();
}
