<?php

$body = function () {
    ?>
    <h1>401</h1>
    <br />
    <h1>Вы не авторизованы для просмотра этой страницы</h1>
    <a href="/user/authentication">Авторизация</a>
<?php
};


$renderLayout(
    'main_template.html.php',
    [
        'title' => '401 страница не найдена',
        'body' => $body,
    ]
);
