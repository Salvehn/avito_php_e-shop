<?php

/** @var \Model\Entity\Product[] $productList */
/** @var bool $isLogged */
/** @var \Closure $path */
$body = function () use ($finalList, $isLogged, $path,$finalPrice,$lastOrder) {
    ?>
    <form method="post">
        <table cellpadding="10">
            <tr>
                <td colspan="3" align="center">Корзина</td>
                <td colspan="3" align="center">Последний заказ: <?= is_null($lastOrder)? '' : $lastOrder ?></td>
            </tr>
<?php

    $n = 1;
    foreach ($finalList as $item) {
        $product = $item['product'];
        $price = $product->getPrice();
        $discount = $item['discount'];
        if(!is_null($discount)){
            $discount_price = $product->getPrice() * $discount->getDiscount();
        }

        ?>
            <tr>
                <td><?= $n++ ?>.</td>
                <td><?= $product->getName() ?></td>
                <td><span style="<?= is_null($discount)? '' : 'text-decoration:line-through;' ?>"> <?= $price ?> </span> <?= is_null($discount) ? '' : (strval($discount_price). ' руб  ( -' . (100-($discount_price/$price)*100) . '% )' )?> </td>
                <td><input type="button" value="Удалить" /></td>
            </tr>
<?php

    } ?>
            <tr>
                <td colspan="3" align="right">Итого: <?= $finalPrice ?> рублей</td>
            </tr>
<?php if ($finalPrice > 0) {
        if ($isLogged) {
            ?>
            <tr>
                <td colspan="3" align="center"><input type="submit" value="Оформить заказ" /></td>
            </tr>
<?php
        } else {
            ?>
            <tr>
                <td colspan="4" align="center">Для оформления заказа, <a href="<?= $path('user_authentication') ?>">авторизуйтесь</a></td>
            </tr>
<?php
        }
    } ?>
        </table>
    </form>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Корзина',
        'body' => $body,
    ]
);
