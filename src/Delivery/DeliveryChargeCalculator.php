<?php

namespace Acme\Delivery;

class DeliveryChargeCalculator
{
    private array $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function calculate(float $subtotal): float
    {
        foreach ($this->rules as $rule) {
            if ($rule instanceof DeliveryRuleInterface) {
                return $rule->calculate($subtotal);
            }
        }
        return 0.0; // Default no charge
    }
}
