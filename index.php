<!DOCTYPE html>
<html lang="en">
<?php
$title = 'Fuad Shop - Main page';
include 'compounts/head.php';
?>


<?php

$curl = curl_init();


curl_setopt($curl, CURLOPT_URL, "https://dummyjson.com/products");

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($curl);

curl_close($curl);

$arr = json_decode($output, true);
$products = $arr["products"];


?>

<body>


    <?php
    include 'compounts/nav.php';
    ?>
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row justify-content-center mb-3">
                <div class="col-md-12 col-xl-10">




                    <?php
                    foreach ($products as $value) {
                        echo '  

                        <div class="card shadow-0 border rounded-3 mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                    <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                        <img src="' . $value['images'][0] . '" class="w-100 min-h-50 " />
                                        <a href="#!">
                                            <div class="hover-overlay">
                                                <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <h5>' . $value['title'] . '</h5>
                                    <div class="d-flex flex-row">
                                        <div class="text-danger mb-1 me-2">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="mt-1 mb-0 text-muted small">
                                        <span>' . $value['category'] . '</span>
                                        <span class="text-primary"> • </span>
                                        <span>' . $value['brand'] . '</span>
                                    </div>

                                    <p class="text-truncate mb-4 mb-md-0">
                                        ' . $value['description'] . '
                                  </p>
                           
                    
                                </div>
                                <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <h4 class="mb-1 me-1">' . round(abs(($value['price'] * $value['discountPercentage'] / 100) - $value['price'])) . ' SAR</h4>
                                        <span class="text-danger"><s>' . $value['price'] . ' SAR</s></span>
                                    </div>
                                    <h6 class="text-success">Free shipping</h6>
                                    <div class="d-flex flex-column mt-4">
                                        <a href="/product.php/'.$value['id'].'" class="btn btn-primary btn-sm" type="button">Details</a>
                                        <button class="btn btn-outline-primary btn-sm mt-2" type="button">
                                            Add to wishlist
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                                  
                                    ';
                    }


                    ?>



                </div>
            </div>


        </div>
        </div>
    </section>







</body>

</html>