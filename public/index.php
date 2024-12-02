<?php
// File: public/index.php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload dependencies

use Acme\Utils\DependencyInjection;
use Acme\Products\Product;
use Acme\Products\ProductCatalog;
use Acme\Offers\BuyOneGetHalfPrice;
use Acme\Delivery\DeliveryChargeCalculator;

// **Problem 1: Product Catalog and Pricing**
$catalog = new ProductCatalog();
$catalog->addProduct(new Product('R01', 'Red Widget', 32.95));
$catalog->addProduct(new Product('G01', 'Green Widget', 24.95));
$catalog->addProduct(new Product('B01', 'Blue Widget', 7.95));

// **Problem 2: Delivery Charge Based on Subtotal**
$deliveryCalculator = new DeliveryChargeCalculator([
    new class implements \Acme\Delivery\DeliveryRuleInterface {
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
]);

// **Problem 3: Offer Implementation - "Buy One Get Half Price"**
$offers = [new BuyOneGetHalfPrice('R01')];

// **Problem 4: Basket Calculation - Example Baskets and Expected Totals**

function calculateTotal($products, $offers) {
    $basket = new Acme\Basket($GLOBALS['catalog'], $offers, $GLOBALS['deliveryCalculator']);
    foreach ($products as $product) {
        $basket->add($product);
    }
    return $basket->total();
}

// Example 1: B01, G01
$example1 = ['B01', 'G01'];
$total1 = calculateTotal($example1, []); // No offers

// Example 2: R01, R01 (Buy one, get the second half price)
$example2 = ['R01', 'R01'];
$total2 = calculateTotal($example2, [new BuyOneGetHalfPrice('R01')]);

// Example 3: R01, G01
$example3 = ['R01', 'G01'];
$total3 = calculateTotal($example3, [new BuyOneGetHalfPrice('R01')]);

// Example 4: B01, B01, R01, R01, R01
$example4 = ['B01', 'B01', 'R01', 'R01', 'R01'];
$total4 = calculateTotal($example4, [new BuyOneGetHalfPrice('R01')]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basket Totals</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: left; }
    </style>
</head>
<body>

<h1>Acme Widget Co Test Task</h1>
<h2>Example Baskets and Expected Totals</h2>

<table>
    <thead>
        <tr>
            <th>Basket</th>
            <th>Expected Total</th>
            <th>Calculated Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>B01, G01</td>
            <td>$37.85</td>
            <td><?php echo number_format($total1, 2); ?></td>
        </tr>
        <tr>
            <td>R01, R01 (Buy one, get half price)</td>
            <td>$54.37</td>
            <td><?php echo number_format($total2, 2); ?></td>
        </tr>
        <tr>
            <td>R01, G01</td>
            <td>$60.85</td>
            <td><?php echo number_format($total3, 2); ?></td>
        </tr>
        <tr>
            <td>B01, B01, R01, R01, R01</td>
            <td>$98.27</td>
            <td><?php echo number_format($total4, 2); ?></td>
        </tr>
    </tbody>
</table>

</body>
</html>
