<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gaocheng
 * Date: 13-8-20
 * Time: 上午10:51
 * To change this template use File | Settings | File Templates.
 */
class Adeal
{
    public $debug=false;


    /**数组递归替换接口vdeid
     * @param array $pars hary:要替换的数组  rary:替换参数
     * @return array
     */

    public function array_replace($pars=array())
    {
        $ret=array(
            "e"=>true,
            "i"=>"",
            "d"=>array(),
        );
        empty($pars['d']) or $this->debug=true;
        $this->debug and $ret['d']['pars']=$pars;
        $hary=&$pars['v']['hary'];//要被替换的数组
        $rary=&$pars['v']['rary'];//替换参数

        if($hary === null || $rary===null)
        {
            $ret['i']="ERROR: pars [11:11:03]";
            return $ret;
        }
        if(!(is_array($hary) && is_array($rary)))
        {
            $ret['i']="Error:hary and rary are must array[11:13:13]";
        }
        $tem_rary=array();
        foreach($rary as $k =>$v)
        {
            $tem_rary['@'.$k.'@']=$v;
        }

        $ret_hary=$this->reary($hary,$tem_rary);
        $ret['e']=false;
        $ret['i']=$ret_hary;
        return $ret;
    }

    public function reary($hary,$rary)
    {
        foreach($hary as $k=>$v)
        {
            if(is_array($v))
            {
                $hary[$k]=$this->reary($v,$rary);
            }else{
                array_key_exists($v,$rary) and $hary[$k]=$rary[$v];
            }
        }
        return $hary;
    }

}