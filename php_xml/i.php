<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
</head>
<body>
       <?php
       include_once("xry.php");
        $xml_str=file_get_contents("item.xml");
       $xry=new xry();

       $xml_ary=$xry->xml2ary("<root>".$xml_str."</root>");

       $equip_arys_tem=array(
           "item"=>$xml_ary['data']['config']['items']['item'],
           "equip"=>$xml_ary['data']['config']['equips']['equip'],
       );
        $equips_ary=array();

       foreach($equip_arys_tem as $k =>$v)
       {
            foreach($v as $vk =>$vv)
            {
                $equips_ary[$vv['@attributes']['id']]=array(
                    "id"=>$vv['@attributes']['id'],
                    "name"=>$vv['@attributes']['name'],
                );
            }
       }

       ?>
<pre>
    <?php
	echo "array(<br/>";
    foreach($equips_ary as $k=>$v)
	{
		echo '"'.$v['id'].'"=>"'.$v['name'].'",<br/>';
	}
	echo ");";
    ?>
</pre>
</body>
</html>
