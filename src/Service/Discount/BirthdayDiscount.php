<?php

declare(strict_types = 1);

namespace Service\Discount;

use Model;
function debug_log($object = null, $label = null)
{
    $message = json_encode($object, JSON_PRETTY_PRINT);
    $label = "Debug" . ($label ? " ($label): " : ': ');
    echo "<script>console.log(\"$label\", $message);</script>";
}
class BirthdayDiscount implements IDiscount
{
    public const DAYS_AMOUNT = 5;
    public const DISCOUNT_MULTIPLIER = 0.95;
    /**
     * @var string
     */
    private $user;

    /**
     * @param Model\Entity\User $user
     */

    public function __construct(Model\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {
        // Получаем индивидуальную скидку Birthday пользователя
        // $discount = $this->find($this->user)->discount();
        $birthday = $this->user->getBirthday();

        $discount = $this->getDiscountBirthday(strtotime($birthday));

        return $discount;
    }
    public function getDiscountBirthday($birthday): float
   {
       #$birthday = '20.11.2010';

       $birthdayString = date('d.m.Y', $birthday);
       $beforeDiscount = date('d.m.Y', strtotime('today 00:00:00 +' . self::DAYS_AMOUNT . ' days'));
       $afterDiscount = date('d.m.Y', strtotime('today 00:00:00 -' . self::DAYS_AMOUNT . ' days'));

       if (($beforeDiscount >= $birthdayString) && ($birthdayString >= $afterDiscount)) {
           return  self::DISCOUNT_MULTIPLIER;
       } else {
           return  1.0;
       }

   }
}
