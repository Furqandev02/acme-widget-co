<?php
namespace Acme\Offers;

use Acme\Products\ProductCatalog;

interface OfferInterface
{
    public function apply(array $items, ProductCatalog $catalog): float;
}
