<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="../base_file/jq1.7min.js"></script>
    </head>
<body>

<?php

/**
通过sel和input批量添加内容
 */
 $cp=array(
	"name"=>"sels",
	"lab"=>"数据测试lab",
	"slv"=>array(
		"news"=>"新闻",
		"china"=>"中国",
		"usa"=>"美国",
		"what"=>"什么",
	),
	
 );
if(empty($cp))
{
    /**
     * ***********************************************输入调试信息
     */
    echo"系统调试中,请联系管理员[13:57:28]";
    exit();
}
?>
<script type="text/javascript">
    function add_bat_em(){
	   // window.alert("step 1");
        var bat_k=$("#bat_key option:selected").val();
        var bat_name=$("#bat_key option:selected").html();
        var bat_v=$("#bat_val").val();
        var bat_ary_name="<?php echo $cp["name"]; ?>";
        var ins_emt_batton="<input type='button' value='-' onclick='del_this(\"div_bat_ary_name_"+bat_k+"_\")' /> ";
        var ins_emt="<div id='div_bat_ary_name_"+bat_k+"_'>"+bat_name+":<input type='text' disabled='disabled' id='bat_ary_name_"+bat_k+"_' value='"+bat_v+"' name='bat_ary_name["+bat_k+"]' />"+ins_emt_batton+"</div>";
        var have_val=$("#bat_ary_name_"+bat_k+"_").val();
       // window.alert("step 2");
       // window.alert("have_val:"+have_val);
        if(have_val)
        {
            var new_val=Number(have_val)+Number(bat_v);
            $("#bat_ary_name_"+bat_k+"_").val(new_val);
           // window.alert("step 4");
           // window.alert(new_val);
        }else{
            $("#bat_list").append(ins_emt);
           // window.alert("step 3");
           // window.alert(ins_emt);
        }
    }

    function del_this(delid)
    {
        $("#"+delid).remove();
    }

</script>
<div class="cpe_title">
    <?php echo $cp['lab'];?>
</div>
<div class="cpe_inp">
    <!--*************************************************设置控件-->
    <div id="bat_list">

    </div>
    <div class="bat_ctl">

        <select id="bat_key">
            <?php
            foreach ($cp['slv'] as $k => $v)
            {
                echo "<option value='{$k}'>{$v}</option>";
            }
            ?>
        </select>
        <input type="text" id="bat_val" />
        <input type="button" value="+" onclick="add_bat_em()" />
    </div>
</div>
</body>
</html>