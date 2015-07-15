<?php
/*Open session to check token*/
session_start();

/*Register autoloader*/

spl_autoload_register(function($class){
    require_once __DIR__ . "/classes/" . $class . ".php";
});

$configs = include "configs.php";
$lang = include "lang.php";


/*Check token*/
$t = $_POST["token"];
if (!isset($t) || $t != $_SESSION["token"]) {
    exit("hacking attempt");
}

/*Set up data for return*/

$result = array(
    "success" => true,
    "errors"  => array()
);

/*Check all params to be valid data*/

foreach ($configs["validation"] as $k=>$v){
    /*Check is $v array*/
    if (is_array($v)){
        foreach($v as $rules){
            $m = array_shift($rules);
            $params = array_merge(array($_POST[$k]), $rules);
            $r = call_user_func_array("validation::$m", $params);
            if (!$r){
                $result["success"] = $r;
                $result["errors"][$k]["type"] = $m;
            }
        }
    }else{
        throw new Exception("Неверно заполнен массив валидации");
    }
}

if (!$result["success"]){
    foreach ($result["errors"] as $k=>&$v){
        if (isset($lang["validation"]["errors"][$k][$v["type"]])){
            $v["msg"] = $lang["validation"]["errors"][$k][$v["type"]];
        }else{
            $v["msg"] = $lang["validation"]["errors"]["default"][$v["type"]];
        }
    }
}

if (!$result["success"]){
    echo json_encode($result);
    exit();
}

try {
    $db = new PDO($configs["db"]["dns"], $configs["db"]["username"], $configs["db"]["pass"], $configs["db"]["options"]);
}catch (Exception $e){
    echo 'Не удалось подключиться: ' . $e->getMessage();
}

$data = array(
    $_POST["username"],
    $_POST["phone"],
    $_POST["email"]
);

$sql = "INSERT INTO `records`(`username`, `phone`, `email`) VALUES (?, ?, ?)";

$q = $db->prepare($sql);
if (!$q->execute(array_values($data))){
    $result["success"] = array("success" => false);
    $result["errors"]["db"] = true;
    $result["errors"]["db_data"] = $q->errorInfo();
}else{
    $result["msg"] = "Ура! Данные успешно отправлены!";
}

echo json_encode($result);
exit();