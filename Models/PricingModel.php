<?php
    class PricingModel {
        public $allCustomers;
        public $allProducts;
        public $wasCalculated;
        public $currentCustomerIndex;
        public $currentProductIndex;
        public $currentProduct;
        public $fixedDiscount;
        public $priceWhenFixed;
        public $variableDiscount;
        public $priceWhenVariable;
        public $bestPrice;
    }
?>