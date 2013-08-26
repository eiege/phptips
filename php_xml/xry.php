<?php
/**
 * 数组和xml之间的相互转换。
 * User: gaocheng
 * Date: 13-7-18
 * Time: 下午4:16
 * To change this template use File | Settings | File Templates.
 */

class xry
{
    /**
     * 数组转xml
     */
    public $version = "1.0";
    public $encoding = "UTF-8";
    public $root = "root";
    public $xml;

    /**
     * 将数组转换成xml
     * @param $arr
     * @param int $dom
     * @param int $item
     * @return array
     */
    function ary2xml($arr,$dom=0,$item=0)
    {
        if (!$dom){
            $dom = new DOMDocument("1.0","utf-8");
        }
        if(!$item){
            $item = $dom->createElement("root");
            $dom->appendChild($item);
        }
        foreach ($arr as $key=>$val){
            $itemx = $dom->createElement(is_string($key)?$key:"item");
            $item->appendChild($itemx);
            if (!is_array($val)){
                $text = $dom->createTextNode($val);
                $itemx->appendChild($text);

            }else {
                $this->ary2xml($val,$dom,$itemx);
            }
        }
        $ret=array(
            "rec"=>$arr,
            "data"=>$dom->saveXML(),
            "runinfo"=>array(
                "dcode"=>"10:43:34",
            ),
        );
        return $ret;
    }

    /**
     * xml转数组
     */
    function xml2ary($xml = "")
    {
        $ret=array(
            "error"=>1,
            "data"=>null,
            "runinfo"=>array(),
        );
        $ret['data']=json_decode(json_encode(simplexml_load_string($xml)),true);

        if($ret['data'])
        {
            $ret['error']=1;
        }
        $ret['runinfo']['xml']=$xml;

        return $ret;
    }
}