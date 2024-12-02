<?php
namespace Acme\Utils;

use Acme\Products\ProductCatalog;
use Acme\Offers\BuyOneGetHalfPrice;
use Acme\Delivery\DeliveryChargeCalculator;
use Acme\Delivery\DeliveryRuleInterface;
use Acme\Basket;

class DependencyInjection
{
    // Method to create and inject dependencies into the Basket class
    public static function createBasket(): Basket
    {
        // Create product catalog and add products
        $catalog = self::createProductCatalog();

        // Define offers (e.g., Buy one get half price for R01)
        $offers = [new BuyOneGetHalfPrice('R01')];

        // Create delivery calculator with custom delivery rules
        $deliveryCalculator = self::createDeliveryCalculator();

        // Create and return the Basket with injected dependencies
        return new Basket($catalog, $offers, $deliveryCalculator);
    }

    // Helper method to create Product Catalog
    private static function createProductCatalog(): ProductCatalog
    {
        $catalog = new ProductCatalog();
        $catalog->addProduct(new \Acme\Products\Product('R01', 'Red Widget', 32.95));
        $catalog->addProduct(new \Acme\Products\Product('G01', 'Green Widget', 24.95));
        $catalog->addProduct(new \Acme\Products\Product('B01', 'Blue Widget', 7.95));

        return $catalog;
    }

    // Helper method to create Delivery Calculator with custom rules
    private static function createDeliveryCalculator(): DeliveryChargeCalculator
    {
        // Define a delivery rule based on the subtotal
        $rules = [
            new class implements DeliveryRuleInterface {
                public function calculate(float $subtotal): float
                {
                    if ($subtotal < 50) {
                        return 4.95;
                    } elseif ($subtotal < 90) {
                        return 2.95;
                    }
                    return 0.0;
                }
            }
        ];

        return new DeliveryChargeCalculator($rules);
    }
}
