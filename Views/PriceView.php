<!--

        * list of all customers
        * list of all products
        * current selected product
        * price after fixed
        * price after variable
        * best price

-->

<h1>Price Calculator</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div>
        <p>Pick a customer :</p>
        <select name="customer">
            <?php foreach($model->allCustomers as $index => $customer) { ?>

                <option 
                    value="<?php echo $index ?>" 
                    <?php if($model->currentCustomerIndex == $index) { ?> selected="selected" <?php } ?>
                >
                    <?php echo $customer->name ?>
                </option>

            <?php } ?>
        </select>
    </div>

    <div>
        <p>Pick a product :</p>
        <select name="product">
            <?php foreach($model->allProducts as $index => $product) { ?>

                <option 
                    value="<?php echo $index ?>"
                    <?php if($model->currentProductIndex == $index) { ?> selected="selected" <?php } ?>    
                >
                    <?php echo $product->name . " (€" . number_format($product->price, 2) . ")" ?>
                </option>

            <?php } ?>
        </select>
    </div>

    <p>
        <input type="submit" value="Calculate price" />
    </p>
</form>

<?php if($model->wasCalculated) { ?>

    <hr/>

<div>
    <h3>Current product</h3>
    <p><?php echo $model->currentProduct->name . " (€" . number_format($model->currentProduct->price, 2) . ")" ?></p>
    <p><?php echo $model->currentProduct->description ?></p>
</div>

<div>
    <h3>Price calculation</h3>
    <p>Original price = €<?php echo number_format($model->currentProduct->price, 2) ?></p>
    <p>Price after fixed discount (€<?php echo number_format($model->fixedDiscount, 2) ?>) = €<?php echo number_format($model->priceWhenFixed, 2) ?></p>
    <p>Price after variable discount (<?php echo $model->variableDiscount ?>%) = €<?php echo number_format($model->priceWhenVariable, 2) ?></p>
</div>

<div>
    <h3>Best price = €<?php echo number_format($model->bestPrice, 2) ?></h3>
</div>

<?php } ?>


