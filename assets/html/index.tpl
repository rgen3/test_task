<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Тестовое задание отправка формы</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <!--[if lt IE 9]>
    <script src="http://html5shiv-printshiv.googlecode.com/svn/trunk/html5shiv-printshiv.js"></script>
    <![endif]-->
</head>
<body>
<!--content starts -->
<h1>Не особо красивая, но адаптивная форма для тестового задания</h1>
<!--form starts-->
<form method="post" action="assets/php/handler.php" enctype="application/x-www-form-urlencoded" id="custom-form">
    <input type="hidden" name="token" value="<?=$token?>" />
    <div class="input-group">
        <label for="username">Ваше имя:</label>
        <input name="username" id="username" type="text" required placeholder="Введите ваше имя"/>
        <small class="error error-username"></small>
    </div>
    <div class="input-group">
        <label for="phone">Ваше телефон:</label>
        <input name="phone" id="phone" type="tel" pattern="((8|\+7|7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}" required placeholder="Введите ваш телефон"/>
        <small class="error error-phone"></small>
    </div>
    <div class="input-group">
        <label for="email">Ваш email:</label>
        <input name="email" id="email" type="text" placeholder="Введите ваш email"/>
        <small class="error error-email"></small>
    </div>
    <div class="input-group">
        <label for="agreement">Я согласен на обработку данных:</label>
        <input type="checkbox" name="agreement" id="agreement" required value="true">
        <small class="error error-agreement"></small>
    </div>
    <div class="input-group">
        <input name="send" type="submit" value="Отправить форму">
    </div>
</form>
<!--form ends -->
<!--content ends -->
</body>
<script src="assets/js/lib.js" type="application/x-javascript"></script>
<script src="assets/js/custom.js" type="application/x-javascript"></script>
</html>