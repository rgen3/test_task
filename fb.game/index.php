<?php
if (isset($_POST["vk"])){
    $vk = $_POST["vk"];
    $url = "https://api.vk.com/method/users.get?user_ids=$vk&fields=contacts";
    $data = file_get_contents($url);
    var_dump($data);
}
?><!html>
<html>
<head>
    <meta charset="utf-8">
    <title>А ну ка</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</head>
<body>
<button id="loginBtn" class="fbLoginBtn" onclick="fbLoginOnClick();">Facebook Login</button>
<div id="response"></div>
</body>
</html>