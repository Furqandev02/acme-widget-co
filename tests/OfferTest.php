<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Acme\Products\Product;
use Acme\Products\ProductCatalog;
use Acme\Offers\BuyOneGetHalfPrice;

class OfferTest extends TestCase
{
    public function testBuyOneGetHalfPriceOffer(): void
    {
        $catalog = $this->getProductCatalog();
        $offer = new BuyOneGetHalfPrice('R01');

        $items = ['R01', 'R01', 'R01'];

        $this->assertEquals(16.475, $offer->apply($items, $catalog)); // Half price of one R01
    }

    public function testOfferDoesNotApply(): void
    {
        $catalog = $this->getProductCatalog();
        $offer = new BuyOneGetHalfPrice('G01');

        $items = ['R01', 'R01'];

        $this->assertEquals(0.0, $offer->apply($items, $catalog)); // Offer not for R01
    }

    private function getProductCatalog(): ProductCatalog
    {
        $catalog = new ProductCatalog();
        $catalog->addProduct(new Product('R01', 'Red Widget', 32.95));
        $catalog->addProduct(new Product('G01', 'Green Widget', 24.95));
        $catalog->addProduct(new Product('B01', 'Blue Widget', 7.95));

        return $catalog;
    }
}
