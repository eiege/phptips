<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="../base_file/jq1.7min.js"></script>
    <title></title>
</head>
<body>

<?php
require_once("pdost.php");

$pdo_available_drivers = PDO::getAvailableDrivers();
pm("pdo_available_drivers", $pdo_available_drivers);

//初始化pdo对象
$pars = array(
    "dbtype" => "mysql",
    "host"   => "localhost",
    "dbname" => "test",
    "user"   => "root",
    "upw"    => "123",
);
$pdo = new dbl($pars);

//查询表
$pars = array(
    array(
        "sql"  => "show tables",
        "pars" => array(),
    ),
);
//$pdo->presql($pars);
//pm("show tables", $pdo->ret);

//插入数据
$pdo->ret = array();
$pars = array(
    array(
        "sql"  => "insert into test_table (story) value (:story)",
        "pars" => array(
            array(
                "story" => date("Y-m-d H:i:s", time()),
            ),
            array(
                "story" => date("Y-m-d H:i:s", time()),
            ),
            array(
                "story" => date("Y-m-d H:i:s", time()),
            ),
            array(
                "story" => date("Y-m-d H:i:s", time()),
            ),
            array(
                "story" => date("Y-m-d H:i:s", time()),
            ),
        ),
    ),
);
//$pdo->presql($pars);

//查询数据
$pdo->ret = array();
$pars = array(
    array(
        "sql"  => "select * from test_table order by id desc ",
        "pars" => array(),
    ),
);
//$pdo->presql($pars);
//pm("show tables", $pdo->ret);

//获取特定的数据
$pdo->ret = array(); //首先将对象结果数据置空
$select_id=1200;
$pars = array(
//    array(
//        "sql"  => "select * from test_table where id=:id order by id desc limit 1",
//        "pars" => array(
//            array("id" => $select_id,),
//        ),
//    ),
    array(
        "sql"=>"select count(*) as num from test_table where id=:id",
        "pars"=>array(
            array(
                "id"=>$select_id,
            ),
        ),
    ),
);
$pdo->presql($pars);
$ret=$pdo->ret;
pm("select id num",$ret[0][0]['num']);
pm("select id", $pdo->ret);


?>

<?php
function pm($t, $c)
{
    echo " <pre>";
    echo "<h4>" . $t . "</h4 ><hr />";
    var_dump($c);
    echo "</pre>";
}

?>
</body>
</html>
