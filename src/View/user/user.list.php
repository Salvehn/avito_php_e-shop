<?php

/** @var \Model\Entity\User[] $productList */
$body = function () use ($userList, $path) {
    ?>
    <table cellpadding="40" cellspacing="0" border="0">
        <tr><td colspan="3" align="center">Наши пользователи</td></tr>

<?php
            $position = 0;
    foreach ($userList as $key => $user) {
        echo $position % 3 ? '' : '<tr>'; ?>
                <td style="text-align: center">

                    <br /><br />
                    <p>Пользователь: <?= $user->getName() ?></p>
                    <ol>
                        <li>Логин: <?= $user->getLogin() ?></li>
                        <li>Имя: <?= $user->getName() ?></li>
                        <li>Роль: <?= $user->getRole()->getTitle() ?></li>
                        <li>Тип роли: <?= $user->getRole()->getType() ?></li>
                    </ol>
                    <hr>
                </td>
<?php
                echo($position + 1) % 3 ? '' : '</tr>';
        ++$position;
    }
    echo $position % 3 ? str_repeat('<td></td>', 3 - $position%3) . '</tr>' : ''; ?>
    </table>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Список пользователей',
        'body' => $body,
    ]
);
