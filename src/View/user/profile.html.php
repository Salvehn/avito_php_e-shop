<?php

/** @var \Model\Entity\User[] $productList */
$body = function () use ($user, $path) {
    ?>
    <div>
        Пользователь: <?= $user->getName() ?> (<?= $user->getBirthday() ?>)


    </div>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Личный кабинет',
        'body' => $body,
    ]
);
