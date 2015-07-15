Этот проект является тестовым заданием,

Суть задания следующая: нужно сделать ajax форму отправки данных с записью в базе данных, и красиво эту форму сверстать.

В данном проекте сознательно не использовались никакие бибилотеки и framework'и

С использованием javascript библиотек (например, jquery), все это возможно сделать в несколько раз быстрее,
тем не менее, нам потребуется огромное количество дополнительного и ненужно функционала.

CSS фреймворки (подобные bootstrap, так же не использовались, т.к. они также негативно скажутся на скорости загрузки)

Сокращенный синтаксис массивов и прочие нововведения php также не использовались с целью сохранить максимальную обратную
совместимость. Из-за использования функции filter_var в классе validation, поддержка скрипта будет осуществлятся только
с версии php 5.2.0.

Тем не менее, необходимо помнить, что поддержка php 5.2.0 больше не осуществляется, а более того в данной сборке существуют
критические уязвимости в безопасности. Стабильная версия php 5.3.

Укороченный синтаксис массивов начинается с верии 5.5.

HTML верстка выполнена с использованием css3 и html5.

Для поддержки скругленных уголков на браузерах ie < 9 верии можно использовать всем известный border-radius.htc, однако в
данном случае он не подключен

Для поддержки html5 свойств подключена библиотека html5shiv с google cdn. Такой подход позволяет 1. Всегда пользоваться
самыми свежими версиями библиотек 2. Позволяет ускорить загрузку этих скриптов у пользователей благодаря технологии cdn.