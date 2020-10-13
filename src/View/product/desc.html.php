<?php

/** @var \Model\Entity\Product[] $productList */
$body = function () use ($productList, $path) {
    ?>
    <table cellpadding="40" cellspacing="0" border="0">
        <tr><td colspan="3" align="center">Наши курсы</td></tr>
        <tr>
            <td colspan="3" align="left">Сортировать по:
                <a href="<?= $path('product_desc_list') ?>?sort=price">Цене</a>
                <a href="<?= $path('product_desc_list') ?>?sort=name">Названию</a>
            </td>
        </tr>
<?php
            $position = 0;
    foreach ($productList as $key => $product) {
        echo $position % 3 ? '' : '<tr>'; ?>
                <td style="text-align: center">
                    <a href="<?= $path('product_info', ['id' => $product->getId()]) ?>"><?= $product->getName() ?></a>
                    <br /><br />
                    Описание: <?= $product->getDesc() ?>
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
        'title' => 'Описание курсов',
        'body' => $body,
    ]
);
