<?php
namespace Acme\Delivery;

interface DeliveryRuleInterface
{
    public function calculate(float $subtotal): float;
}
