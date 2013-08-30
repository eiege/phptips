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

$pars = array(
    "dbtype" => "mysql",
    "host"   => "localhost",
    "dbname" => "test",
    "user"   => "root",
    "upw"    => "123",
);
$pdo = new dbl($pars);

$pars = array(
    array(
        "sql"  => "show tables",
        "pars" => array(),
    ),
);
$pdo->presql($pars);
pm("show tables", $pdo->ret);

$pdo->ret=array();
$pars = array(
    array(
        "sql" => "insert into test_table (story) value (:story)",
        "pars" => array(
            array(
                "story" => date("Y-m-d H:i:s",time()),
            ),
            array(
                "story" => date("Y-m-d H:i:s",time()),
            ),
            array(
                "story" => date("Y-m-d H:i:s",time()),
            ),
            array(
                "story" => date("Y-m-d H:i:s",time()),
            ),
            array(
                "story" => date("Y-m-d H:i:s",time()),
            ),
        ),
    ),
);
$pdo->presql($pars);


$pdo->ret=array();
$pars = array(
    array(
        "sql"  => "select * from test_table order by id desc ",
        "pars" => array(),
    ),
);
$pdo->presql($pars);
pm("show tables", $pdo->ret);

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
