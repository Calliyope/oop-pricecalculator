<?php

require 'PriceFunctions.php';
require '../Models/PricingModel.php';

//// THINGS TO DO ON FIRST PAGE LOAD

$customers = json_decode(file_get_contents('../customers.json'), false);
$groups = json_decode(file_get_contents('../groups.json'), false);
$products = json_decode(file_get_contents('../products.json'), false);

$model = new PricingModel();
$model->allCustomers = $customers;
$model->allProducts = $products;
$model->wasCalculated = false;
$model->currentCustomerIndex = 0;
$model->currentProductIndex = 0;

///// THINGS TO DO ON SUBMIT

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    //var_dump($_POST);

    $customer = $customers[$_POST['customer']];
    $product = $products[$_POST['product']];

    // What are the groups that the customer belongs to?
    $customerGroups = getGroupsForCustomer($customer, $groups);

    //What is the highest percent discount available IN THESE GROUPS?

    $highestVariableDiscount = getHighestVariableDiscount_version2($customerGroups);

    //What is the sum of all fixed discounts available?

    $sumOfAllFixedDiscounts = getFixedDiscountSum($customerGroups);

    // What is the price after applying a fixed discount?

    $priceAfterFixedDiscount = calculateFixedDiscountPrice($product->price, $sumOfAllFixedDiscounts);

    // What is the price after applying a variable discount?

    $priceAfterVariableDiscount = calculateVariableDiscountPrice($product->price, $highestVariableDiscount);

    // Which of these prices is best for the customer (= lowest)?

    $bestPrice;

    if($priceAfterFixedDiscount > $priceAfterVariableDiscount) {
        $bestPrice = $priceAfterVariableDiscount;
    } else {
        $bestPrice = $priceAfterFixedDiscount;
    }

    $model->wasCalculated = true;
    $model->currentCustomerIndex = $_POST['customer'];
    $model->currentProductIndex = $_POST['product'];
    $model->currentProduct = $product;
    $model->fixedDiscount = $sumOfAllFixedDiscounts;
    $model->variableDiscount = $highestVariableDiscount;
    $model->priceWhenFixed = $priceAfterFixedDiscount;
    $model->priceWhenVariable = $priceAfterVariableDiscount;
    $model->bestPrice = $bestPrice;
}

require '../Views/PriceView.php';

?>
