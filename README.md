<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Тестовое задание ГТС</h1>
    <br>
</p>

Добавлена админка для того чтобы видеть список заявок и пользователей. Войти можно со следующими данными:

email: kzt1@bk.ru

пароль: 1q2w3e4r

Для того чтобы запустить систему, необходимо следующее:

* Установить PHP 7, MySQL 7.1, Apache или Nginx и Composer либо скачать OpenServer
* Склонить или скачать исходники
* : cd <корневая папка проекта>
* : composer update
* : php init
* 0[development] выбрать
* Создать в Mysql базу <название базы>
* <корневая папка проекта>\common\config\main-local.php изменить в следующей форме:

'dsn' => 'mysql:host=127.0.0.1;dbname=<название базы>',

'username' => '<логин>',

'password' => '<пароль>',


* : php yii migrate
* применить "yes"
* Настроить вебсервер следующим образом:

домен task.front на папку <корневая папка проекта>\frontend\web
домен task.back на папку <корневая папка проекта>\backend\web

Для Apache и Nginx есть <a href="https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md"> подробная инструкция</a>