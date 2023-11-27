<!DOCTYPE html>
<html lang="en">
<?php
$title = 'Fuad Shop - Cart';
include 'compounts/head.php';
?>


<?php
$total = 0;
$totalDis = 0;
$arr = array();
if(!empty($_COOKIE["cart"])) {
    $array = str_replace('[','', $_COOKIE["cart"]);
    $array = str_replace("]","",$array);
    $array = explode(',', $array); 
    foreach($array as $value) {
        $curl = curl_init();


        curl_setopt($curl, CURLOPT_URL, "https://dummyjson.com/products/" . $value);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($curl);
        $output = json_decode($output, true);
        curl_close($curl);

        array_push($arr,$output);
        $total = $total + $output['price'];
        $totalDis = $totalDis + ($output['price'] * $output['discountPercentage'] / 100);
    }
}
//print_r($arr);


?>

<body>

    <?php
    include 'compounts/nav.php';
    ?>



<div class="container">
    <main>
        <div class="py-5 text-center">
            <h2>Checkout form</h2>
        </div>
        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill"><?php echo count($arr); ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <?php 
                    
                    if($total == 0){
                        echo '
                        <li class="list-group-item d-flex justify-content-between lh-sm text-center">
                        <h6 class="my-0">No Products exsit in Cart</h6>
                        </li>';
                    }else{
                        foreach($arr as $value) {
                            echo '
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                  <h6 class="my-0">'.$value['title'].'</h6>
                                  <small class="text-muted">'.$value['category'].'</small>
                                </div>
                              <span class="text-muted">'.$value['price'].' SAR</span>
                            </li>
                            
                            ';
                        }
                    }
                    ?>
                  

                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Total Discount</h6>
                        </div>
                        <span class="text-muted"><?php echo round($totalDis); ?> SAR</span>
                    </li>

                    <?php 

                    if($total != 0){
                        echo '
                        <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code</h6>
                            <small>SALE30</small>
                        </div>
                        <span class="text-success">-300 SAR</span>
                    </li>
                        ';
                    }
                    
                    ?>
                    
                    
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (With VAT)</span>
                        <strong><?php  if($total != 0){ echo round($total-$totalDis)-300;} else {echo 0;} ?> SAR</strong>
                    </li>
                </ul>
    
                <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <button type="submit" class="btn btn-danger">Redeem</button>
                    </div>
                </form>
            </div>
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" novalidate>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">First name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>
    
    
                        <div class="col-12">
                            <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>
    
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Plaza street" required>
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>
    
                        <div class="col-12">
                            <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                        </div>
    
                        <div class="col-md-5">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select" id="country" required>
                                <option value="">Choose...</option>
                                <option>India</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>
    
                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <select class="form-select" id="state" required>
                                <option value="">Choose...</option>
                                <option>Delhi</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <label for="zip" class="form-label">Zip</label>
                            <input type="text" class="form-control" id="zip" placeholder="" required>
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>
    
                    <hr class="my-4">
    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="save-info">
                        <label class="form-check-label" for="save-info">Save this information for next time</label>
                    </div>
    
                    <hr class="my-4">
    
                    <h4 class="mb-3">Payment</h4>
    
                    <div class="my-3">
                        <div class="form-check">
                            <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                            <label class="form-check-label" for="credit">Credit card</label>
                        </div>
                        <div class="form-check">
                            <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
                            <label class="form-check-label" for="debit">Mada</label>
                        </div>
                        <div class="form-check">
                            <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                            <label class="form-check-label" for="paypal">paypal</label>
                        </div>
                        <div class="form-check">
                            <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                            <label class="form-check-label" for="paypal">STC Pay</label>
                        </div>
                    </div>
    
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label for="cc-name" class="form-label">Name on card</label>
                            <input type="text" class="form-control" id="cc-name" placeholder="" required>
                            <small class="text-muted">Full name as displayed on card</small>
                            <div class="invalid-feedback">
                                Name on card is required
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <label for="cc-number" class="form-label">Credit card number</label>
                            <input type="text" class="form-control" id="cc-number" placeholder="" required>
                            <div class="invalid-feedback">
                                Credit card number is required
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <label for="cc-expiration" class="form-label">Expiration</label>
                            <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                            <div class="invalid-feedback">
                                Expiration date required
                            </div>
                        </div>
    
                        <div class="col-md-3">
                            <label for="cc-cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                            <div class="invalid-feedback">
                                Security code required
                            </div>
                        </div>
                    </div>
    
                    <hr class="my-4">
    
                    <button class="w-100 btn btn-danger btn-lg my-4" type="submit">Continue to checkout</button>

                </form>
            </div>
        </div>
    </main>
</div>

</body>

</html>