<?php
namespace Acme;

use Acme\Products\ProductCatalog;
use Acme\Delivery\DeliveryChargeCalculator;

class Basket
{
    private ProductCatalog $catalog;
    private array $offers;
    private DeliveryChargeCalculator $deliveryCalculator;
    private array $items = [];

    public function __construct(
        ProductCatalog $catalog,
        array $offers,
        DeliveryChargeCalculator $deliveryCalculator
    ) {
        $this->catalog = $catalog;
        $this->offers = $offers;
        $this->deliveryCalculator = $deliveryCalculator;
    }

    public function add(string $productCode): void
    {
        if (!$this->catalog->getProduct($productCode)) {
            throw new \Exception("Product $productCode not found.");
        }
        $this->items[] = $productCode;
    }

    public function total(): float
    {
        $subtotal = $this->calculateSubtotal();
        $discount = $this->applyOffers();
        $delivery = $this->deliveryCalculator->calculate($subtotal - $discount);

        // Round the total to 2 decimal places to avoid floating-point precision issues
        return round($subtotal - $discount + $delivery, 2);
    }

    private function calculateSubtotal(): float
    {
        $subtotal = 0.0;
        foreach ($this->items as $productCode) {
            $product = $this->catalog->getProduct($productCode);
            if ($product) {
                $subtotal += $product->getPrice();
            }
        }
        return $subtotal;
    }

    private function applyOffers(): float
    {
        $discount = 0.0;
        foreach ($this->offers as $offer) {
            $discount += $offer->apply($this->items, $this->catalog);
        }
        return $discount;
    }
}
