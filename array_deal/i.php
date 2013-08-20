<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="../base_file/jq1.7min.js" ></script>
    <title></title>
</head>
<body>

<?php
require_once("Adeal.php");
$adeal=new Adeal();
$hary=array(
    "class"=>"@classlist@",
    "result"=>array("abc","@what@","lol"),
    "osc"=>"zhongwen",
    "putin"=>array(
        "zhongwen",
        "mod"=>array(
            "@hello@",
            "whatoc"
        ),
    ),
);
$rary=array(
    "classlist"=>"THIS IS CLASSLIST",
    "what"=>"THIS IS WHAT",
    "hello"=>"HELLO",
);
$pars=array(
    "v"=>array(
        "hary"=>$hary,
        "rary"=>$rary,
    ),
);
$ret=$adeal->array_replace($pars);
pm("hary",$ret);
?>

<?php
function pm($t, $c)
{
    echo "<pre>";
    echo "<h4>" . $t . "</h4><hr />";
    var_dump($c);
    echo "</pre>";
}

?>
</body>
</html>
