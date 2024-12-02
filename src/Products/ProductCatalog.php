<?php
namespace Acme\Products;

class ProductCatalog
{
    private array $products = [];

    public function addProduct(Product $product): void
    {
        $this->products[$product->getCode()] = $product;
    }

    public function getProduct(string $code): ?Product
    {
        return $this->products[$code] ?? null;
    }
}
