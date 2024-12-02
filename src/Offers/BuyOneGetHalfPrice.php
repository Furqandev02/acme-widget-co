<?php
namespace Acme\Offers;

use Acme\Products\ProductCatalog;

class BuyOneGetHalfPrice implements OfferInterface
{
    private string $productCode;

    public function __construct(string $productCode)
    {
        $this->productCode = $productCode;
    }

    public function apply(array $items, ProductCatalog $catalog): float
    {
        $count = array_count_values($items)[$this->productCode] ?? 0;
        $product = $catalog->getProduct($this->productCode);

        if ($count > 1 && $product) {
            // Apply discount for every second item
            return floor($count / 2) * ($product->getPrice() / 2);
        }
        return 0.0;
    }
}
