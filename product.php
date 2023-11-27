<!DOCTYPE html>
<html lang="en">

<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (empty($path) || preg_match('/\/[0-999]/', $path) == 0) {
    header("Location: /index.php");
    exit();
}

$segments = explode('/', trim($path, '/'));


$curl = curl_init();


curl_setopt($curl, CURLOPT_URL, "https://dummyjson.com/products/" . $segments[1]);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($curl);

curl_close($curl);

$arr = json_decode($output, true);
//print_r($arr);



function sendToCartCookie()
{  //$GLOBALS['arr']
    $item = $GLOBALS['arr'];
    $array = "";
    if(empty($_COOKIE["cart"])) {
        $array = array();
        array_push($array, $item['id']);
    }else{
        $array = str_replace('[','', $_COOKIE["cart"]);
        $array = str_replace("]","",$array);
        $array = explode(',', $array); 
        array_push($array, $item['id']);

    }
    setcookie("cart", '[' . implode(',', $array) . ']', time() + (86400 * 30),'/');
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitBtn"])) {
    // Call the PHP function
    sendToCartCookie();
}


?>




<?php


$title = 'Fuad Shop - Product page';
include 'compounts/head.php';
?>

<link rel="stylesheet" href="/css/product.css">

<body>
    <?php
    include 'compounts/nav.php';
    ?>

    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="images p-3">
                                <div class="text-center p-4"> <img id="main-image" src=<?php echo $arr['images'][0] ?> width="250" /> </div>
                                <div class="thumbnail text-center"> <?php foreach ($arr['images'] as $img) {
                                                                        echo '<img onclick="change_image(this)" src="' . $img . '" width="70">';
                                                                    } ?> </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center"> <i class="fa fa-long-arrow-left"></i> <span class="ml-1"><?php echo $arr['brand'] ?></span> </div> <i class="fa fa-shopping-cart text-muted"></i>
                                </div>
                                <div class="mt-4 mb-3">
                                    <h5 class="text-uppercase"><?php echo $arr['title'] ?></h5>
                                    <div class="price d-flex flex-row align-items-center"> <span class="act-price"><?php echo round(abs(($arr['price'] * $arr['discountPercentage'] / 100) - $arr['price'])) ?> SAR</span>
                                        <div class="ml-2"> &nbsp; <small class="dis-price"><?php echo $arr['price']  ?> SAR</small> <span><?php echo round($arr['discountPercentage'])  ?>% OFF</span> </div>
                                    </div>
                                </div>
                                <p class="about"><?php echo $arr['description']  ?>%</p>

                                <div class="cart mt-4 align-items-center">
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <button type="submit" name="submitBtn" class="btn btn-danger text-uppercase mr-2 px-4">Add to cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function change_image(image) {

            var container = document.getElementById("main-image");

            container.src = image.src;
        }
        document.addEventListener("DOMContentLoaded", function(event) {});
    </script>


</body>

</html>