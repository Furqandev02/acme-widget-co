<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Acme\Delivery\DeliveryChargeCalculator;

class DeliveryTest extends TestCase
{
    public function testDeliveryForLowSubtotal(): void
    {
        $deliveryCalculator = $this->getDeliveryCalculator();

        $this->assertEquals(4.95, $deliveryCalculator->calculate(40.00));
    }

    public function testDeliveryForMediumSubtotal(): void
    {
        $deliveryCalculator = $this->getDeliveryCalculator();

        $this->assertEquals(2.95, $deliveryCalculator->calculate(70.00));
    }

    public function testDeliveryForHighSubtotal(): void
    {
        $deliveryCalculator = $this->getDeliveryCalculator();

        $this->assertEquals(0.0, $deliveryCalculator->calculate(120.00));
    }

    private function getDeliveryCalculator(): DeliveryChargeCalculator
    {
        return new DeliveryChargeCalculator([
            new class implements \Acme\Delivery\DeliveryRuleInterface {
                public function calculate(float $subtotal): float
                {
                    return $subtotal < 50 ? 4.95 : ($subtotal < 90 ? 2.95 : 0.0);
                }
            }
        ]);
    }
}
