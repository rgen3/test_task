<?php

if(session_id() == '') {
    session_start();
}

/*Set up token to prevent crsf*/
if (!isset($_SESSION["token"])){
    $token = $_SESSION["token"] = md5(time());
}else{
    $token = $_SESSION["token"];
}


/*Создаем некое подобие шаблонизатора, чтобы не возиться в одном файле и с html, и с php*/
ob_start();
    include 'assets/html/index.tpl';
    $content = ob_get_contents();
ob_end_clean();

echo $content;